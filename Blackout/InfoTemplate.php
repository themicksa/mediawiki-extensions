<?php
/**
 * Created by JetBrains PhpStorm.
 * User: john
 * Date: 1/17/12
 * Time: 2:47 PM
 * To change this template use File | Settings | File Templates.
 */
class InfoTemplate extends QuickTemplate {

	/**
	 * Main function, used by classes that subclass QuickTemplate
	 * to show the actual HTML output
	 */
	public function execute() {
		?>
		<style type="text/css">#sopaOverlay {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			z-index: 2147483647; /* 32-bit max */·
			color: #dedede;
			background: black url(//upload.wikimedia.org/wikipedia/commons/9/98/WP_SOPA_Splash_Full.jpg) no-repeat 0 0;
			overflow: auto;
		}
		#sopaColumn {
			font-family:Times New Roman;
			width:400px;
			position:absolute;
			top:80px;
			left:420px;
			color: #dedede;
			padding-bottom: 30px;
		}
		#sopaHeadline {
			font-size: 1.5em;
			margin-bottom: 0.5em;
		}
		#sopaText {
			text-align:justify;
		}
		#sopaColumn a {
			color: #eeeeee;
			text-decoration: underline;
			cursor: pointer;
		}
		#sopaColumn a:hover {
			color:#ffffff;
		}
		#sopaAction {
			display: none;
		}
		#sopaColumn a.action {
			padding-right: 15px;
			margin-top: 2px;
			background: url(//upload.wikimedia.org/wikipedia/commons/3/3a/WP_SOPA_Arrow_right_dedede.png) center right no-repeat;
		}
		#sopaColumn a.action:hover {
			background: url(//upload.wikimedia.org/wikipedia/commons/6/63/WP_SOPA_Arrow_right_ffffff.png) center right no-repeat;
		}

		#sopaColumn a.action.open {
			background: url(//upload.wikimedia.org/wikipedia/commons/e/ec/WP_SOPA_Arrow_down_dedede.png) center right no-repeat;
		}
		#sopaColumn a.action.open:hover {
			background: url(//upload.wikimedia.org/wikipedia/commons/f/fb/WP_SOPA_Arrow_down_ffffff.png) center right no-repeat;
		}
		.sopaActionDiv {
			margin-left: 1em;
			margin-bottom: 1em;
		}

		.sopaActionHead {
			font-weight: bold;
		}
		.sopaSocial {
			float: left;
			text-align: center;
			margin-right: 12px;
			margin-bottom: 3px;
			font-size: small;
		}
		.sopaSocial a {
			text-decoration: none;
		}
</style>
	<div id="sopaOverlay"><div id="sopaColumn"><div id="sopaHeadline">WE NEED YOU TO PROTECT<br>FREE SPEECH ONLINE</div><div id="sopaText"><p>The Wikipedia community has authorized a blackout of the English version of Wikipedia for 24 hours in protest of proposed legislation — the Stop Online Piracy Act (SOPA) in the U.S. House of Representatives, and the PROTECTIP Act (PIPA) in the U.S. Senate — that, if passed, will harm the free, secure, and open Internet. These bills endanger free speech both in the United States and abroad, setting a frightening precedent of Internet censorship for the world.</p><p>Today we ask you to take action.</p></div><div id="sopaTakeAction"><a class="action open">Take action</a></div><div id="sopaAction" style="display: block; "><div class="sopaActionDiv"><p class="sopaActionHead">Contact your congressional representatives</p><div class="sopaActionDiv"><form action="/wiki/Special:CongressLookup"><label for="zip">Your zip code:</label> <input name="zip" type="text" size="5"> <input type="submit" name="submit" value="Look up"></form></div></div><div class="sopaActionDiv"><p class="sopaActionHead">Make your voice heard</p><div class="sopaActionDiv"><div><div class="sopaSocial"><a style="text-decoration: none; " href="https://www.facebook.com/sharer.php?u=http%3A%2F%2Fexample.com%2F"><img width="33" height="33" src="//upload.wikimedia.org/wikipedia/commons/2/2a/WP_SOPA_sm_icon_facebook_dedede.png"></a><br><a style="text-decoration: none; color: rgb(222, 222, 222); " href="https://www.facebook.com/sharer.php?u=http%3A%2F%2Fexample.com%2F">Facebook</a></div><div class="sopaSocial"><a style="text-decoration: none; " href="https://m.google.com/app/plus/x/?v=compose&amp;content=Google%20Plus%20Post%20Here%20http%3A%2F%2Fexample.com%2F"><img width="33" height="33" src="//upload.wikimedia.org/wikipedia/commons/0/08/WP_SOPA_sm_icon_gplus_dedede.png"></a><br><a style="text-decoration: none; " href="https://m.google.com/app/plus/x/?v=compose&amp;content=Google%20Plus%20Post%20Here%20http%3A%2F%2Fexample.com%2F">Google+</a></div><div class="sopaSocial"><a style="text-decoration: none; " href="https://twitter.com/intent/tweet?original_referer=https%3A%2F%2Ftest.wikipedia.org%2Fwiki%2FMain_Page%3Fbanner%3Dblackout&amp;text=Tweet%20here%20%23WikipediaBlackout%20http%3A%2F%2Fexample.com%2F"><img width="33" height="33" src="//upload.wikimedia.org/wikipedia/commons/4/45/WP_SOPA_sm_icon_twitter_dedede.png"></a><br><a style="text-decoration: none; " href="https://twitter.com/intent/tweet?original_referer=https%3A%2F%2Ftest.wikipedia.org%2Fwiki%2FMain_Page%3Fbanner%3Dblackout&amp;text=Tweet%20here%20%23WikipediaBlackout%20http%3A%2F%2Fexample.com%2F">Twitter</a></div></div><div style="clear:both;"></div></div></div></div><div id="sopaLearnMore"><a class="action" href="http://example.com/">Learn more</a></div></div></div>
<?php
	}
}
