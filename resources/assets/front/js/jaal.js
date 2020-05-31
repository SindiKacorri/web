(() => {
	"use strict";

	if(window.orderFinishNotify){
		localStorage.clear();
		toastr.success(ofn);
	}

	let orderIncrement = document.getElementById("increment");
	let orderDecrement = document.getElementById("decrement");
	let orderProductBtn = document.getElementById("add-product");
	let productImage = document.getElementById("primary-img");
	let bagIcon = document.getElementById("bag-count");
	let productTitle = document.getElementById("vptitle");
	let productImgs = document.querySelectorAll('.product-view .image-thumb > img');
	let displayPrice = document.getElementById("vpprice");
	let availablePrices;

	let orderCount = document.getElementById("product-count");
	let sizes = document.querySelectorAll(".p_size");

	let productQty = 1;
	let selectedSizeId = 0;
	let selectedSizeN = ""; //size name
	let selectedPrice = 0;

	let bagCount = localStorage.getItem('bic') ? parseInt(localStorage.getItem('bic')) : 0;
	let guestBag = [];

	function init(){
		//just for mobile nav
		let fixedDiv = document.getElementById("fixed");
		let shade = document.getElementById("shad");
		let mobileNav = document.getElementById("mobile-nav");
		//navButton toggle
		let navO = document.getElementById("nav-o"); // navigation open
		let navc = document.getElementById("nav-cc"); // navigation close

		if(bagCount > 0) bagIcon.innerHTML = bagCount;

		if(localStorage.getItem('gsp')){
			guestBag = JSON.parse(lbtoa(localStorage.getItem('gsp'))); // guest selected products
		}

		if(document.getElementById("price_list")) {
			availablePrices = document.getElementById("price_list").value.split(',');
		}

		//btn toggle
		navO.addEventListener('click', () => {
				fixedDiv.classList.add('open');
				shade.classList.add('open');
				mobileNav.classList.add('open-mobile-nav');
		});

		navc.addEventListener('click', () => {
			fixedDiv.classList.remove('open');
			shade.classList.remove('open');
			mobileNav.classList.remove('open-mobile-nav');
		});

		productImgs.forEach((thumb) => {
			thumb.addEventListener('click', () => {
				switchThumbnail(thumb);
			});
		});
	}

	this.switchThumbnail = (thumb) => {
		//remove previously selected imgs
		productImgs.forEach(p => {
			p.classList.remove('selected');
		});
		productImage.setAttribute('src', thumb.getAttribute('src'));
		//current thumb add classlist selected
		thumb.classList.add('selected');
	}

	this.increment = () => {
		productQty++;
		orderCount.innerHTML = parseInt(productQty);
	}

	this.selectSize = (size) => {
		selectedSizeId = parseInt(size.getAttribute("data-size"));
		selectedSizeN = size.innerHTML;

		sizes.forEach(s => {
			s.classList.remove('selected');
		});

		size.classList.add('selected');

		this.onSizeSelected(size.getAttribute("data-index"));
	}

	this.onSizeSelected = (index) => {
		selectedPrice = availablePrices[index];
		displayPrice.innerHTML = `EUR ${availablePrices[index]}`;
	}

	this.decrement = () => {
		if(productQty == 1) return;
		productQty--;
		orderCount.innerHTML = parseInt(productQty);
	}

	this.addProduct = () => {
		if(selectedSizeId == 0){
			return toastr.warning("Ju lutem zgjidhni përmasën e produktit!");
		}
		let imgSrc = productImage.src;

		bagCount++;
		bagIcon.innerHTML = bagCount;
		localStorage.setItem('bic', bagCount);
		guestBag.unshift(this.populateBag());
		localStorage.setItem('gsp', latob(JSON.stringify(guestBag)));
		return toastr.success("Produkti u shtua ne shportë!")
	}

	this.populateBag = () =>{
		let item = new Object();
		item.uuid = document.getElementById('puid').value;
		item.src = productImage.src;
		item.title = productTitle.innerHTML;
		item.price = parseFloat(selectedPrice);
		item.qty = productQty;
		item.sizeId = selectedSizeId;
		item.sizeName = selectedSizeN;
		return item;
	}

	this.checkoutSumary = () => {

		let productsSummaryDiv = document.getElementById("products-summary");
		let sum1Div = document.getElementById('sum1');
		let sum2Div = document.getElementById('sum2');
		let submitBtn = document.getElementById('ltd-order'); //finish checkout button
		let products;
		let orderSum = 0;
		if(bagCount){
			products = JSON.parse(lbtoa(localStorage.getItem('gsp')))
		}

		if(!products || !products.length) return;
		products.forEach(item => {
			orderSum += item.price * item.qty;
			productsSummaryDiv.insertAdjacentHTML('beforeend', this.checkoutSummaryTemplate(item.title, item.qty, item.price))
		});
		sum1Div.innerHTML = `EUR ${orderSum}`;
		sum2Div.innerHTML = `EUR ${orderSum}`;

		let sIds = products.map(p => p.sizeId).join(','); // size ids
		let uIds = products.map(p => p.uuid).join(',');   // uuids
		let qty = products.map(p => p.qty).join(',');     // quantity

		document.getElementById('psi').value = sIds;
		document.getElementById('pid').value = uIds;
		document.getElementById('pqty').value = qty;
	}

	this.checkoutSummaryTemplate = (title, qty, price) => {
		return `<li>${title}<span> x${qty}</span> <span class="price">EUR ${price}</span></li>`;
	}

	this.orderItemsTemplate = () => {
		let ordersDiv = document.getElementById('odp');
		let sumDiv = document.getElementById('sum');
		let products;
		let orderSum = 0;
		if(bagCount){
			products = JSON.parse(lbtoa(localStorage.getItem('gsp')))
		}

		products.forEach((item, index) => {
			orderSum += item.price * item.qty;
			ordersDiv.insertAdjacentHTML('beforeend', this.ProductOrderTemplate(item.src, item.title, item.sizeName, item.price, item.qty, index));
		});

		sumDiv.innerHTML = `EUR ${orderSum}`;
		this.addCancelEventListener = () => {
			let cancelBtns = document.querySelectorAll(".order-cancel");

			cancelBtns.forEach(c => {
				c.addEventListener('click', () => {
					let iremove = parseInt(c.getAttribute('data-pId'));
					//decrase order price
					orderSum -= products[iremove].price * products[iremove].qty;
					orderSum = Math.round(orderSum * 100) / 100;
					sumDiv.innerHTML = `EUR ${orderSum}`;

					products.splice(iremove,1);
					localStorage.setItem('gsp', latob(JSON.stringify(products)));
					this.refreshGuestBag();
					this.reloadProducts();
				});
			});
		}

		this.reloadProducts = () => {
			ordersDiv.innerHTML = "";
			products.forEach((item, index) => {
				ordersDiv.insertAdjacentHTML('beforeend', this.ProductOrderTemplate(item.src, item.title, item.sizeName, item.price, item.qty, index));
			});
			this.addCancelEventListener();
		}

		this.refreshGuestBag = () => {
			//bag localstorage count and icon
			bagCount--;
			localStorage.setItem('bic', bagCount);
			bagIcon.innerHTML = bagCount;
		}

		//call event listener for first time
		this.addCancelEventListener();
	}

	this.ProductOrderTemplate = (img, title, size, price, qty, index) =>{
		return `
		<div class="order-item flex100">
			<div class="w45 xs-w-100">
				<div class="product-title">
					<img src="${img}" class="img-responsive img-thumb">
					<div class="meta">
						<div class="title">${title}</div>
						<div class="p_size" data-size="1" style="width:100px;">${size}</div>
						<!-- <div class="color-box" style="background-color: #000;" data-color="1"></div> -->
					</div>
				</div>
			</div>
			<div class="w15 xs-w-75">
				<div class="price"><span class="meta visible-xs">Çmimi: </span>EUR ${price}</div>
			</div>
			<div class="w15 xs-w-75">
				<span class="meta visible-xs">Sasia: </span>
				<div class="quantity" style="display:inline-block;">
					<div class="count float-none" style="background-color:#fff"> ${qty}</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="w15 xs-w-75">
				<div class="price"> <span class="meta visible-xs">Totali: </span>EUR ${price * qty}</div>
			</div>
			<div class="order-cancel" data-pId="${index}"><i class="fas fa-times"></i></div>
			<div class="clearfix"></div>
		</div>`;
	}

	function latob(str) {
		var keyStr = "ABCDEFGHIJKLMNOP" +
		"QRSTUVWXYZabcdef" +
		"ghijklmnopqrstuv" +
		"wxyz0123456789+/" +
		"=";

		str = encodeURI(str);
		var output = "";
		var chr1, chr2, chr3 = "";
		var enc1, enc2, enc3, enc4 = "";
		var i = 0;

		do {
			chr1 = str.charCodeAt(i++);
			chr2 = str.charCodeAt(i++);
			chr3 = str.charCodeAt(i++);

			enc1 = chr1 >> 2;
			enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
			enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
			enc4 = chr3 & 63;

			if (isNaN(chr2)) {
				enc3 = enc4 = 64;
			} else if (isNaN(chr3)) {
				enc4 = 64;
			}

			output = output +
				keyStr.charAt(enc1) +
				keyStr.charAt(enc2) +
				keyStr.charAt(enc3) +
				keyStr.charAt(enc4);
			chr1 = chr2 = chr3 = "";
			enc1 = enc2 = enc3 = enc4 = "";
		} while (i < str.length);

		return output;
	}

	function lbtoa(str){
		var keyStr = "ABCDEFGHIJKLMNOP" +
		"QRSTUVWXYZabcdef" +
		"ghijklmnopqrstuv" +
		"wxyz0123456789+/" +
		"=";
		var output = "";
		var chr1, chr2, chr3 = "";
		var enc1, enc2, enc3, enc4 = "";
		var i = 0;

		// remove all characters that are not A-Z, a-z, 0-9, +, /, or =
		var base64test = /[^A-Za-z0-9\+\/\=]/g;
		if (base64test.exec(str)) {
			console.log("There were invalid base64 characters in the input text.\n" +
					"Valid base64 characters are A-Z, a-z, 0-9, '+', '/',and '='\n" +
					"Expect errors in decoding.");
		}
		str = str.replace(/[^A-Za-z0-9\+\/\=]/g, "");

		do {
			enc1 = keyStr.indexOf(str.charAt(i++));
			enc2 = keyStr.indexOf(str.charAt(i++));
			enc3 = keyStr.indexOf(str.charAt(i++));
			enc4 = keyStr.indexOf(str.charAt(i++));

			chr1 = (enc1 << 2) | (enc2 >> 4);
			chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
			chr3 = ((enc3 & 3) << 6) | enc4;

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
	if(window.genjopt){
		this.orderItemsTemplate();
	}
	//if finish checkout order
	if(window.fchojl){
		this.checkoutSumary();
	}

	if(orderIncrement && typeof orderIncrement == "object"){
		orderIncrement.addEventListener('click', this.increment);
	}
	if(orderDecrement && typeof orderDecrement == "object"){
		orderDecrement.addEventListener('click', this.decrement);
	}

	if(typeof sizes == "object" && sizes.length){
		sizes.forEach(s => {
			s.addEventListener('click', () => this.selectSize(s));
		})
	}

	if(orderProductBtn && typeof orderProductBtn == "object"){
		orderProductBtn.addEventListener('click', this.addProduct);
	}
})();