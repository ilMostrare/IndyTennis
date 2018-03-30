function validateEmail(emailString) {
    var regX = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    // console.log(regX.test(emailString));
    return regX.test(emailString);
}

function setBindings() {


    $("#logo").click(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });

    //$('.navItem').click(function(){
    //    $(this).addClass('current').siblings('.navItem').removeClass('current');
    //});

    $("#singles tr:even").css({
        "background-color":"#dcdcdc"
    });
    $("#doubles tr:odd").css({
        "background-color":"#dcdcdc"
    });

    $("form .singles-player-name").click(function (evt) {
        evt.preventDefault();

        var viewPlayer = $(this).val();
        console.log(viewPlayer);

        $.ajax({
            url: '',
            type: 'POST',
            data: {
                viewPlayerID: viewPlayer
            }
        }).done(function (data) {
            console.log("Success");
            console.log(data);
            window.location.href = "Player";
        });
    });

    $("form .doubles-player-name").click(function (evt) {
        evt.preventDefault();

        var viewPlayer = $(this).val();
        console.log(viewPlayer);

        $.ajax({
            url: '',
            type: 'POST',
            data: {
                viewPlayerID: viewPlayer
            }
        }).done(function (data) {
            console.log("Success");
            console.log(data);
            window.location.href = "Player";
        });
    });

}

$(document).ready(function () {

    setBindings();

});