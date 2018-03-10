jQuery(document).ready(function ($)
{
    $("input.add_input").click(function () {
        let foodId = $(this).next().val();
        Consumption.add(foodId);
    });

    let $searchBar = Search.getSearchBar();
    let searchBarValue = $searchBar.val();
    $('#search_bar').on('change paste keyup',function(){
        if(searchBarValue !== $searchBar.val()){
            Search.search();
            searchBarValue = $searchBar.val();
        }
    });

    $('#table_last_food').on('click','button[name=delete-food]', function() {
        let consId = $(this).attr('data-food-user-id');
        Consumption.remove(consId);
    });

    $("#next_food").click(function(){
        TableFood.changePage(TableFood.getPage() + 10)
    });

    $("#prev_food").click(function(){
        TableFood.changePage(TableFood.getPage() - 10)
    });
});

