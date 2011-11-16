<?php

/**
 * 
 *
 * @since 1.7
 *
 * @licence GNU GPL v3
 * @author James Hong Kong
 */
class SRFD3Treemap extends SMWDistributablePrinter {
	
	protected static $m_barchartnum = 1;
	
	protected $m_charttitle;
	protected $m_barcolor;
	protected $m_bardirection;
	protected $m_numbersaxislabel;

	/**
	 * (non-PHPdoc)
	 * @see SMWResultPrinter::handleParameters()
	 */
	protected function handleParameters( array $params, $outputmode ) {
		parent::handleParameters( $params, $outputmode );
		
		$this->m_charttitle = $this->m_params['charttitle'];
		$this->m_barcolor = $this->m_params['barcolor'];
		$this->m_bardirection = $this->m_params['bardirection'];
		$this->m_numbersaxislabel = $this->m_params['numbersaxislabel'];
	}

	public function getName() {
		return wfMsg( 'srf_printername_D3Treemap' );
	}

	public static function registerResourceModules() {
		global $wgResourceModules, $srfgIP;

		$resourceTemplate = array(
			'localBasePath' => $srfgIP . '/D3',
			'remoteExtPath' => 'SemanticResultFormats/D3'
		);
		$wgResourceModules['ext.srf.d3'] = $resourceTemplate + array(
			'scripts' => array(
				'd3.js',
			),
			'styles' => array(
				'd3.css',
			),
		);

		$wgResourceModules['ext.srf.d3treemap'] = $resourceTemplate + array(
			'scripts' => array(
				'd3.layout.min.js',
			),
			'dependencies' => array(
				'ext.srf.d3',
			),
		);	
 	}

	protected function loadJavascriptAndCSS() {
		global $wgOut;
		$wgOut->addModules( 'ext.srf.d3treemap' );
	}

	/**
	 * Add the JS and CSS resources needed by this chart.
	 * 
	 * @since 1.7
	 */
	protected function addResources() {
		if ( self::$m_barchartnum > 1 ) {
			return;
		}

		// MW 1.17 +
		if ( class_exists( 'ResourceLoader' ) ) {
			$this->loadJavascriptAndCSS();
			return;
		}
		global $wgOut, $srfgJQPlotIncluded;
		global $srfgScriptPath;

		$scripts = array();
		$wgOut->includeJQuery();
	}

