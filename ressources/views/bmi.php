<?php /** @var \Dinet\Patient\PatientCtrl $PatientCtrl */ ?>
<section class="IMC">
    <header>
        <h2>Mon IMC</h2>
    </header>
    <p id="bmip" style="color: <?= $PatientCtrl->getBMI()->getColor() ?>; text-align: center;">
        <span id="bmi" style="font-size: <?= $PatientCtrl->getBMI()->getFontSize(); ?>;">
            <?= $PatientCtrl->getBMI() ?>
        </span>
        <br>
        <span id="bmi_comment">
            <?= $PatientCtrl->getBMI()->getComment() ?>
        </span>
    </p>
</section>
