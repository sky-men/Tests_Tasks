$(document).ready(function() {

    //текущий блок с кнопками
    var buttons_block = $('#buttons');

    //сохраняем оригинальный блок с кнопками для последующего восстановления
    var buttons_block_origin = buttons_block.clone();

    //сами кнопки
    var buttons = buttons_block.children();

    var counter = 0;

    $('body').on("click", buttons, function (event) {
        counter++;

        //очищаем всё внутри блока с кнопками
        buttons_block.children().remove();

        if(counter == 1) {
            buttons_block.append(buttons[1].outerHTML);
            buttons_block.append(buttons[2].outerHTML);
            buttons_block.append(buttons[0].outerHTML);
        }
        else if(counter == 2) {
            buttons_block.append(buttons[2].outerHTML);
            buttons_block.append(buttons[0].outerHTML);
            buttons_block.append(buttons[1].outerHTML);
        }
        else {
            buttons_block.append(buttons_block_origin.html());
            counter = 0;
        }
    });
});