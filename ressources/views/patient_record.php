<?php
/**
 * @var \Dinet\Patient\PatientCtrl $PatientCtrl
 * @var string $nonceName
 */
?>
<section class="patient_record">
    <header>
        <h2>Informations du patient <?= $PatientCtrl->getPatient()->getLogin() ?></h2>
    </header>
    <form class="patient_record_form" id="patient_form" action="<?= admin_url('admin-post.php?action=post_save_patient') ?>" method="post">
        <h3>Renseignements administratifs</h3>
        <div class="patient_record_form_group">
            <label for="firstname">Prénom :</label>
            <input id="firstname" type="text" name="FirstName" value="<?= $PatientCtrl->getPatient()->getFirstName() ?>">
        </div>
        <div class="patient_record_form_group">
            <label for="lastname">Nom :</label>
            <input id="lastname" type="text" name="LastName" value="<?= $PatientCtrl->getPatient()->getLastName() ?>">
        </div>
        <div class="patient_record_form_group">
            <label for="phone">Téléphone :</label>
            <input id="phone" type="text" name="Phone" value="<?= $PatientCtrl->getPatient()->getPhone() ?>">
        </div>
        <div class="patient_record_form_group">
            <label for="dob">Date de naissance :</label>
            <input id="dob" type="date" name="DateOfBirth" value="<?= $PatientCtrl->getPatient()->getDateOfBirth() ?>">
        </div>
        <div class="patient_record_form_group">
            <label for="job">Profession :</label>
            <input id="job" type="text" name="Job" value="<?= $PatientCtrl->getPatient()->getJob() ?>">
        </div>
        <h3>Renseignements médicaux</h3>
        <div style="display: flex;justify-content: space-between">
            <div class="patient_record_form_group">
                <label for="weight">Poids :</label>
                <input style="width: 70px;" id="weight" type="text" name="Weight" value="<?= $PatientCtrl->getPatient()->getWeight()->getValue() ?>">
            </div>
            <div class="patient_record_form_group" style="margin-right: 0.5rem">
                <label style="width: 70px;" for="height">Taille :</label>
                <input style="width: 70px;" id="height" type="text" name="Height" value="<?= $PatientCtrl->getPatient()->getHeight() ?>">
            </div>
            <div class="patient_record_form_group" style="margin-right: 0.5rem">
                <label style="width: 70px;" for="bmi">IMC :</label>
                <input style="width: 70px;" id="bmi" type="text" value="<?= ! is_string( $PatientCtrl->getBMI()->getBmi() ) ? $PatientCtrl->getBMI()->getBmi() : 0 ?>" disabled>
            </div>
        </div>
        <div class="patient_record_form_group">
            <label for="familialHistory">Antécédent familiaux :</label>
            <input id="familialHistory" type="text" name="FamilialHistory" value="<?= $PatientCtrl->getPatient()->getFamilialHistory() ?>">
        </div>
        <div class="patient_record_form_group">
            <label for="medicalHistory">Antécédent médicaux :</label>
            <input id="medicalHistory" type="text" name="MedicalHistory" value="<?= $PatientCtrl->getPatient()->getFamilialHistory() ?>">
        </div>
        <div class="patient_record_form_group" style="display: flex;">
            <label for="obs">Observations :</label>&nbsp;
            <textarea id="obs" form="patient_form" name="Observation"><?= $PatientCtrl->getPatient()->getObservation() ?></textarea>
        </div>
        <input type="button" id="patientFormSubmit" class="button button-primary" value="Enregistrer">
        <input type="hidden" id="patientId" value="<?= $PatientCtrl->getPatient()->getUserId() ?>">
        <input type="hidden" id="nonceName" value="<?= $nonceName ?>">
    </form>
</section>
