function validateEmail(emailString) {
    var regX = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    return regX.test(emailString);
}

function closeModal() {
    $(".modal-wrapper").css("display", "none")
}

function setBindings() {

    $("#logo").click(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });

    $('.optionsList li').click(function(){
        $(this).addClass('current').siblings('').removeClass('current');
    });

    $('#createMatches').click(function(){
        $('#createRoundMatches').css({"display":"block"});
    });
    $('#editMatches').click(function(){
        $('#createRoundMatches').css({"display":"none"});
    });
    $('#enterScores').click(function(){
        $('#createRoundMatches').css({"display":"none"});
    });
    $('#addAnnounce').click(function(){
        $('#createRoundMatches').css({"display":"none"});
    });
    $('#changePassword').click(function(){
        $('#createRoundMatches').css({"display":"none"});
    });

    $("#singles tr:even").css({
        "background-color":"#dcdcdc"
    });
    $("#doubles tr:odd").css({
        "background-color":"#dcdcdc"
    });

    $("#loginSubmit").click(function (evt) {
        evt.preventDefault();

        var logEM = $("#loginEM").val();
        var logPass = $("#loginPASS").val();

        //console.log(logEM);
        //console.log(logPass);

        if (logEM == ""){
            swal("Oops...", "Please Enter Your Email!", "error");
        } else if (!validateEmail(logEM)){
            swal("Oops...", "Please Enter a Valid Email!", "error");
        } else if (logPass == ""){
            swal("Oops...", "Please Enter Your Password!", "error");
        } else {
            $.ajax({
                url: '',
                type: 'POST',
                data: {
                    loginEmail: logEM,
                    loginPassword: logPass
                }
            }).done(function (data) {
                if(data.charAt(0)>0) {
                    console.log("Success");
                    //console.log(data);
                    window.location.href = "Admin";
                } else {
                    console.log("Failed");
                    //console.log(data);
                    swal("Oops...", "Login Information is Invalid!", "error");
                }
            });

        }
    });

    $("form .singles-player-name").click(function (evt) {
        evt.preventDefault();

        var viewPlayer = $(this).val();
        //console.log(viewPlayer);

        $.ajax({
            url: '',
            type: 'POST',
            data: {
                viewPlayerID: viewPlayer
            }
        }).done(function (data) {
            console.log("Success");
            //console.log(data);
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
            //console.log(data);
            window.location.href = "Player";
        });
    });

    $(".admin").click(function (evt) {
        $(".modal-wrapper").css("display", "flex");
        $(".login-wrapper").css("display", "block");
        //console.log("am i working?")
    });

    $(".close-button").click(function (evt) {
        closeModal();
    });

}

$(document).ready(function () {

    setBindings();

});