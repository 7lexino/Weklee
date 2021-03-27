var openDiv;

function toggleDiv(divID) {
    $("#" + divID).fadeToggle(200, function() {
        openDiv = $(this).is(':visible') ? divID : null;
    });
}

$(document).click(function(e) {
    if (!$(e.target).closest('#'+openDiv).length) {
        toggleDiv(openDiv);
    }
});
var openDivNotif;

function toggleDivNotif(divID) {
    $("#" + divID).fadeToggle(200, function() {
        openDivNotif = $(this).is(':visible') ? divID : null;
    });
}

$(document).click(function(e) {
    if (!$(e.target).closest('#'+openDivNotif).length) {
        toggleDivNotif(openDivNotif);
    }
});