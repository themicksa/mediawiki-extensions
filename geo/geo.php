<?
require_once ( "geo_functions.php" ) ;

# geo paramater class
# this class is used for parameter storage, data access and caching, etc.
class geo_params
	{
	var $min_x = 1000000 ;
	var $max_x = -1000000 ;
	var $min_y = 1000000 ;
	var $max_y = -1000000 ;
	var $draw = array () ; # What to draw
	var $labels = array () ; # The text labels
	var $languages = array ( "en" ) ; # Default language
	var $styles = array ( "default" => "fill:#EEEEEE;" ) ; # All the styles
	var $label_styles = array () ; # All the label styles
	var $starters = array () ; # The objects to start drawing with
	var $fits = array () ; # Which objects to fit into the viewport
	var $object_tree = array () ; # The current object(s) being rendered
	var $cache2 = array () ; # The article cache
	var $later_objects = array () ; # Things that should be drawn at the end, like cities

#	var $geo_cache = array () ; # The article cache
	
	function settings ( $sets )
		{
		$sets = explode ( "\n" , strtolower ( $sets ) ) ;
		foreach ( $sets AS $s )
			{
			$s = explode ( ":" , $s , 2 ) ;
			if ( count ( $s ) == 2 ) # key = value
				{
				$key = trim ( $s[0] ) ;
				$value = trim ( $s[1] ) ;
				if ( $key == "languages" )
					{
					$this->languages = explode ( ";" , str_replace ( "," , ";" , $value ) ) ; # "," and ";" are valid separators
					}
				else if ( $key == "style" || $key == "label" || $key == "draw" )
					{
					$a = explode ( "=" , $value , 2 ) ;
					if ( count ( $a ) == 1 ) $a[] = "1" ;
					$b = explode ( ";" , str_replace ( "," , ";" , $a[0] ) ) ;
					foreach ( $b AS $c )
						{
						$d = explode ( ";" , str_replace ( "," , ";" , $a[1] ) ) ;
						foreach ( $d AS $e )
							{
							$e = explode ( ":" , $e ) ;
							$va = trim ( strtolower ( $e[0] ) ) ;
							if ( count ( $e ) < 2 ) $vb = "" ; #/*$this->styles*/$kv[$c][$e[0]] = "" ;
							else $vb = trim ( strtolower ( $e[1] ) ) ;# /*$this->styles*/$kv[$c][$e[0]] = trim ( strtolower ( $e[1] ) ) ;
							if ( $key == "style" ) $this->styles[$c][$va] = $vb ;
							else if ( $key == "label" ) $this->label_styles[$c][$va] = $vb ;
							else if ( $key == "draw" ) $this->draw[$c][$va] = $vb ;
							}
						}
					}
				else if ( $key == "show" )
					{
					$a = explode ( ";" , str_replace ( "," , ";" , $value ) ) ;
					$this->starters = array_merge ( $this->starters , $a ) ;
					}
				else if ( $key == "fit" )
					{
					$a = explode ( ";" , str_replace ( "," , ";" , $value ) ) ;
					$this->fits = array_merge ( $this->fits , $a ) ;
					}
				}
			}
			
		# Cleanup
		foreach ( $this->starters AS $k => $v ) $this->starters[$k] = trim ( $v ) ;
		foreach ( $this->fits AS $k => $v ) $this->fits[$k] = trim ( $v ) ;
		}

	# The actual SVG collecting and "rendering"
	function getSVG ()
		{
		foreach ( $this->starters AS $s )
			{
			$g = new geo ;
			$g->set_from_id ( $s , $this ) ;
			$svg = $g->draw ( $this ) ;
			}
#		return "" ; # TESTING!
		$svg .= $this->get_svg_objects () ;
		$svg .= $this->get_svg_labels () ;

		# Finalizing
		$viewBox = $this->get_view_box () ;
		$svg = 
		'<?xml version="1.0" encoding="utf-8" standalone="no"?>
		<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.0//EN" "http://www.w3.org/TR/SVG/DTD/svg10.dtd">
		<svg viewBox="' . $viewBox .
		'" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve">
			<g id="mainlayer">
		'
			. $svg .
			'</g>
		</svg>
		' ;

		return $svg ;
		}

	# This can read the data directly as an article from the database
	function read_from_article ( $id )
		{
		$t = Title::newFromText ( "Geo:" . $id ) ;
		$a = new Article ( $t ) ;
		return $a->getContent ( true ) ;
		}
	
	# This can read the data from a mediawiki installation via URL
	# *Much* slower than the function above
	function read_from_url ( $id )
		{
		$index = "http://127.0.0.1/phase3/index.php" ;
		$filename = "{$index}?title=Geo:{$id}&action=raw" ;
		$handle = fopen($filename, "r");
		$contents = '';
		while (!feof($handle))
			$contents .= fread($handle, 8192);
		fclose($handle);
		return $contents ;
		}
	
	# This reads the data and manages the cache
	function get_raw_text ( $id )
		{
#		if ( isset ( $this->geo_cache[$id] ) ) # Try the cache first...
#			return $this->geo_cache[$id] ;
	
		if ( MEDIAWIKI ) # Direct connection to mediawiki database via Article/Title class
			$contents = $this->read_from_article ( $id ) ;
		else # Over-the-net connection via URL "&action=raw", much slower
			$contents = $this->read_from_url ( $id ) ;
	
		# Return text
#		$this->geo_cache[$id] = $contents ; # Cache the result
		return $contents ;
		}

	function match_object_style ( $object , $type )
		{
		$ret = array () ;
		if ( isset ( $this->styles["{$object}[{$type}]"] ) )
			$ret = $this->styles["{$object}[{$type}]"] ;
		return implode ( "; " , $ret ) ;
		}
		
	function data_to_real ( &$x , &$y )
		{
		$x = coordinate_to_number ( coordinate_take_apart ( $x ) ) ;
		$y = coordinate_to_number ( coordinate_take_apart ( $y ) ) ;
	
		$z = $x ; $x = $y ; $y = $z ; # Switching y/x to x/y
		$y = 90 * 3600 - $y ; # displaying from north to south

		# Recording min and max
		$this->min_x = min ( $this->min_x , $x ) ;
		$this->min_y = min ( $this->min_y , $y ) ;
		$this->max_x = max ( $this->max_x , $x ) ;
		$this->max_y = max ( $this->max_y , $y ) ;
		}

	function get_view_box ()
		{
		$min_x = $this->min_x ;
		$max_x = $this->max_x ;
		$min_y = $this->min_y ;
		$max_y = $this->max_y ;
		$width = $max_x - $min_x ;
		$height = $max_y - $min_y ;
		$min_x -= $width / 10 ;
		$min_y -= $height / 10 ;
		$max_x += $width / 10 ;
		$max_y += $height / 10 ;
		
		$max_x -= $min_x ;
		$max_y -= $min_y ;
		return "{$min_x} {$min_y} {$max_x} {$max_y}" ;
		}

	function add_label ( $text_array )
		{
		$this->labels[] = $text_array ;
		}
		
	function get_svg_objects ()
		{
		return implode ( "\n" , $this->later_objects ) ;
		}

	function get_svg_labels ()
		{
		$ret = "" ;
		$medium_font_size = floor ( ( $this->max_x - $this->min_x ) / 50 ) ;
		foreach ( $this->labels AS $l )
			{
			$text = $l['text'] ;
			$x = $l['x'] ;
			$y = $l['y'] ;
			$s = "<text style='" ;
			
			$p = array() ; # Default styles
			$p["text-anchor"] = "middle" ;
			$p["fill-opacity"] = "0.7" ;
			$p["font-size"] = "medium" ;

			if ( isset ( $l['style'] ) )
				{
				foreach ( $l['style'] AS $k => $v ) # Chosen style overrides default style
					$p[$k] = $v ;
				}

			# Fix font size shortcuts
			if ( $p['font-size'] == "" ) $p['font-size'] = "medium" ;
			if ( $p['font-size'] == "medium" ) $p['font-size'] = $medium_font_size . "pt" ;

			# Link?
			if ( isset ( $l['style']['href'] ) )
				{
				$href = $l['style']['href'] ;
				unset ( $l['style']['href'] ) ; # Don't want this to show up in the style attribute
				}
			else $href = "" ;

			# Make a style parameter string
			foreach ( $p AS $pk => $pv )
				$s .= "{$pk}: {$pv}; " ;
			
			$s .= "' x='{$x}' y='{$y}'>{$text}</text>" ;
			
			if ( $href != "" )
				$s = "<a xlink:href=\"{$href}\">{$s}</a>" ;
			
			$ret .= $s."\n" ;
			}
		return $ret ;
		}

	# This function converts an ID like "germany.bavaria.cities#*" into the actual list of entries on the given page
	# An ID "#*" will load every entry on that page
	function expand_ids ( &$ids , $me )
		{
		$ret = array () ;
		foreach ( $ids AS $id )
			{
			$id = trim ( $id ) ;
			if ( substr ( $id , -2 ) == "#*" )
				{
				$this->geo_get_text ( substr ( $id , 0 , - 2 ) ) ; # Force page into cache
				$match = substr ( $id , 0 , - 1 ) ;
				if ( $match == "#" ) $match = $me . $match ; # the "#*" case
				foreach ( array_keys ( $this->cache2 ) AS $x )
					{
					if ( substr ( $x , 0 , strlen ( $match ) ) == $match # Same beginning
							AND $x != $match AND $x != $me ) # Don't want recursive inclusion of head element ;-)
						$ret[] = $x ;
					}
				}
			else $ret[] = $id ;
			}
#		print implode ( ", " , $ret ) . "\n" ;
		$ids = $ret ;
		}

	# This gets the text of an entry. An ID like "germany.bavaria.cities" will get the first entry,
	# while "germany.bavaria.cities#munich" will get only the munich data.
	# The function caches all entries of a page, and acts as a key generator for expand_ids
	function geo_get_text ( $id )
		{
		$id = trim ( strtolower ( $id ) ) ;
		
		$parts = explode ( "#" , $id ) ;
		if ( count ( $parts ) == 2 )
			{
			$id = array_shift ( $parts ) ;
			$subid = array_shift ( $parts ) ;
			}
		else $subid = "" ;

		# Is this already in the parts cache?
		if ( isset ( $this->cache2["{$id}#{$subid}"] ) )
			return $this->cache2["{$id}#{$subid}"] ;

		# We have this already loaded, nothing to see here...
		if ( isset ( $this->cache2["{$id}#"] ) )
			return "" ;
		
		$ret = "\n" . $this->get_raw_text ( $id ) ;
		$ret = explode ( "\n==" , $ret ) ;
		
#		if ( $subid == "" ) return $ret[0] ; # Default
		
		$this->cache2["{$id}#"] = array_shift ( $ret ) ;
		foreach ( $ret AS $s )
			{
			$s = explode ( "\n" , $s , 2 ) ;
			$heading = array_shift ( $s ) ;
			$heading = strtolower ( trim ( str_replace ( "=" , "" , $heading ) ) ) ;
			$this->cache2["{$id}#{$heading}"] = array_shift ( $s ) ;
#			if ( $heading == $subid ) return array_shift ( $s ) ;
			}

		if ( isset ( $this->cache2["{$id}#{$subid}"] ) )
			return $this->cache2["{$id}#{$subid}"] ;
	#	print "Not found : {$id}#{$subid}\n" ;
		return "" ; # Query not found
		}

	}

