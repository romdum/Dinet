<?php
use Dinet\Dinet;
use Dinet\SettingsEnum;
use Dinet\UtilPath;

/** @var \Dinet\Patient\PatientCtrl $PatientCtrl */
?>

<?php include UtilPath::getViewsPath( 'header' ); ?>
    <main>
        <?php if ( Dinet::$setting->getSetting( SettingsEnum::MONITORING, SettingsEnum::DISPLAY, SettingsEnum::CHART ) ): ?>
            <?php if( $PatientCtrl->settings->getSetting( SettingsEnum::MONITORING, SettingsEnum::DISPLAY, SettingsEnum::CHART ) ): ?>

            <?php endif; ?>
        <?php endif; ?>

        <?php if ( Dinet::$setting->getSetting( SettingsEnum::MONITORING, SettingsEnum::DISPLAY, SettingsEnum::BMI ) ): ?>
            <?php if( $PatientCtrl->settings->getSetting( SettingsEnum::MONITORING, SettingsEnum::DISPLAY, SettingsEnum::BMI ) ): ?>

            <?php endif; ?>
        <?php endif; ?>

    </main>
<?php include UtilPath::getViewsPath('toast' ) ?>