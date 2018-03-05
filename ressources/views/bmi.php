<?php /** @var \Dinet\Patient\PatientCtrl $PatientCtrl */ ?>
<section class="IMC">
    <header>
        <h2>Mon IMC</h2>
    </header>
    <p id="bmip" style="color: <?= $PatientCtrl->getImcColor() ?>; text-align: center;">
        <span id="bmi" style="font-size: <?= $PatientCtrl->getImcFontSize(); ?>;">
            <?= $PatientCtrl->getImc() ?>
        </span>
        <br>
        <span id="bmi_comment">
            <?= $PatientCtrl->getImcComment() ?>
        </span>
    </p>
</section>
