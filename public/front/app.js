var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

var _this = this;

(function () {
	"use strict";

	if (window.orderFinishNotify) {
		localStorage.clear();
		toastr.success(ofn);
	}

	var orderIncrement = document.getElementById("increment");
	var orderDecrement = document.getElementById("decrement");
	var orderProductBtn = document.getElementById("add-product");
	var productImage = document.getElementById("primary-img");
	var bagIcon = document.getElementById("bag-count");
	var productTitle = document.getElementById("vptitle");
	var productImgs = document.querySelectorAll('.product-view .image-thumb > img');
	var displayPrice = document.getElementById("vpprice");
	var availablePrices = void 0;

	var orderCount = document.getElementById("product-count");
	var sizes = document.querySelectorAll(".p_size");

	var productQty = 1;
	var selectedSizeId = 0;
	var selectedSizeN = ""; //size name
	var selectedPrice = 0;

	var bagCount = localStorage.getItem('bic') ? parseInt(localStorage.getItem('bic')) : 0;
	var guestBag = [];

	function init() {
		//just for mobile nav
		var fixedDiv = document.getElementById("fixed");
		var shade = document.getElementById("shad");
		var mobileNav = document.getElementById("mobile-nav");
		//navButton toggle
		var navO = document.getElementById("nav-o"); // navigation open
		var navc = document.getElementById("nav-cc"); // navigation close

		if (bagCount > 0) bagIcon.innerHTML = bagCount;

		if (localStorage.getItem('gsp')) {
			guestBag = JSON.parse(lbtoa(localStorage.getItem('gsp'))); // guest selected products
		}

		if (document.getElementById("price_list")) {
			availablePrices = document.getElementById("price_list").value.split(',');
		}

		//btn toggle
		navO.addEventListener('click', function () {
			fixedDiv.classList.add('open');
			shade.classList.add('open');
			mobileNav.classList.add('open-mobile-nav');
		});

		navc.addEventListener('click', function () {
			fixedDiv.classList.remove('open');
			shade.classList.remove('open');
			mobileNav.classList.remove('open-mobile-nav');
		});

		productImgs.forEach(function (thumb) {
			thumb.addEventListener('click', function () {
				switchThumbnail(thumb);
			});
		});
	}

	_this.switchThumbnail = function (thumb) {
		//remove previously selected imgs
		productImgs.forEach(function (p) {
			p.classList.remove('selected');
		});
		productImage.setAttribute('src', thumb.getAttribute('src'));
		//current thumb add classlist selected
		thumb.classList.add('selected');
	};

	_this.increment = function () {
		productQty++;
		orderCount.innerHTML = parseInt(productQty);
	};

	_this.selectSize = function (size) {
		selectedSizeId = parseInt(size.getAttribute("data-size"));
		selectedSizeN = size.innerHTML;

		sizes.forEach(function (s) {
			s.classList.remove('selected');
		});

		size.classList.add('selected');

		_this.onSizeSelected(size.getAttribute("data-index"));
	};

	_this.onSizeSelected = function (index) {
		selectedPrice = availablePrices[index];
		displayPrice.innerHTML = "EUR " + availablePrices[index];
	};

	_this.decrement = function () {
		if (productQty == 1) return;
		productQty--;
		orderCount.innerHTML = parseInt(productQty);
	};

	_this.addProduct = function () {
		if (selectedSizeId == 0) {
			return toastr.warning("Ju lutem zgjidhni përmasën e produktit!");
		}
		var imgSrc = productImage.src;

		bagCount++;
		bagIcon.innerHTML = bagCount;
		localStorage.setItem('bic', bagCount);
		guestBag.unshift(_this.populateBag());
		localStorage.setItem('gsp', latob(JSON.stringify(guestBag)));
		return toastr.success("Produkti u shtua ne shportë!");
	};

	_this.populateBag = function () {
		var item = new Object();
		item.uuid = document.getElementById('puid').value;
		item.src = productImage.src;
		item.title = productTitle.innerHTML;
		item.price = parseFloat(selectedPrice);
		item.qty = productQty;
		item.sizeId = selectedSizeId;
		item.sizeName = selectedSizeN;
		return item;
	};

	_this.checkoutSumary = function () {

		var productsSummaryDiv = document.getElementById("products-summary");
		var sum1Div = document.getElementById('sum1');
		var sum2Div = document.getElementById('sum2');
		var submitBtn = document.getElementById('ltd-order'); //finish checkout button
		var products = void 0;
		var orderSum = 0;
		if (bagCount) {
			products = JSON.parse(lbtoa(localStorage.getItem('gsp')));
		}

		if (!products || !products.length) return;
		products.forEach(function (item) {
			orderSum += item.price * item.qty;
			productsSummaryDiv.insertAdjacentHTML('beforeend', _this.checkoutSummaryTemplate(item.title, item.qty, item.price));
		});
		sum1Div.innerHTML = "EUR " + orderSum;
		sum2Div.innerHTML = "EUR " + orderSum;

		var sIds = products.map(function (p) {
			return p.sizeId;
		}).join(','); // size ids
		var uIds = products.map(function (p) {
			return p.uuid;
		}).join(','); // uuids
		var qty = products.map(function (p) {
			return p.qty;
		}).join(','); // quantity

		document.getElementById('psi').value = sIds;
		document.getElementById('pid').value = uIds;
		document.getElementById('pqty').value = qty;
	};

	_this.checkoutSummaryTemplate = function (title, qty, price) {
		return "<li>" + title + "<span> x" + qty + "</span> <span class=\"price\">EUR " + price + "</span></li>";
	};

	_this.orderItemsTemplate = function () {
		var ordersDiv = document.getElementById('odp');
		var sumDiv = document.getElementById('sum');
		var products = void 0;
		var orderSum = 0;
		if (bagCount) {
			products = JSON.parse(lbtoa(localStorage.getItem('gsp')));
		}

		products.forEach(function (item, index) {
			orderSum += item.price * item.qty;
			ordersDiv.insertAdjacentHTML('beforeend', _this.ProductOrderTemplate(item.src, item.title, item.sizeName, item.price, item.qty, index));
		});

		sumDiv.innerHTML = "EUR " + orderSum;
		_this.addCancelEventListener = function () {
			var cancelBtns = document.querySelectorAll(".order-cancel");

			cancelBtns.forEach(function (c) {
				c.addEventListener('click', function () {
					var iremove = parseInt(c.getAttribute('data-pId'));
					//decrase order price
					orderSum -= products[iremove].price * products[iremove].qty;
					orderSum = Math.round(orderSum * 100) / 100;
					sumDiv.innerHTML = "EUR " + orderSum;

					products.splice(iremove, 1);
					localStorage.setItem('gsp', latob(JSON.stringify(products)));
					_this.refreshGuestBag();
					_this.reloadProducts();
				});
			});
		};

		_this.reloadProducts = function () {
			ordersDiv.innerHTML = "";
			products.forEach(function (item, index) {
				ordersDiv.insertAdjacentHTML('beforeend', _this.ProductOrderTemplate(item.src, item.title, item.sizeName, item.price, item.qty, index));
			});
			_this.addCancelEventListener();
		};

		_this.refreshGuestBag = function () {
			//bag localstorage count and icon
			bagCount--;
			localStorage.setItem('bic', bagCount);
			bagIcon.innerHTML = bagCount;
		};

		//call event listener for first time
		_this.addCancelEventListener();
	};

	_this.ProductOrderTemplate = function (img, title, size, price, qty, index) {
		return "\n\t\t<div class=\"order-item flex100\">\n\t\t\t<div class=\"w45 xs-w-100\">\n\t\t\t\t<div class=\"product-title\">\n\t\t\t\t\t<img src=\"" + img + "\" class=\"img-responsive img-thumb\">\n\t\t\t\t\t<div class=\"meta\">\n\t\t\t\t\t\t<div class=\"title\">" + title + "</div>\n\t\t\t\t\t\t<div class=\"p_size\" data-size=\"1\" style=\"width:100px;\">" + size + "</div>\n\t\t\t\t\t\t<!-- <div class=\"color-box\" style=\"background-color: #000;\" data-color=\"1\"></div> -->\n\t\t\t\t\t</div>\n\t\t\t\t</div>\n\t\t\t</div>\n\t\t\t<div class=\"w15 xs-w-75\">\n\t\t\t\t<div class=\"price\"><span class=\"meta visible-xs\">\xC7mimi: </span>EUR " + price + "</div>\n\t\t\t</div>\n\t\t\t<div class=\"w15 xs-w-75\">\n\t\t\t\t<span class=\"meta visible-xs\">Sasia: </span>\n\t\t\t\t<div class=\"quantity\" style=\"display:inline-block;\">\n\t\t\t\t\t<div class=\"count float-none\" style=\"background-color:#fff\"> " + qty + "</div>\n\t\t\t\t\t<div class=\"clearfix\"></div>\n\t\t\t\t</div>\n\t\t\t</div>\n\t\t\t<div class=\"w15 xs-w-75\">\n\t\t\t\t<div class=\"price\"> <span class=\"meta visible-xs\">Totali: </span>EUR " + price * qty + "</div>\n\t\t\t</div>\n\t\t\t<div class=\"order-cancel\" data-pId=\"" + index + "\"><i class=\"fas fa-times\"></i></div>\n\t\t\t<div class=\"clearfix\"></div>\n\t\t</div>";
	};

	function latob(str) {
		var keyStr = "ABCDEFGHIJKLMNOP" + "QRSTUVWXYZabcdef" + "ghijklmnopqrstuv" + "wxyz0123456789+/" + "=";

		str = encodeURI(str);
		var output = "";
		var chr1,
		    chr2,
		    chr3 = "";
		var enc1,
		    enc2,
		    enc3,
		    enc4 = "";
		var i = 0;

		do {
			chr1 = str.charCodeAt(i++);
			chr2 = str.charCodeAt(i++);
			chr3 = str.charCodeAt(i++);

			enc1 = chr1 >> 2;
			enc2 = (chr1 & 3) << 4 | chr2 >> 4;
			enc3 = (chr2 & 15) << 2 | chr3 >> 6;
			enc4 = chr3 & 63;

			if (isNaN(chr2)) {
				enc3 = enc4 = 64;
			} else if (isNaN(chr3)) {
				enc4 = 64;
			}

			output = output + keyStr.charAt(enc1) + keyStr.charAt(enc2) + keyStr.charAt(enc3) + keyStr.charAt(enc4);
			chr1 = chr2 = chr3 = "";
			enc1 = enc2 = enc3 = enc4 = "";
		} while (i < str.length);

		return output;
	}

	function lbtoa(str) {
		var keyStr = "ABCDEFGHIJKLMNOP" + "QRSTUVWXYZabcdef" + "ghijklmnopqrstuv" + "wxyz0123456789+/" + "=";
		var output = "";
		var chr1,
		    chr2,
		    chr3 = "";
		var enc1,
		    enc2,
		    enc3,
		    enc4 = "";
		var i = 0;

		// remove all characters that are not A-Z, a-z, 0-9, +, /, or =
		var base64test = /[^A-Za-z0-9\+\/\=]/g;
		if (base64test.exec(str)) {
			console.log("There were invalid base64 characters in the input text.\n" + "Valid base64 characters are A-Z, a-z, 0-9, '+', '/',and '='\n" + "Expect errors in decoding.");
		}
		str = str.replace(/[^A-Za-z0-9\+\/\=]/g, "");

		do {
			enc1 = keyStr.indexOf(str.charAt(i++));
			enc2 = keyStr.indexOf(str.charAt(i++));
			enc3 = keyStr.indexOf(str.charAt(i++));
			enc4 = keyStr.indexOf(str.charAt(i++));

			chr1 = enc1 << 2 | enc2 >> 4;
			chr2 = (enc2 & 15) << 4 | enc3 >> 2;
			chr3 = (enc3 & 3) << 6 | enc4;

			output = output + String.fromCharCode(chr1);

			if (enc3 != 64) {
				output = output + String.fromCharCode(chr2);
			}
			if (enc4 != 64) {
				output = output + String.fromCharCode(chr3);
			}

			chr1 = chr2 = chr3 = "";
			enc1 = enc2 = enc3 = enc4 = "";
		} while (i < str.length);

		return decodeURI(output);
	}

	init(); // basic functionality

	// if generate order product options
	if (window.genjopt) {
		_this.orderItemsTemplate();
	}
	//if finish checkout order
	if (window.fchojl) {
		_this.checkoutSumary();
	}

	if (orderIncrement && (typeof orderIncrement === "undefined" ? "undefined" : _typeof(orderIncrement)) == "object") {
		orderIncrement.addEventListener('click', _this.increment);
	}
	if (orderDecrement && (typeof orderDecrement === "undefined" ? "undefined" : _typeof(orderDecrement)) == "object") {
		orderDecrement.addEventListener('click', _this.decrement);
	}

	if ((typeof sizes === "undefined" ? "undefined" : _typeof(sizes)) == "object" && sizes.length) {
		sizes.forEach(function (s) {
			s.addEventListener('click', function () {
				return _this.selectSize(s);
			});
		});
	}

	if (orderProductBtn && (typeof orderProductBtn === "undefined" ? "undefined" : _typeof(orderProductBtn)) == "object") {
		orderProductBtn.addEventListener('click', _this.addProduct);
	}
})();