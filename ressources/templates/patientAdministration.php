<?php
/**
 * @var \Dinet\Monitoring\FoodMonitoringChart $Chart
 * @var \Dinet\Goal\UI $goalUI
 */

use Dinet\Dinet;
use Dinet\SettingsEnum;
use Dinet\UtilPath;

?>

<?php include UtilPath::getViewsPath( 'header' ); ?>
<main>
    <div style="display:flex;">
        <?php include UtilPath::getViewsPath( 'patient_record' ); ?>

        <div style="display:flex;flex-wrap: wrap;">
            <?php if( Dinet::$setting->getSetting( SettingsEnum::GOAL, SettingsEnum::ACTIVATE ) ): ?>
                <?php $goalUI->displayGoals( $_GET['patient_id'] ); ?>
            <?php endif; ?>

            <?php if( Dinet::$setting->getSetting( SettingsEnum::CONSULTATION, SettingsEnum::ACTIVATE ) ): ?>
                <?php include UtilPath::getViewsPath( 'consultation/patient_consultation' ); ?>
            <?php endif; ?>
            <?php $Chart->display(); ?>
            <?php if( \Dinet\Dinet::$setting->getSetting( SettingsEnum::MONITORING, SettingsEnum::ACTIVATE ) ): ?>
                <?php include UtilPath::getViewsPath( 'monitoring/lastFood' ); ?>
            <?php endif; ?>
        </div>
    </div>

</main>

<?php include UtilPath::getViewsPath('toast' ) ?>