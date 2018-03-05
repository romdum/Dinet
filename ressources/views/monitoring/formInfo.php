<?php
/**
 * @var \Dinet\Patient\PatientCtrl $PatientCtrl
 * @var string $nonceName
 */
?>
<section class="add_info">
    <header>
        <h2>Mes infos</h2>
    </header>
    <form id="formInfo">
        <div>
            <label for="height">Taille</label>
            <input type="text" placeholder="Taille" name="Height" id="height" value="<?= $PatientCtrl->getPatient()->getHeight() ?>">
        </div>
        <div>
            <label for="weight">Poids</label>
            <input type="number" placeholder="Poids" name="Weight" id="weight" value="<?= $PatientCtrl->getPatient()->getWeight() ?>">
        </div>
        <input type="button" value="Enregistrer" class="save_info" id="formInfoSubmit">
        <input type="hidden" id="nonceName" value="<?= $nonceName ?>">
    </form>
</section>
