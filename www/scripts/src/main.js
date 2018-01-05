// CSS styles

import 'bootstrap-custom.scss'
import 'font-awesome/scss/font-awesome.scss'
import 'topfix.scss'
import 'main.scss'

// Main App Code

// jQuery

$(function(){

	function afterAjaxInit() {
		
		$(".topfix").topFix();

	};


	// All nette.ajax.js extenensions used in entire app:

	$.nette.ext('bs-modal', {

		init: function() {
			// if the modal has some content, show it when page is loaded
			var $modal = $('#modal');
			if ($modal.find('.modal-content').html().trim().length !== 0) {
				$modal.modal('show');
			}
		},
		success: function (jqXHR, status, settings) {
			
			if (typeof settings.responseJSON.snippets != 'undefined') {
				var $snippet = settings.responseJSON.snippets['snippet--modal'];
			}
			if (!$snippet) {
				return;
			}

			var $modal = $('#modal');
			if ($modal.find('.modal-content').html().trim().length !== 0) {
				$modal.modal('show');
			} else {
				$modal.modal('hide');
			}
		}
	});


	$.nette.ext('spinner', {
		init: function () {

			this.spinner = this.createSpinner();

			afterAjaxInit();

		},
		start: function () {
			var _this = this;
			this.spinning = setTimeout(function () {
				//_this.spinner.fadeIn();
			}, 1000);
			//console.log("create");
		},
		complete: function () {
			clearTimeout(this.spinning);
			//this.spinner.fadeOut();
			//console.log("complete");

			afterAjaxInit();

		}
	}, {
		createSpinner: function () {

			return $(".spinner");
		},
		spinning: null,
		spinner: null
	});



	// Nette ajax init:

	$.nette.init();

});