# "geo" class
class geo
	{
	var $id ;
	var $data = array () ;
	var $xsum , $ysum , $count ;

	function geo_get_text ( $id , &$params )
		{
		return $params->geo_get_text ( $id ) ;
/*		$id = trim ( strtolower ( $id ) ) ;
		
		$parts = explode ( "#" , $id ) ;
		if ( count ( $parts ) == 2 )
			{
			$id = array_shift ( $parts ) ;
			$subid = array_shift ( $parts ) ;
			}
		else $subid = "" ;
		
		$ret = "\n" . $params->get_raw_text ( $id ) ;
		$ret = explode ( "\n==" , $ret ) ;
		
		if ( $subid == "" ) return $ret[0] ; # Default
		
		array_shift ( $ret ) ;
		foreach ( $ret AS $s )
			{
			$s = explode ( "\n" , $s , 2 ) ;
			$heading = array_shift ( $s ) ;
			$heading = strtolower ( trim ( str_replace ( "=" , "" , $heading ) ) ) ;
			if ( $heading == $subid ) return array_shift ( $s ) ;
			}
	#	print "Not found : {$id}#{$subid}\n" ;
		return "" ; # Query not found
*/		}

	function set_from_id ( $id , &$params )
		{
		$this->id = $id ;
		$t = explode ( "\n;" , "\n".$this->geo_get_text ( $id , $params ) ) ;
		$this->data = array () ;
		foreach ( $t AS $x )
			{
			$b = explode ( ":" , $x , 2 ) ;
			while ( count ( $b ) < 2 ) $b[] = "" ;
			$key = strtolower ( str_replace ( " " , "" , array_shift ( $b ) ) ) ;
			$key = str_replace ( "\n" , "" , $key ) ;
			$value = trim ( str_replace  ( "\n" , "" , array_shift ( $b ) ) ) ;
			$value = explode ( ";" , $value ) ;
			if ( $key != "" ) $this->data[$key] = $value ;
			}
		}

	function scan_raw_data ( &$data , &$ret , &$params )
		{
		$data = explode ( " " , $data ) ;
		foreach ( $data AS $a )
			{
			$a = explode ( "," , $a ) ;
			if ( count ( $a ) == 2 )
				{
				$x = trim ( array_shift ( $a ) ) ;
				$y = trim ( array_shift ( $a ) ) ;
				$params->data_to_real ( $x , $y ) ;
				$ret[] = array ( $x , $y ) ;
				}
			}
		}

	function get_data ( &$params )
		{
		$ret = array () ;
		if ( !isset ( $this->data["data"] ) ) return $ret ; # No data in this set
		$data = $this->data["data"] ;
		$data = array_shift ( $data ) ;
		
		$sets = explode ( ";" , $data ) ;
		foreach ( $sets AS $data )
			{
			$data = trim ( strtolower ( $data ) ) ;
			if ( substr ( $data , 0 , 9 ) == "reference" )
				{
				$data = trim ( substr ( $data , 9 ) ) ;
				$data = trim ( substr ( $data , 1 , strlen ( $data ) - 2 ) ) ;
				$data = explode ( "," , $data ) ;
				$params->expand_ids ( $data , $this->id ) ;
				foreach ( $data AS $v )
					{
					$v = $this->fullid ( $v ) ;
					$ng = new geo ;
					$ng->set_from_id ( $v , $params ) ;
					$b = $ng->get_data ( $params ) ;
					$this->add_reordered_data ( $ret , $b ) ;
					}
				}
			else $this->scan_raw_data ( $data , $ret , $params ) ;
			}
		return $ret ;
		}

	function add_reordered_data ( &$original , &$toadd )
		{
		if ( count ( $toadd ) == 0 ) return ; # Nothing to add
		if ( count ( $original ) == 0 )
			{
			$original = $toadd ;
			return ;
			}
		
		$o_last = array_pop ( $original ) ; array_push ( $original , $o_last ) ; # Get last one and restore
		$t_last = array_pop ( $toadd ) ; array_push ( $toadd , $t_last ) ; # Get last one and restore
		$t_first = array_shift ( $toadd ) ; array_unshift ( $toadd , $t_first ) ; # Get first one and restore
		
		$dist_to_first =	( $o_last[0] - $t_first[0] ) * ( $o_last[0] - $t_first[0] ) +
								( $o_last[1] - $t_first[1] ) * ( $o_last[1] - $t_first[1] ) ;

		$dist_to_last =	( $o_last[0] - $t_last[0] ) * ( $o_last[0] - $t_last[0] ) +
								( $o_last[1] - $t_last[1] ) * ( $o_last[1] - $t_last[1] ) ;

		if ( $dist_to_last < $dist_to_first ) # If the last point of toadd is closer than the fist one,
			$toadd = array_reverse ( $toadd ) ; # add in other direction

		$original = array_merge ( $original , $toadd ) ;
		}

	function get_specs ( $base , $modes )
		{
		foreach ( $modes AS $x )
			{
			if ( isset ( $this->data["{$base}[{$x}]"] ) )
				return "{$base}[{$x}]" ;
			}
		if ( isset ( $this->data[$base] ) )
			return $base ;
		return "" ;
		}
		
	function get_current_type ( &$params ) # params may override native type
		{
		$t = $this->get_specs ( "type" , array ( "political" ) ) ;
		if ( $t != "" ) $t = $this->data[$t][0] ;
		return $t ;
		}

	function fullid ( $id )
		{
		$id = trim ( strtolower ( $id ) ) ;
		if ( substr ( $id , 0 , 1 ) == "#" )
 			$id = $this->id . $id ;
		return $id ;
		}

	function draw_line ( $line , &$params )
		{
		$ret = "" ;
		$a = explode ( "(" , $line , 2 ) ;
		while ( count ( $a ) < 2 ) $a[] = "" ;
		$command = trim ( strtolower ( array_shift ( $a ) ) ) ;
		$values = trim ( str_replace ( ")" , "" , array_shift ( $a ) ) ) ;
		if ( $command == "addregs" || $command == "include" )
			{
			$values = explode ( "," , $values ) ;
			$params->expand_ids ( $values , $this->id ) ;
			foreach ( $values AS $v )
				{
				$v = $this->fullid ( $v ) ;
				$ng = new geo ;
				$ng->set_from_id ( $v , $params ) ;
				$ret .= $ng->draw ( $params ) ;
				}
			}
		else if ( $command == "polygon" || $command == "polyline" )
			{
			if ( !$this->draw_this ( $params ) ) return $ret ;
			$data = array () ;
			$values = explode ( "," , $values ) ;
			$params->expand_ids ( $values , $this->id ) ;
			foreach ( $values AS $v )
				{
				$v = $this->fullid ( $v ) ;
				$ng = new geo ;
				$ng->set_from_id ( $v , $params ) ;
				$b = $ng->get_data ( $params ) ;
				$this->add_reordered_data ( $data , $b ) ;
				}

			$style = $this->get_current_style ( $params ) ;
			if ( $command == "polygon" ) $ret .= "<polygon {$style} points=\"" ;
			if ( $command == "polyline" ) $ret .= "<polyline {$style} points=\"" ;
			foreach ( $data AS $a )
				{
				$x = $a[0] ;
				$y = $a[1] ;
				$this->xsum += $x ;
				$this->ysum += $y ;
				$this->count++ ;
				$ret .= "{$x},{$y} " ;
				}
			$ret = trim ( $ret ) . "\"/>\n" ;
			
			}
		return $ret ;
		}

	function add_label ( $x , $y , &$params )
		{
		if ( !$this->label_this ( $params ) ) return ;
		$text = $this->get_specs ( "name" , $params->languages ) ;
		if ( $text == "" ) return "" ; # No label found
		$text = trim ( $this->data[$text][0] ) ;
		if ( $text == "" ) return "" ; # No point in showing an empty label
		$x = floor ( $x ) ;
		$y = floor ( $y ) ;
		
		$a = array ( "text" => $text , "x" => $x , "y" => $y , "font-size" => "medium" ) ;
		$a['style'] = $this->get_label_style ( &$params ) ;
		if ( isset ( $a['style']['clickable'] ) )
			{
			$href = "http://" . $params->languages[0] . ".wikipedia.org/wiki/" . str_replace ( " " , "_" , $text ) ;
			unset ( $a['style']['clickable'] ) ; # Shouldn't show up in style list
			$a['style']['href'] = $href ;
			}
		$params->add_label ( $a ) ;
		}
	
	function draw ( &$params )
		{
		array_push ( $params->object_tree , $this->id ) ;
		$ret = "" ;
		$this->xsum = $this->ysum = $this->count = 0 ;
		$match = $this->get_specs ( "region" , array ( "political" ) ) ;
		
		if ( $this->draw_this ( $params ) AND $this->get_current_type ( $params ) == "city" )
			{
			$b = $this->get_data ( $params ) ;
			$b = $b[0] ; # Only one point for cities...
			if ( isset ( $this->data['magnitude'][0] ) ) $r = floor ( trim ( $this->data['magnitude'][0] ) ) * 100 ;
			else $r = 300 ;
			$params->later_objects[] = "<circle cx=\"{$b[0]}\" cy=\"{$b[1]}\" r=\"{$r}\" fill=\"red\" style=\"fill-opacity:0.5\"/>\n" ;
#			$ret .= "<circle cx=\"{$b[0]}\" cy=\"{$b[1]}\" r=\"{$r}\" fill=\"red\" style=\"fill-opacity:0.5\"/>\n" ;
			$this->add_label ( $b[0] , $b[1] , $params ) ;
			}
		else if ( $match != "" )
			{
			$a = $this->data[$match] ;
			foreach ( $a AS $line )
				$ret .= $this->draw_line ( $line , $params ) ;
			}
		if ( $this->count > 0 )
			{
			$x = $this->xsum / $this->count ;
			$y = $this->ysum / $this->count ;
			$this->add_label ( $x , $y , $params ) ;
			}
		array_pop ( $params->object_tree ) ;
		return $ret ;
		}

	function draw_this ( &$params )
		{
		$a = $this->my_matches ( $params->draw , $params ) ;
		if ( count ( $a ) > 0 ) return true ;
		return false ;
		}

	function label_this ( &$params )
		{
		$a = $this->my_matches ( $params->label_styles , $params ) ;
		if ( count ( $a ) > 0 ) return true ;
		return false ;
		}

	function is_in_list ( $key , &$params )
		{
		$a = explode ( "[" , $key , 2 ) ;
		if ( count ( $a ) < 2 ) return false ;
		$sobj = trim ( array_shift ( $a ) ) ;
		$stype = trim ( str_replace ( "]" , "" , array_shift ( $a ) ) ) ;
		$type = $this->get_current_type ( $params ) ;
		if ( ( $sobj == "" OR in_array ( $sobj , $params->object_tree ) ) AND $stype == $type ) return true ;
		return false ;
		}

	function my_matches ( &$haystack , &$params )
		{
		$ret = array () ;
		foreach ( $haystack AS $k => $v )
			{
			if ( $k == $this->id OR $this->is_in_list ( $k , $params ) )
				$ret[] = $k ;
			}
		return $ret ;
		}

	function get_label_style ( &$params )
		{
		$matches = $this->my_matches ( $params->label_styles , $params ) ;
		$ret = array () ;
		foreach ( $matches AS $m )
			{
			$a = $params->label_styles[$m] ;
			foreach ( $a AS $k => $v )
				{
				$k = trim ( $k ) ;
				if ( $k != "" ) $ret[strtolower($k)] = strtolower($v) ;
				}
			}
		return $ret ;
		}

	function get_current_style ( &$params )
		{
		$matches = $this->my_matches ( $params->styles , $params ) ;
		$ret = array () ;
		foreach ( $matches AS $m )
			{
			$a = $params->styles[$m] ;
			foreach ( $a AS $k => $v )
				{
				$k = trim ( $k ) ;
				if ( $k != "" ) $ret[strtolower($k)] = strtolower($v) ;
				}
			}
		$s = "" ;
		foreach ( $ret AS $k => $v )
			$s .= "{$k}:{$v}; " ;
		$ret = "style=\"{$s}\"" ;
		return $ret ;
		}
	}

?>