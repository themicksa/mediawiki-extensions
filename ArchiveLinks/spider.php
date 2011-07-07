<?php

/**
 * This class is for the actual spidering and will be calling wget
 */
$path = getenv('MW_INSTALL_PATH');
if (strval($path) === '') {
	$path = realpath( dirname(__FILE__) . '/../..' );
}

require_once "$path/maintenance/Maintenance.php";

class ArchiveLinksSpider extends Maintenance {

	private $db_master;
	private $db_slave;
	private $db_result;
	private $jobs;

	public function execute( ) {
		global $wgArchiveLinksConfig, $wgLoadBalancer, $path;

		$this->db_master = $this->getDB(DB_MASTER);
		$this->db_slave = $this->getDB(DB_SLAVE);
		$this->db_result = array();

		if ( $wgArchiveLinksConfig['run_spider_in_loop'] ) {
			/* while ( TRUE ) {		
			  if ( ( $url = $this->check_queue() ) !== false ) {

			  }
			  sleep(1);
			  } */
			die( 'Sorry, at the current time running the spider as a daemon isn\'t supported.' );
		} else {
			//for right now we will pipe everything through the replication_check_queue function just for testing purposes
			/*if ( $wgLoadBalancer->getServerCount() > 1 ) {
				if ( ( $url = $this->replication_check_queue() ) !== false ) {
					
				}
			  } else {
				if ( ( $url = $this->check_queue() ) !== false ) {
				  
				}
			}*/

			if ( ( $url = $this->check_queue() ) !== false ) {
				switch( $wgArchiveLinksConfig['download_lib'] ) {
					case 'curl':
						die( 'At the current time support for libcurl is not available.' );
					case 'wget':
					default:
						$this->call_wget( $url );
				}
			}
		}
		return null;
	}
	
	private function call_wget( $url ) {
		global $wgArchiveLinksConfig;
		if ( array_key_exists( 'path_to_wget', $wgArchiveLinksConfig ) && file_exists( $wgArchiveLinksConfig['path_to_wget'] ) ) {
			die ( 'Support is not yet added for wget in a different directory' );
		} elseif ( file_exists( "$path/wget.exe" ) ) {
			if ( $wgArchiveLinksConfig['file_types_to_archive'] ) {
				if ( is_array( $wgArchiveLinksConfig['file_types_to_archive']) ){
					$accept_file_types = '-A ' . implode( ',', $wgArchiveLinksConfig['filetypes_to_archive'] );
				} else {
					$accept_file_types = '-A ' . $wgArchiveLinksConfig['file_types_to_archive'];
				}
			} else {
				$accept_file_types = '';
			}
			//At the current time we are only adding support for the local filestore, but swift support is something that will be added later
			switch( $wgArchiveLinksConfig['filestore_to_use'] ) {
				case 'local':
				default:
					if ( $wgArchiveLinksConfig['subfolder_name'] ) {
						$content_dir = 'extensions/ArchiveLinks/' . $wgArchiveLinksConfig['subfolder_name'];
					} elseif ( $wgArchiveLinksConfig['content_path'] ) {
						$content_dir =  realpath( $wgArchiveLinksConfig['content_path'] );
						if ( !$content_dir ) {
							die ( 'The path you have set for $wgArchiveLinksConfig[\'content_path\'] does not exist.' .
									'This makes the spider a very sad panda. Please either create it or use a different setting.');
						}
					} else {
						$content_dir = 'extensions/ArchiveLinks/' . 'archived_content/';
					}
					$dir = $path . $content_dir . sha1( time() . ' - ' . $url );
					$dir = escapeshellarg( $dir );
					$sanitized_url = escapeshellarg( $url );
			}

			shell_exec( "cd $path" );
			shell_exec( "wget.exe -nH -p -H -E -k -o \"./log.txt\" -Q2m -P $dir $accept_file_types $sanitized_url" );
		} else {
			//this is primarily designed with windows in mind and no built in wget, so yeah, *nix support should be added, in other words note to self...
			die ( 'wget must be installed in order for the spider to function in wget mode' );
		}
	}

	private function check_queue( ) {
		//need to fix this to use arrays instead of what I'm doing now
		$this->db_result['job-fetch'] = $this->db_slave->select('el_archive_queue', '*', '`el_archive_queue`.`delay_time` <= ' . time()
						. ' AND `el_archive_queue`.`in_progress` = 0'
						. ' ORDER BY `el_archive_queue`.`queue_id` ASC'
						. ' LIMIT 1');

		if ( $this->db_result['job-fetch']->numRows() > 0 ) {
			$row = $this->db_result['job-fetch']->fetchRow();
			
			//$this->delete_dups( $row['url'] );			

			return $row['url'];
		} else {
			//there are no jobs to do right now
			return false;
		}
	}

