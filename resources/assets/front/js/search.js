(function() {
	"use strict";

	let categories = document.querySelectorAll('.s-categories > li');
	let sizes = document.querySelectorAll('.options.sizes > div');
	let searchButton = document.getElementById('c_s');
	let clearButton = document.getElementById('c_s_c')

	let selectedCategory;
	let selectedSize;


	function init() {
		let currentUrl = new URL(window.location);
		let currentCategory = currentUrl.searchParams.get("category_id");
		let currentSize = currentUrl.searchParams.get("size_id");

		if(categories && typeof categories == "object") {
			categories.forEach(q => {
				if(currentCategory && q.dataset.id == currentCategory) {
					q.classList.add('selected');
				}
				q.addEventListener('click', () => selectCategory(q));
			});
		}

		if(sizes && typeof sizes == "object") {
			sizes.forEach(q => {
				if(currentSize && q.dataset.id == currentSize) {
					q.classList.add('selected');
				}
				q.addEventListener('click', () => selectSize(q));
			});
		}

		if(searchButton && typeof searchButton == "object") {
			searchButton.addEventListener('click', () => filterProducts());
		}

		if(clearButton && typeof clearButton == "object") {
			clearButton.addEventListener('click', () => clearFilters());
		}

	}

	function clearFilters() {
		window.location.href = '?';
	}

	function filterProducts() {
		var toGo = new URL(window.location);

		if(selectedCategory && typeof selectedCategory != "undefined") {
			toGo.searchParams.set("category_id", selectedCategory.toString());
		}

		if(selectedSize && typeof selectedSize != "undefined") {
			toGo.searchParams.set("size_id", selectedSize.toString());
		}

		window.location.href = toGo.href;

	}

	function selectCategory (category) {
		categories.forEach(p => {
			p.classList.remove('selected');
		});

		selectedCategory = category.dataset.id;
		category.classList.add('selected');
	}

	function selectSize(size) {
		sizes.forEach(p => {
			p.classList.remove('selected');
		});

		selectedSize = size.dataset.id;

		size.classList.add('selected');
	}

	init();
})();