jQuery(function(){
    jQuery('#addGoalBtn').click(function(){
        Goal.add();
    });
});

let Goal = (function()
{
    let add = function()
    {
        addRequest().success(function(response){
            jQuery('#goalList').append('<li>'+Goal.getNewGoalInput().val()+'</li>');
            Goal.getNewGoalInput().val('')
        });
    };

    let addRequest = function()
    {
        let data = {
            action          : "goalSaveRequest",
            nonce           : utilGoal.nonce,
            goalDescription : Goal.getNewGoalInput().val(),
            goalDone        : false,
            goalDate        : "02/04/2018",
            goalUserId      : parseInt(jQuery('#patient_id').val())
        };

        return jQuery.post({
            url     : utilGoal.ajaxURL,
            dataType: "json",
            data    : data
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