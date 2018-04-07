let GoalSelector = (function(){

    let $newGoalInput;
    let $goalList;
    let $patientId;
    let $addGoalBtn;

    let getNewGoalInput = function()
    {
        if( typeof $newGoalInput === 'undefined' ){
            $newGoalInput = jQuery('#newGoalInput');
        }
        return $newGoalInput;
    };

    let getGoalList = function()
    {
        if( typeof $goalList === 'undefined' ){
            $goalList = jQuery('#goalList');
        }
        return $goalList;
    };

    let getPatientId = function()
    {
        if( typeof $patientId === 'undefined' ){
            $patientId = jQuery('#patient_id');
        }
        return $patientId;
    };

    let getAddGoalBtn = function()
    {
        if( typeof $addGoalBtn === 'undefined' ){
            $addGoalBtn = jQuery('#addGoalBtn');
        }
        return $addGoalBtn;
    };

    return {
        getNewGoalInput: getNewGoalInput,
        getGoalList: getGoalList,
        getAddGoalBtn: getAddGoalBtn,
        getPatientId: getPatientId
    }
})();