;(function ($) {
    "use strict";

    function ayvo_cols($masonry) {
        var r = 1,
            n = $masonry.width(),
            t = $masonry.attr("data-cols");

        if ( t == "1" ) {
            r = 1;
            return r;
        }
        if ( t == "2" ) {
            r = 2;
            if ( n < 600 ) r = 1;
            return r;
        } else if ( t == "3" ) {
            r = 3;
            if ( n < 600 ) r = 1;
            else if ( n >= 600 && n < 768 ) r = 2;
            else if ( n >= 768 && n < 992 ) r = 3;
            else if ( n >= 992 ) r = 3;
            return r;
        } else if ( t == "4" ) {
            r = 4;
            if ( n < 600 ) r = 1;
            else if ( n >= 600 && n < 768 ) r = 2;
            else if ( n >= 768 && n < 992 ) r = 3;
            else if ( n >= 992 ) r = 4;
            return r;
        } else if ( t == "5" ) {
            r = 5;
            if ( n < 600 ) r = 1;
            else if ( n >= 600 && n < 768 ) r = 2;
            else if ( n >= 768 && n < 992 ) r = 3;
            else if ( n >= 992 && n < 1140 ) r = 4;
            else if ( n >= 1140 ) r = 5;
            return r;
        } else if ( t == "6" ) {
            r = 5;
            if ( n < 600 ) r = 1;
            else if ( n >= 600 && n < 768 ) r = 2;
            else if ( n >= 768 && n < 992 ) r = 3;
            else if ( n >= 992 && n < 1160 ) r = 4;
            else if ( n >= 1160 ) r = 6;
            return r;
        } else if ( t == "8" ) {
            r = 5;
            if ( n < 600 ) r = 1;
            else if ( n >= 600 && n < 768 ) r = 2;
            else if ( n >= 768 && n < 992 ) r = 3;
            else if ( n >= 992 && n < 1160 ) r = 4;
            else if ( n >= 1160 ) r = 8;
            return r;
        }
    }

    function ayvo_grid($masonry) {
        var t = ayvo_cols($masonry);
        var n = $masonry.width();
        var r = n / t;
        r     = Math.floor(r);
        $masonry.find('.isotope-item').each(function (t) {
            $(this).css({
                width: r + 'px'
            });
        });
    }

    $.fn.ayvo_isotpe = function () {
        var _this = $(this);
        _this.on('ayvo_isotpe', function () {
            _this.each(function () {
                var $this   = $(this),
                    $layout = $this.data('layout'),
                    $grid   = $this.isotope({
                        percentPosition: true,
                        itemSelector: '.isotope-item',
                        layoutMode: $layout
                    });
                if ( $layout != 'packery' )
                    ayvo_grid($this);
                $grid.imagesLoaded(function () {
                    $grid.isotope('layout');
                });
                $(document).on('click', '.filter-button-group a', function (e) {
                    e.preventDefault();
                    var filterValue = $(this).data('filter');
                    $grid.isotope({filter: filterValue});
                    $(this).addClass('active').siblings().removeClass('active');
                    $this.find('.lazy').ovic_init_lazy_load();
                });
            });
        }).trigger('ayvo_isotpe');
        $(window).on('resize', function () {
            _this.trigger('ayvo_isotpe');
        });
    }
    window.addEventListener('load',
        function (ev) {
            if ( $('.ayvo-isotope').length ) {
                $('.ayvo-isotope').ayvo_isotpe();
            }
        }, false);
})(window.jQuery);