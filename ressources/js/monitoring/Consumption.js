let Consumption = (function()
{
    'use strict';

    let quantity;
    let feelingBefore;
    let feelingAfter;
    let hungryLevel;
    let date;
    let hour;

    let addConsumption = function(foodId)
    {
        initVar( TableFood.getRowData(foodId) );

        if( isValidQuantity() ){
            saveRequest(foodId)
                .success(function(response){
                    TableFood.eraseData();
                    TableEatenFood.addRow(response.html);
                    makeToast("Consommation ajoutée", "#57b676");
                    updateChart(response.datasets);
                })
                .error(function(){
                    makeToast("Une erreur s'est produite", "#cf1a2e")
                });

            if( ! Search.isEmpty() ){
                Search.eraseSearchBar();
            }
        } else {
            makeToast("Quantité invalide", "#cf1a2e");
        }
    };

    let saveRequest = function(foodId)
    {
        return jQuery.post({
            url     : utilConsumption.ajaxURL,
            dataType: "json",
            data    : {
                action        : "saveWithAjax",
                nonce         : utilConsumption.nonceAddCons,
                food_id       : foodId,
                quantity      : quantity,
                eat_date      : date,
                eat_hour      : hour,
                hungry_level  : hungryLevel,
                feeling_before: feelingBefore,
                feeling_after : feelingAfter
            }
        });
    };

    let removeConsumption = function(consId){
        removeRequest(consId)
            .success(function(response){
                TableEatenFood.getTable().find('button[data-food-user-id="'+consId+'"]').parents('tr').remove();
                makeToast("Consommation supprimée", "#57b676");
                updateChart(response.datasets);
            })
            .error(function(){
                makeToast("Une erreur s'est produite", "#cf1a2e");
            });
    };

    let removeRequest = function(consId){
        return jQuery.post({
            url     : utilConsumption.ajaxURL,
            dataType: "json",
            data    : {
                action      : "ajax_remove_eaten_food",
                nonce       : utilConsumption.nonceRemoveCons,
                cons_id     : consId
            }
        });
    };

    let isValidQuantity = function()
    {
        return quantity > 0 && !isNaN(quantity)
    };

    let initVar = function(data)
    {
        quantity      = data.quantity;
        feelingBefore = data.quantity;
        feelingAfter  = data.feelingBefore;
        hungryLevel   = data.feelingAfter;
        date          = data.date;
        hour          = data.hour;
    };

    return {
        add    : addConsumption,
        remove : removeConsumption
    }
})();