	/**
	 * Get the JS and HTML that needs to be added to the output to create the chart.
	 * 
	 * @since 1.7
	 * 
	 * @param array $data label => value
	 */
	protected function getFormatOutput( array $data ) {
		global $wgOut;

		$this->isHTML = true;

		$maxValue = count( $data ) == 0 ? 0 : max( $data );
		
		if ( $this->params['min'] === false ) {
			$minValue = count( $data ) == 0 ? 0 : min( $data );
		}
		else {
			$minValue = $this->params['min'];
		}
		
		foreach ( $data as $i => &$nr ) {
			if ( $this->m_bardirection == 'horizontal' ) {
				$nr = array( $nr, $i );
			}
		}
		
		$treemapID = 'treemap' . self::$m_barchartnum;
		self::$m_barchartnum++;
		
		$labels_str = FormatJson::encode( array_keys( $data ) );
		$numbers_str = FormatJson::encode( array_values( $data ) );
		
		$labels_axis = 'xaxis';
		$numbers_axis = 'yaxis';
		
		$angle_val = -40;
		$barmargin = 6;
		
		if ( $this->m_bardirection == 'horizontal' ) {
			$labels_axis = 'yaxis';
			$numbers_axis = 'xaxis';
			$angle_val = 0;
			$barmargin = 8 ;
		}
		
		$barwidth = 20; // width of each bar
		$bardistance = 4; // distance between two bars

		// Calculate the tick values for the numbers, based on the
		// lowest and highest number. jqPlot has its own option for
		// calculating ticks automatically - "autoscale" - but it
		// currently (September 2010) fails for numbers less than 1,
		// and negative numbers.
		// If both max and min are 0, just escape now.
		if ( $maxValue == 0 && $minValue == 0 ) {
			return null;
		}
		// Make the max and min slightly larger and bigger than the
		// actual max and min, so that the bars don't directly touch
		// the top and bottom of the graph
		if ( $maxValue > 0 ) { $maxValue += .001; }
		if ( $minValue < 0 ) { $minValue -= .001; }
		if ( $maxValue == 0 ) {
			$multipleOf10 = 0;
			$maxAxis = 0;
		} else {
			$multipleOf10 = pow( 10, floor( log( $maxValue, 10 ) ) );
			$maxAxis = ceil( $maxValue / $multipleOf10 ) * $multipleOf10;
		}
		
		if ( $minValue == 0 ) {
			$negativeMultipleOf10 = 0;
			$minAxis = 0;
		} else {
			$negativeMultipleOf10 = -1 * pow( 10, floor( log( $minValue, 10 ) ) );
			$minAxis = ceil( $minValue / $negativeMultipleOf10 ) * $negativeMultipleOf10;
		}
		
		$numbers_ticks = '';
		$biggerMultipleOf10 = max( $multipleOf10, -1 * $negativeMultipleOf10 );
		$lowestTick = floor( $minAxis / $biggerMultipleOf10 + .001 );
		$highestTick = ceil( $maxAxis / $biggerMultipleOf10 - .001 );
		
		for ( $i = $lowestTick; $i <= $highestTick; $i++ ) {
			$numbers_ticks .= ($i * $biggerMultipleOf10) . ', ';
		}

#		$pointlabels = FormatJson::encode( $this->params['pointlabels'] );

		$width = $this->params['width'];
		$height = $this->params['height'];

		
		$js_treemap =<<<END
<script type="text/javascript">
$(document).ready(function() {
//http://dealloc.me/2011/06/24/d3-is-not-a-graphing-library.html
var data, h, max, pb, pl, pr, pt, ticks, version, vis, w, x, y, _ref;
    version = Number(document.location.hash.replace('#', ''));
    data = {$numbers_str};
    _ref = [20, 20, 20, 20], pt = _ref[0], pl = _ref[1], pr = _ref[2], pb = _ref[3];
    w = $width - (pl + pr);
    h = $height - (pt + pb);
    max = d3.max(data);
    x = d3.scale.linear().domain([0, data.length - 1]).range([0, w]);
    y = d3.scale.linear().domain([0, max]).range([h, 0]);
    vis = d3.select('#$treemapID').style('margin', '20px auto').style('width', "" + w + "px").append('svg:svg').attr('width', w + (pl + pr)).attr('height', h + pt + pb).attr('class', 'viz').append('svg:g').attr('transform', "translate(" + pl + "," + pt + ")");
    vis.selectAll('path.line').data([data]).enter().append("svg:path").attr("d", d3.svg.line().x(function(d, i) {
      return x(i);
    }).y(y));
    if (version < 2 && version !== 0) {
      return;
    }
    ticks = vis.selectAll('.ticky').data(y.ticks(7)).enter().append('svg:g').attr('transform', function(d) {
      return "translate(0, " + (y(d)) + ")";
    }).attr('class', 'ticky');
    ticks.append('svg:line').attr('y1', 0).attr('y2', 0).attr('x1', 0).attr('x2', w);
    ticks.append('svg:text').text(function(d) {
      return d;
    }).attr('text-anchor', 'end').attr('dy', 2).attr('dx', -4);
    ticks = vis.selectAll('.tickx').data(x.ticks(data.length)).enter().append('svg:g').attr('transform', function(d, i) {
      return "translate(" + (x(i)) + ", 0)";
    }).attr('class', 'tickx');
    ticks.append('svg:line').attr('y1', h).attr('y2', 0).attr('x1', 0).attr('x2', 0);
    ticks.append('svg:text').text(function(d, i) {
      return i;
    }).attr('y', h).attr('dy', 15).attr('dx', -2);
    if (version < 3 && version !== 0) {
      return;
    }
    return vis.selectAll('.point').data(data).enter().append("svg:circle").attr("class", function(d, i) {
      if (d === max) {
        return 'point max';
      } else {
        return 'point';
      }
    }).attr("r", function(d, i) {
      if (d === max) {
        return 6;
      } else {
        return 4;
      }
    }).attr("cx", function(d, i) {
      return x(i);
    }).attr("cy", function(d) {
      return y(d);
    }).on('mouseover', function() {
      return d3.select(this).attr('r', 8);
    }).on('mouseout', function() {
      return d3.select(this).attr('r', 4);
    }).on('click', function(d, i) {
      return console.log(d, i);
    });
  });
</script>
END;
		$wgOut->addScript( $js_treemap );
				
		return Html::element(
			'div',
			array(
				'id' => $treemapID,
				'style' => Sanitizer::checkCss( "margin-top: 20px; margin-left: 20px; margin-right: 20px; width: {$width}px; height: {$height}px;" )
			)
		);
	}

	/**
	 * @see SMWResultPrinter::getParameters
	 */
	public function getParameters() {
		$params = parent::getParameters();
		
		$params['height'] = new Parameter( 'height', Parameter::TYPE_INTEGER, 400 );
		$params['height']->setMessage( 'srf_paramdesc_chartheight' );
		
		// TODO: this is a string to allow for %, but better handling would be nice
		$params['width'] = new Parameter( 'width', Parameter::TYPE_STRING, '400' );
		$params['width']->setMessage( 'srf_paramdesc_chartwidth' );
		
		$params['charttitle'] = new Parameter( 'charttitle', Parameter::TYPE_STRING, ' ' );
		$params['charttitle']->setMessage( 'srf_paramdesc_charttitle' );
		
		$params['barcolor'] = new Parameter( 'barcolor', Parameter::TYPE_STRING, '#85802b' );
		$params['barcolor']->setMessage( 'srf_paramdesc_barcolor' );
		
		$params['bardirection'] = new Parameter( 'bardirection', Parameter::TYPE_STRING, 'vertical' );
		$params['bardirection']->setMessage( 'srf_paramdesc_bardirection' );
		$params['bardirection']->addCriteria( new CriterionInArray( 'horizontal', 'vertical' ) );
		
		$params['numbersaxislabel'] = new Parameter( 'numbersaxislabel', Parameter::TYPE_STRING, ' ' );
		$params['numbersaxislabel']->setMessage( 'srf_paramdesc_barnumbersaxislabel' );
		
		$params['min'] = new Parameter( 'min', Parameter::TYPE_INTEGER );
		$params['min']->setMessage( 'srf-paramdesc-minvalue' );
		$params['min']->setDefault( false, false );
		
#		$params['pointlabels'] = new Parameter( 'pointlabels', Parameter::TYPE_BOOLEAN, false );
#		$params['pointlabels']->setMessage( 'srf-paramdesc-pointlabels' );
		
		return $params;
	}
	
}
