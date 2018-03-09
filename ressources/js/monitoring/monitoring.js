jQuery(document).ready(function ($)
{
    $("input.add_input").click(function () {
        let foodId = $(this).next().val();
        Consumption.add(foodId);
    });

    $('#search_bar').on('change paste keyup',function(){
        Search.search();
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


