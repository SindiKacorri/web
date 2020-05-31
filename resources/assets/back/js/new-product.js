(function() {
	"use strict";
	let defaultHTML;
	let index = 1; // 0 eshte default

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
						console.log(index);
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

		//console.log(e.target.dataset);
	}

	document.addEventListener("DOMContentLoaded", () => {
		var el = document.getElementById('spg');
		if(el) {
			defaultHTML = el.children[0].innerHTML;
		}

		// register events
		document.getElementById("add-spg").addEventListener("click", () => {
			el.insertAdjacentHTML('beforeend', addNewSizePrice());
			refreshEventListeners();
		});
	});
})();