	/**
	 * This function checks a local file for a local block of jobs that is to be done
	 * if there is none that exists it gets a block, create ones, and waits to avoid any replag problems
	 */
	private function replication_check_queue( ) {
		global $path, $wgArchiveLinksConfig;
		if ( file_exists( "$path/extensions/ArchiveLinks/spider-temp.txt" ) ) {
			$file = file_get_contents( "$path/extensions/ArchiveLinks/spider-temp.txt" );
			$file = unserialize( $file );
		} else {
			//we don't have any temp file, lets get a block of jobs to do and make one
			$this->db_result['job-fetch'] = $this->db_slave->select( 'el_archive_queue', '*', 
					array(
						'delay_time <= "' . time() . '"',
						'in_progress' => '0')
					, __METHOD__, 
					array(
						'LIMIT' => '15',
						'ORDER BY' => 'queue_id ASC'
					));
			//echo $this->db_result['job-fetch'];
			
			$this->jobs = array();

			$wait_time = $this->db_slave->getLag() * 3;
			$pid = (string) microtime() . ' - ' .  getmypid();
			$time = time();
			
			//echo $pid;
			
			$this->jobs['pid'] = $pid;
			$this->jobs['execute_time'] = $wait_time + $time;
			
			if ($this->db_result['job-fetch']->numRows() > 0) {
				//$row = $this->db_result['job-fetch']->fetchRow();
				while ( $row = $this->db_result['job-fetch']->fetchRow() ) {
					//var_export($row);

					if ( $row['insertion_time'] >= $row['insertion_time'] + $wait_time ) {
						if ( $row['in_progress'] === '0') {
							$retval = $this->reserve_job( $row );
						} else {
							//in_progress is not equal to 0, this means that the job was reserved some time before
							//it could have been by a previous instance of this spider (assuming not running in a loop)
							//or a different spider entirely, since we don't have have a temp file to go on we have to assume 
							//it was a different spider (it could have been deleted by a user), we will only ignore the in_progress
							//lock if it has been a long time (2 hours by default) since the job was initally reserved
							$reserve_time = explode( ' ', $row['in_progress'] );
							$reserve_time = $reserve_time[2];
							
							array_key_exists( 'in_progress_ignore_delay', $wgArchiveLinksConfig ) ? $ignore_in_prog_time = $wgArchiveLinksConfig['in_progress_ignore_delay'] :
								$ignore_in_prog_time = 7200;
							
							if ( $reserve_time + $ingore_in_prog_time + $wait_time > $ignore_in_prog_time + $wait_time ) {
								$retval = $this->reserve_job( $row );
							}
						}
						
					} else {
						//let's wait for everything to replicate, add to temp file and check back later
						$this->jobs[] = $row;
					}
				}
			}
			
			//var_dump( $this->jobs );
			
			$this->jobs = serialize( $this->jobs );
			//file_put_contents( "$path/extensions/ArchiveLinks/spider-temp.txt", $this->jobs );
		}
		
		if ( $retval !== true ) {
			$retval = false;
		}
		return $retval;
	}
	
	private function delete_dups( $url ) {
		//Since we querried the slave to check for dups when we insterted instead of the master let's check
		//that the job isn't in the queue twice, we don't want to archive it twice
		$this->db_result['dup-check'] = $this->db_slave->select('el_archive_queue', '*', array( 'url' => $url ), __METHOD__, 
				array( 'ORDER BY' => 'queue_id ASC' ) );
		
		if ( $this->db_result['dup-check']->numRows() > 1 ) {
			//keep only the first job and remove all duplicates
			$this->db_result['dup-check']->fetchRow();
			while ( $del_row = $this->db_result['dup-check']->fetchRow() ) {
				echo 'you have a dup ';
				var_dump( $del_row );
				//this is commented for testing purposes, so I don't have to keep readding the duplicate to my test db
				//in other words this has a giant "remove before flight" ribbon hanging from it...
				//$this->db_master->delete( 'el_archive_queue', '`el_archive_queue`.`queue_id` = ' . $del_row['queue_id'] );    
			}
		}
	}
	
	private function reserve_job( $row ) {
		$this->jobs['execute_urls'][] = $row['url'];
		$this->db_master->update( 'el_archive_queue', array( $row['in_progress'] => "\"$pid\"" ), array( 'queue_id' => $row['queue_id'] ),
				__METHOD__ ) or die( 'can\'t reserve job' );
		$this->delete_dups( $row['url'] );
		return true;
	}
}

$maintClass = 'ArchiveLinksSpider';
require_once RUN_MAINTENANCE_IF_MAIN;