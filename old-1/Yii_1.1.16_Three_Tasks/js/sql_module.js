$(document).ready(function () {

    //region Смена регистра первых букв слов в наименовании сервисов
    $('[id ^= service_]').on("click", function (event) {
        var service_id = this.id.slice(this.id.indexOf("_", -1) + 1);


        var preg = /([^\s]*.+?[\s$]*)/g; //регулярка на слово с пробелами
        var pockets;
        var service_name = '';
        while ((pockets = preg.exec($(this).text())) != null) {
            var word = pockets[0];

            if (word.charAt(0) == word.charAt(0).toUpperCase())
                word = word.charAt(0).toLowerCase() + word.substr(1);
            else if (word.charAt(0) == word.charAt(0).toLowerCase())
                word = word.charAt(0).toUpperCase() + word.substr(1);

            service_name = service_name + word;
        }

        if(service_name)
            $(this).text(service_name);

        $.post( "/sql/default/updateService", { service_id: service_id, service_name: service_name } );
    });
    //endregion

});

