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
            goalDate        : getDate(),
            goalUserId      : parseInt(GoalSelector.getPatientId().val())
        };

        return jQuery.post({
            url     : utilGoalAjax.ajaxURL,
            dataType: "json",
            data    : data
        });
    };

    let getDate = function()
    {
        let d = new Date();

        let month = d.getMonth()+1;
        let day = d.getDate();

        return (day<10 ? '0' : '') + day + '/' +
            (month<10 ? '0' : '') + month + '/' +
            d.getFullYear();
    };

    return {
        setDoneRequest: setDoneRequest,
        addRequest: addRequest
    }
})();