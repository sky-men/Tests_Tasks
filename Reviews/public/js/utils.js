$(document).ready(function () {

    $('#sort').on("change", function (event) {

        document.location.href = '/?order=' + jQuery(this).val();
    });

    $('#preview').on("click", function (event) {

        var reviews = $('#reviews');

        var preview_content = $('#preview_content');

        if (preview_content)
            preview_content.remove();

        var name = $('#name');

        var email = $('#email');

        var review = $('#review');

        if (!name.val() || !email.val() || !review.val()) {
            alert('Заполните все поля');
            return false;
        }

        $('body,html').animate({scrollTop: 0}, 1);

        //todo верстку можно получить динамически
        reviews.prepend('<div id="preview_content"> <div> <div class="user_info"> <span class="user">' + name.val() + '</span> <span>(' + email.val() + ')</span> </div> </div> <div class="review"> ' + review.val() + ' </div> </div>');

        $('#preview_content').show('slow');
    });

});