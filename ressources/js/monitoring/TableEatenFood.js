let TableEatenFood = function()
{
    'use strict';

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