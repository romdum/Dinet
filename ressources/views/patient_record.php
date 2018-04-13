<?php
/**
 * @var \Dinet\Patient\PatientCtrl $PatientCtrl
 * @var string $nonceName
 */
?>
<section class="patient_record">
    <header>
        <h2>Informations du patient</h2>
    </header>
    <form class="patient_record_form" id="patient_form" action="<?= admin_url('admin-post.php?action=post_save_patient') ?>" method="post">
        <div class="patient_record_form_group">
            <label for="login">Identifiant :</label>
            <input id="login" type="text" value="<?= $PatientCtrl->getPatient()->getLogin() ?>" disabled>
        </div>
        <div class="patient_record_form_group">
            <label for="firstname">Prénom :</label>
            <input id="firstname" type="text" name="FirstName" value="<?= $PatientCtrl->getPatient()->getFirstName() ?>">
        </div>
        <div class="patient_record_form_group">
            <label for="lastname">Nom :</label>
            <input id="lastname" type="text" name="LastName" value="<?= $PatientCtrl->getPatient()->getLastName() ?>">
        </div>
        <div class="patient_record_form_group">
            <label for="weight">Poids :</label>
            <input id="weight" type="text" name="Weight" value="<?= $PatientCtrl->getPatient()->getWeight()->getValue() ?>">
        </div>
        <div class="patient_record_form_group">
            <label for="height">Taille :</label>
            <input id="height" type="text" name="Height" value="<?= $PatientCtrl->getPatient()->getHeight() ?>">
        </div>
        <div class="patient_record_form_group">
            <label for="phone">Téléphone :</label>
            <input id="phone" type="text" name="Phone" value="<?= $PatientCtrl->getPatient()->getPhone() ?>">
        </div>
        <div class="patient_record_form_group">
            <label for="obs">Observations :</label>
            <textarea id="obs" form="patient_form" name="Observation"><?= $PatientCtrl->getPatient()->getObservation() ?></textarea>
        </div>
        <input type="button" id="patientFormSubmit" class="button button-primary" value="Enregistrer">
        <input type="hidden" id="patientId" value="<?= $PatientCtrl->getPatient()->getUserId() ?>">
        <input type="hidden" id="nonceName" value="<?= $nonceName ?>">
    </form>
</section>
