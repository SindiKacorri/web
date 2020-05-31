!function ($) {

	"use strict";

	// Global Onyx object
	var Onyx = Onyx || {};

	var images = document.getElementById("img_paths");
	var ids = [];


	Onyx = {

		/**
		* Fire all functions
		*/
		init: function() {
			var self = this,
			obj;

			for (obj in self) {
				if ( self.hasOwnProperty(obj)) {
					var _method =  self[obj];
					if ( _method.selector !== undefined && _method.init !== undefined ) {
						if ( $(_method.selector).length > 0 ) {
							_method.init();
						}
					}
				}
			}
		},


		/**
		* Files upload
		*/
		userFilesDropzone: {
			selector: 'div.dropzone',
			init: function() {
				var base = this,
				container = $(base.selector);

				base.initFileUploader(base, 'div.dropzone');
			},
			initFileUploader: function(base, target) {
				var previewNode = document.querySelector("#onyx-dropzone-template");

				previewNode.id = "";

				var previewTemplate = previewNode.parentNode.innerHTML;
				previewNode.parentNode.removeChild(previewNode);

				var onyxDropzone = new Dropzone(target, {
					url: ($(target).attr("data-back")) ? $(target).attr("data-back") : null, // Check that our form has an action attr and if not, set one here
					maxFiles: 15,
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					maxFilesize: 20,
					acceptedFiles: "image/*,application/pdf,.doc,.docx,.xls,.xlsx,.csv,.tsv,.ppt,.pptx,.pages,.odt,.rtf",
					previewTemplate: previewTemplate,
					previewsContainer: "#previews",
					clickable: true,

					createImageThumbnails: true,

					/**
					* The text used before any files are dropped.
					*/
					dictDefaultMessage: "Drop files here to upload.", // Default: Drop files here to upload

					/**
					* The text that replaces the default message text it the browser is not supported.
					*/
					dictFallbackMessage: "Your browser does not support drag'n'drop file uploads.", // Default: Your browser does not support drag'n'drop file uploads.

					/**
					* If the filesize is too big.
					* `{{filesize}}` and `{{maxFilesize}}` will be replaced with the respective configuration values.
					*/
					dictFileTooBig: "File is too big ({{filesize}}MiB). Max filesize: {{maxFilesize}}MiB.", // Default: File is too big ({{filesize}}MiB). Max filesize: {{maxFilesize}}MiB.

					/**
					* If the file doesn't match the file type.
					*/
					dictInvalidFileType: "You can't upload files of this type.", // Default: You can't upload files of this type.

					/**
					* If the server response was invalid.
					* `{{statusCode}}` will be replaced with the servers status code.
					*/
					dictResponseError: "Server responded with {{statusCode}} code.", // Default: Server responded with {{statusCode}} code.

					/**
					* If `addRemoveLinks` is true, the text to be used for the cancel upload link.
					*/
					dictCancelUpload: "Cancel upload.", // Default: Cancel upload

					/**
					* The text that is displayed if an upload was manually canceled
					*/
					dictUploadCanceled: "Upload canceled.", // Default: Upload canceled.

					/**
					* If `addRemoveLinks` is true, the text to be used for confirmation when cancelling upload.
					*/
					dictCancelUploadConfirmation: "Are you sure you want to cancel this upload?", // Default: Are you sure you want to cancel this upload?

					/**
					* If `addRemoveLinks` is true, the text to be used to remove a file.
					*/
					dictRemoveFile: "Remove file", // Default: Remove file

					/**
					* If this is not null, then the user will be prompted before removing a file.
					*/
					dictRemoveFileConfirmation: null, // Default: null

					/**
					* Displayed if `maxFiles` is st and exceeded.
					* The string `{{maxFiles}}` will be replaced by the configuration value.
					*/
					dictMaxFilesExceeded: "You can not upload any more files.", // Default: You can not upload any more files.

					/**
					* Allows you to translate the different units. Starting with `tb` for terabytes and going down to
					* `b` for bytes.
					*/
					dictFileSizeUnits: {tb: "TB", gb: "GB", mb: "MB", kb: "KB", b: "b"},

				});

				Dropzone.autoDiscover = false;

				onyxDropzone.on("addedfile", function(file) {
					$('.preview-container').css('visibility', 'visible');
					file.previewElement.classList.add('type-' + base.fileType(file.name)); // Add type class for this element's preview
				});

				onyxDropzone.on("totaluploadprogress", function (progress) {
					debugger;
					var progr = document.querySelectorAll(".dz-progress > .dz-upload");

					if (progr === undefined || progr === null) return;

					progr.forEach( bar => {
						bar.style.width = progress + "%";
					});
				});

				onyxDropzone.on('dragenter', function () {
					$(target).addClass("hover");
				});

				onyxDropzone.on('dragleave', function () {
					$(target).removeClass("hover");
				});

				onyxDropzone.on('drop', function () {
					$(target).removeClass("hover");
				});

				onyxDropzone.on('addedfile', function () {

					// Remove no files notice
					$(".no-files-uploaded").slideUp("easeInExpo");

				});

				onyxDropzone.on('removedfile', function (file) {
					debugger;
					$.ajax({
						type: "POST",
						url: ($(target).attr("data-back")) ? $(target).attr("data-back") : null,
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						data: {
							back_id: file.back_id,
							delete_file: 1
						},
						success: function(response){
							var pingu = ids.indexOf(parseInt(response.id));

							if(pingu > -1){
								ids.splice(pingu, 1);
								images.value = ids;
							}

							toastr.success("Fotoja u fshi!");
						}
					});

					// Show no files notice
					if ( base.dropzoneCount() == 0 ) {
						$(".no-files-uploaded").slideDown("easeInExpo");
						$(".uploaded-files-count").html(base.dropzoneCount());
					}

				});

				onyxDropzone.on("success", function(file, response) {
					file.back_id = response.id;
					ids.push(response.id);
					images.value = ids;

					// Make it wait a little bit to take the new element
					setTimeout(function(){
						$(".uploaded-files-count").html(base.dropzoneCount());
						toastr.success("Fotoja u ruajt me sukses!");
					}, 350);

					onyxDropzone.emit("complete", file);
					// Something to happen when file is uploaded

				});

				if(typeof productImages !== "undefined" && productImages.length) {
					ids = productImages.map(q => q.id);
					images.value = ids;
					productImages.forEach(img => {
						var mockFile = {"name": img.path, "back_id": img.id};
						onyxDropzone.emit("addedfile", mockFile);
						onyxDropzone.emit("thumbnail", mockFile, "/front/products/images/" + img.path);
						onyxDropzone.emit("totaluploadprogress", 100);
					});
					$(".uploaded-files-count").html(productImages.length);
				}
				window.onyxDropzone = onyxDropzone;
			},
			dropzoneCount: function() {
				var filesCount = $("#previews > .dz-success.dz-complete").length;
				return filesCount;
			},
			fileType: function(fileName) {
				var fileType = (/[.]/.exec(fileName)) ? /[^.]+$/.exec(fileName) : undefined;
				return fileType[0];
			}
		}
	}

	$(document).ready(function() {

		Onyx.init();

	});

}(jQuery);

