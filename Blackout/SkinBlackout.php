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
		$template = 'BlackoutTemplate', $useHeadElement = true;
}

class BlackoutTemplate extends QuickTemplate {

	/**
	 * Main function, used by classes that subclass QuickTemplate
	 * to show the actual HTML output
	 */
	public function execute() {
		// Output HTML Page
		$this->html( 'headelement' );
		?>

		Hei
	</body>
</html>
<?php
	}
}