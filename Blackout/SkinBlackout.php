<?php
/**
 * Created by JetBrains PhpStorm.
 * User: john
 * Date: 1/17/12
 * Time: 2:36 PM
 * To change this template use File | Settings | File Templates.
 */
class SkinBlackout extends SkinTemplate {
	var $skinname = 'vector', $stylename = 'vector',
		$template = 'BlackoutTemplate', $useHeadElement = false;
}

class BlackoutTemplate extends QuickTemplate {

	/**
	 * Main function, used by classes that subclass QuickTemplate
	 * to show the actual HTML output
	 */
	public function execute() {
		// Output HTML Page
		?>
	<!DOCTYPE html>
	<html lang="en" dir="ltr" class="client-nojs">
	<head>
		<title>Wikipedia, the free encyclopedia</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Style-Type" content="text/css" />
		<meta name="generator" content="MediaWiki 1.18wmf1" />
		<style type="text/css">
			body {
				color: white;
				margin: 2em;
				font-family: arial, sans-serif;
				font-size: 15px;
				background: black url('//upload.wikimedia.org/wikipedia/commons/9/98/WP_SOPA_Splash_Full.jpg') no-repeat 0 0;
			}
			a:link, a:visited {
				color: #28a6b1;
			}
			a:hover, a:active {
				color: #999999;
			}
			div#everything {
				width: 920px;
				margin: 0 auto;
			}
			div#instructions {
				float:left;
				text-align: left;
				width: 580px;
				background-color: #202020;
				-moz-border-radius: 10px;
				-webkit-border-radius: 10px;
				border-radius: 10px;
				padding: 5px 20px 20px 20px;
				filter:alpha(opacity=90);
				-moz-opacity:0.90;
				-khtml-opacity: 0.90;
				opacity: 0.90;
			}
			div#contacts {
				float:left;
				width: 259px;
				padding: 5px 20px;
			}
			table.person {
				margin-bottom: 1em;
				border: none;
			}
			table.person td.name {
				font-weight: bold;
			}
			p {
				margin: 1em 0;
			}
			p.quote {
				font-family: georgia, serif;
				font-size: 14px;
				color: #CCCCCC;
			}
			h3 {
				font-weight: normal;
				font-size: 20px;
			}
			h4 {
				font-weight: normal;
				font-size: 17px;
			}
		</style>
	</head>
	<body>
		Hei
	</body>
</html>
<?php
	}
}