jQuery(document).ready(function($){
    $('#patientFormSubmit').click(function(){
        $('.patient_record .inputError').removeClass('inputError');

        formatHeight();
        formatWeight();
        formatPhone( ' ' );

        checkValue('firstname','[a-zA-Z]');
        checkValue('lastname','[a-zA-Z]');
        checkValue('weight','[0-9]{1,3}[.]?[0-9]{0,}');
        checkValue('height','[0-9]{1,3}[.]?[0-9]{0,}');
        checkValue('phone','^[(+33)|0]{1}[1-9]{1}[ |.]?([0-9]{2}[ |.]?){4}$');
        checkValue('job','[a-zA-Z]');
        if( $('.patient_record .inputError').length === 0 )
        {
            savePatientRecord();
        }
    });

    $('#formInfoSubmit').click(function(){
        $('#formInfo').find('.inputError').removeClass('inputError');

        formatHeight();
        formatWeight();

        checkValue('weight','[0-9]{1,3}[.]?[0-9]{0,}');
        checkValue('height','[0-9]{1,3}[.]?[0-9]{0,}');

        if( $('#formInfo').find('.inputError').length === 0 )
        {
            saveFormInfo();
        }
    });

    $('#height, #weight').change(function(){
        $('#bmi').val(calculBMI($('#height').val(),$('#weight').val()));
    });
});

let savePatientRecord = function(){
    jQuery.post({
        url     : SavePatientRecordUtil.ajaxurl,
        dataType: "json",
        data    : {
            action          : "ajaxSavePatient",
            nonce           : SavePatientRecordUtil.nonce,
            nonceName       : jQuery('#nonceName').val(),
            patientId       : jQuery('#patientId').val(),
            FirstName       : jQuery('#firstname').val(),
            LastName        : jQuery('#lastname').val(),
            Weight          : jQuery('#weight').val(),
            Height          : jQuery('#height').val(),
            Phone           : jQuery('#phone').val(),
            Observation     : jQuery('#obs').val(),
            Job             : jQuery('#job').val(),
            DateOfBirth     : jQuery('#dob').val(),
            FamilialHistory : jQuery('#familialHistory').val(),
            MedicalHistory  : jQuery('#medicalHistory').val()
        },
        success : function (response)
        {
            makeToast("Informations enregistrées", "#57b676");
            updateChart(response.dataset,response.labels);
        },
        error   : function ()
        {
            console.log("error");
            makeToast("Une erreur s'est produite", "#cf1a2e");
        }
    });
};

let saveFormInfo = function(){
    jQuery.post({
        url     : SavePatientRecordUtil.ajaxurl,
        dataType: "json",
        data    : {
            action      : "ajaxSavePatient",
            nonce       : SavePatientRecordUtil.nonce,
            nonceName   : jQuery('#nonceName').val(),
            Weight      : jQuery('#weight').val(),
            Height      : jQuery('#height').val(),
        },
        success : function (response)
        {
            let $bmi = jQuery('#bmi');
            $bmi.text(response.bmi.number);
            $bmi.css("font-size",response.bmi.font_size);
            jQuery('#bmi_comment').text(response.bmi.comment);
            jQuery('#bmip').css("color",response.bmi.color);
            makeToast("Informations enregistrées", "#57b676");
        },
        error   : function ()
        {
            console.log("error");
            makeToast("Une erreur s'est produite", "#cf1a2e");
        }
    });
};

let checkValue = function(id, regex){

    regex = RegExp(regex);
    let $elem = jQuery('#' + id);
    let value = $elem.val();

    if( ! regex.test(value) ){
        $elem.addClass('inputError');
        return false;
    } else {
        return true;
    }
};

let formatHeight = function(){
    let $height = jQuery('#height');

    $height.val( $height.val().replace(',','.') );

    if( $height.val() > 3 )
        $height.val( $height.val() / 100 );

    $height.val( $height.val().substr(0,4) );
};

let formatWeight = function(){
    let $weight = jQuery('#weight');
    $weight.val( $weight.val().replace(',','.') );
};

let formatPhone = function( separator = '' ){
    let $phone = jQuery('#phone');
    let phone = $phone.val();
    let result = '';

    for( let i = 0; i < phone.length; i++ )
        if( ! isNaN( phone[i] ) && phone[i] !== ' ' )
            result += phone[i] + ( result.replace(new RegExp(separator,'g'),'').length % 2 ? separator : '' );

    $phone.val(result);
};

let calculBMI = function(height, weight)
{
    return Math.round(weight / (height * height) * 10 ) / 10;
};