const $ = jQuery;

function makeToast(text, hexColor)
{
    let $toast = $("#dinet_toast");
    $toast.text(text);
    $toast.css("background", hexColor);
    $toast.fadeIn(400).delay(2500).fadeOut(400);
}

function getCurrentDate()
{
    let today = new Date();
    let dd = today.getDate().length > 1 ? today.getDate() : '0' + today.getDate();
    let mm = (today.getMonth()+1).length > 1 ? today.getMonth()+1 : '0'+parseInt(today.getMonth()+1);
    let yyyy = today.getFullYear();
    return dd+'-'+mm+'-'+yyyy;
}
