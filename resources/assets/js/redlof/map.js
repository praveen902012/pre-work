// Quick feature detection
function isTouchEnabled() {
    return (('ontouchstart' in window) || (navigator.MaxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0));
}

$(function() {

    if ($('#lakes').find('path').eq(0).attr('fill') != 'undefined') {

        $('#lakes').find('path').attr({
            'fill': map_config['default'].lakesColor
        }).css({
            'stroke': map_config['default'].borderColor
        });
    }

    $('#map-tip').css({
        'box-shadow': '1px 2px 4px ' + map_config['default'].hoverShadow,
        '-moz-box-shadow': '2px 3px 6px ' + map_config['default'].hoverShadow,
        '-webkit-box-shadow': '2px 3px 6px ' + map_config['default'].hoverShadow,
    });

    if ($('#shadow').find('path').eq(0).attr('fill') != 'undefined') {

        var shadowOpacity = map_config['default'].shadowOpacity;

        shadowOpacity = parseInt(shadowOpacity);

        if (shadowOpacity >= 100) {
            shadowOpacity = 1;
        } else if (shadowOpacity <= 0) {
            shadowOpacity = 0;
        } else {
            shadowOpacity = shadowOpacity / 100;
        }

        $('#shadow').find('path').attr({
            'fill': map_config['default'].mapShadow
        }).css({
            'fill-opacity': shadowOpacity
        });
    }
});

function addEvent(id, relationId) {

    var _obj = $('#' + id);

    var _Textobj = $('#' + id + ',' + '#' + map_config[id].namesId);
    //var _h = $('#map').height();

    $('#' + ['text-abb']).attr({
        'fill': map_config['default'].namesColor
    });

    _obj.attr({
        'fill': map_config[id].upColor,
        'stroke': map_config['default'].borderColor
    });

    _Textobj.attr({
        'cursor': 'default'
    });

    if (map_config[id].enable == true) {

        if (isTouchEnabled()) {
            //clicking effect

            _Textobj.on('touchstart', function(e) {

                var touch = e.originalEvent.touches[0];

                var x = touch.pageX + 10,
                    y = touch.pageY + 15;

                var tipw = $('#map-tip').outerWidth(),
                    tiph = $('#map-tip').outerHeight();

                x = (x + tipw > $(document).scrollLeft() + $(window).width()) ? x - tipw - (20 * 2) : x;

                y = (y + tiph > $(document).scrollTop() + $(window).height()) ? $(document).scrollTop() + $(window).height() - tiph - 10 : y;

                $('#' + id).css({
                    'fill': map_config[id].downColor
                });

                $('#map-tip').show().html(map_config[id].hover);

                $('#map-tip').css({
                    left: x,
                    top: y
                });
            });

            _Textobj.on('touchend', function() {
                $('#' + id).css({
                    'fill': map_config[id].upColor
                });
                if (map_config[id].target == 'new_window') {
                    window.open(map_config[id].url);
                } else if (map_config[id].target == 'same_window') {
                    window.location.href = map_config[id].url;
                }
            });
        }

        _Textobj.attr({
            'cursor': 'pointer'
        });

        _Textobj.hover(function() {

            //moving in/out effect
            $('#map-tip').show().html(map_config[id].hover);

            _obj.css({
                'fill': map_config[id].overColor
            });

        }, function() {

            $('#map-tip').hide();

            $('#' + id).css({
                'fill': map_config[id].upColor
            });
        });

        //clicking effect
        _Textobj.mousedown(function() {

            $('#' + id).css({
                'fill': map_config[id].downColor
            });

        });

        _Textobj.mouseup(function() {

            $('#' + id).css({
                'fill': map_config[id].overColor
            });

            if (map_config[id].target == 'new_window') {

                window.open(map_config[id].url);

            } else if (map_config[id].target == 'same_window') {

                window.location.href = map_config[id].url;
            }
        });

        _Textobj.mousemove(function(e) {

            var x = e.pageX + 10,
                y = e.pageY + 15;

            var tipw = $('#map-tip').outerWidth(),
                tiph = $('#map-tip').outerHeight();

            x = (x + tipw > $(document).scrollLeft() + $(window).width()) ? x - tipw - (20 * 2) : x;

            y = (y + tiph > $(document).scrollTop() + $(window).height()) ? $(document).scrollTop() + $(window).height() - tiph - 10 : y;

            $('#map-tip').css({
                left: x,
                top: y
            });
        });
    }
}