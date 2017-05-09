const $ = jQuery;

function makeToast(text, hexColor)
{
    let $toast = $("#dinet_toast");
    $toast.text(text);
    $toast.css("background", hexColor);
    $toast.fadeIn(400).delay(2500).fadeOut(400);
}