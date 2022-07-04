DialogWindow = {
    Toast: {
        show: function (message, long) {
            if (documentReady) {
                $("div#toast").text(message).fadeIn(500);
                let timeout = long ? 7 : 4;
                setTimeout(function () {
                    $("div#toast").fadeOut(500)
                }, timeout * 1000);
            } else {
                DialogWindow.toastMessage = message;
                DialogWindow.toastLong = long;
                setTimeout('DialogWindow.Toast.show(DialogWindow.toastMessage, DialogWindow.toastLong)', 500);
            }
            console.log('toast show');
        }
    },
    toastMessage: "",
    toastLong: 4
}
let documentReady = false;
$(document).ready(function () {
    $("body").append("<div id=\"toast\" style=\"display: none\"></div>");
    documentReady = true;
});
