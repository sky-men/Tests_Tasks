$(document).ready(function () {

    //region Конфигурация
    var id = 'tree';

    var nodCssClass = 'ui-state-default ui-sortable-handle';

    var sort_conf  = {
        cancel: "div",
        opacity:0.55
    };

    var editable_conf = {
        lineBreaks : false,
        closeOnEnter : true
    };
    //endregion

    var tree = $("#"+id);

    tree.sortable(sort_conf);

    var spans = $("#"+id+' span');

    //region Добавление кнопок действий
    var btn_container = $('#action_btn_container').html();

    if(tree.attr('new'))
        spans.prepend(btn_container);
    //endregion

    spans.sortable(sort_conf).addClass(nodCssClass);

    $('.title').editable(editable_conf);

    //Добавление подэлемента
    $('body').on("click", '.add_btn', function () {
        $(this).parent().parent().append('<span class="'+nodCssClass+'">'+btn_container+'<div class="title">Item</div></span>');
        $('.title').editable(editable_conf);
        $("#"+id+' span').sortable(sort_conf);
    });

    //удаление элемента
    $('body').on("click", '.rem_btn', function () {
        $(this).parent().parent().remove();
    });

    //сворачивание/разворачивание ветки
    $('body').on("click", '.slide_btn', function () {
        $(this).parent().parent().children('span').slideToggle(500);
    });


    saveTree(id);

});

/**
 * Функция отправки html-дома дерева, при его изменении
 */
function saveTree(id)
{
    var MutationObserver = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver;

    var tree = $("#"+id);

    var observer = new MutationObserver(function (mutations) {
        //удаление метки нового документа
        tree.removeAttr('new');

        $.post(window.location+'app/db/save.php', { tree: $("#"+id)[0].outerHTML }, function(data){});

        return true;

    });

    observer.observe(tree[0], {
        attributes: true,
        subtree: true,
        childList: true,
        characterData: true
    });
}