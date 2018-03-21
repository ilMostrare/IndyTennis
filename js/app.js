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
}

$(document).ready(function () {

    setBindings();

}