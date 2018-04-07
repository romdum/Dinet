let GoalAjax = (function()
{
    let setDoneRequest = function(goalId)
    {
        let data = {
            action     : "goalSetDoneRequest",
            nonce      : utilGoalAjax.nonceSetGoalDone,
            goalUserId : parseInt(GoalSelector.getPatientId().val()),
            goalId     : goalId
        };

        return jQuery.post({
            url     : utilGoalAjax.ajaxURL,
            dataType: "json",
            data    : data
        });
    };

    let addRequest = function()
    {
        let data = {
            action          : "goalSaveRequest",
            nonce           : utilGoalAjax.nonceNewGoal,
            goalDescription : GoalSelector.getNewGoalInput().val(),
            goalDone        : 0,
            goalDate        : "02/04/2018",
            goalUserId      : parseInt(GoalSelector.getPatientId().val())
        };

        return jQuery.post({
            url     : utilGoalAjax.ajaxURL,
            dataType: "json",
            data    : data
        });
    };

    return {
        setDoneRequest: setDoneRequest,
        addRequest: addRequest
    }
})();