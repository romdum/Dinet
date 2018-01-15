$(document).ready(function ()
{
    $("#next_food").click(function ()
    {
        pagination(10);
    });
    $("#prev_food").click(function ()
    {
        pagination(-10);
    });
});

function pagination(nbArticle)
{
    let $table_food = $("#table_food");
    let page = parseInt($table_food.attr("data-page")) + nbArticle;

    if (page >= 0 && page < 398)
    {
        $.post({
            url     : myAjax.ajaxurl,
            dataType: "json",
            data    : {
                action: "food_pagination",
                nonce : myAjax.nonce,
                page  : page,
            },
            success : function (response)
            {
                let i = 0;
                $(".food_item").each(function ()
                {
                    if (response[i] != undefined)
                    {
                        $(this).removeAttr("style");
                        $(this).children("td:nth-child(1)").text(response[i].Désignation);
                        $(this).children("td:nth-child(2)").text(response[i].Groupe);
                        $(this).children("td:nth-child(3)").children("input[type=button]").attr("data-food-id", response[i].id);
                        $table_food.attr("data-page", page);
                    } else
                    {
                        $(this).css("display", "none");
                    }
                    i++;
                });
            },
            error   : function ()
            {
                makeToast("Une erreur s'est produite", "#cf1a2e");
            }
        });
    }
}
