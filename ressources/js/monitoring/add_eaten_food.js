jQuery(document).ready(function ($)
{
    $("input.add_input").click(function ()
    {
        let food_id = $(this).next().val();
        TableFood.addConsumption(food_id);
    });

});

let TableEatenFood = function(){
    let getTable = function(){
        return jQuery('#table_last_food');
    };

    let addRow = function(html){
        getTable().find('tbody').prepend(html);
    };

    return {
        getTable : getTable,
        addRow   : addRow
    }
}();

let TableFood = function()
{
    let getTable = function(){
        return jQuery('#table_food');
    };

    let eraseData = function(){
        let $tableFood = getTable();
        let date = new Date();
        let time = date.toTimeString().substr(0,5);
        date = date.toISOString().substr(0,10);

        $tableFood.find('.quantity').val('');
        $tableFood.find('[name="feeling_before"]').val('');
        $tableFood.find('[name="feeling_after"]').val('');
        $tableFood.find('option').removeAttr('selected');
        $tableFood.find('[type="date"]').val(date);
        $tableFood.find('[type="time"]').val(time);
    };

    let addConsumption = function(food_id){
        if( isValidQuantity(food_id) ){
            ajax(food_id)
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

    let getAjaxData = function(food_id){
        let $row = jQuery('input[name="food-id"][value="' + food_id + '"]').parent().parent();

        return {
            action        : "saveWithAjax",
            nonce         : utilAddEatenFood.nonce,
            food_id       : food_id,
            quantity      : $row.find('.quantity').val(),
            eat_date      : $row.find('input[name="eat_date"]').val(),
            eat_hour      : $row.find('input[name="eat_hour"]').val(),
            hungry_level  : $row.find('select[name="hungry_level"] option:selected').val(),
            feeling_before: $row.find('input[name="feeling_before"]').val(),
            feeling_after : $row.find('input[name="feeling_after"]').val()
        }
    };

    let ajax = function(food_id){
        return jQuery.post({
            url     : utilAddEatenFood.ajaxURL,
            dataType: "json",
            data    : getAjaxData(food_id)
        });
    };

    let isValidQuantity = function(food_id){
        let quantity = parseInt( jQuery('input[name="food-id"][value="' + food_id + '"]').parent().parent().find('.quantity').val() );
        return quantity > 0 && !isNaN(quantity)
    };

    return {
        getTable       : getTable,
        eraseData      : eraseData,
        addConsumption : addConsumption
    }
}();