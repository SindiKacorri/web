var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

(function () {
	"use strict";

	var categories = document.querySelectorAll('.s-categories > li');
	var sizes = document.querySelectorAll('.options.sizes > div');
	var searchButton = document.getElementById('c_s');
	var clearButton = document.getElementById('c_s_c');

	var selectedCategory = void 0;
	var selectedSize = void 0;

	function init() {
		var currentUrl = new URL(window.location);
		var currentCategory = currentUrl.searchParams.get("category_id");
		var currentSize = currentUrl.searchParams.get("size_id");

		if (categories && (typeof categories === 'undefined' ? 'undefined' : _typeof(categories)) == "object") {
			categories.forEach(function (q) {
				if (currentCategory && q.dataset.id == currentCategory) {
					q.classList.add('selected');
				}
				q.addEventListener('click', function () {
					return selectCategory(q);
				});
			});
		}

		if (sizes && (typeof sizes === 'undefined' ? 'undefined' : _typeof(sizes)) == "object") {
			sizes.forEach(function (q) {
				if (currentSize && q.dataset.id == currentSize) {
					q.classList.add('selected');
				}
				q.addEventListener('click', function () {
					return selectSize(q);
				});
			});
		}

		if (searchButton && (typeof searchButton === 'undefined' ? 'undefined' : _typeof(searchButton)) == "object") {
			searchButton.addEventListener('click', function () {
				return filterProducts();
			});
		}

		if (clearButton && (typeof clearButton === 'undefined' ? 'undefined' : _typeof(clearButton)) == "object") {
			clearButton.addEventListener('click', function () {
				return clearFilters();
			});
		}
	}

	function clearFilters() {
		window.location.href = '?';
	}

	function filterProducts() {
		var toGo = new URL(window.location);

		if (selectedCategory && typeof selectedCategory != "undefined") {
			toGo.searchParams.set("category_id", selectedCategory.toString());
		}

		if (selectedSize && typeof selectedSize != "undefined") {
			toGo.searchParams.set("size_id", selectedSize.toString());
		}

		window.location.href = toGo.href;
	}

	function selectCategory(category) {
		categories.forEach(function (p) {
			p.classList.remove('selected');
		});

		selectedCategory = category.dataset.id;
		category.classList.add('selected');
	}

	function selectSize(size) {
		sizes.forEach(function (p) {
			p.classList.remove('selected');
		});

		selectedSize = size.dataset.id;

		size.classList.add('selected');
	}

	init();
})();