window.stars = [];
$( function() {
	$('div.tam-star ul').css('list-style','none');
	$('div.tam-star').each( function() {
		$(this).css('width','400px').css('height','400px').css('background','yellow');
		$('a', this).each( function() {

			// Initialise the <a> element
			var e = $(this);
			e.css('position','absolute').css('background','pink').css('padding','0 5px');

			// Get the depth of this element
			var li = e.parent();
			var d = 0;
			while( li[0].tagName == 'LI' ) {
				li = li.parent().parent();
				d++;
			}

			// Get the parent <a> or <div>
			var p = e.parent().parent().parent();
			if( d > 1 ) p = p.children().first();

			// Create a unique ID and persistent data for this element
			e.attr('id', 'starnode' + window.stars.length);
			window.stars.push( { parent: p, depth: d } );

			// Animate the element from the parent to the circumference
			var r = 120;
			if( d == 2 ) r = 70;
			if( d == 3 ) r = 30;
			e.animate( { foo: r }, {
				duration: 1000,
				easing: 'swing',
				step: function(now, fx) {
					var e = $(fx.elem);
					var p = window.stars[e.attr('id').substr(8)].parent;
					var ox = p.position().left + p.width() / 2;
					var oy = p.position().top + p.height() / 2;
					var i = e.parent().index();
					var n = e.parent().parent().children().last().index() + 1;
					var a = Math.PI * 2 * i / n;
					var y = Math.sin(a) * now;
					var x = Math.cos(a) * now;
					e.css('left', ox + x - e.width() / 2).css('top', oy + y - e.height() / 2);
				}
			});
		})
	});
});
