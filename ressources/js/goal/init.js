jQuery(function(){
    GoalSelector.getAddGoalBtn().click(function(){
        Goal.add();
    });
    GoalSelector.getGoalList().on('click','li',function(){
        Goal.setDone( jQuery(this).attr('data-id') );
    });
});