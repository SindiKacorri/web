(function() {
	"use strict";
	let defaultHTML;
	let editHTML;

	let availableSizes = modifyFromSizes(productSizes);

	let index = availableSizes.length; // 0 eshte default

	function addNewSizePrice() {
		let toAdd = `
		<div class="sizes-price" data-id="${index}">
			${defaultHTML}
			<div class="actions-div del-spg" data-id="${index}">
				<i class="fa fa-remove text-red pull-right" data-id="${index++}"></i>
			</div>
		</div>`;

		return toAdd;
	}

	function editNewSizePrice(size, i) {
		let toAdd =  editHTML;

		let sizesDropdown = Array.from(toAdd.children[0].children[0].children);
		let sizeIndex;

		sizesDropdown.forEach((q, index) => {
			if(q.getAttribute("value") == size.size_id) {
				sizeIndex = index;
			}
		});

		toAdd.children[0].children[0].children[sizeIndex].setAttribute('selected', true);

		toAdd.children[1].children[0].children[1].setAttribute('value', parseInt(size.first_price));
		if(!!size.hasDiscount) {
			toAdd.children[2].children[0].children[1].setAttribute('value', parseInt(size.second_price));
		}

		let toReturn = `
			<div class="sizes-price" data-id="${i}">
				${toAdd.innerHTML}
				${i > 0 ? `
				<div class="actions-div del-spg" data-id="${i}">
					<i class="fa fa-remove text-red pull-right" data-id="${i}"></i>
				</div>` : ''}
			</div>`;

			toAdd.children[0].children[0].children[sizeIndex].removeAttribute('selected');
			toAdd.children[1].children[0].children[1].setAttribute('value', '');
			toAdd.children[2].children[0].children[1].setAttribute('value', '');

			return toReturn;
		}

	function modifyFromSizes(data) {
		let toReturn = [];
		data.forEach(q => {
			let temp = {};
			temp.size_id = q.pivot.size_id;
			temp.hasDiscount = q.pivot.has_discount;
			temp.first_price = q.pivot.price;
			temp.second_price = q.pivot.second_price;

			toReturn.unshift(temp);
		});

		return toReturn;
	}

	function refreshEventListeners() {
		let deleteBtnGroup = document.querySelectorAll('.del-spg');

		if(deleteBtnGroup.length) {
			deleteBtnGroup.forEach(q => q.addEventListener("click", deleteSzGroup));
		}
	}

	function deleteSzGroup(e) {
		var el = document.getElementById('spg');

		if(el) {
			let toRemoveElements = document.querySelectorAll('.sizes-price');
			if(toRemoveElements.length) {
				toRemoveElements.forEach(q => {
					if(typeof q.dataset.id !== "undefined" && q.dataset.id == e.target.dataset.id) {
						el.removeChild(el.children[e.target.dataset.id]);
						index--;
					}
				});
			}

			for(var i = 1; i< el.children.length; i++) {
				el.children[i].dataset.id = i;
				if(el.children[i].childElementCount) {
					el.children[i].children[3].dataset.id = i;
					el.children[i].children[3].children[0].dataset.id = i;
				}
			}
		}
	}

	document.addEventListener("DOMContentLoaded", () => {
		var el = document.getElementById('spg');
		if(el) {
			defaultHTML = el.children[0].innerHTML;

			var tmp = document.createElement('body');
			tmp.innerHTML = defaultHTML;

			//defaultHTML = el;
			editHTML = tmp;
		}
		el.innerHTML = '';

		availableSizes.forEach((size, index) => {
			el.insertAdjacentHTML('beforeend', editNewSizePrice(size, index));
		});
		refreshEventListeners();

		// register events
		document.getElementById("add-spg").addEventListener("click", () => {
			el.insertAdjacentHTML('beforeend', addNewSizePrice());
			refreshEventListeners();
		});
	});
})();