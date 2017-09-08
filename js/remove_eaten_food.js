$(document).ready(function(){
    $('button[name=delete-food]').click(function(){
        let $delBtn = $(this);
        $.post({
            url     : myAjax.ajaxurl,
            dataType: "json",
            data    : {
                action  : "ajax_remove_eaten_food",
                nonce   : myAjax.nonce,
                conso_id: $delBtn.attr('data-food-user-id')
            },
            success : function (response)
            {
                $delBtn.parents('tr').remove();
                makeToast("Consommation supprimée", "#57b676");
                updateChart(response.datasets);
            },
            error   : function (response)
            {
                console.log("error")
                makeToast("Une erreur s'est produite", "#cf1a2e");
            }
        });
    });
});
