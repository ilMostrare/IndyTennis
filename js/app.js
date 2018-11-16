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

    //#region Admin Functions
    $('#createMatches').click(function(){
        $('#createMatches').css({"background-color":"#ECECEC","border-radius":"5px"});
        $('#editMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterSGLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#enterDBLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#addAnnounce').css({"background-color":"white","border-radius":"5px"});
        $('#changePassword').css({"background-color":"white","border-radius":"5px"});
        $('#addPlayers').css({"background-color":"white","border-radius":"5px"});
        $('#changeEmail').css({"background-color":"white","border-radius":"5px"});
        $('#changePhone').css({"background-color":"white","border-radius":"5px"});
        $('#loggoutt').css({"background-color":"white","border-radius":"5px"});

        $('#createRoundMatches').css({"display":"block"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterSGLSScoreResults').css({"display":"none"});
        $('#enterDBLSScoreResults').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
    });
    $('#editMatches').click(function(){
        $('#editMatches').css({"background-color":"#ECECEC","border-radius":"5px"});
        $('#createMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterSGLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#enterDBLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#addAnnounce').css({"background-color":"white","border-radius":"5px"});
        $('#changePassword').css({"background-color":"white","border-radius":"5px"});
        $('#addPlayers').css({"background-color":"white","border-radius":"5px"});
        $('#changeEmail').css({"background-color":"white","border-radius":"5px"});
        $('#changePhone').css({"background-color":"white","border-radius":"5px"});
        $('#loggoutt').css({"background-color":"white","border-radius":"5px"});
        
        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"block"});
        $('#enterSGLSScoreResults').css({"display":"none"});
        $('#enterDBLSScoreResults').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
    });
    $('#enterSGLSScores').click(function(){
        $('#enterSGLSScores').css({"background-color":"#ECECEC","border-radius":"5px"});
        $('#createMatches').css({"background-color":"white","border-radius":"5px"});
        $('#editMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterDBLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#addAnnounce').css({"background-color":"white","border-radius":"5px"});
        $('#changePassword').css({"background-color":"white","border-radius":"5px"});
        $('#addPlayers').css({"background-color":"white","border-radius":"5px"});
        $('#changeEmail').css({"background-color":"white","border-radius":"5px"});
        $('#changePhone').css({"background-color":"white","border-radius":"5px"});
        $('#loggoutt').css({"background-color":"white","border-radius":"5px"});

        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterSGLSScoreResults').css({"display":"block"});
        $('#enterDBLSScoreResults').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
    });
    $('#enterDBLSScores').click(function(){
        $('#enterDBLSScores').css({"background-color":"#ECECEC","border-radius":"5px"});
        $('#createMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterSGLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#editMatches').css({"background-color":"white","border-radius":"5px"});
        $('#addAnnounce').css({"background-color":"white","border-radius":"5px"});
        $('#changePassword').css({"background-color":"white","border-radius":"5px"});
        $('#addPlayers').css({"background-color":"white","border-radius":"5px"});
        $('#changeEmail').css({"background-color":"white","border-radius":"5px"});
        $('#changePhone').css({"background-color":"white","border-radius":"5px"});
        $('#loggoutt').css({"background-color":"white","border-radius":"5px"});

        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterSGLSScoreResults').css({"display":"none"});
        $('#enterDBLSScoreResults').css({"display":"block"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
    });
    $('#addAnnounce').click(function(){
        $('#addAnnounce').css({"background-color":"#ECECEC","border-radius":"5px"});
        $('#createMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterSGLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#editMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterDBLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#changePassword').css({"background-color":"white","border-radius":"5px"});
        $('#addPlayers').css({"background-color":"white","border-radius":"5px"});
        $('#changeEmail').css({"background-color":"white","border-radius":"5px"});
        $('#changePhone').css({"background-color":"white","border-radius":"5px"});
        $('#loggoutt').css({"background-color":"white","border-radius":"5px"});

        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterSGLSScoreResults').css({"display":"none"});
        $('#enterDBLSScoreResults').css({"display":"none"});
        $('#addAnnouncement').css({"display":"block"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
    });
    $('#changePassword').click(function(){
        $('#changePassword').css({"background-color":"#ECECEC","border-radius":"5px"});
        $('#createMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterSGLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#editMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterDBLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#addAnnounce').css({"background-color":"white","border-radius":"5px"});
        $('#addPlayers').css({"background-color":"white","border-radius":"5px"});
        $('#changeEmail').css({"background-color":"white","border-radius":"5px"});
        $('#changePhone').css({"background-color":"white","border-radius":"5px"});
        $('#loggoutt').css({"background-color":"white","border-radius":"5px"});

        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterSGLSScoreResults').css({"display":"none"});
        $('#enterDBLSScoreResults').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"block"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
    });
    $('#addPlayers').click(function(){
        $('#addPlayers').css({"background-color":"#ECECEC","border-radius":"5px"});
        $('#createMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterSGLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#editMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterDBLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#addAnnounce').css({"background-color":"white","border-radius":"5px"});
        $('#changePassword').css({"background-color":"white","border-radius":"5px"});
        $('#changeEmail').css({"background-color":"white","border-radius":"5px"});
        $('#changePhone').css({"background-color":"white","border-radius":"5px"});
        $('#loggoutt').css({"background-color":"white","border-radius":"5px"});

        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterSGLSScoreResults').css({"display":"none"});
        $('#enterDBLSScoreResults').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"block"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
    });
    $('#changeEmail').click(function(){
        $('#changeEmail').css({"background-color":"#ECECEC","border-radius":"5px"});
        $('#createMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterSGLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#editMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterDBLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#addAnnounce').css({"background-color":"white","border-radius":"5px"});
        $('#changePassword').css({"background-color":"white","border-radius":"5px"});
        $('#addPlayers').css({"background-color":"white","border-radius":"5px"});
        $('#changePhone').css({"background-color":"white","border-radius":"5px"});
        $('#loggoutt').css({"background-color":"white","border-radius":"5px"});

        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterSGLSScoreResults').css({"display":"none"});
        $('#enterDBLSScoreResults').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"block"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
    });
    $('#changePhone').click(function(){
        $('#changePhone').css({"background-color":"#ECECEC","border-radius":"5px"});
        $('#createMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterSGLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#editMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterDBLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#addAnnounce').css({"background-color":"white","border-radius":"5px"});
        $('#changePassword').css({"background-color":"white","border-radius":"5px"});
        $('#addPlayers').css({"background-color":"white","border-radius":"5px"});
        $('#changeEmail').css({"background-color":"white","border-radius":"5px"});
        $('#loggoutt').css({"background-color":"white","border-radius":"5px"});

        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterSGLSScoreResults').css({"display":"none"});
        $('#enterDBLSScoreResults').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"block"});
        $('#logout').css({"display":"none"});
    });
    $('#loggoutt').click(function(){
        $('#loggoutt').css({"background-color":"#ECECEC","border-radius":"5px"});
        $('#createMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterSGLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#editMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterDBLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#addAnnounce').css({"background-color":"white","border-radius":"5px"});
        $('#changePassword').css({"background-color":"white","border-radius":"5px"});
        $('#addPlayers').css({"background-color":"white","border-radius":"5px"});
        $('#changeEmail').css({"background-color":"white","border-radius":"5px"});
        $('#changePhone').css({"background-color":"white","border-radius":"5px"});

        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterSGLSScoreResults').css({"display":"none"});
        $('#enterDBLSScoreResults').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"block"});
    });
    //#endregion

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

    //#region View Player Page
    $("form .singles-player-name").click(function (evt) {
        evt.preventDefault();

        var viewPlayer = $(this).val();
        console.log(viewPlayer);

        $.ajax({
            url: '',
            type: 'POST',
            data: {
                viewPlayerID: viewPlayer
            },
            success: function(data){
                console.log("Success"),
                //console.log(data);
                window.location.href = "Player"
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.Message);
              }
        })
    });
    $("form .singlesMatch-player1-name").click(function (evt) {
        evt.preventDefault();

        var viewPlayer = $(this).val();
        console.log(viewPlayer);

        $.ajax({
            url: '',
            type: 'POST',
            data: {
                viewMatchPlayerID: viewPlayer
            },
            success: function(data){
                console.log("Success"),
                //console.log(data);
                window.location.href = "Player"
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.Message);
            }
        })        
    });
    $("form .singlesMatch-player2-name").click(function (evt) {
        evt.preventDefault();

        var viewPlayer = $(this).val();
        console.log(viewPlayer);

        $.ajax({
            url: '',
            type: 'POST',
            data: {
                viewMatchPlayerID: viewPlayer
            },
            success: function(data){
                console.log("Success"),
                //console.log(data);
                window.location.href = "Player"
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.Message);
            }
        })
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
            },
            success: function(data){
                console.log("Success"),
                //console.log(data);
                window.location.href = "Player"
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.Message);
            }
        })
    });
    //#endregion

    //#region Admin Tools
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

    $("form #sglsScoreSubmit").click(function (evt) {
        evt.preventDefault();

        var sglsMatchID = parseInt($("#sglsMatchID").val());
        var sglsSet1P1 = parseInt($("#sglsSet1P1").val());
        var sglsSet2P1 = parseInt($("#sglsSet2P1").val());
        var sglsSet3P1 = $("#sglsSet3P1").val();
        var sglsSet1P2 = parseInt($("#sglsSet1P2").val());
        var sglsSet2P2 = parseInt($("#sglsSet2P2").val());
        var sglsSet3P2 = $("#sglsSet3P2").val();
        var sglsPlayoff = $("#sglsPlayoff").prop("checked");
        var sglsChallenge = $("#sglsChallenge").prop("checked");
        var sglsWinner = parseInt($('input[name=sglsWinner]:checked').val());

        //#region Value Handling
        if(sglsPlayoff == true){
            sglsPlayoff = 1;
        } else {
            sglsPlayoff = 0;
        };
        if(sglsChallenge == true){
            sglsChallenge = 1;
        } else {
            sglsChallenge = 0;
        };
        if(sglsSet3P1 == ''){
            sglsSet3P1 = 0;
        } else {
            sglsSet3P1 = parseInt(sglsSet3P1);
        };
        if(sglsSet3P2 == ''){
            sglsSet3P2 = 0;
        } else {
            sglsSet3P2 = parseInt(sglsSet3P2);
        };
        //#endregion

        // console.log(sglsMatchID," ",sglsSet1P1," ",sglsSet2P1," ",sglsSet3P1," ",sglsSet1P2," ",sglsSet2P2," ",sglsSet3P2," ",sglsPlayoff," ",sglsChallenge," ",sglsWinner);

        if ((sglsSet1P1 > 7) || isNaN(sglsSet1P1)){
            swal("Oops...", "Score Entered is Invalid!", "error");
        } else if ((sglsSet2P1 > 7) || isNaN(sglsSet2P1)){
            swal("Oops...", "Score Entered is Invalid!", "error");
        } else if (sglsSet3P1 > 7){
            swal("Oops...", "Score Entered is Invalid!", "error");
        } else if ((sglsSet1P2 > 7) || isNaN(sglsSet2P1)){
            swal("Oops...", "Score Entered is Invalid!", "error");
        } else if ((sglsSet2P2 > 7) || isNaN(sglsSet2P1)){
            swal("Oops...", "Score Entered is Invalid!", "error");
        } else if (sglsSet3P2 > 7){
            swal("Oops...", "Score Entered is Invalid!", "error");
        } else if (isNaN(sglsWinner)){
            swal("Oops...", "Please Select a Winner!", "error");
        } else {
            $.ajax({
                url: '',
                type: 'POST',
                data: {
                    ntrSGLSMatchID: sglsMatchID,
                    ntrSGLSS1P1: sglsSet1P1,
                    ntrSGLSS2P1: sglsSet2P1,
                    ntrSGLSS3P1: sglsSet3P1,
                    ntrSGLSS1P2: sglsSet1P2,
                    ntrSGLSS2P2: sglsSet2P2,
                    ntrSGLSS3P2: sglsSet3P2,
                    ntrSGLSPlayoff: sglsPlayoff,
                    ntrSGLSChallenge: sglsChallenge,
                    ntrSGLSWinner: sglsWinner
                }
            }).done(function (data) {
                console.log("Success");
                console.log(data);
                swal("Success", "Scores Entered", "success");
                $(".enterSGLSScores")[0].reset();
            });
            // console.log("hello");
        }
    });

    $("form #newPlayerSubmit").click(function (evt){
        evt.preventDefault();

        var newFName = $("#newFName").val();
        var newLName = $("#newLName").val();
        var newEmail = $("#newEmail").val();
        var newPhone = parseInt($("#newPhone").val());
        var newSGLSPoints = $("#newSGLSPoints").val();
        var newDBLSPoints = $("#newDBLSPoints").val();
        var newSGLSPlayer = $("#newSGLSPlayer").prop("checked");
        var newDBLSPlayer = $("#newDBLSPlayer").prop("checked");

        //#region Value Handling
        if(newSGLSPlayer == true){
            newSGLSPlayer = 1;
        } else {
            newSGLSPlayer = 0;
        };
        if(newDBLSPlayer == true){
            newDBLSPlayer = 1;
        } else {
            newDBLSPlayer = 0;
        };
        if(newSGLSPoints == ''){
            newSGLSPoints = 0;
        } else {
            newSGLSPoints = parseInt(newSGLSPoints);
        };
        if(newDBLSPoints == ''){
            newDBLSPoints = 0;
        } else {
            newDBLSPoints = parseInt(newDBLSPoints);
        };
        //#endregion

        //console.log(newFName," ",newLName," ",newEmail," ",newPhone," ",newSGLSPoints," ",newDBLSPoints," ",newSGLSPlayer," ",newDBLSPlayer);

        if ((newPhone.toString().length) != 10){
            swal("Oops...", "Please Enter a Valid Phone Number! (Must be 10 digits)", "error");
        } else if ((newSGLSPlayer == 1) && (newSGLSPoints == 0)){
            swal("Oops...", "Please Enter Starting Singles Points", "error");
        } else if ((newDBLSPlayer == 1) && (newDBLSPoints == 0)){
            swal("Oops...", "Please Enter Starting Doubles Points", "error");
        } else if ((newFName == '') || (newLName == '')){
            swal("Oops...", "Please Enter Player's Full Name", "error");
        } else if (newEmail == ''){
            swal("Oops...", "Please Enter Player's Email", "error");
        } else {
            $.ajax({
                url: '',
                type: 'POST',
                data: {
                    ntrNewFName: newFName,
                    ntrNewLName: newLName,
                    ntrNewEmail: newEmail,
                    ntrNewPhone: newPhone,
                    ntrNewSGLSPoints: newSGLSPoints,
                    ntrNewDBLSPoints: newDBLSPoints,
                    ntrNewSGLSPlayer: newSGLSPlayer,
                    ntrNewDBLSPlayer: newDBLSPlayer
                }
            }).done(function (data) {
                console.log("Success");
                console.log(data);
                swal("Success", "Scores Entered", "success");
                $(".addNewPLYR")[0].reset();
            });

            //console.log(newFName," ",newLName," ",newEmail," ",newPhone," ",newSGLSPoints," ",newDBLSPoints," ",newSGLSPlayer," ",newDBLSPlayer);

        } 

    });

    //#endregion
}

$(document).ready(function () {

    setBindings();

});