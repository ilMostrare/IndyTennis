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


    $('.navLinks .listA').click(function(){
        $(this).addClass('currentPage').siblings('').removeClass('currentPage');
    });

    //region Admin Functions
    $('#createMatches').click(function(){
        $('#createRoundMatches').css({"display":"block"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterScoreResults').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
    });
    $('#editMatches').click(function(){
        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"block"});
        $('#enterScoreResults').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
    });
    $('#enterScores').click(function(){
        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterScoreResults').css({"display":"block"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
    });
    $('#addAnnounce').click(function(){
        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterScoreResults').css({"display":"none"});
        $('#addAnnouncement').css({"display":"block"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
    });
    $('#changePassword').click(function(){
        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterScoreResults').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"block"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
    });
    $('#addPlayers').click(function(){
        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterScoreResults').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"block"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
    });
    $('#changeEmail').click(function(){
        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterScoreResults').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"block"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
    });
    $('#changePhone').click(function(){
        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterScoreResults').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"block"});
        $('#logout').css({"display":"none"});
    });
    $('#loggoutt').click(function(){
        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterScoreResults').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"block"});
    });
    //endregion

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
                    window.location.href = "";
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

    $("form .create-sgls-matches").click(function (evt) {
        evt.preventDefault();

        var createSGLSMatches = $(this).val();
        console.log(createSGLSMatches);

        $.ajax({
            url: '',
            type: 'POST',
            data: {
                createSGLSID: createSGLSMatches
            }
        }).done(function (data) {
            console.log("Success");
            console.log(data);
            swal("Success", "Singles Matches Created", "success");
        });
    });
}

$(document).ready(function () {

    setBindings();

});