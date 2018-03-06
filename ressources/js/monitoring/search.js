jQuery(document).ready(function()
{
    jQuery('#search_bar').keyup(function(){
        Search.search();
    });
});

/**
 * Module Search
 */
let Search = (function(){
    let $searchBar = jQuery('#search_bar');

    /**
     * Refresh $searchBar variable.
     */
    let refreshSearchBarVar = function(){
        $searchBar = jQuery($searchBar.selector);
    };

    /**
     * Function use to know if you can search. We consider you can search if the search value length is
     * superior or equal to 3.
     * @returns {boolean}
     */
    let canSearch = function(){
        refreshSearchBarVar();
        return $searchBar.val().length >= 3 || $searchBar.val().length === 0;
    };

    let canShowPaginationButtons = function(){
        refreshSearchBarVar();
        return $searchBar.val().length === 3 || $searchBar.val().length === 0;
    };

    /**
     * Function use to erase search bar content. This will restore food table content too.
     */
    let eraseSearchBar = function(){
        $searchBar.val('');
        search();
    };

    let isEmpty = function(){
        refreshSearchBarVar();
        return $searchBar.val() === '';
    };

    /**
     * Main function use to search.
     */
    let search = function(){
        if( canSearch() )
        {
            ajax();

            Pagination.hideButtons();
            if( canShowPaginationButtons() )
            {
                Pagination.showButtons();
            }
        }
    };

    /**
     * Ajax function.
     */
    let ajax = function(){

        jQuery.post({
            url       : utilFoodSearch.ajaxURL,
            dataType  : "json",
            data      : {
                action: "food_search",
                nonce : utilFoodSearch.nonce,
                search: $searchBar.val()
            },
            success   : function (response)
            {
                reloadTable(response);
            },
            error     : function ()
            {
                makeToast("Une erreur s'est produite", "#cf1a2e");
            }
        });
    };

    let reloadTable = function(data){
        let i = 0;
        jQuery(".food_item").each(function ()
        {
            if (data[i] != undefined)
            {
                jQuery(this).removeAttr("style");
                jQuery(this).children("td:nth-child(1)").text(data[i].designation);
                jQuery(this).children("td:nth-child(2)").text(data[i].group);
                jQuery(this).find("td:last-child").find('input[name="food-id"]').val(data[i].id);
            }
            else
            {
                jQuery(this).css("display", "none");
            }
            i++;
        });
    };

    return {
        $searchBar     : $searchBar,
        search         : search,
        isEmpty        : isEmpty,
        eraseSearchBar : eraseSearchBar
    }
})();