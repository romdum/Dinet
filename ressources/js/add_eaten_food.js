$(document).ready(function ()
{
    $("input.add_input").click(function ()
    {
        let food_id = $(this).attr("data-food-id");
        let quantity = parseInt($(this).prev().val());

        if (quantity !== 0 && !isNaN(quantity))
        {
            ajax_add_eaten_food(food_id, quantity);
        }
        else
        {
            makeToast("Quantité invalide", "#cf1a2e");
        }
    });

});

function ajax_add_eaten_food(food_id, quantity)
{
    // BUG: food name doesnt work
    // BUG: data-fodd-user-id doesnt work 
    $.post({
        url     : myAjax.ajaxurl,
        dataType: "json",
        data    : {
            action  : "add_eaten_food",
            nonce   : myAjax.nonce,
            food_id : food_id,
            quantity: quantity
        },
        success : function (response)
        {
            $(".quantity").val("");
            $('#table_last_food tbody').append('' +
            '<tr class="">' +
                '<td>'+ getCurrentDate() +'</td>'+
                '<td>'+ 0 +'</td>'+
                '<td>'+ quantity +'</td>'+
                '<td>' +
                    '<button type="button" class="btn-delete" data-food-user-id="'+ 0 +'" name="delete-food"><span class="dashicons dashicons-trash"></span></button>' +
                '</td>' +
            '</tr>');
            makeToast("Consommation ajoutée", "#57b676");
            updateChart(response.datasets);
        },
        error   : function ()
        {
            makeToast("Une erreur s'est produite", "#cf1a2e");
        }
    });

}

function updateChart(datasets)
{
    let ctx = document.getElementById("myChart").getContext("2d");
    let d = new Date();
    let dates = [new Date().getWeek(-21), new Date().getWeek(-14), new Date().getWeek(-7), new Date().getWeek()];

    let myChart = new Chart(ctx, {
        type   : 'line',
        data   : {
            labels  : [
                "du " +[dates[0][0].getDate()+" au "+dates[0][1].getDate()],
                "du " +[dates[1][0].getDate()+" au "+dates[1][1].getDate()],
                "du " +[dates[2][0].getDate()+" au "+dates[2][1].getDate()],
                "du " +[dates[3][0].getDate()+" au "+dates[3][1].getDate()]
            ],
            datasets: datasets
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    }
                }]
            }
        }
    });
}
