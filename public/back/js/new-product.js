(function () {
	"use strict";

	var defaultHTML = void 0;
	var index = 1; // 0 eshte default

	function addNewSizePrice() {
		var toAdd = "\n\t\t<div class=\"sizes-price\" data-id=\"" + index + "\">\n\t\t\t" + defaultHTML + "\n\t\t\t<div class=\"actions-div del-spg\" data-id=\"" + index + "\">\n\t\t\t\t<i class=\"fa fa-remove text-red pull-right\" data-id=\"" + index++ + "\"></i>\n\t\t\t</div>\n\t\t</div>";

		return toAdd;
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
						console.log(index);
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

		//console.log(e.target.dataset);
	}

	document.addEventListener("DOMContentLoaded", function () {
		var el = document.getElementById('spg');
		if (el) {
			defaultHTML = el.children[0].innerHTML;
		}

		// register events
		document.getElementById("add-spg").addEventListener("click", function () {
			el.insertAdjacentHTML('beforeend', addNewSizePrice());
			refreshEventListeners();
		});
	});
})();