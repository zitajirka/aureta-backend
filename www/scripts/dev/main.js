webpackJsonp([ 1 ], [ , , , , , , , , , function(module, exports) {}, function(module, exports) {}, function(module, exports) {}, function(module, exports) {}, , function(module, exports, __webpack_require__) {
    "use strict";
    (function($) {
        __webpack_require__(10);
        __webpack_require__(9);
        __webpack_require__(12);
        __webpack_require__(11);
        $(function() {
            function afterAjaxInit() {
                $(".topfix").topFix();
            }
            $.nette.ext("bs-modal", {
                init: function init() {
                    var $modal = $("#modal");
                    if ($modal.find(".modal-content").html().trim().length !== 0) {
                        $modal.modal("show");
                    }
                },
                success: function success(jqXHR, status, settings) {
                    if (typeof settings.responseJSON.snippets != "undefined") {
                        var $snippet = settings.responseJSON.snippets["snippet--modal"];
                    }
                    if (!$snippet) {
                        return;
                    }
                    var $modal = $("#modal");
                    if ($modal.find(".modal-content").html().trim().length !== 0) {
                        $modal.modal("show");
                    } else {
                        $modal.modal("hide");
                    }
                }
            });
            $.nette.ext("spinner", {
                init: function init() {
                    this.spinner = this.createSpinner();
                    afterAjaxInit();
                },
                start: function start() {
                    var _this = this;
                    this.spinning = setTimeout(function() {}, 1e3);
                },
                complete: function complete() {
                    clearTimeout(this.spinning);
                    afterAjaxInit();
                }
            }, {
                createSpinner: function createSpinner() {
                    return $(".spinner");
                },
                spinning: null,
                spinner: null
            });
            $.nette.init();
        });
    }).call(exports, __webpack_require__(0));
} ], [ 14 ]);