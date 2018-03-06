jQuery(document).ready(function ($)
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
    let $table_food = jQuery("#table_food");
    let page = parseInt($table_food.attr("data-page")) + nbArticle;

    if (page >= 0 && page < 398)
    {
        jQuery.post({
            url     : utilFoodPagination.ajaxURL,
            dataType: "json",
            data    : {
                action: "food_pagination",
                nonce : utilFoodPagination.nonce,
                page  : page,
            },
            success : function (response)
            {
                let i = 0;
                jQuery(".food_item").each(function ()
                {
                    if (response[i] !== undefined)
                    {
                        jQuery(this).removeAttr("style");
                        jQuery(this).children("td:nth-child(1)").text(response[i].designation);
                        jQuery(this).children("td:nth-child(2)").text(response[i].group);
                        jQuery(this).children("td:last-child").children("input[name='food-id']").val(response[i].id);
                        $table_food.attr("data-page", page);
                    } else
                    {
                        jQuery(this).css("display", "none");
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

let Pagination = (function(){
    let $buttons = jQuery(".pagination_button");

    let hideButtons = function(){
        $buttons.css("display", "none");
    };

    let showButtons = function(){
        $buttons.removeAttr("style");
    };

    return {
        $buttons : $buttons,
        hideButtons : hideButtons,
        showButtons : showButtons
    };
})();