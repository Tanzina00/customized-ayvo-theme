;(function ($) {
    "use strict";

    $.fn.ayvo_fullpage_scroll = function () {
        var _this = $(this);
        _this.on('ayvo_fullpage_scroll', function () {
            var _top = $('#header').outerHeight();
            $(this).fullpage({
                //fixedElements: '#header',
                navigation:true,
                scrollOverflow:true,
                responsiveWidth: 1200,
                //paddingTop: _top
            });
        }).trigger('ayvo_fullpage_scroll');
    };
    window.addEventListener('load',
        function (ev) {
            if ( $('#fullpage').length ) {
                $('#fullpage').ayvo_fullpage_scroll();
            }
        }, false);
})(window.jQuery);