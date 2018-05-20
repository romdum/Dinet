let TableFood = (function()
{
    'use strict';

    let getTable = function()
    {
        return jQuery('#table_food');
    };

    let eraseData = function()
    {
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

    let getRowData = function(foodId)
    {
        let $row = jQuery('input[name="food-id"][value="' + foodId + '"]').parents('tr');

        return {
            quantity      : $row.find('.quantity').val(),
            date          : $row.find('input[name="eat_date"]').val(),
            hour          : $row.find('input[name="eat_hour"]').val(),
            hungryLevel   : $row.find('select[name="hungry_level"] option:selected').val(),
            feelingBefore : $row.find('input[name="feeling_before"]').val(),
            feelingAfter  : $row.find('input[name="feeling_after"]').val()
        }
    };

    let hideRow = function($row)
    {
        $row.css("display", "none");
    };

    let showRow = function($row)
    {
        $row.removeAttr("style");
    };

    let setRowData = function($row,data)
    {
        $row.children("td:nth-child(1)").text(data.designation);
        $row.children("td:nth-child(2)").text(data.group);
        $row.children("td:last-child").children("input[name='food-id']").val(data.id);
    };

    let reloadTable = function(data, page = null)
    {
        let $table = getTable();
        $table.find(".food_item").each(function(i){
            if (data[i] !== undefined) {
                TableFood.showRow(jQuery(this));
                TableFood.setRowData(jQuery(this),data[i]);
            } else {
                TableFood.hideRow(jQuery(this));
            }
        });
        if( page !== null ){
            $table.attr("data-page", page);
        }
        eraseData();
    };

    let changePage = function(page)
    {
        if (page >= 0 && page < utilTableFood.foodNbr){
            getPageData(page)
                .success(function(response){
                    reloadTable(response,page);
                })
                .error(function(){
                    makeToast("Une erreur s'est produite", "#cf1a2e");
                });
        }
    };

    let getPageData = function(page){
        return jQuery.post({
            url: utilTableFood.ajaxURL,
            dataType: "json",
            data: {
                action: "food_pagination",
                nonce: utilTableFood.noncePagination,
                page: page,
            }
        });
    };

    let getPage = function(){
        return parseInt(getTable().attr("data-page"));
    };

    let hidePaginationButtons = function(){
        jQuery(".pagination_button").css("display", "none");
    };

    let showPaginationButtons = function(){
        jQuery(".pagination_button").removeAttr("style");
    };

    return {
        getTable    : getTable,
        getPage     : getPage,
        eraseData   : eraseData,
        getRowData  : getRowData,
        setRowData  : setRowData,
        reloadTable : reloadTable,
        changePage  : changePage,
        hideRow     : hideRow,
        showRow     : showRow,
        hidePaginationButtons : hidePaginationButtons,
        showPaginationButtons : showPaginationButtons
    }
})();