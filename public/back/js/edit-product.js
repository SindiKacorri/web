(function () {
	"use strict";

	var defaultHTML = void 0;
	var editHTML = void 0;

	var availableSizes = modifyFromSizes(productSizes);

	var index = availableSizes.length; // 0 eshte default

	function addNewSizePrice() {
		var toAdd = "\n\t\t<div class=\"sizes-price\" data-id=\"" + index + "\">\n\t\t\t" + defaultHTML + "\n\t\t\t<div class=\"actions-div del-spg\" data-id=\"" + index + "\">\n\t\t\t\t<i class=\"fa fa-remove text-red pull-right\" data-id=\"" + index++ + "\"></i>\n\t\t\t</div>\n\t\t</div>";

		return toAdd;
	}

	function editNewSizePrice(size, i) {
		var toAdd = editHTML;

		var sizesDropdown = Array.from(toAdd.children[0].children[0].children);
		var sizeIndex = void 0;

		sizesDropdown.forEach(function (q, index) {
			if (q.getAttribute("value") == size.size_id) {
				sizeIndex = index;
			}
		});

		toAdd.children[0].children[0].children[sizeIndex].setAttribute('selected', true);

		toAdd.children[1].children[0].children[1].setAttribute('value', parseInt(size.first_price));
		if (!!size.hasDiscount) {
			toAdd.children[2].children[0].children[1].setAttribute('value', parseInt(size.second_price));
		}

		var toReturn = "\n\t\t\t<div class=\"sizes-price\" data-id=\"" + i + "\">\n\t\t\t\t" + toAdd.innerHTML + "\n\t\t\t\t" + (i > 0 ? "\n\t\t\t\t<div class=\"actions-div del-spg\" data-id=\"" + i + "\">\n\t\t\t\t\t<i class=\"fa fa-remove text-red pull-right\" data-id=\"" + i + "\"></i>\n\t\t\t\t</div>" : '') + "\n\t\t\t</div>";

		toAdd.children[0].children[0].children[sizeIndex].removeAttribute('selected');
		toAdd.children[1].children[0].children[1].setAttribute('value', '');
		toAdd.children[2].children[0].children[1].setAttribute('value', '');

		return toReturn;
	}

	function modifyFromSizes(data) {
		var toReturn = [];
		data.forEach(function (q) {
			var temp = {};
			temp.size_id = q.pivot.size_id;
			temp.hasDiscount = q.pivot.has_discount;
			temp.first_price = q.pivot.price;
			temp.second_price = q.pivot.second_price;

			toReturn.unshift(temp);
		});

		return toReturn;
	}

	function refreshEventListeners() {
		var deleteBtnGroup = document.querySelectorAll('.del-spg');

		if (deleteBtnGroup.length) {
			deleteBtnGroup.forEach(function (q) {
				return q.addEventListener("click", deleteSzGroup);
			});
		}
	}

	function deleteSzGroup(e) {
		var el = document.getElementById('spg');

		if (el) {
			var toRemoveElements = document.querySelectorAll('.sizes-price');
			if (toRemoveElements.length) {
				toRemoveElements.forEach(function (q) {
					if (typeof q.dataset.id !== "undefined" && q.dataset.id == e.target.dataset.id) {
						el.removeChild(el.children[e.target.dataset.id]);
						index--;
					}
				});
			}

			for (var i = 1; i < el.children.length; i++) {
				el.children[i].dataset.id = i;
				if (el.children[i].childElementCount) {
					el.children[i].children[3].dataset.id = i;
					el.children[i].children[3].children[0].dataset.id = i;
				}
			}
		}
	}

	document.addEventListener("DOMContentLoaded", function () {
		var el = document.getElementById('spg');
		if (el) {
			defaultHTML = el.children[0].innerHTML;

			var tmp = document.createElement('body');
			tmp.innerHTML = defaultHTML;

			//defaultHTML = el;
			editHTML = tmp;
		}
		el.innerHTML = '';

		availableSizes.forEach(function (size, index) {
			el.insertAdjacentHTML('beforeend', editNewSizePrice(size, index));
		});
		refreshEventListeners();

		// register events
		document.getElementById("add-spg").addEventListener("click", function () {
			el.insertAdjacentHTML('beforeend', addNewSizePrice());
			refreshEventListeners();
		});
	});
})();