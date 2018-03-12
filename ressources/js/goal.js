jQuery(document).ready(function(){
    $('#addGoalBtn').click(function(){
        Goal.add();
    });
});

let Goal = (function()
{
    let add = function( description )
    {

    };

    let addRequest = function()
    {
        return jQuery.post({
            url     : utilGoal.ajaxurl,
            dataType: "json",
            data    : {
                action      : "saveRequest",
                nonce       : utilGoal.nonce,
            }
        });
    };

    return {
        add : add
    }
})();