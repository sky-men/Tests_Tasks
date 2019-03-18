$(document).ready(function() {

    $('.btn').on("click", function(event){
        $.getJSON(window.location, function( data ) {
            var main_obj = $('tbody');

            var html_elm = main_obj.children().clone();
            html_elm.hide();
            var children = $(html_elm[0]).children();

            main_obj.children().remove();
            main_obj.removeClass( "hidden" );

            for (var i = 0; i < data.length; i++) {
                children[0].innerHTML = data[i].firstname;
                children[1].innerHTML = data[i].lastname;
                children[2].innerHTML = data[i].id;
                children[3].innerHTML = data[i].totalPrice;
                children[4].innerHTML = data[i].status;
                children[5].innerHTML = data[i].method_name;
                children[6].innerHTML = data[i].product_name;
                main_obj.append(html_elm[0].outerHTML);
            }

            var z = 0;
            var timerId = setInterval(function(obj) {
                $(main_obj.children()[z]).show('2000');
                z++;
                if(!main_obj.children()[z])
                    clearInterval(timerId);
            }, 1000, main_obj.children());

        });
    });
});
