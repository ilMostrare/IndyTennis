function validateEmail(emailString) {
    var regX = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    return regX.test(emailString);
}

function pwGen() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  
    for (var i = 0; i < 10; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));
  
    return text;
}
  
//   console.log(makeid());

function setBindings() {

    //#region MISC

    $("#logo").click(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });


    $('.navLinks .listA').click(function(){
        $(this).addClass('currentPage').siblings('').removeClass('currentPage');
    });

    $("#singles tr:even").css({
        "background-color":"#dcdcdc"
    });    
    $("#doubles tr:odd").css({
        "background-color":"#dcdcdc"
    });
    $("#teamDoubles tr:even").css({
        "background-color":"#dcdcdc"
    });

    $("#loginSubmit").click(function (evt) {
        evt.preventDefault();

        var logEM = $("#loginEM").val();
        var logPass = $("#loginPASS").val();

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
                    //console.log("Success");
                    window.location.href = "";
                } else {
                    console.log("Failed");
                    swal("Oops...", "Login Information is Invalid!", "error");
                }
            });

        }
    });

    //#region ladder mobile view controller
    var ladderView = 1;
    $("#sglsLadderView").click(function (evt){
        $(this).css({"border-bottom-color": "#333333", "border-bottom-style": "solid", "border-bottom-width": ".5px", "color": "#333333"});
        $("#dblsLadderView").css({"border": "none", "color": "#868686"});
        $("#TDLadderView").css({"border": "none", "color": "#868686"});

        $(".left").css({"display":"block"});
        $(".right").css({"display":"none"});
        $(".farRight").css({"display":"none"});

        ladderView = 1;
    });
    $("#dblsLadderView").click(function (evt){
        $(this).css({"border-bottom-color": "#333333", "border-bottom-style": "solid", "border-bottom-width": ".5px", "color": "#333333"});
        $("#sglsLadderView").css({"border": "none", "color": "#868686"});
        $("#TDLadderView").css({"border": "none", "color": "#868686"});

        $(".left").css({"display":"none"});
        $(".right").css({"display":"block"});
        $(".farRight").css({"display":"none"});

        ladderView = 2;
    });
    $("#TDLadderView").click(function (evt){
        $(this).css({"border-bottom-color": "#333333", "border-bottom-style": "solid", "border-bottom-width": ".5px", "color": "#333333"});
        $("#dblsLadderView").css({"border": "none", "color": "#868686"});
        $("#sglsLadderView").css({"border": "none", "color": "#868686"});

        $(".left").css({"display":"none"});
        $(".right").css({"display":"none"});
        $(".farRight").css({"display":"block"});

        ladderView = 3
    });
    //#endregion

    //#region edit player view controller
    $(".updateEM").css({"display":"none"});
    $(".updatePN").css({"display":"none"});
    $("#passwordView").css({"border-bottom-color": "#333333", "border-bottom-style": "solid", "border-bottom-width": ".5px", "color": "#333333"});
    $("#phoneView").css({"border": "none", "color": "#868686"});
    $("#emailView").css({"border": "none", "color": "#868686"});

    $("#passwordView").click(function (evt){
        $(this).css({"border-bottom-color": "#333333", "border-bottom-style": "solid", "border-bottom-width": ".5px", "color": "#333333"});
        $("#phoneView").css({"border": "none", "color": "#868686"});
        $("#emailView").css({"border": "none", "color": "#868686"});

        $(".updatePW").css({"display":"block"});
        $(".updateEM").css({"display":"none"});
        $(".updatePN").css({"display":"none"});
    });
    $("#emailView").click(function (evt){
        $(this).css({"border-bottom-color": "#333333", "border-bottom-style": "solid", "border-bottom-width": ".5px", "color": "#333333"});
        $("#passwordView").css({"border": "none", "color": "#868686"});
        $("#phoneView").css({"border": "none", "color": "#868686"});

        $(".updatePW").css({"display":"none"});
        $(".updateEM").css({"display":"block"});
        $(".updatePN").css({"display":"none"});
    });
    $("#phoneView").click(function (evt){
        $(this).css({"border-bottom-color": "#333333", "border-bottom-style": "solid", "border-bottom-width": ".5px", "color": "#333333"});
        $("#passwordView").css({"border": "none", "color": "#868686"});
        $("#emailView").css({"border": "none", "color": "#868686"});

        $(".updatePW").css({"display":"none"});
        $(".updateEM").css({"display":"none"});
        $(".updatePN").css({"display":"block"});
    });
    //#endregion

    //#region edit matches view controller
    $(".editDBLSMatch").css({"display":"none"});
    $(".editTDMatch").css({"display":"none"});
    $("#editSGView").css({"border-bottom-color": "#333333", "border-bottom-style": "solid", "border-bottom-width": ".5px", "color": "#333333"});
    $("#editDBView").css({"border": "none", "color": "#868686"});
    $("#editTDView").css({"border": "none", "color": "#868686"});

    $("#editSGView").click(function (evt){
        $(this).css({"border-bottom-color": "#333333", "border-bottom-style": "solid", "border-bottom-width": ".5px", "color": "#333333"});
        $("#editTDView").css({"border": "none", "color": "#868686"});
        $("#editDBView").css({"border": "none", "color": "#868686"});

        $(".editSGLSMatch").css({"display":"block"});
        $(".editDBLSMatch").css({"display":"none"});
        $(".editTDMatch").css({"display":"none"});
    });
    $("#editDBView").click(function (evt){
        $(this).css({"border-bottom-color": "#333333", "border-bottom-style": "solid", "border-bottom-width": ".5px", "color": "#333333"});
        $("#editSGView").css({"border": "none", "color": "#868686"});
        $("#editTDView").css({"border": "none", "color": "#868686"});

        $(".editSGLSMatch").css({"display":"none"});
        $(".editDBLSMatch").css({"display":"block"});
        $(".editTDMatch").css({"display":"none"});
    });
    $("#editTDView").click(function (evt){
        $(this).css({"border-bottom-color": "#333333", "border-bottom-style": "solid", "border-bottom-width": ".5px", "color": "#333333"});
        $("#editSGView").css({"border": "none", "color": "#868686"});
        $("#editDBView").css({"border": "none", "color": "#868686"});

        $(".editSGLSMatch").css({"display":"none"});
        $(".editDBLSMatch").css({"display":"none"});
        $(".editTDMatch").css({"display":"block"});
    });
    //#endregion
    
    //#region enter scores view controller
    $(".enterDBLSScores").css({"display":"none"});
    $(".enterTDScores").css({"display":"none"});
    $("#enterSGView").css({"border-bottom-color": "#333333", "border-bottom-style": "solid", "border-bottom-width": ".5px", "color": "#333333"});
    $("#enterDBView").css({"border": "none", "color": "#868686"});
    $("#enterTDView").css({"border": "none", "color": "#868686"});

    $("#enterSGView").click(function (evt){
        $(this).css({"border-bottom-color": "#333333", "border-bottom-style": "solid", "border-bottom-width": ".5px", "color": "#333333"});
        $("#enterTDView").css({"border": "none", "color": "#868686"});
        $("#enterDBView").css({"border": "none", "color": "#868686"});

        $(".enterSGLSScores").css({"display":"block"});
        $(".enterDBLSScores").css({"display":"none"});
        $(".enterTDScores").css({"display":"none"});
    });
    $("#enterDBView").click(function (evt){
        $(this).css({"border-bottom-color": "#333333", "border-bottom-style": "solid", "border-bottom-width": ".5px", "color": "#333333"});
        $("#enterSGView").css({"border": "none", "color": "#868686"});
        $("#enterTDView").css({"border": "none", "color": "#868686"});

        $(".enterSGLSScores").css({"display":"none"});
        $(".enterDBLSScores").css({"display":"block"});
        $(".enterTDScores").css({"display":"none"});
    });
    $("#enterTDView").click(function (evt){
        $(this).css({"border-bottom-color": "#333333", "border-bottom-style": "solid", "border-bottom-width": ".5px", "color": "#333333"});
        $("#enterSGView").css({"border": "none", "color": "#868686"});
        $("#enterDBView").css({"border": "none", "color": "#868686"});

        $(".enterSGLSScores").css({"display":"none"});
        $(".enterDBLSScores").css({"display":"none"});
        $(".enterTDScores").css({"display":"block"});
    });
    //#endregion

    $( window ).resize( function( evt ) {
        // $( "#orientation" ).text( "This device is in " + evt.orientation + " mode!" );
        if(window.innerWidth > window.innerHeight){
            $(".left").css({"display":"block"});
            $(".right").css({"display":"block"});
            $(".farRight").css({"display":"block"});
        } else {
            if(ladderView == 1){
                $(".left").css({"display":"block"});
                $(".right").css({"display":"none"});
                $(".farRight").css({"display":"none"});
            } else if (ladderView == 2){
                $(".left").css({"display":"none"});
                $(".right").css({"display":"block"});
                $(".farRight").css({"display":"none"});
            } else {
                $(".left").css({"display":"none"});
                $(".right").css({"display":"none"});
                $(".farRight").css({"display":"block"});
            }
        }
    });

    //#endregion

    //#region Admin Functions
    $('#createMatches').click(function(){
        $('#createMatches').css({"background-color":"#ECECEC","border-radius":"5px"});
        $('#editMatches').css({"background-color":"white","border-radius":"5px"});
        $('#addChallengeM').css({"background-color":"white","border-radius":"5px"});
        $('#enterSGLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#dropLadderView').css({"background-color":"white","border-radius":"5px"});
        $('#addAnnounce').css({"background-color":"white","border-radius":"5px"});
        $('#changePassword').css({"background-color":"white","border-radius":"5px"});
        $('#addPlayers').css({"background-color":"white","border-radius":"5px"});
        $('#changeEmail').css({"background-color":"white","border-radius":"5px"});
        $('#changePhone').css({"background-color":"white","border-radius":"5px"});
        $('#loggoutt').css({"background-color":"white","border-radius":"5px"});
        $('#addTDTeam').css({"background-color":"white","border-radius":"5px"});

        $('#createRoundMatches').css({"display":"block"});
        $('#editRoundMatches').css({"display":"none"});
        $('#addChallengeMatch').css({"display":"none"});
        $('#enterSGLSScoreResults').css({"display":"none"});
        $('#dropLadderDiv').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
        $('#addNewTDTeam').css({"display":"none"});

        $(".enterSGLSScores")[0].reset();
        $(".addNewPLYR")[0].reset();
        $(".updatePW")[0].reset();
        $(".editDBLSMatch")[0].reset();
        $(".addAnnounce")[0].reset();
        $(".updatePN")[0].reset();
        $(".enterDBLSScores")[0].reset();
        $(".editSGLSMatch")[0].reset();
        $(".editDBLSMatch")[0].reset();
        $(".addChallenge")[0].reset();
        $(".addNewTD")[0].reset();
    });
    $('#editMatches').click(function(){
        $('#editMatches').css({"background-color":"#ECECEC","border-radius":"5px"});
        $('#createMatches').css({"background-color":"white","border-radius":"5px"});
        $('#addChallengeM').css({"background-color":"white","border-radius":"5px"});
        $('#enterSGLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#dropLadderView').css({"background-color":"white","border-radius":"5px"});
        $('#addAnnounce').css({"background-color":"white","border-radius":"5px"});
        $('#changePassword').css({"background-color":"white","border-radius":"5px"});
        $('#addPlayers').css({"background-color":"white","border-radius":"5px"});
        $('#changeEmail').css({"background-color":"white","border-radius":"5px"});
        $('#changePhone').css({"background-color":"white","border-radius":"5px"});
        $('#loggoutt').css({"background-color":"white","border-radius":"5px"});
        $('#addTDTeam').css({"background-color":"white","border-radius":"5px"});
        
        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"block"});
        $('#addChallengeMatch').css({"display":"none"});
        $('#enterSGLSScoreResults').css({"display":"none"});
        $('#dropLadderDiv').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
        $('#addNewTDTeam').css({"display":"none"});

        $(".enterSGLSScores")[0].reset();
        $(".addNewPLYR")[0].reset();
        $(".updatePW")[0].reset();
        $(".editDBLSMatch")[0].reset();
        $(".addAnnounce")[0].reset();
        $(".updatePN")[0].reset();
        $(".enterDBLSScores")[0].reset();
        $(".addChallenge")[0].reset();
        // $(".editSGLSMatch")[0].reset();
        // $(".editDBLSMatch")[0].reset();
        $(".addNewTD")[0].reset();
    });
    $('#addChallengeM').click(function(){
        $('#addChallengeM').css({"background-color":"#ECECEC","border-radius":"5px"});
        $('#editMatches').css({"background-color":"white","border-radius":"5px"});
        $('#createMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterSGLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#dropLadderView').css({"background-color":"white","border-radius":"5px"});
        $('#addAnnounce').css({"background-color":"white","border-radius":"5px"});
        $('#changePassword').css({"background-color":"white","border-radius":"5px"});
        $('#addPlayers').css({"background-color":"white","border-radius":"5px"});
        $('#changeEmail').css({"background-color":"white","border-radius":"5px"});
        $('#changePhone').css({"background-color":"white","border-radius":"5px"});
        $('#loggoutt').css({"background-color":"white","border-radius":"5px"});
        $('#addTDTeam').css({"background-color":"white","border-radius":"5px"});
        
        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#addChallengeMatch').css({"display":"block"});
        $('#enterSGLSScoreResults').css({"display":"none"});
        $('#dropLadderDiv').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
        $('#addNewTDTeam').css({"display":"none"});

        $(".enterSGLSScores")[0].reset();
        $(".addNewPLYR")[0].reset();
        $(".updatePW")[0].reset();
        $(".editDBLSMatch")[0].reset();
        $(".addAnnounce")[0].reset();
        $(".updatePN")[0].reset();
        $(".enterDBLSScores")[0].reset();
        $(".editSGLSMatch")[0].reset();
        $(".editDBLSMatch")[0].reset();
        // $(".addChallenge")[0].reset();
        $(".addNewTD")[0].reset();
    });
    $('#enterSGLSScores').click(function(){
        $('#enterSGLSScores').css({"background-color":"#ECECEC","border-radius":"5px"});
        $('#createMatches').css({"background-color":"white","border-radius":"5px"});
        $('#editMatches').css({"background-color":"white","border-radius":"5px"});
        $('#addChallengeM').css({"background-color":"white","border-radius":"5px"});
        $('#dropLadderView').css({"background-color":"white","border-radius":"5px"});
        $('#addAnnounce').css({"background-color":"white","border-radius":"5px"});
        $('#changePassword').css({"background-color":"white","border-radius":"5px"});
        $('#addPlayers').css({"background-color":"white","border-radius":"5px"});
        $('#changeEmail').css({"background-color":"white","border-radius":"5px"});
        $('#changePhone').css({"background-color":"white","border-radius":"5px"});
        $('#loggoutt').css({"background-color":"white","border-radius":"5px"});
        $('#addTDTeam').css({"background-color":"white","border-radius":"5px"});

        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterSGLSScoreResults').css({"display":"block"});
        $('#dropLadderDiv').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
        $('#addChallengeMatch').css({"display":"none"});
        $('#addNewTDTeam').css({"display":"none"});

        // $(".enterSGLSScores")[0].reset();
        $(".addNewPLYR")[0].reset();
        $(".updatePW")[0].reset();
        $(".editDBLSMatch")[0].reset();
        $(".addAnnounce")[0].reset();
        $(".updatePN")[0].reset();
        $(".enterDBLSScores")[0].reset();
        $(".editSGLSMatch")[0].reset();
        $(".editDBLSMatch")[0].reset();
        $(".addChallenge")[0].reset();
        $(".addNewTD")[0].reset();
    });
    $('#dropLadderView').click(function(){
        $('#dropLadderView').css({"background-color":"#ECECEC","border-radius":"5px"});
        $('#createMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterSGLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#editMatches').css({"background-color":"white","border-radius":"5px"});
        $('#addChallengeM').css({"background-color":"white","border-radius":"5px"});
        $('#addAnnounce').css({"background-color":"white","border-radius":"5px"});
        $('#changePassword').css({"background-color":"white","border-radius":"5px"});
        $('#addPlayers').css({"background-color":"white","border-radius":"5px"});
        $('#changeEmail').css({"background-color":"white","border-radius":"5px"});
        $('#changePhone').css({"background-color":"white","border-radius":"5px"});
        $('#loggoutt').css({"background-color":"white","border-radius":"5px"});
        $('#addTDTeam').css({"background-color":"white","border-radius":"5px"});

        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterSGLSScoreResults').css({"display":"none"});
        $('#dropLadderDiv').css({"display":"block"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
        $('#addChallengeMatch').css({"display":"none"});
        $('#addNewTDTeam').css({"display":"none"});

        $(".enterSGLSScores")[0].reset();
        $(".addNewPLYR")[0].reset();
        $(".updatePW")[0].reset();
        $(".editDBLSMatch")[0].reset();
        $(".addAnnounce")[0].reset();
        $(".updatePN")[0].reset();
        // $(".enterDBLSScores")[0].reset();
        $(".editSGLSMatch")[0].reset();
        $(".editDBLSMatch")[0].reset();
        $(".addChallenge")[0].reset();
        $(".addNewTD")[0].reset();
    });
    $('#addAnnounce').click(function(){
        $('#addAnnounce').css({"background-color":"#ECECEC","border-radius":"5px"});
        $('#createMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterSGLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#editMatches').css({"background-color":"white","border-radius":"5px"});
        $('#addChallengeM').css({"background-color":"white","border-radius":"5px"});
        $('#dropLadderView').css({"background-color":"white","border-radius":"5px"});
        $('#changePassword').css({"background-color":"white","border-radius":"5px"});
        $('#addPlayers').css({"background-color":"white","border-radius":"5px"});
        $('#changeEmail').css({"background-color":"white","border-radius":"5px"});
        $('#changePhone').css({"background-color":"white","border-radius":"5px"});
        $('#loggoutt').css({"background-color":"white","border-radius":"5px"});
        $('#addTDTeam').css({"background-color":"white","border-radius":"5px"});

        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterSGLSScoreResults').css({"display":"none"});
        $('#dropLadderDiv').css({"display":"none"});
        $('#addAnnouncement').css({"display":"block"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
        $('#addChallengeMatch').css({"display":"none"});
        $('#addNewTDTeam').css({"display":"none"});

        $(".enterSGLSScores")[0].reset();
        $(".addNewPLYR")[0].reset();
        $(".updatePW")[0].reset();
        $(".editDBLSMatch")[0].reset();
        // $(".addAnnounce")[0].reset();
        $(".updatePN")[0].reset();
        $(".enterDBLSScores")[0].reset();
        $(".editSGLSMatch")[0].reset();
        $(".editDBLSMatch")[0].reset();
        $(".addChallenge")[0].reset();
        $(".addNewTD")[0].reset();
    });
    $('#changePassword').click(function(){
        $('#changePassword').css({"background-color":"#ECECEC","border-radius":"5px"});
        $('#createMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterSGLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#editMatches').css({"background-color":"white","border-radius":"5px"});
        $('#addChallengeM').css({"background-color":"white","border-radius":"5px"});
        $('#dropLadderView').css({"background-color":"white","border-radius":"5px"});
        $('#addAnnounce').css({"background-color":"white","border-radius":"5px"});
        $('#addPlayers').css({"background-color":"white","border-radius":"5px"});
        $('#changeEmail').css({"background-color":"white","border-radius":"5px"});
        $('#changePhone').css({"background-color":"white","border-radius":"5px"});
        $('#loggoutt').css({"background-color":"white","border-radius":"5px"});
        $('#addTDTeam').css({"background-color":"white","border-radius":"5px"});

        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterSGLSScoreResults').css({"display":"none"});
        $('#dropLadderDiv').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"block"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
        $('#addChallengeMatch').css({"display":"none"});
        $('#addNewTDTeam').css({"display":"none"});

        $(".enterSGLSScores")[0].reset();
        $(".addNewPLYR")[0].reset();
        // $(".updatePW")[0].reset();
        $(".editDBLSMatch")[0].reset();
        $(".addAnnounce")[0].reset();
        $(".updatePN")[0].reset();
        $(".enterDBLSScores")[0].reset();
        $(".editSGLSMatch")[0].reset();
        $(".editDBLSMatch")[0].reset();
        $(".addChallenge")[0].reset();
        $(".addNewTD")[0].reset();
    });
    $('#addPlayers').click(function(){
        $('#addPlayers').css({"background-color":"#ECECEC","border-radius":"5px"});
        $('#createMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterSGLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#editMatches').css({"background-color":"white","border-radius":"5px"});
        $('#addChallengeM').css({"background-color":"white","border-radius":"5px"});
        $('#dropLadderView').css({"background-color":"white","border-radius":"5px"});
        $('#addAnnounce').css({"background-color":"white","border-radius":"5px"});
        $('#changePassword').css({"background-color":"white","border-radius":"5px"});
        $('#changeEmail').css({"background-color":"white","border-radius":"5px"});
        $('#changePhone').css({"background-color":"white","border-radius":"5px"});
        $('#loggoutt').css({"background-color":"white","border-radius":"5px"});
        $('#addTDTeam').css({"background-color":"white","border-radius":"5px"});

        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterSGLSScoreResults').css({"display":"none"});
        $('#dropLadderDiv').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"block"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
        $('#addChallengeMatch').css({"display":"none"});
        $('#addNewTDTeam').css({"display":"none"});

        $(".enterSGLSScores")[0].reset();
        // $(".addNewPLYR")[0].reset();
        $(".updatePW")[0].reset();
        $(".addAnnounce")[0].reset();
        $(".editDBLSMatch")[0].reset();
        $(".updatePN")[0].reset();
        $(".enterDBLSScores")[0].reset();
        $(".editSGLSMatch")[0].reset();
        $(".editDBLSMatch")[0].reset();
        $(".addChallenge")[0].reset();
        $(".addNewTD")[0].reset();
    });
    $('#addTDTeam').click(function(){
        $('#addTDTeam').css({"background-color":"#ECECEC","border-radius":"5px"});
        $('#createMatches').css({"background-color":"white","border-radius":"5px"});
        $('#editMatches').css({"background-color":"white","border-radius":"5px"});
        $('#addChallengeM').css({"background-color":"white","border-radius":"5px"});
        $('#enterSGLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#dropLadderView').css({"background-color":"white","border-radius":"5px"});
        $('#addAnnounce').css({"background-color":"white","border-radius":"5px"});
        $('#changePassword').css({"background-color":"white","border-radius":"5px"});
        $('#addPlayers').css({"background-color":"white","border-radius":"5px"});
        $('#changeEmail').css({"background-color":"white","border-radius":"5px"});
        $('#changePhone').css({"background-color":"white","border-radius":"5px"});
        $('#loggoutt').css({"background-color":"white","border-radius":"5px"});

        $('#addNewTDTeam').css({"display":"block"});
        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#addChallengeMatch').css({"display":"none"});
        $('#enterSGLSScoreResults').css({"display":"none"});
        $('#dropLadderDiv').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});

        //$(".addNewTD")[0].reset();
        $(".enterSGLSScores")[0].reset();
        $(".addNewPLYR")[0].reset();
        $(".updatePW")[0].reset();
        $(".editDBLSMatch")[0].reset();
        $(".addAnnounce")[0].reset();
        $(".updatePN")[0].reset();
        $(".enterDBLSScores")[0].reset();
        $(".editSGLSMatch")[0].reset();
        $(".editDBLSMatch")[0].reset();
        $(".addChallenge")[0].reset();
    });
    $('#changeEmail').click(function(){
        $('#changeEmail').css({"background-color":"#ECECEC","border-radius":"5px"});
        $('#createMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterSGLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#editMatches').css({"background-color":"white","border-radius":"5px"});
        $('#addChallengeM').css({"background-color":"white","border-radius":"5px"});
        $('#dropLadderView').css({"background-color":"white","border-radius":"5px"});
        $('#addAnnounce').css({"background-color":"white","border-radius":"5px"});
        $('#changePassword').css({"background-color":"white","border-radius":"5px"});
        $('#addPlayers').css({"background-color":"white","border-radius":"5px"});
        $('#changePhone').css({"background-color":"white","border-radius":"5px"});
        $('#loggoutt').css({"background-color":"white","border-radius":"5px"});
        $('#addTDTeam').css({"background-color":"white","border-radius":"5px"});

        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterSGLSScoreResults').css({"display":"none"});
        $('#dropLadderDiv').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"block"});
        $('#logout').css({"display":"none"});
        $('#addChallengeMatch').css({"display":"none"});
        $('#addNewTDTeam').css({"display":"none"});

        $(".enterSGLSScores")[0].reset();
        $(".addNewPLYR")[0].reset();
        $(".updatePW")[0].reset();
        $(".addAnnounce")[0].reset();
        // $(".editDBLSMatch")[0].reset();
        $(".updatePN")[0].reset();
        $(".enterDBLSScores")[0].reset();
        $(".editSGLSMatch")[0].reset();
        $(".editDBLSMatch")[0].reset();
        $(".addChallenge")[0].reset();
        $(".addNewTD")[0].reset();
    });
    $('#changePhone').click(function(){
        $('#changePhone').css({"background-color":"#ECECEC","border-radius":"5px"});
        $('#createMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterSGLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#editMatches').css({"background-color":"white","border-radius":"5px"});
        $('#addChallengeM').css({"background-color":"white","border-radius":"5px"});
        $('#dropLadderView').css({"background-color":"white","border-radius":"5px"});
        $('#addAnnounce').css({"background-color":"white","border-radius":"5px"});
        $('#changePassword').css({"background-color":"white","border-radius":"5px"});
        $('#addPlayers').css({"background-color":"white","border-radius":"5px"});
        $('#changeEmail').css({"background-color":"white","border-radius":"5px"});
        $('#loggoutt').css({"background-color":"white","border-radius":"5px"});
        $('#addTDTeam').css({"background-color":"white","border-radius":"5px"});

        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterSGLSScoreResults').css({"display":"none"});
        $('#dropLadderDiv').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"block"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"none"});
        $('#addChallengeMatch').css({"display":"none"});
        $('#addNewTDTeam').css({"display":"none"});

        $(".enterSGLSScores")[0].reset();
        $(".addNewPLYR")[0].reset();
        $(".updatePW")[0].reset();
        $(".editDBLSMatch")[0].reset();
        $(".addAnnounce")[0].reset();
        // $(".updatePN")[0].reset();
        $(".enterDBLSScores")[0].reset();
        $(".editSGLSMatch")[0].reset();
        $(".editDBLSMatch")[0].reset();
        $(".addChallenge")[0].reset();
        $(".addNewTD")[0].reset();
    });
    $('#loggoutt').click(function(){
        $('#loggoutt').css({"background-color":"#ECECEC","border-radius":"5px"});
        $('#createMatches').css({"background-color":"white","border-radius":"5px"});
        $('#enterSGLSScores').css({"background-color":"white","border-radius":"5px"});
        $('#editMatches').css({"background-color":"white","border-radius":"5px"});
        $('#addChallengeM').css({"background-color":"white","border-radius":"5px"});
        $('#dropLadderView').css({"background-color":"white","border-radius":"5px"});
        $('#addAnnounce').css({"background-color":"white","border-radius":"5px"});
        $('#changePassword').css({"background-color":"white","border-radius":"5px"});
        $('#addPlayers').css({"background-color":"white","border-radius":"5px"});
        $('#changeEmail').css({"background-color":"white","border-radius":"5px"});
        $('#changePhone').css({"background-color":"white","border-radius":"5px"});
        $('#addTDTeam').css({"background-color":"white","border-radius":"5px"});

        $('#createRoundMatches').css({"display":"none"});
        $('#editRoundMatches').css({"display":"none"});
        $('#enterSGLSScoreResults').css({"display":"none"});
        $('#dropLadderDiv').css({"display":"none"});
        $('#addAnnouncement').css({"display":"none"});
        $('#changePW').css({"display":"none"});
        $('#addNewPlayers').css({"display":"none"});
        $('#changePH').css({"display":"none"});
        $('#changeEM').css({"display":"none"});
        $('#logout').css({"display":"block"});
        $('#addChallengeMatch').css({"display":"none"});
        $('#addNewTDTeam').css({"display":"none"});

        $(".enterSGLSScores")[0].reset();
        $(".enterDBLSScores")[0].reset();
        $(".addNewPLYR")[0].reset();
        $(".updatePW")[0].reset();
        $(".editDBLSMatch")[0].reset();
        $(".addAnnounce")[0].reset();
        $(".updatePN")[0].reset();
        $(".editSGLSMatch")[0].reset();
        $(".editDBLSMatch")[0].reset();
        $(".addChallenge")[0].reset();
        $(".addNewTD")[0].reset();

        var logoutID = 1;

        swal({
            title: 'Are you sure you want to logout?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#53A548',
            cancelButtonColor: 'dimgrey',
            confirmButtonText: 'Logout',
            closeOnConfirm: false
        },function () {
            swal(
                'Logged Out!', '', 'success'
            );

            $.ajax({
                url: '',
                type: 'POST',
                data: {
                    logout: logoutID
                }
            }).done(function (data) {
                //console.log("Success");
                window.location.href = "/index.php";
            });
        })
    });
    //#endregion

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
                //console.log("Success"),
                //console.log(data);
                window.location.href = "Player.php"
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
                //console.log("Success"),
                //console.log(data);
                window.location.href = "Player.php"
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.Message);
              }
        })
    });
    $("form .TD-player-name").click(function (evt) {
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
                //console.log("Success"),
                //console.log(data);
                window.location.href = "Player.php"
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

        if (viewPlayer == 11){
            //do nothing
        } else {
            $.ajax({
                url: '',
                type: 'POST',
                data: {
                    viewMatchPlayerID: viewPlayer
                },
                success: function(data){
                    //console.log("Success"),
                    ////console.log(data);
                    window.location.href = "Player.php"
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }
            })
        }
                
    });
    $("form .singlesMatch-player2-name").click(function (evt) {
        evt.preventDefault();

        var viewPlayer = $(this).val();
        console.log(viewPlayer);

        if (viewPlayer == 11){
            //do nothing
        } else {
            $.ajax({
                url: '',
                type: 'POST',
                data: {
                    viewMatchPlayerID: viewPlayer
                },
                success: function(data){
                    //console.log("Success"),
                    ////console.log(data);
                    window.location.href = "Player.php"
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }
            })
        }
    });

    $("form .doublesMatch-player-name").click(function (evt) {
        evt.preventDefault();

        var viewPlayer = $(this).val();
        console.log(viewPlayer);

        if (viewPlayer == 11){
            //do nothing
        } else {
            $.ajax({
                url: '',
                type: 'POST',
                data: {
                    viewMatchPlayerID: viewPlayer
                },
                success: function(data){
                    //console.log("Success"),
                    ////console.log(data);
                    window.location.href = "Player.php"
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }
            })
        }
    });

    $("form .TDMatch-player-name").click(function (evt) {
        evt.preventDefault();

        var viewPlayer = $(this).val();
        console.log(viewPlayer);

        if (viewPlayer == 11){
            //do nothing
        } else {
            $.ajax({
                url: '',
                type: 'POST',
                data: {
                    viewMatchPlayerID: viewPlayer
                },
                success: function(data){
                    //console.log("Success"),
                    ////console.log(data);
                    window.location.href = "Player.php"
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }
            })
        }
    });

    $("#viewPlayerPage").click(function (evt) {
        evt.preventDefault();

        var viewPlayer = $(this).data('value');
        console.log(viewPlayer);

        $.ajax({
            url: '',
            type: 'POST',
            data: {
                viewMatchPlayerID: viewPlayer
            },
            success: function(data){
                //console.log("Success"),
                ////console.log(data);
                window.location.href = "Player.php"
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.Message);
            }
        })
                
    });

    $(".viewPlayer").click(function (evt) {
        evt.preventDefault();
        var viewPlayer = $(this).val();

        if (viewPlayer == 11){
            //do nothing
        } else {
            $.ajax({
                url: '',
                type: 'POST',
                data: {
                    viewMatchPlayerID: viewPlayer
                },
                success: function(data){
                    //console.log("Success"),
                    ////console.log(data);
                    window.location.href = "Player.php"
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }
            })
        }
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
            //console.log("Success");
            // console.log(data);
            swal({title: "Success", text: "Singles Matches Created!", type: "success"},
                function(){ 
                    // do nothing
                }
            );
        });
    });

    $("form .create-dbls-matches").click(function (evt) {
        evt.preventDefault();

        var createDBLSMatches = $(this).val();
        console.log(createDBLSMatches);

        $.ajax({
            url: '',
            type: 'POST',
            data: {
                createDBLSID: createDBLSMatches
            }
        }).done(function (data) {
            //console.log("Success");
            // console.log(data);
            swal({title: "Success", text: "Doubles Matches Created!", type: "success"},
                function(){ 
                   // do nothing
                }
            );
        });
    });

    $("form .create-TD-matches").click(function (evt) {
        evt.preventDefault();

        var createTDMatches = $(this).val();
        console.log(createTDMatches);

        $.ajax({
            url: '',
            type: 'POST',
            data: {
                createTDID: createTDMatches
            }
        }).done(function (data) {
            //console.log("Success");
            // console.log(data);
            swal({title: "Success", text: "Team Doubles Matches Created!", type: "success"},
                function(){ 
                    // do nothing
                }
            );
        });
    });

    $("form #sglsMatchEditSubmit").click(function (evt) {
        evt.preventDefault();

        var editsglsMatchID = parseInt($("#editsglsMatchID").val());
        var editSGLSP1 = $("#editSGLSP1").val();
        var editSGLSP2 = $("#editSGLSP2").val();

        //#region Value Handling
        if (editSGLSP1 == ''){
            editSGLSP1 = 0;
        } else {
            editSGLSP1 = parseInt(editSGLSP1);
        }

        if (editSGLSP2 == ''){
            editSGLSP2 = 0;
        } else {
            editSGLSP2 = parseInt(editSGLSP2);
        }
        //#endregion

        console.log(editsglsMatchID+" "+editSGLSP1+" "+editSGLSP2);

        $.ajax({
            url: '',
            type: 'POST',
            data: {
                ntrEditsglsMatchID: editsglsMatchID,
                ntrEditSGLSP1: editSGLSP1,
                ntrEditSGLSP2: editSGLSP2
            }
        }).done(function (data) {
            //console.log("Success");
            //console.log(data);
            swal({title: "Success", text: "Singles Match Updated!", type: "success"},
                function(){ 
                    location.reload();
                }
            );
            $(".editSGLSMatch")[0].reset();
        });
    });

    $("form #dblsMatchEditSubmit").click(function (evt) {
        evt.preventDefault();

        var editdblsMatchID = parseInt($("#editdblsMatchID").val());
        var editDBLSP1 = $("#editDBLSP1").val();
        var editDBLSP2 = $("#editDBLSP2").val();
        var editDBLSP3 = $("#editDBLSP3").val();
        var editDBLSP4 = $("#editDBLSP4").val();

        //#region Value Handling
        if (editDBLSP1 == ''){
            editDBLSP1 = 0;
        } else {
            editDBLSP1 = parseInt(editDBLSP1);
        }

        if (editDBLSP2 == ''){
            editDBLSP2 = 0;
        } else {
            editDBLSP2 = parseInt(editDBLSP2);
        }

        if (editDBLSP3 == ''){
            editDBLSP3 = 0;
        } else {
            editDBLSP3 = parseInt(editDBLSP3);
        }

        if (editDBLSP4 == ''){
            editDBLSP4 = 0;
        } else {
            editDBLSP4 = parseInt(editDBLSP4);
        }
        //#endregion

        // console.log(editdblsMatchID+" "+editDBLSP1+" "+editDBLSP2+" "+editDBLSP3+" "+editDBLSP4);

        $.ajax({
            url: '',
            type: 'POST',
            data: {
                ntrEditdblsMatchID: editdblsMatchID,
                ntrEditDBLSP1: editDBLSP1,
                ntrEditDBLSP2: editDBLSP2,
                ntrEditDBLSP3: editDBLSP3,
                ntrEditDBLSP4: editDBLSP4
            }
        }).done(function (data) {
            // //console.log("Success");
            //console.log(data);
            swal({title: "Success", text: "Doubles Match Created!", type: "success"},
                function(){ 
                    location.reload();
                }
            );
            $(".editDBLSMatch")[0].reset();
        });
    });

    $("form #TDMatchEditSubmit").click(function (evt) {
        evt.preventDefault();

        var editTDMatchID = $("#editTDMatchID").val();
        var editTDT1 = $("#editTDT1").val();
        var editTDT2 = $("#editTDT2").val();

        //#region Value Handling
        if (editTDT1 == ''){
            editTDT1 = 0;
        } else {
            editTDT1 = editTDT1;
        }

        if (editTDT2 == ''){
            editTDT2 = 0;
        } else {
            editTDT2 = editTDT2;
        }
        //#endregion

        // console.log(editTDMatchID+" "+editTDT1+" "+editTDT2);

        $.ajax({
            url: '',
            type: 'POST',
            data: {
                ntrEditTDMatchID: editTDMatchID,
                ntrEditTDT1: editTDT1,
                ntrEditTDT2: editTDT2
            }
        }).done(function (data) {
            //console.log("Success");
            console.log(data);
            swal({title: "Success", text: "Team Doubles Match Updated!", type: "success"},
                function(){ 
                    location.reload();
                }
            );
            $(".editTDMatch")[0].reset();
        });
    });

    $("form #addChallengeSubmit").click(function (evt) {
        evt.preventDefault();

        var addChallengeP1 = $("#addChallengeP1").val();
        var addChallengeP2 = $("#addChallengeP2").val();

        // console.log(editsglsMatchID+" "+editSGLSP1+" "+editSGLSP2);

        $.ajax({
            url: '',
            type: 'POST',
            data: {
                ntrAddChallengeP1: addChallengeP1,
                ntrAddChallengeP1: addChallengeP2
            }
        }).done(function (data) {
            //console.log("Success");
            //console.log(data);
            swal({title: "Success", text: "Challenge Match Entered", type: "success"},
                function(){ 
                    location.reload();
                }
            );
            $(".editSGLSMatch")[0].reset();
        });
    });

    $("form #sglsScoreSubmit").click(function (evt) {
        evt.preventDefault();
        var sglsDNP;
        var sglsWalkover;
        var p1Set = 0;
        var p2Set = 0;

        var sglsMatchID = parseInt($("#sglsMatchID").val());
        var sglsSet1P1 = parseInt($("#sglsSet1P1").val());
        var sglsSet2P1 = parseInt($("#sglsSet2P1").val());
        var sglsSet3P1 = $("#sglsSet3P1").val();
        var sglsSet1P2 = parseInt($("#sglsSet1P2").val());
        var sglsSet2P2 = parseInt($("#sglsSet2P2").val());
        var sglsSet3P2 = $("#sglsSet3P2").val();
        var sglsPlayoff = $("#sglsPlayoff").prop("checked");
        var sglsChallenge = $("#sglsChallenge").prop("checked");
        // var sglsWinner = parseInt($('input[name=sglsWinner]:checked').val());
        
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
        if( (sglsSet1P1 == 0) && (sglsSet2P1 == 0) && (sglsSet3P1 == 0) && (sglsSet1P2 == 0) && (sglsSet2P2 == 0) && (sglsSet3P2 == 0) ){
            sglsDNP = 1;
            sglsWinner = 0;
        } else {
            sglsDNP = 0;
        }
        if( ((sglsSet1P1 == 1) && (sglsSet2P1 == 1) && (sglsSet3P1 == 0) && (sglsSet1P2 == 0) && (sglsSet2P2 == 0) && (sglsSet3P2 == 0)) || ((sglsSet1P2 == 1) && (sglsSet2P2 == 1) && (sglsSet3P2 == 0)  && (sglsSet1P1 == 0) && (sglsSet2P1 == 0) && (sglsSet3P1 == 0)) ){
            sglsWalkover = 1;
        } else {
            sglsWalkover = 0;
        }

        if(sglsSet1P1 > sglsSet1P2){
            p1Set++;
        } else {
            p2Set++;
        }
        if(sglsSet2P1 > sglsSet2P2){
            p1Set++;
        } else {
            p2Set++;
        }
        if(sglsSet3P1 > sglsSet3P2){
            p1Set++;
        } else {
            p2Set++;
        }

        if(p1Set > p2Set){
            sglsWinner = 1;
        } else {
            sglsWinner = 2;
        }
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
            if(sglsDNP == 1){
                swal({
                    title: 'Match Not Played?',
                    text: "",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#53A548',
                    cancelButtonColor: 'dimgrey',
                    confirmButtonText: 'Submit',
                    closeOnConfirm: false
                },function () {                           
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
                            ntrSGLSWinner: sglsWinner,
                            ntrsglsDNP: sglsDNP
                        }
                    }).done(function (data) {
                        //console.log("Success");
                        //console.log(data);
                        swal({title: "Success", text: "Scores Entered", type: "success"},
                            function(){ 
                                location.reload();
                            }
                        );
                        $(".enterSGLSScores")[0].reset();
                    });
                })
            } else if (sglsWalkover == 1){
                swal({
                    title: 'Walkover?',
                    text: "",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#53A548',
                    cancelButtonColor: 'dimgrey',
                    confirmButtonText: 'Submit',
                    closeOnConfirm: false
                },function () {                           
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
                            ntrSGLSWinner: sglsWinner,
                            ntrsglsDNP: sglsDNP
                        }
                    }).done(function (data) {
                        //console.log("Success");
                        //console.log(data);
                        swal({title: "Success", text: "Scores Entered", type: "success"},
                            function(){ 
                                location.reload();
                            }
                        );
                        $(".enterSGLSScores")[0].reset();
                    });
                })
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
                            ntrSGLSWinner: sglsWinner,
                            ntrsglsDNP: sglsDNP
                        }
                    }).done(function (data) {
                        //console.log("Success");
                        //console.log(data);
                        swal({title: "Success", text: "Scores Entered", type: "success"},
                            function(){ 
                                location.reload();
                            }
                        );
                        $(".enterSGLSScores")[0].reset();
                });
            }
            
        }
    });

    $("form #DBlsScoreSubmit").click(function (evt) {
        evt.preventDefault();
        var DBlsSet1Winner;
        var DBlsSet2Winner;
        var DBlsSet3Winner;
        var DBlsDNP;

        var DBlsMatchID = $("#DBlsMatchID").val();
        var DBlsSet1T1 = parseInt($("#DBlsSet1T1").val());
        var DBlsSet2T1 = parseInt($("#DBlsSet2T1").val());
        var DBlsSet3T1 = parseInt($("#DBlsSet3T1").val());
        var DBlsSet1T2 = parseInt($("#DBlsSet1T2").val());
        var DBlsSet2T2 = parseInt($("#DBlsSet2T2").val());
        var DBlsSet3T2 = parseInt($("#DBlsSet3T2").val());
        var DBlsPlayoff = $("#DBlsPlayoff").prop("checked");

        //#region Value Handling
        if(DBlsSet1T1 > DBlsSet1T2){
            DBlsSet1Winner = 1;
        } else {
            DBlsSet1Winner = 2;
        }
        if(DBlsSet2T1 > DBlsSet2T2){
            DBlsSet2Winner = 1;
        } else {
            DBlsSet2Winner = 2;
        }
        if(DBlsSet3T1 > DBlsSet3T2){
            DBlsSet3Winner = 1;
        } else {
            DBlsSet3Winner = 2;
        }
        if(DBlsPlayoff == true){
            DBlsPlayoff = 1;
        } else {
            DBlsPlayoff = 0;
        };
        if( (DBlsSet1T1 == 0) && (DBlsSet2T1 == 0) && (DBlsSet3T1 == 0) && (DBlsSet1T2 == 0) && (DBlsSet2T2 == 0) && (DBlsSet3T2 == 0) ){
            DBlsDNP = 1;
            DBlsSet1Winner = 0;
            DBlsSet2Winner = 0;
            DBlsSet3Winner = 0;
        } else {
            DBlsDNP = 0;
        }
        //#endregion


        if ((DBlsSet1T1 > 7) || isNaN(DBlsSet1T1)){
            swal("Oops...", "Score Entered is Invalid!", "error");
        } else if ((DBlsSet2T1 > 7) || isNaN(DBlsSet2T1)){
            swal("Oops...", "Score Entered is Invalid!", "error");
        } else if ((DBlsSet3T1 > 7) || isNaN(DBlsSet3T1)){
            swal("Oops...", "Score Entered is Invalid!", "error");
        } else if ((DBlsSet1T2 > 7) || isNaN(DBlsSet2T1)){
            swal("Oops...", "Score Entered is Invalid!", "error");
        } else if ((DBlsSet2T2 > 7) || isNaN(DBlsSet2T1)){
            swal("Oops...", "Score Entered is Invalid!", "error");
        } else if ((DBlsSet3T2 > 7) || isNaN(DBlsSet3T2)){
            swal("Oops...", "Score Entered is Invalid!", "error");
        } else {
            // console.log(DBlsMatchID," ",DBlsSet1T1," ",DBlsSet2T1," ",DBlsSet3T1," ",DBlsSet1T2," ",DBlsSet2T2," ",DBlsSet3T2," ",DBlsPlayoff," ",DBlsChallenge," ",DBlsSet1Winner," ",DBlsSet2Winner," ",DBlsSet3Winner," ",DBlsDNP);

            if(DBlsDNP == 1){
                swal({
                    title: 'Match Not Played?',
                    text: "",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#53A548',
                    cancelButtonColor: 'dimgrey',
                    confirmButtonText: 'Submit',
                    closeOnConfirm: false
                },function () {                           
                    $.ajax({
                        url: '',
                        type: 'POST',
                        data: {
                            ntrDBLSMatchID: DBlsMatchID,
                            ntrDBLSS1T1: DBlsSet1T1,
                            ntrDBLSS2T1: DBlsSet2T1,
                            ntrDBLSS3T1: DBlsSet3T1,
                            ntrDBLSS1T2: DBlsSet1T2,
                            ntrDBLSS2T2: DBlsSet2T2,
                            ntrDBLSS3T2: DBlsSet3T2,
                            ntrDBLSPlayoff: DBlsPlayoff,
                            ntrDBLSSet1Winner: DBlsSet1Winner,
                            ntrDBLSSet2Winner: DBlsSet2Winner,
                            ntrDBLSSet3Winner: DBlsSet3Winner,
                            ntrDBlsDNP: DBlsDNP
                        }
                    }).done(function (data) {
                        //console.log("Success");
                        //console.log(data);
                        swal({title: "Success", text: "Scores Entered", type: "success"},
                            function(){ 
                                location.reload();
                            }
                        );
                        $(".enterDBLSScores")[0].reset();
                    });
                })
            } else {
                $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                        ntrDBLSMatchID: DBlsMatchID,
                        ntrDBLSS1T1: DBlsSet1T1,
                        ntrDBLSS2T1: DBlsSet2T1,
                        ntrDBLSS3T1: DBlsSet3T1,
                        ntrDBLSS1T2: DBlsSet1T2,
                        ntrDBLSS2T2: DBlsSet2T2,
                        ntrDBLSS3T2: DBlsSet3T2,
                        ntrDBLSPlayoff: DBlsPlayoff,
                        ntrDBLSSet1Winner: DBlsSet1Winner,
                        ntrDBLSSet2Winner: DBlsSet2Winner,
                        ntrDBLSSet3Winner: DBlsSet3Winner,
                        ntrDBlsDNP: DBlsDNP
                    }
                }).done(function (data) {
                    //console.log("Success");
                    //console.log(data);
                    swal({title: "Success", text: "Scores Entered", type: "success"},
                            function(){ 
                                location.reload();
                            }
                        );
                    $(".enterDBLSScores")[0].reset();
                });
            }
            
        }
    });

    $("form #TDScoreSubmit").click(function (evt) {
        evt.preventDefault();
        var TDWinner;
        var team1Sets = 0;
        var team2Sets = 0;
        var TDDNP;

        var TDMatchID = $("#TDMatchID").val();
        var TDSet1T1 = parseInt($("#TDSet1T1").val());
        var TDSet2T1 = parseInt($("#TDSet2T1").val());
        var TDSet3T1 = parseInt($("#TDSet3T1").val());
        var TDSet1T2 = parseInt($("#TDSet1T2").val());
        var TDSet2T2 = parseInt($("#TDSet2T2").val());
        var TDSet3T2 = parseInt($("#TDSet3T2").val());
        var TDPlayoff = $("#TDPlayoff").prop("checked");

        //#region Value Handling
        if( (TDSet1T1 > TDSet1T2) ){
            team1Sets++;
        } else {
            team2Sets++;
        } 
        if( (TDSet2T1 > TDSet2T2) ){
            team1Sets++;
        } else {
            team2Sets++;
        } 
        if( (TDSet3T1 > TDSet3T2) ){
            team1Sets++;
        } else {
            team2Sets++;
        } 

        if(team1Sets > team2Sets){
            TDWinner = 1;
        } else {
            TDWinner = 2;
        }
        
        if( (TDSet1T1 == 0) && (TDSet2T1 == 0) && (TDSet3T1 == 0) && (TDSet1T2 == 0) && (TDSet2T2 == 0) && (TDSet3T2 == 0) ){
            TDDNP = 1;
            TDWinner = 0;
        } else {
            TDDNP = 0;
        }
        //#endregion


        if ((TDSet1T1 > 7) || isNaN(TDSet1T1)){
            swal("Oops...", "Score Entered is Invalid!", "error");
        } else if ((TDSet2T1 > 7) || isNaN(TDSet2T1)){
            swal("Oops...", "Score Entered is Invalid!", "error");
        } else if ((TDSet3T1 > 7) || isNaN(TDSet3T1)){
            swal("Oops...", "Score Entered is Invalid!", "error");
        } else if ((TDSet1T2 > 7) || isNaN(TDSet2T1)){
            swal("Oops...", "Score Entered is Invalid!", "error");
        } else if ((TDSet2T2 > 7) || isNaN(TDSet2T1)){
            swal("Oops...", "Score Entered is Invalid!", "error");
        } else if ((TDSet3T2 > 7) || isNaN(TDSet3T2)){
            swal("Oops...", "Score Entered is Invalid!", "error");
        } else {
            // console.log(TDMatchID," ",TDSet1T1," ",TDSet2T1," ",TDSet3T1," ",TDSet1T2," ",TDSet2T2," ",TDSet3T2," ",TDPlayoff," ",TDChallenge," ",TDSet1Winner," ",TDSet2Winner," ",TDSet3Winner," ",TDDNP);

            if(TDDNP == 1){
                swal({
                    title: 'Match Not Played?',
                    text: "",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#53A548',
                    cancelButtonColor: 'dimgrey',
                    confirmButtonText: 'Submit',
                    closeOnConfirm: false
                },function () {                           
                    $.ajax({
                        url: '',
                        type: 'POST',
                        data: {
                            ntrTDMatchID: TDMatchID,
                            ntrTDS1T1: TDSet1T1,
                            ntrTDS2T1: TDSet2T1,
                            ntrTDS3T1: TDSet3T1,
                            ntrTDS1T2: TDSet1T2,
                            ntrTDS2T2: TDSet2T2,
                            ntrTDS3T2: TDSet3T2,
                            ntrTDPlayoff: TDPlayoff,
                            ntrTDWinner: TDWinner,
                            ntrTDDNP: TDDNP
                        }
                    }).done(function (data) {
                        //console.log("Success");
                        //console.log(data);
                        swal({title: "Success", text: "Scores Entered", type: "success"},
                            function(){ 
                                location.reload();
                            }
                        );
                        $(".enterTDScores")[0].reset();
                    });
                })
            } else {
                $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                        ntrTDMatchID: TDMatchID,
                        ntrTDS1T1: TDSet1T1,
                        ntrTDS2T1: TDSet2T1,
                        ntrTDS3T1: TDSet3T1,
                        ntrTDS1T2: TDSet1T2,
                        ntrTDS2T2: TDSet2T2,
                        ntrTDS3T2: TDSet3T2,
                        ntrTDPlayoff: TDPlayoff,
                        ntrTDWinner: TDWinner,
                        ntrTDDNP: TDDNP
                    }
                }).done(function (data) {
                    //console.log("Success");
                    //console.log(data);
                    swal({title: "Success", text: "Scores Entered", type: "success"},
                            function(){ 
                                location.reload();
                            }
                        );
                    $(".enterTDScores")[0].reset();
                });
            }
            
        }
    });

    $("form #newPlayerSubmit").click(function (evt){
        evt.preventDefault();

        var newFName = $("#newFName").val();
        var newLName = $("#newLName").val();
        var newEmail = $("#newEmail").val();
        var newPhone = parseInt($("#newPhone").val());
        var newPassword = pwGen();
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
        } else if ((newPassword == '') || (newPassword.length < 8)){
            swal("Oops...", "Please Enter a Valid Password (Must be at least 8 characters)", "error");
        } else {

            var templateParams = {
                fname: newFName,
                lname: newLName,
                email: newEmail,
                phone: newPhone,
                pw: newPassword
            };
             
            emailjs.send('zoho', 'indytenniswelcome', templateParams)
                .then(function(response) {
                    console.log('SUCCESS!', response.status, response.text);
                }, function(error) {
                    console.log('FAILED. consol..', error);
            });

            $.ajax({
                url: '',
                type: 'POST',
                data: {
                    ntrNewFName: newFName,
                    ntrNewLName: newLName,
                    ntrNewEmail: newEmail,
                    ntrNewPhone: newPhone,
                    ntrNewPassword: newPassword,
                    ntrNewSGLSPoints: newSGLSPoints,
                    ntrNewDBLSPoints: newDBLSPoints,
                    ntrNewSGLSPlayer: newSGLSPlayer,
                    ntrNewDBLSPlayer: newDBLSPlayer
                }
            }).done(function (data) {
                //console.log("Success");
                //console.log(data);
                swal({title: "Success", text: "Player Entered", type: "success"},
                    function(){ 
                        $(".addNewPLYR")[0].reset();
                    }
                );
            });

            //console.log(newFName," ",newLName," ",newEmail," ",newPhone," ",newSGLSPoints," ",newDBLSPoints," ",newSGLSPlayer," ",newDBLSPlayer);

        } 

    });

    $("form #newTDTSubmit").click(function (evt){
        evt.preventDefault();

        var newPlayer1 = $("#userNewTDID1").val();
        var newPlayer2 = $("#userNewTDID2").val();
        var newTDStartPoints = $("#newTDPoints").val();

        //#region Value Handling
        if(newTDStartPoints == ''){
            newTDStartPoints = 0;
        } else {
            newTDStartPoints = parseInt(newTDStartPoints);
        };
        //#endregion


        if (!(newPlayer1 > 0)){
            swal("Oops...", "Please Select a Player 1", "error");
        } else if (!(newPlayer2 > 0)){
            swal("Oops...", "Please Select a Player 2", "error");
        } else {
            $.ajax({
                url: '',
                type: 'POST',
                data: {
                    ntrUserNewTDID1: newPlayer1,
                    ntrUserNewTDID2: newPlayer2,
                    ntrNewTDPoints: newTDStartPoints
                }
            }).done(function (data) {
                //console.log("Success");
                //console.log(data);
                swal({title: "Success", text: "Team Entered", type: "success"},
                            function(){ 
                                $(".addNewTD")[0].reset();
                            }
                        );
            });

            //console.log(newFName," ",newLName," ",newEmail," ",newPhone," ",newSGLSPoints," ",newDBLSPoints," ",newSGLSPlayer," ",newDBLSPlayer);

        } 

    });

    $("form #dropLadderSubmit").click(function (evt){
        evt.preventDefault();
        
        var dropPlayerID = parseInt($("#dropLadderID").val());
        var dropSingles = $("#dropSGLS").prop("checked");
        var dropDubs = $("#dropDubs").prop("checked");
        var dropTeamDubs = $("#dropTeamDubs").prop("checked");

        //#region value handling
        if(dropSingles == true){
            dropSingles = 1;
        } else {
            dropSingles = 0;
        };
        if(dropDubs == true){
            dropDubs = 1;
        } else {
            dropDubs = 0;
        };
        if(dropTeamDubs == true){
            dropTeamDubs = 1;
        } else {
            dropTeamDubs = 0;
        };
        //#endregion

        // console.log(dropPlayerID," ",dropSingles," ",dropDubs," ",dropTeamDubs);


        $.ajax({
            url: '',
            type: 'POST',
            data: {
                ntrDropPlayerID: dropPlayerID,
                ntrDropSGLS: dropSingles,
                ntrDropDBLS: dropDubs,
                ntrDropTD: dropTeamDubs
            }
        }).done(function (data) {
            swal({title: "Success", text: "Player Dropped", type: "success"},
                function(){ 
                    // console.log(data);
                    $(".dropLadderForm")[0].reset();  
                }
            );             
        });
    });

    $("form #newPasswordSubmit").click(function (evt){
        evt.preventDefault();

        var userNewPWID = $("#userNewPWID").val();
        var newUserPW = $("#userNewPW").val();
        var newUserPW2 = $("#userNewPW2").val();

        if (!(newUserPW === newUserPW2)){
            swal("Oops...", "Passwords do not match!", "error");            
        } else if ((newUserPW == '') || (newUserPW.length < 8)) {
            swal("Oops...", "Please Enter a Valid Password (Must be at least 8 characters)", "error");
        } else {

            swal({
                title: 'Are you sure?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#53A548',
                cancelButtonColor: 'dimgrey',
                confirmButtonText: 'Submit',
                showLoaderOnConfirm: true,
                closeOnConfirm: false
            },function () {
                $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                        ntrUserNewPWID: userNewPWID,
                        ntrNewUserPW: newUserPW
                    }
                }).done(function (data) {
                    //console.log("Success");
                    //console.log(data);
                    swal({title: "Success", text: "Password Updated", type: "success"},
                        function(){ 
                            $(".updatePW")[0].reset();
                        }
                    );
                });
            })

        }

    });

    $("form #newEmailSubmit").click(function (evt){
        evt.preventDefault();

        var userNewEMID = $("#userNewEMID").val();
        var newUserEM = $("#userNewEM").val();

        if (!validateEmail(newUserEM)){
            swal("Oops...", "Please Enter a Valid Email", "error");
        } else {

            swal({
                title: 'Are you sure?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#53A548',
                cancelButtonColor: 'dimgrey',
                confirmButtonText: 'Submit',
                showLoaderOnConfirm: true,
                closeOnConfirm: false
            },function () {
                $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                        ntrUserNewEMID: userNewEMID,
                        ntrNewUserEM: newUserEM
                    }
                }).done(function (data) {
                    //console.log("Success");
                    //console.log(data);
                    swal({title: "Success", text: "Email Updated", type: "success"},
                        function(){ 
                            $(".editDBLSMatch")[0].reset();
                        }
                    );
                });
            })

            

        }

    });

    $("form #newPhoneSubmit").click(function (evt){
        evt.preventDefault();

        var userNewPNID = $("#userNewPNID").val();
        var newUserPN = $("#userNewPN").val();

        if ((newUserPN == '') || ((newUserPN.toString().length) != 10)){
            swal("Oops...", "Please Enter a Valid Phone Number (Must be 10 digits)", "error");
        } else {

            swal({
                title: 'Are you sure?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#53A548',
                cancelButtonColor: 'dimgrey',
                confirmButtonText: 'Submit',
                showLoaderOnConfirm: true,
                closeOnConfirm: false
            },function () {
                $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                        ntrUserNewPNID: userNewPNID,
                        ntrNewUserPN: newUserPN
                    }
                }).done(function (data) {
                    //console.log("Success");
                    //console.log(data);
                    swal({title: "Success", text: "Phone Number Updated", type: "success"},
                        function(){ 
                            $(".updatePN")[0].reset();
                        }
                    );
                });
            }) 

        }

    });

    $("form #newAnnounceSubmit").click(function (evt){
        evt.preventDefault();

        var newAnnounceTitle = $("#announceTitle").val();
        var newAnnounceDesc = $("#announceDesc").val();
        var newAnnounceDate = $("#announceDate").val();
        var newAnnounceLink = $("#announceLink").val();

        if (newAnnounceTitle == ''){
            swal("Oops...", "Please Enter a Title", "error");
        } else {
            $.ajax({
                url: '',
                type: 'POST',
                data: {
                    ntrAnnounceTitle: newAnnounceTitle,
                    ntrAnnounceDesc: newAnnounceDesc,
                    ntrAnnounceDate: newAnnounceDate,
                    ntrAnnounceLink: newAnnounceLink
                }
            }).done(function (data) {
                //console.log("Success");
                //console.log(data);
                swal({title: "Success", text: "Announcement Entered", type: "success"},
                        function(){ 
                            $(".addAnnounce")[0].reset();
                        }
                    );
            });

            // console.log(newAnnounceTitle, newAnnounceDesc, newAnnounceDate, newAnnounceLink)
            // $(".addAnnounce")[0].reset();

        }

    });

    //#endregion

}

$(document).ready(function () {

    setBindings();

    var curURLStr = window.location.href;
    var posLastSlash = curURLStr.lastIndexOf("/");
    var endStr = curURLStr.substr(posLastSlash , (curURLStr.length - posLastSlash) )

    localStorage.setItem('url',endStr);
    var curURL = localStorage.getItem('url');
    // console.log(curURL);

    if(curURL == "/About.php"){
        $( "#about" ).closest('li').css({"background-color": "#EEF95D"});
        $( "#about" ).css({"color": "black"});
    } else if (curURL == "/Ladder.php" || curURL == "/RoundMatches.php") {
        $( "#ladder" ).closest('li').css({"background-color": "#EEF95D"});
        $( "#ladder" ).css({"color": "black"}); 
    } else if (curURL == "/") {
        $( "#homePage" ).closest('li').css({"background-color": "#EEF95D"});
        $( "#homePage" ).css({"color": "black"});
    } else {
      // do nothing    
    }
    
});