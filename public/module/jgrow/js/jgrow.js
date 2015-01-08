/**
 * jGrow
 *
 * jGrow is a jQuery plug-in that makes the textarea adjust its
 * size according to the length of the text.
 *
 * Source code: https://github.com/berkerpeksag/jquery-jgrow
 */

;(function ($) {
    "use strict";

    var htmlspecialchars = function (text) {
        var chars = ['&', '<', '>', '"'];
        var replacements = ['&amp;', '&lt;', '&gt;', '&quot;'];

        for (var i = 0; i < chars.length; i++) {
            var re = new RegExp(chars[i], 'gi');
            if (re.test(text))
                text = text.replace(re, replacements[i]);
        }
        return text;
    };

    var jgrow = function (k, settings) {
        var $t = k;

        var id = 'jgrow-' + $t.attr('name').replace(/[^a-z0-9-_:.]/gi, '_');
        var h = $t.css('height');
        h = parseInt(h == 'auto' ? '50px' : h);
        var l = $t.css('line-height');
        l = parseInt(l == 'normal' ? '16px' : l);
        var v = htmlspecialchars($t.val()).replace(/\n/g, '<br />');

        if (!$('#' + id).length) {
            $('<div/>').attr('id', id).css({
                'border': $t.css('border'),
                'font-family': $t.css('font-family'),
                'font-size': $t.css('font-size'),
                'font-weight': $t.css('font-weight'),
                'left': '-999px',
                'overflow': 'auto',
                'word-wrap': 'break-word',
                'padding': $t.css('padding'),
                'position': 'absolute',
                'top': 0,
                'width': $t.css('width')
            }).html(v).appendTo('body');
        }
        else {
            $('#' + id).html(v);
        }

        var n_h = $.browser.msie ? parseInt($('#' + id).innerHeight()) : parseInt($('#' + id).css('height')) + l;

        if ((settings.max_height != 'none') && (n_h > parseInt(settings.max_height))) {
            $t.css({
                'overflow': 'auto',
                'height': (parseInt(settings.max_height) + l) + 'px'
            });
        }
        else if (n_h > settings.cache_height) {
            $t.css('height', n_h + 'px');
        }
        else {
            var cache_height = isNaN(settings.cache_height) ? 0 : settings.cache_height + 'px';
            $t.css('height', cache_height);
        }
    };

    $.fn.jgrow = function (settings) {
        var _settings = $.extend({}, $.fn.jgrow.defaults, settings);

        this.each(function () {
            var $t = $(this);
            var height = $.browser.msie ? $t.innerHeight() : $t.css('height');
            $t.css(_settings);
            _settings.cache_height = parseInt(height);

            (new jgrow($(this), _settings));
        }).keyup(function () {
            (new jgrow($(this), _settings));
        });
    };

    $.fn.jgrow.defaults = {
        max_height: 'none',
        resize: 'none',
        overflow: 'hidden',
        cache_height: 0
    };

    $.fn.jGrow = $.fn.jgrow;

    $.fn.jgrow.VERSION = '0.6.1';

})(jQuery);