<?php
/**
 * @var \Dinet\Monitoring\FoodMonitoringChart $Chart
 */

use Dinet\Dinet;
use Dinet\SettingsEnum;
use Dinet\UtilPath;

?>

<?php include UtilPath::getViewsPath( 'header' ); ?>
<main>
    <div style="display:flex;">
        <?php include UtilPath::getViewsPath( 'patient_record' ); ?>

        <?php if( Dinet::$setting->getSetting( 'Consultation', 'activate' ) ): ?>
            <?php include UtilPath::getViewsPath( 'admin/patient_consultation' ); ?>
        <?php endif; ?>
    </div>

    <div style="display:flex;">
        <?php $Chart->display(); ?>
        <?php if( \Dinet\Dinet::$setting->getSetting( SettingsEnum::MONITORING, SettingsEnum::ACTIVATE ) ): ?>
            <?php include UtilPath::getViewsPath( 'monitoring/lastFood' ); ?>
        <?php endif; ?>
    </div>
</main>

<?php include UtilPath::getViewsPath('toast' ) ?>