/**
 * Module Search
 */
let Search = (function()
{
    let getSearchBar = function()
    {
        return jQuery('#search_bar');
    };

    /**
     * Function use to know if you can search. We consider you can search if the search value length is
     * superior or equal to 3.
     * @returns {boolean}
     */
    let canSearch = function()
    {
        // TODO: ajouter condition si le tableau est vide on ne cherche pas plus loin
        return getSearchBar().val().length >= 3 || getSearchBar().val().length === 0;
    };

    let canShowPaginationButtons = function()
    {
        return getSearchBar().val().length === 3 || getSearchBar().val().length === 0;
    };

    /**
     * Function use to erase search bar content. This will restore food table content too.
     */
    let eraseSearchBar = function()
    {
        getSearchBar().val('');
        search();
    };

    let isEmpty = function(){
        return getSearchBar().val() === '';
    };

    /**
     * Main function use to search.
     */
    let search = function()
    {
        if( canSearch() )
        {
            searchRequest()
                .success(function(response){
                    TableFood.reloadTable(response);
                })
                .error(function(){
                    makeToast("Une erreur s'est produite", "#cf1a2e");
                });

            TableFood.hidePaginationButtons();
            if( canShowPaginationButtons() )
            {
                TableFood.showPaginationButtons();
            }
        }
    };

    /**
     * Ajax function.
     */
    let searchRequest = function()
    {
        return jQuery.post({
            url       : utilFoodSearch.ajaxURL,
            dataType  : "json",
            data      : {
                action: "food_search",
                nonce : utilFoodSearch.nonce,
                search: getSearchBar().val()
            }
        });
    };

    return {
        getSearchBar   : getSearchBar,
        search         : search,
        isEmpty        : isEmpty,
        eraseSearchBar : eraseSearchBar
    }
})();