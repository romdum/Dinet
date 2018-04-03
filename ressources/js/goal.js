jQuery(function(){
    jQuery('#addGoalBtn').click(function(){
        Goal.add();
    });
    jQuery('#goalList').on('click','li',function(){
        Goal.setDone( jQuery(this).attr('data-id') );
    });
});

let Goal = (function()
{
    let add = function()
    {
        addRequest().success(function(response){
            jQuery('#goalList').append('<li data-id="'+response.id+'">'+response.icon+response.description+'</li>');
            Goal.getNewGoalInput().val('')
        });
    };

    let addRequest = function()
    {
        let data = {
            action          : "goalSaveRequest",
            nonce           : utilGoal.nonce,
            goalDescription : Goal.getNewGoalInput().val(),
            goalDone        : 0,
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

    let setDone = function(goalId)
    {
        setDoneRequest(goalId).success(function(response){
            console.log(response);
            let $li = jQuery('li[data-id="'+goalId+'"]');
            if( response.isDone ){
                $li.addClass('goalDone');
            } else {
                $li.removeClass('goalDone');
            }
            $li.find('svg').remove();
            $li.prepend(response.icon)
                .find('svg')
                .animate({  borderSpacing: 360 }, {
                    step: function(now,fx) {
                        jQuery(this).css('-webkit-transform','rotate('+now+'deg)');
                        jQuery(this).css('-moz-transform','rotate('+now+'deg)');
                        jQuery(this).css('transform','rotate('+now+'deg)');
                    },
                    duration:'slow'
                },'linear');
        });
    };

    let setDoneRequest = function(goalId)
    {
        let data = {
            action     : "goalSetDoneRequest",
            nonce      : utilGoal.nonce,
            goalUserId : parseInt(jQuery('#patient_id').val()),
            goalId     : goalId
        };

        return jQuery.post({
            url     : utilGoal.ajaxURL,
            dataType: "json",
            data    : data
        });
    };

    return {
        add : add,
        getNewGoalInput: getNewGoalInput,
        setDone : setDone
    }
})();