<div class="wrap">
    <h1>Paramètre du patient <?= $this->PatientCtrl->getPatient()->getFirstName() . ' ' . $this->PatientCtrl->getPatient()->getLastName() ?></h1>
    <form method="post" action="<?= admin_url( 'admin-post.php' ) ?>">
        <?php $this->displaySettings( $this->PatientCtrl->getSettings()->getSetting() ); ?>
        <div class="form-group">
            <input type="hidden" name="action" value="patientSettingsSave">
            <input type="hidden" name="patient_id" value="<?= $this->PatientCtrl->getPatient()->getUserId() ?>">
            <input type="submit" value="Enregistrer" class="button button-primary">
        </div>
    </form>
</div>