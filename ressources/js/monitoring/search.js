jQuery(document).ready(function ($)
{
    $("#search_bar").keyup(function ()
    {
        let search_value = $(this).val();

        if (search_value.length >= 3 || search_value.length === 0)
        {
            $.post({
                url       : utilFoodSearch.ajaxURL,
                dataType  : "json",
                data      : {
                    action: "food_search",
                    nonce : utilFoodSearch.nonce,
                    search: search_value
                },
                success   : function (response)
                {
                    let i = 0;
                    $(".food_item").each(function ()
                    {
                        if (response[i] != undefined)
                        {
                            $(this).removeAttr("style");
                            $(this).children("td:nth-child(1)").text(response[i].designation);
                            $(this).children("td:nth-child(2)").text(response[i].group);
                            $(this).find("td:last-child").find('input[name="food-id"]').val(response[i].id);
                        }
                        else
                        {
                            $(this).css("display", "none");
                        }
                        i++;
                    });
                },
                error     : function ()
                {
                    makeToast("Une erreur s'est produite", "#cf1a2e");
                }
            });

            $(".pagination_button").css("display", "none");
            if (search_value.length === 3 || search_value.length === 0)
            {
                $(".pagination_button").removeAttr("style");
            }
        }
    });
});