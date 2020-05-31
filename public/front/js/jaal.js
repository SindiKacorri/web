(function(){
	"use strict";

	$(document).ready(function(){
		initMainSlider();
		initStaffSlider();
	});

	function initMainSlider(){
		const showcase = $('#owl1');
		showcase.owlCarousel({
			items:1,
			dots:true,
			autoplay: true,
			autoplayTimeout: 3500,
			loop: true
		});
	}

	function initStaffSlider(){
		const staffPicks = $('#owl2');
		staffPicks.owlCarousel({
			items:4,
			margin: 20,
			nav:true,
			autoplay: true,
			autoplayTimeout: 2500,
			loop: true,
			dots:false,
			navText:["<div class='slider-nav'><img src='/src/nav/left-chevron.svg' /></div>","<div class='slider-nav'><img src='/src/nav/right-chevron.svg' /></div>"],
			responsive: {
				0: {
					nav:false,
					items:1
				},
				768: {
					items: 2
				},
				992: {
					items:4
				}
			}
		});
	}
})();
