jQuery(function(){
    jQuery('#addGoalBtn').click(function(){
        Goal.add( Goal.getNewGoalInput().val() );
    });
});

let Goal = (function()
{
    let add = function( description )
    {
        addRequest( description ).success(function(){
            console.log("ok")
        });
    };

    let addRequest = function( description )
    {
        return jQuery.post({
            url     : utilGoal.ajaxURL,
            dataType: "json",
            data    : {
                action          : "goalSaveRequest",
                nonce           : utilGoal.nonce,
                goalDescription : description,
                goalDone        : false,
                goalDate        : "02/04/2018"
            }
        });
    };

    let getNewGoalInput = function()
    {
        return jQuery('#newGoalInput');
    };

    return {
        add : add,
        getNewGoalInput: getNewGoalInput
    }
})();