$(document).ready(function () {

    var auth_link = $('#auth_link');
    var reg_link = $('#reg_link');
    var register_block = $('#register_block');
    var login_block = $('#login_block');
    var auth_history_link = $('#auth_history_link');
    var auth_history = $('#auth_history');
    var last_users_link = $('#last_users_link');
    var last_registers_users = $('#last_registers_users');

    reg_link.on("click", function (event) {
        event.preventDefault();

        login_block.hide();
        register_block.show();
    });

    auth_link.on("click", function (event) {
        event.preventDefault();

        register_block.hide();
        login_block.show();
    });

    auth_history_link.on("click", function (event) {
        event.preventDefault();

        auth_history.toggle(200);
    });

    last_users_link.on("click", function (event) {
        event.preventDefault();

        last_registers_users.toggle(200);
    });

});