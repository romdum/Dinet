<?php
/**
 * @var \Dinet\Chart $Chart
 * @var \Dinet\Patient\PatientCtrl $PatientCtrl
 * @var \Dinet\Goal\UI $Goal
 * @var array $display
 */

use Dinet\Dinet;
use Dinet\SettingsEnum;
use Dinet\UtilPath;

?>

<?php include UtilPath::getViewsPath( 'header' ); ?>
<main>
    <?php if ( Dinet::$setting->getSetting( SettingsEnum::MONITORING, SettingsEnum::DISPLAY, SettingsEnum::CHART ) ): ?>
        <?php if( $PatientCtrl->settings->getSetting( SettingsEnum::MONITORING, SettingsEnum::DISPLAY, SettingsEnum::CHART ) ): ?>
            <?php $Chart->display(); ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ( Dinet::$setting->getSetting( SettingsEnum::MONITORING, SettingsEnum::DISPLAY, SettingsEnum::BMI ) ): ?>
        <?php if( $PatientCtrl->settings->getSetting( SettingsEnum::MONITORING, SettingsEnum::DISPLAY, SettingsEnum::BMI ) ): ?>
            <?php include UtilPath::getViewsPath( 'bmi' ); ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php if( @$display['goal'] ): ?>
        <?php $Goal->displayGoals( $PatientCtrl->getPatient()->getUserId() ) ?>
    <?php endif; ?>

    <?php include UtilPath::getViewsPath( 'monitoring/formInfo' ); ?>
    <?php include UtilPath::getViewsPath( 'monitoring/lastFood' ); ?>
    <?php include UtilPath::getViewsPath( 'monitoring/add_eaten_food' ); ?>
</main>
<?php include UtilPath::getViewsPath('toast' ) ?>