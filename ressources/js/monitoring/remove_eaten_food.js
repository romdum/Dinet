jQuery(document).ready(function($){
    $('#table_last_food').on('click','button[name=delete-food]', function(){
        let $delBtn = $(this);
        $.post({
            url     : utilRemoveCons.ajaxURL,
            dataType: "json",
            data    : {
                action      : "ajax_remove_eaten_food",
                nonce       : utilRemoveCons.nonce,
                cons_id     : $delBtn.attr('data-food-user-id')
            },
            success : function (response)
            {
                $delBtn.parents('tr').remove();
                makeToast("Consommation supprimée", "#57b676");
                updateChart(response.datasets);
            },
            error   : function ()
            {
                console.log("error");
                makeToast("Une erreur s'est produite", "#cf1a2e");
            }
        });
    });
});
