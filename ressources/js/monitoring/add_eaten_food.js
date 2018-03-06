jQuery(document).ready(function ($)
{
    $("input.add_input").click(function ()
    {
        let food_id = $(this).next().val();
        let quantity = parseInt( $(this).parent().parent().find('.quantity').val() );
        if (quantity > 0 && !isNaN(quantity))
        {
            ajax_add_eaten_food(food_id, quantity);
            Search.eraseSearch();
        }
        else
        {
            makeToast("Quantité invalide", "#cf1a2e");
        }
    });

});

function ajax_add_eaten_food(food_id, quantity)
{
    let $row = jQuery('input[name="food-id"][value="' + food_id + '"]').parent().parent();

    jQuery.post({
        url     : utilAddEatenFood.ajaxURL,
        dataType: "json",
        data    : {
            action        : "saveWithAjax",
            nonce         : utilAddEatenFood.nonce,
            food_id       : food_id,
            quantity      : quantity,
            eat_date      : $row.find('input[name="eat_date"]').val(),
            eat_hour      : $row.find('input[name="eat_hour"]').val(),
            hungry_level  : $row.find('select[name="hungry_level"] option:selected').val(),
            feeling_before: $row.find('input[name="feeling_before"]').val(),
            feeling_after : $row.find('input[name="feeling_after"]').val(),
        },
        success : function (response)
        {
            jQuery(".quantity").val("");
            jQuery('#table_last_food').find('tbody').prepend(response.html);
            makeToast("Consommation ajoutée", "#57b676");
            updateChart(response.datasets);
        },
        error   : function ()
        {
            console.log("error");
            makeToast("Une erreur s'est produite", "#cf1a2e");
        }
    });

}

