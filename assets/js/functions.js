;(function ($) {
    "use strict";

    $(document).on('click', 'a.backtotop', function () {
        $('html, body').animate({scrollTop: 0}, 800);
        return false;
    });
    $(document).on('click', '.ovic-tabs .tab-link a', function () {
        $(this).closest('.tab-head').removeClass('open');
    });

    $(document).on('click', '.widget-area .arrow', function () {
        var _widget = $(this).closest('.widget');
        _widget.children().not('.widgettitle').not('.screen-reader-text').slideToggle(300);
        _widget.toggleClass('active');
        _widget.find('.lazy').ovic_init_lazy_load();
    });
    $(document).on('click', '.grid-view-mode .grid-number', function (e) {
        var _this   = $(this),
            _items  = _this.closest('.main-content').find('.ovic-products'),
            _reset  = _this.closest('.wrap-display-mode').find('.grid-number.reset'),
            _number = _this.val();

        if ( _this.hasClass('reset') ) {
            _items.addClass('auto-clear');
            _items.attr('class', function (i, c) {
                return c.replace(/(^|\s)custom-grid-\S+/g, '');
            });
            _this.closest('.wrap-display-mode').find('.grid-number.reset').removeClass('active');
        } else {
            _this.addClass('active').siblings().removeClass('active');
            _items.removeClass('auto-clear');
            _items.attr('class', function (i, c) {
                return c.replace(/(^|\s)custom-grid-\S+/g, '');
            });
            _items.addClass('custom-grid-' + _number);
            _reset.attr('data-value', _number);
        }
        if ( _items.hasClass('equal-container') ) {
            _items.ovic_better_equal_elems();
        }
        e.preventDefault();
    });
    $.fn.ayvo_category_product = function () {
        $(this).each(function () {
            var _main = $(this);
            _main.find('.cat-parent').each(function () {
                if ( $(this).hasClass('current-cat-parent') ) {
                    $(this).addClass('show-sub');
                    $(this).children('.children').slideDown(400);
                }
                $(this).children('.children').before('<span class="carets"></span>');
            });
            _main.children('.cat-parent').each(function () {
                var curent = $(this).find('.children');
                $(this).children('.carets').on('click', function () {
                    $(this).parent().toggleClass('show-sub');
                    $(this).parent().children('.children').slideToggle(400);
                    _main.find('.children').not(curent).slideUp(400);
                    _main.find('.cat-parent').not($(this).parent()).removeClass('show-sub');
                });
                var next_curent = $(this).find('.children');
                next_curent.children('.cat-parent').each(function () {
                    var child_curent = $(this).find('.children');
                    $(this).children('.carets').on('click', function () {
                        $(this).parent().toggleClass('show-sub');
                        $(this).parent().parent().find('.cat-parent').not($(this).parent()).removeClass('show-sub');
                        $(this).parent().parent().find('.children').not(child_curent).slideUp(400);
                        $(this).parent().children('.children').slideToggle(400);
                    })
                });
            });
        });
    }

    $('body').on('click', '.quantity .quantity-plus', function (e) {
        var _this  = $(this).closest('.quantity').find('input.qty'),
            _value = parseInt(_this.val()),
            _max   = parseInt(_this.attr('max')),
            _step  = parseInt(_this.data('step'));

        _value = _value + _step;
        if ( _max && _value > _max ) {
            _value = _max;
        }
        _this.val(_value);
        _this.trigger("change");
        e.preventDefault();
    });
    $(document).on('change', function () {
        $('.quantity').each(function () {
            var _this  = $(this).find('input.qty'),
                _value = parseInt(_this.val()),
                _max   = parseInt(_this.attr('max'));
            if ( _value > _max ) {
                $(this).find('.quantity-plus').css('pointer-events', 'none')
            } else {
                $(this).find('.quantity-plus').css('pointer-events', 'auto')
            }
        })
    });
    $('body').on('click', '.quantity .quantity-minus', function (e) {
        var _this  = $(this).closest('.quantity').find('input.qty'),
            _value = parseInt(_this.val()),
            _min   = parseInt(_this.attr('min')),
            _step  = parseInt(_this.data('step'));

        _value = _value - _step;
        if ( _min && _value < _min ) {
            _value = _min;
        }
        if ( !_min && _value < 0 ) {
            _value = 0;
        }
        _this.val(_value);
        _this.trigger("change");
        e.preventDefault();
    });

    $(document).on('click', '.ovic-call-to-action .gallery a', function (e) {
        e.preventDefault();
        var _cimg    = $(this).attr('href'),
            _content = $(this).closest('.ovic-call-to-action'),
            _timg    = _content.find('.main-banner img');

        if ( _cimg ) {
            _timg.parent().addClass('loading-lazy');
            _timg.attr('src', _cimg).attr('srcset', _cimg);
            _timg.one('load', function () {
                $(this).parent().removeClass('loading-lazy');
            });
            $(this).addClass('active').siblings().removeClass('active');
        }
    });

    $('body').on('added_to_wishlist removed_from_wishlist', function () {
        $.ajax({
            data: {
                action: 'ayvo_update_wishlist_count'
            },
            success: function (data) {
                //do something
                $('.block-wishlist .count').text(data);
            },
            url: ayvo_ajax_frontend[ 'ajaxurl' ]
        });
    });

    $.fn.ayvo_product_gallery = function () {
        $(this).each(function () {
            var _items      = $(this).closest('.product-inner').data('items'),
                _main_slide = $(this).find('.product-gallery-slick'),
                _dot_slide  = $(this).find('.gallery-dots');

            _main_slide.not('.slick-initialized').each(function () {
                var _this   = $(this),
                    _config = [];

                if ( $('body').hasClass('rtl') ) {
                    _config.rtl = true;
                }
                _config.prevArrow    = '<span class="abc icon-chevron-thin-left prev"></span>';
                _config.nextArrow    = '<span class="abc icon-chevron-thin-right next"></span>';
                _config.cssEase      = 'linear';
                _config.infinite     = true;
                _config.fade         = true;
                _config.slidesMargin = 0;
                _config.arrows       = false;
                _config.asNavFor     = _dot_slide;
                _this.slick(_config);
            });
            _dot_slide.not('.slick-initialized').each(function () {
                var _config = [];
                if ( $('body').hasClass('rtl') ) {
                    _config.rtl = true;
                }
                _config.slidesToShow  = _items;
                _config.infinite      = true;
                _config.focusOnSelect = true;
                _config.vertical      = true;
                _config.slidesMargin  = 20;
                _config.prevArrow     = '<span class="abc icon-chevron-thin-up prev"></span>';
                _config.nextArrow     = '<span class="abc icon-chevron-thin-down next"></span>';
                _config.asNavFor      = _main_slide;
                _config.responsive    = [
                    {
                        breakpoint: 640,
                        settings: {
                            vertical: false,
                            prevArrow: '<span class="abc icon-chevron-thin-left prev"></span>',
                            nextArrow: '<span class="abc icon-chevron-thin-right next"></span>',
                        }
                    }
                ];
                $(this).slick(_config);
            })
        })
    }

    function ayvo_custom_menu() {
        if ( ('.ovic-custommenu').length > 0 ) {
            $('.ovic-custommenu').find('.menu-item').each(function () {
                if ( $(this).hasClass('menu-item-has-children') ) {
                    $(this).prepend('<a class="toggle-submenu" href="#"></a>');
                }
            });
        }
        $(document).on('click', '.ovic-custommenu .toggle-submenu', function () {
            $(this).closest('.menu-item-has-children').toggleClass('open-submenu');
            return false;
        });
    }

    $.fn.ayvo_countdown = function () {
        $(this).each(function () {
            var _this           = $(this),
                _text_countdown = '';

            _this.countdown(_this.data('datetime'), {elapse: true})
                .on('update.countdown', function (event) {
                    if ( event.elapsed ) {
                        _text_countdown = event.strftime(
                            '<span class="days"><span class="number">00</span><span class="text">' + ayvo_ajax_frontend.day_text + '</span></span>' +
                            '<span class="hour"><span class="number">00</span><span class="text">' + ayvo_ajax_frontend.hrs_text + '</span></span>' +
                            '<span class="mins"><span class="number">00</span><span class="text">' + ayvo_ajax_frontend.mins_text + '</span></span>' +
                            '<span class="secs"><span class="number">00</span><span class="text">' + ayvo_ajax_frontend.secs_text + '</span></span>'
                        );
                    } else {
                        _text_countdown = event.strftime(
                            '<span class="days"><span class="number">%D</span><span class="text">' + ayvo_ajax_frontend.day_text + '</span></span>' +
                            '<span class="hour"><span class="number">%H</span><span class="text">' + ayvo_ajax_frontend.hrs_text + '</span></span>' +
                            '<span class="mins"><span class="number">%M</span><span class="text">' + ayvo_ajax_frontend.mins_text + '</span></span>' +
                            '<span class="secs"><span class="number">%S</span><span class="text">' + ayvo_ajax_frontend.secs_text + '</span></span>'
                        );
                    }
                    _this.html(_text_countdown);
                });
        });
    }

    /* HEADER MOBILE */
    // Cart mobile
    $(document).on('click', '.header-mobile .close-btn', function () {
        $(this).closest('.header-settings').removeClass('open');
        $(this).closest('.header-settings').find('.menu-config').removeClass('active');
        return false;
    });
    $(document).on('click', '.header-nav .close-menu', function () {
        $(this).closest('.header-nav').removeClass('open');
        return false;
    });

    

    function ayvo_footer_mobile() {
        if ( $(window).innerWidth() < 1025 ) {
            if ( $('.main-container .sidebar').length > 0 ) {
                $('.main-container .sidebar').prepend('<div class="head"><h3 class="sidebar-mobile-title">Sidebar</h3><a class="sidebar-close-btn" href="#"><i class="abc icon-x"></i></a></div>');
            }
        }
        $(document).on('click', '.footer-mobile .sidebar-open-btn', function () {
            if ( $('.shop-sidebar').find('.lazy').length > 0 ) {
                $('.shop-sidebar').find('.lazy').lazy({delay: 0});
            }
            $(this).closest('body').find('.sidebar').addClass('open');
            $(this).addClass('active');
            return false;
        });
        if ( ('.main-container').length > 0 ) {
            if ( $('.main-container').hasClass('no-sidebar') ) {
                $('.main-container').closest('body').find('.footer-mobile .sidebar-item').addClass('hidden');
            }
        }
        $(document).on('click', '.sidebar .sidebar-close-btn', function () {
            $(this).closest('body').find('.sidebar').removeClass('open');
            $(this).closest('body').find('.footer-mobile .sidebar-open-btn').removeClass('active');
            return false;
        });
        $(document).on('click', function (e) {
            var target = $(e.target);
            if ( !target.closest('.main-container .sidebar').length ) {
                $('.main-container .sidebar').removeClass('open');
                $('.footer-mobile .open-sidebar-btn').removeClass('active');
            }
        });

        $(document).on('click', '.footer-mobile .shop-open-filter', function () {
            if ( $('.shop-sidebar').find('.lazy').length > 0 ) {
                $('.shop-sidebar').find('.lazy').lazy({delay: 0});
            }
            $(this).closest('body').find('.shop-control .filter-sidebar-content').addClass('open');
            $(this).addClass('active');
            return false;
        });

    }

    function footer_click_menu() {
        if ( $(window).innerWidth() < 480 ) {
            if ( $('.footer .ovic-custommenu ').length > 0 ) {
                $('.footer .ovic-custommenu .widgettitle').prepend('<a class="toggle-menu" href="#"></a>');
            }
            $(document).on('click', '.footer .ovic-custommenu .toggle-menu', function () {
                $(this).closest('.ovic-custommenu').toggleClass('open');
                return false;
            });
        }
    }

    /* /HEADER MOBILE */
    $.fn.ayvo_sticky_header = function () {
        var $this = $(this);
        if ( $(window).innerWidth() > 1024 ) {
            $this.on('ayvo_sticky_header', function () {
                $this.each(function () {
                    if ( ayvo_ajax_frontend.ovic_sticky_menu == 1 ) {
                        var _this            = $(this),
                            _previousScroll  = 0,
                            _adminBar        = 0,
                            _header          = _this.closest('.header'),
                            _currentOffset   = _this.offset().top + _this.outerHeight(),
                            _headerOrgOffset = _this.offset().top + _header.outerHeight();

                        if ( $('body').hasClass('rtl') ) {
                            _currentOffset = _currentOffset - _adminBar;
                        }
                        _header.css('height', _header.outerHeight());
                        $(window).on('scroll', function (ev) {
                            if ( $(window).width() > 1024 ) {
                                var _currentScroll = $(this).scrollTop(),
                                    _stickyHeight  = 0;

                                if ( _currentScroll > _headerOrgOffset ) {
                                    _this.addClass('fixed');
                                    _this.removeClass('hide-header');
                                } else {
                                    _this.addClass('hide-header');
                                    _this.removeClass('fixed');

                                }
                                _previousScroll = _currentScroll;
                            }
                        });
                    }
                });
            }).trigger('ayvo_sticky_header');
        }
    };

    /* LOADMORE */
    function removeParam(key, sourceURL) {
        var rtn         = sourceURL.split("?")[ 0 ],
            param,
            params_arr  = [],
            queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[ 1 ] : "";
        if ( queryString !== "" ) {
            params_arr = queryString.split("&");
            for ( var i = params_arr.length - 1; i >= 0; i -= 1 ) {
                param = params_arr[ i ].split("=")[ 0 ];
                if ( param === key ) {
                    params_arr.splice(i, 1);
                }
            }
            rtn = rtn + "?" + params_arr.join("&");
        }
        return rtn;
    }

    $(document).on('click', '.view-more-button', function (e) {
        var _this       = $(this),
            _Nurl       = '',
            _Curl       = _this.attr('href'),
            _data_query = _this.data();

        _this.addClass('loading');
        _Curl = removeParam('ovic_raw_content', _Curl);
        $.ajax({
            type: 'GET',
            url: _Curl,
            data: {
                ovic_raw_content: 1
            },
            cache: false,
            async: false,
            success: function (response) {
                if ( _data_query.current < _data_query.max ) {
                    var $html       = $.parseHTML(response),
                        $raw_html   = $('.response-loadmore', $html),
                        $pagination = $('.view-more-button', $html),
                        $items      = $($raw_html[ 0 ].innerHTML);

                    $('.response-loadmore').append($items);
                    if ( $('.ayvo-isotope').length > 0 ) {
                        $('.ayvo-isotope').isotope('appended', $items, true);
                    }
                    if ( $.fn.lazy )
                        $('.response-loadmore .lazy').lazy({delay: 0});
                    _this.data('current', $pagination.data('current'));
                    _this.attr('href', $pagination.attr('href'));
                    if ( $pagination.data('current') >= _data_query.max ) {
                        _this.remove();
                    }
                    history.pushState({path: _Curl, title: document.title}, null, _Curl);
                }
            },
            complete: function () {
                _this.removeClass('loading');
            }
        });
        e.preventDefault();
    });
    $(document).on('click', '.popup-gallery .close', function (e) {
        $('.overlay-body').removeClass('active');
        $(this).closest('.popup-gallery').removeClass('active');
        e.preventDefault();
    });
    $(document).on('click', '.block-search .close-search', function (e) {
        $(this).closest('.block-search').removeClass('open');
        e.preventDefault();
    });
    $(document).on('click', '.login-register-form .out-login', function (e) {
        $('.overlay-body').addClass('active');
        $(this).closest('.login-register-form').addClass('open');
        e.preventDefault();
    });
    $(document).on('click', '.overlay-body', function (e) {
        $(this).removeClass('active');
        $('.popup-gallery').removeClass('active');
        $('.login-register-form').removeClass('open');
        e.preventDefault();
    });
    $(document).on('click', '.ayvo-footer-account a', function (e) {
        var _this    = $(this),
            _data    = _this.data(),
            _content = _this.closest('.woocommerce');

        if ( _data.page == 'register' ) {
            _this.data('page', 'login');
            _this.html(_data.login);
            if ( _content.find('.popup-account-title').length > 0 )
                _content.find('.popup-account-title').html('Register');
            _content.find('.u-column2').slideDown('slow').siblings().slideUp('slow');
        } else {
            _this.data('page', 'register');
            _this.html(_data.register);
            if ( _content.find('.popup-account-title').length > 0 )
                _content.find('.popup-account-title').html('Sign in');
            _content.find('.u-column1').slideDown('slow').siblings().slideUp('slow');
        }
        e.preventDefault();
    });
    $(document).on('click', '.popup-portfolio', function (e) {
        var _html    = '',
            _this    = $(this),
            _ID      = _this.data('id'),
            _content = _this.closest('.blog-portfolio').find('.popup-gallery'),
            _title   = _content.find('.title-gallery');

        _content.addClass('active loading');
        $('.overlay-body').addClass('active');
        if ( ovic_ajax_frontend !== undefined ) {
            $.ajax({
                type: 'POST',
                url: ovic_ajax_frontend.ovic_ajax_url.toString().replace('%%endpoint%%', 'ayvo_ajax_gallery'),
                data: {
                    security: ovic_ajax_frontend.security,
                    id: _ID,
                },
                success: function (response) {
                    for ( var i in response[ 'gallery' ] ) {
                        _html += '<img src="' + response[ 'gallery' ][ i ] + '">';
                    }
                    _title.html(response[ 'title' ]);
                    _title.attr('href', response[ 'href' ]);
                    _content.find('.list-gallery').html('<div class="owl-slick" data-slick=\'{"slidesToShow": 1, "fade": true}\'>' + _html + '</div>');
                },
                complete: function () {
                    if ( $.fn.slick )
                        _content.find('.owl-slick').ovic_init_carousel();
                    _content.removeClass('loading');
                }
            });
        }
        e.preventDefault();
    });
    $(document).on('click', '.loadmore-product a', function (e) {
        var _this         = $(this),
            _main_content = _this.closest('.ovic-products'),
            _parent       = _this.closest('.loadmore-product'),
            _loop_query   = _parent.data('loop'),
            _loop_id      = _parent.data('id'),
            _loop_style   = _parent.data('style'),
            _loop_thumb   = _parent.data('thumb'),
            _liststyle    = _parent.data('type'),
            _loop_class   = _parent.data('class');

        _main_content.addClass('loading');
        $.ajax({
            type: 'POST',
            url: ovic_ajax_frontend.ovic_ajax_url.toString().replace('%%endpoint%%', 'ayvo_product_loadmore'),
            data: {
                security: ovic_ajax_frontend.security,
                loop_query: _loop_query,
                loop_class: _loop_class,
                loop_id: _loop_id,
                loop_style: _loop_style,
                loop_thumb: _loop_thumb,
            },
            success: function (response) {
                if ( response[ 'out_post' ] == 'yes' ) {
                    _this.remove();
                }
                if ( _liststyle == 'owl' ) {
                    _main_content.find('.owl-slick').slick('unslick');
                }
                if ( response[ 'success' ] == 'yes' && response[ 'out_post' ] == 'no' ) {
                    _main_content.find('.response-product').append(response[ 'html' ]);
                    _parent.data('id', response[ 'loop_id' ]);
                }
            },
            complete: function () {
                _main_content.find('.owl-slick').ovic_init_carousel();
                _main_content.find('.equal-container.better-height').ovic_better_equal_elems();
                _main_content.removeClass('loading');
            }
        });
        e.preventDefault();
    });

    $.fn.ayvo_slide_product       = function () {
        var _this = $(this);
        _this.on('ayvo_slide_product', function () {
            $(this).each(function () {
                var _config  = [],
                    _gallery = $(this).find('.woocommerce-product-gallery__wrapper');

                if ( $('body').hasClass('rtl') ) {
                    _config.rtl = true;
                }
                _config.prevArrow    = '<span class="abc icon-chevron-thin-left prev"></span>';
                _config.nextArrow    = '<span class="abc icon-chevron-thin-right next"></span>';
                _config.cssEase      = 'linear';
                _config.dots         = true;
                _config.infinite     = false;
                _config.slidesToShow = 2;
                _config.responsive   = [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesMargin: 20,
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesMargin: 10,
                        }
                    },
                    {
                        breakpoint: 570,
                        settings: {
                            slidesToShow: 1,
                            slidesMargin: 0,
                        }
                    }
                ];
                _gallery.slick(_config);
                _gallery.on('afterChange', function (event, slick, direction) {
                    if ( $.fn.ovic_init_lazy_load )
                        _gallery.find('.lazy').ovic_init_lazy_load();
                });
            });
        }).trigger('ayvo_slide_product');
    };
    $.fn.ayvo_sticky_sidebar      = function () {
        var _this = $(this);
        _this.wrap('<div class="sticky-product-wrap"></div>');
        _this.on('ayvo_sticky_sidebar', function () {
            setTimeout(function () {
                _this.each(function () {
                    var _wrap_content    = $(this).closest('.wrapper-single-product'),
                        _wrap_sticky     = $(this).closest('.sticky-product-wrap'),
                        _sidebar_content = $(this);

                    var _height_content      = _wrap_content.height() - 20,
                        _offset_content      = _wrap_content.offset(),
                        _full_height_content = _height_content + _offset_content.top,
                        _StickyScrollDown    = 10,
                        _StickyScrollUp      = 0,
                        _lastScrollTop       = 0;

                    if ( $(window).innerWidth() > 1199 ) {
                        _sidebar_content.css({
                            width: _sidebar_content.width(),
                        });
                    }
                    if ( $('body').hasClass('admin-bar') ) {
                        _StickyScrollDown += 32;
                        _StickyScrollUp += 32;
                    }
                    if ( ayvo_ajax_frontend.ovic_sticky_menu == 1 ) {
                        _StickyScrollDown += 90;
                        _StickyScrollUp += 90;
                    }
                    $(window).scroll(function (event) {
                        if ( $(window).innerWidth() > 1199 ) {
                            /* SIDEBAR */
                            var _scroll_window       = $(window).scrollTop(),
                                _offset_sidebar      = _sidebar_content.offset(),
                                _height_sidebar      = _sidebar_content.height(),
                                _full_height_sidebar = _sidebar_content.outerHeight() + _offset_sidebar.top;

                            if ( _scroll_window > _lastScrollTop ) {
                                if ( _offset_sidebar.top < _scroll_window ) {
                                    _sidebar_content.addClass('sticky').css({
                                        position: 'fixed',
                                        top: _StickyScrollDown,
                                        bottom: 'auto',
                                    });
                                }
                                if ( _full_height_sidebar > _full_height_content ) {
                                    _sidebar_content.addClass('block-sticky').css({
                                        top: 'auto',
                                        bottom: '10px',
                                        position: 'absolute',
                                    });
                                }
                            } else {
                                if ( _offset_sidebar.top > _scroll_window ) {
                                    if ( _offset_content.top > _scroll_window ) {
                                        _sidebar_content.removeClass('sticky').css({
                                            top: 'auto',
                                            bottom: 'auto',
                                            position: 'inherit',
                                        });
                                    } else {
                                        _sidebar_content.removeClass('block-sticky').css({
                                            top: _StickyScrollUp,
                                            position: 'fixed',
                                            bottom: 'auto',
                                        });
                                    }
                                }
                            }
                            _lastScrollTop = _scroll_window;
                        }
                    });
                });
            }, 100);
        }).trigger('ayvo_sticky_sidebar');
    };
    $.fn.ayvo_popup_product_video = function () {
        $(this).magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 300,
            preloader: false,
            fixedContentPos: false,
        });
    };
    $(document).ajaxComplete(function (event, xhr, settings) {
        if ( xhr.status == 200 && xhr.responseText ) {
            if ( $('.ovic-countdown').length > 0 && $.fn.countdown ) {
                $('.ovic-countdown').ayvo_countdown();
            }
        }
    });
    $(document).on('added_to_cart removed_from_cart', function () {
        if ( $('.woocommerce-mini-cart').length ) {
            $('.woocommerce-mini-cart').scrollbar();
        }
    });
    $(window).scroll(function () {
        if ( $(window).scrollTop() > 50 ) {
            $('.block-search ').click(function(){
				('.open').toggle();
			});
        }
        if ( $(window).scrollTop() > 1000 ) {
            $('.backtotop').addClass('show');
        } else {
            $('.backtotop').removeClass('show');
        }
        if ( $(window).scrollTop() > 300 ) {
            $('.footer-mobile').addClass('open');
        } else {
            $('.footer-mobile').removeClass('open');
        }
    });

    /* RESIZE */
    var resize_id;
    $(window).resize(function () {
        clearTimeout(resize_id);
        resize_id = setTimeout(doneResizing, 500);
    });

    function doneResizing() {
        ayvo_footer_mobile();
        if ( $('.header .header-wrap-stick').length ) {
            $('.header .header-wrap-stick').ayvo_sticky_header();
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        ayvo_footer_mobile();
        ayvo_custom_menu();
        ayvo_hidden_sidebar();
        footer_click_menu();
        if ( $('.owl-slick').length > 0 && $.fn.slick ) {
            $('.owl-slick').slick("slickSetOption", "swipeToSlide", true, true);
        }
        if ( $('.woocommerce-mini-cart').length ) {
            $('.woocommerce-mini-cart').scrollbar();
        }
        if ( $('.header .header-wrap-stick').length ) {
            $('.header .header-wrap-stick').ayvo_sticky_header();
        }
        if ( $('.ovic-video .video-button').length && $.fn.magnificPopup ) {
            $('.ovic-video .video-button').ayvo_popup_product_video();
        }
        if ( $('.ovic-countdown').length && $.fn.countdown ) {
            $('.ovic-countdown').ayvo_countdown();
        }
        if ( $('.product-gallery').length ) {
            $('.product-gallery').ayvo_product_gallery();
        }
        if ( $('.single-thumb-slide .woocommerce-product-gallery').length ) {
            $('.single-thumb-slide .woocommerce-product-gallery').ayvo_slide_product();
        }
        if ( $('.single-thumb-sticky .summary,.single-thumb-sticky .flex-control-nav').length ) {
            $('.single-thumb-sticky .summary,.single-thumb-sticky .flex-control-nav').ayvo_sticky_sidebar();
        }
        if ( $('.widget_product_categories .product-categories').length ) {
            $('.widget_product_categories .product-categories').ayvo_category_product();
        }
    });
})(window.jQuery);