(function ($) {
    var documentHeight = 0;
    var contentHeight = 0;
    var topContentOffset = 0;
    var currentHeight = 0;
    var contentSelector;
    var scrollTimer = null;
    var percentageScrolled;

    function handleScroll() {
        if ($(document).height() - $(window).height() < 20) {
            percentageScrolled = 100;
        } else {
            currentHeight = $(document).scrollTop();

            if (currentHeight > 1) {
                if ($(window).scrollTop() + $(window).height() > $(document).height() - 20) {
                    percentageScrolled = 100;
                } else {
                    percentageScrolled = Math.round(currentHeight / contentHeight * 100);
                }
            } else {
                percentageScrolled = 0;
            }
        }
        var displayPercentageScrolled = Math.min(percentageScrolled, 100);

        $('.scroll_progress_plugin input').val(displayPercentageScrolled).change();
    }

    $(window).on("load", function () {
        documentHeight = $(document).height();
        window.scroll_progress_plugin_rangeslider_settings = scroll_progress_plugin_rangeslider_settings;

        contentHeight = $(document).height() - $(window).height();

        $('body').append('<div class="scroll_progress_plugin"><input type="range" min="0" max="100" step="1"' +
            ' disabled' +
            ' value="0"></div>');

        $('.scroll_progress_plugin input[type="range"]').rangeslider({polyfill: false});

        if (typeof scroll_progress_plugin_rangeslider_settings[0].scroll_progress_bar_color !== "undefined") {
            $('.scroll_progress_plugin .rangeslider').css({background: scroll_progress_plugin_rangeslider_settings[0].scroll_progress_bar_color});
        }
        if (typeof scroll_progress_plugin_rangeslider_settings[0].scroll_progress_scrolled_color !== "undefined") {
            $('.scroll_progress_plugin .rangeslider__fill').css({background: scroll_progress_plugin_rangeslider_settings[0].scroll_progress_scrolled_color});
        }
        if (typeof scroll_progress_plugin_rangeslider_settings[0].scroll_progress_indicator_show !== "undefined" && scroll_progress_plugin_rangeslider_settings[0].scroll_progress_indicator_show) {
            $('body').append('<style>' +
                'body .scroll_progress_plugin .rangeslider__handle {\n' +
                '    display: initial;\n' +
                '}</style>');
        }
        if (typeof scroll_progress_plugin_rangeslider_settings[0].scroll_progress_position_top !== "undefined" && scroll_progress_plugin_rangeslider_settings[0].scroll_progress_position_top) {
            $('body').append('<style>' +
                'body .scroll_progress_plugin {\n' +
                '    bottom: initial;\n' +
                '    top: 0;\n' +
                '}</style>');
        }

        $(document).scroll();
    });

    $(document).scroll(function () {
        if (!documentHeight || !contentHeight) {
            return;
        }

        if (scrollTimer) {
            clearTimeout(scrollTimer);
        }
        scrollTimer = setTimeout(handleScroll, 1);
    });
})(jQuery);