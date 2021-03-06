﻿/*
 Custom radio & checkbox jQuery plugin;
 by N0r8 millianorb@gmail.com;
 https://github.com/n0r8/Custom-radio-checkbox
 usage:
 $('your checkbox or radio selector').Custom({
 customStyleClass:'classForcustomView',
 customHeight:'height of checkbox or radio'
 });

 example:
 $('input[type="checkbox"]').Custom({
 customStyleClass:'checkbox',
 customHeight:'16'
 });
 */
(function ($) {
    $.CustomData = {
        elements:$()
    };

    $.fn.extend({

        Custom:function (options) {

            var elements = this;
            $.CustomData.elements = $.CustomData.elements.add(elements);

            /*Дефолтные значения параметров*/
            var defaults = {
                customStyleClass:"checkbox",
                customHeight:"16",
                enableHover:false
            };

            /*Заменяем дефолтные опции на переданные если таковые есть*/
            options = $.extend(defaults, options);

            /*Вид при нажатии на активный и неактивный элементы*/
            var pushed = function () {
                var element = $(this).children('input');
                if (element.prop('checked')) {
                    /*смещения в спрайте*/
                    $(this).css('backgroundPosition', "0px -" + options.customHeight * 3 + "px");
                } else {
                    $(this).css('backgroundPosition', "0px -" + options.customHeight + "px");
                }
            };

            /*Отмечаем нажатый елемент все остальные сбрасываем, если они в групе(radio)*/
            var check = function () {
                var el = $(this);
                var element = el.children('input');

                if (element.prop('checked') && element.is(':checkbox')) {/*Отмеченный чекбокс*/
                    el.css('backgroundPosition', '0px 0px');
                    element.prop('checked', false).change();
                    /*Меняем атрибут на неотмеченный и вызываем событие смены состояния элемента*/
                } else {
                    if (element.is(':checkbox')) {/*Неотмеченный чекбокс*/
                        el.css('backgroundPosition', "0px -" + options.customHeight * 2 + "px");
                    } else {
                        /*Радиобатоны*/
                        el.css('backgroundPosition', "0px -" + options.customHeight * 2 + "px");
                        $('input[name="' + element.attr('name') + '"]').not(element).parent().css('backgroundPosition', '0px 0px');
                    }

                    element.prop('checked', true).change();
                }

            };

            /*Обновление картинки при клике по лейблу и загрузке документа*/
            var update = function () {
                $.CustomData.elements.each(function () { /*Проходим по всем елементам и проверяем их состояние*/
                    var el = $(this);
                    if (el.prop('checked')) {
                        el.parent().css('backgroundPosition', "0px -" + el.attr('data-height') * 2 + "px");
                    } else {
                        el.parent().css('backgroundPosition', "0px 0px");
                    }
                });
            };

            /*Обновление при изменении состояния disabled/enabled */
            var refresh = function () {
                var el = $(this);
                el.parent()[!el.prop('disabled') ? 'bind' : 'unbind']({mousedown:pushed, mouseup:check})[!el.prop('disabled') ? 'removeClass' : 'addClass']('disabled');
                !el.prop('disabled') ? hoverBind(el) : $('label[for=' + el.attr('id') + ']').unbind("mouseenter.label").unbind("mouseout.label");
            };

            var hoverBind = function (element) {
                var el = element;
                var span = el.parent();

                /*Hover is disabled by default*/
                if (options.enableHover && !el.prop('disabled')) {
                    $('label[for=' + el.attr('id') + ']').bind({
                        "mouseenter.label":function () {
                            if (el.prop('checked')) {
                                span.css('backgroundPosition', "0px -" + el.attr('data-height') * 3 + "px");
                            } else {
                                span.css('backgroundPosition', "0px -" + el.attr('data-height') + "px");
                            }
                        },
                        "mouseout.label":function () {
                            if (el.prop('checked')) {
                                span.css('backgroundPosition', "0px -" + el.attr('data-height') * 2 + "px");
                            } else {
                                span.css('backgroundPosition', "0px 0px");
                            }
                        }
                    });
                }
            };

            return this.each(function () {
                var el = $(this);
                if (el.attr('data-init') != '1') {
                    el.attr({'data-init':'1', 'data-height':options.customHeight}).wrap('<span/>');

                    /*Приписываем класс оформления переданный в параметрах*/
                    var span = el.parent().addClass(options.customStyleClass);

                    if (el.prop('checked')) {  /*Задаем картинку еси элемент отмечен*/
                        span.css('backgroundPosition', "0px -" + (options.customHeight * 2) + "px");
                    }

                    hoverBind(el);

                    /*Бинд на изменение состояния элемента и кастомное событие для обновления после программного изменения состояния кнопки*/
                    el.bind({change:update, 'custom.refresh':refresh});

                    if (!el.prop('disabled')) {
                        span.parent('label').length ? span.bind({mousedown:pushed}) : span.bind({mousedown:pushed, mouseup:check});
                    } else {
                        span.addClass('disabled');
                    }

                }
            });
        }
    });

})(jQuery);