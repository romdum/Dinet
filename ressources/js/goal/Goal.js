let Goal = (function()
{
    let add = function()
    {
        GoalAjax.addRequest().success(function(response){
            GoalSelector.getGoalList()
                .append(response.html);
            GoalSelector.getNewGoalInput().val('')
        });
    };

    let setDone = function(goalId)
    {
        GoalAjax.setDoneRequest(goalId).success(function(response){
            toggleCheck(jQuery('li[data-id="'+goalId+'"]'), response.isDone, response.icon);
        });
    };

    let toggleCheck = function($obj, isDone, icon)
    {
        if( isDone ){
            $obj.addClass('goalDone');
        } else {
            $obj.removeClass('goalDone');
        }
        $obj.find('svg').remove();
        $obj.prepend(icon)
            .find('svg')
            .animate({borderSpacing: 360}, {step: checkAnimation, duration:'slow'},'linear');
    };

    let checkAnimation = function(now, fx)
    {
        jQuery(this).css('-webkit-transform','rotate('+now+'deg)');
        jQuery(this).css('-moz-transform','rotate('+now+'deg)');
        jQuery(this).css('transform','rotate('+now+'deg)');
    };

    return {
        add : add,
        setDone : setDone
    }
})();