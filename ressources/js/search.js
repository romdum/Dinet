/**
 * Created by romain on 21/04/17.
 */

$(document).ready(function ()
{
    $("#search_bar").keyup(function ()
    {
        let search_value = $(this).val();

        if (search_value.length > 3)
        {
            $.post({
                url       : myAjax.ajaxurl,
                dataType  : "json",
                data      : {
                    action: "food_search",
                    nonce : myAjax.nonce,
                    search: search_value,
                },
                beforeSend: function ()
                {
                    //$field.after('<img src="ajax-loader.gif" alt="loader" id="ajax-loader" />'); // ajout d'un loader pour signifier l'action
                },
                success   : function (response)
                {
                    $(".pagination_button").css("display", "none");
                    let i = 0;
                    $(".food_item").each(function ()
                    {
                        if (response[i] != undefined)
                        {
                            $(this).removeAttr("style");
                            $(this).children("td:nth-child(1)").text(response[i].Désignation);
                            $(this).children("td:nth-child(2)").text(response[i].Groupe);
                            $(this).children("td:nth-child(3)").children("input[type=button]").attr("data-food-id", response[i].id);
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
        } else if (search_value.length === 3 || search_value.length === 0)
        {
            $(".pagination_button").removeAttr("style");

            let page = parseInt($("#table_food").attr("data-page"));

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
    });
});