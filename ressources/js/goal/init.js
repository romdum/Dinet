jQuery(function(){
    // click on add button
    GoalSelector.getAddGoalBtn().click(function(){
        Goal.add();
    });
    // click on a goal to finish it
    GoalSelector.getGoalList().on('click','li',function(){
        Goal.setDone( jQuery(this).attr('data-id') );
    });
    // hover goal description to display date
    GoalSelector.getGoalDescription().hover(function(){
        jQuery(this).next('.goalDate').fadeIn('fast');
    }, function(){
        jQuery(this).next('.goalDate').fadeOut('fast');
    });
});