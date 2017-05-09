<section class="IMC">
    <header>
        <h2>Mon IMC</h2>
    </header>
    <p style="color: <?= $BMI->get_imc_color() ?>; text-align: center;">
        <span style="font-size: <?= $BMI->get_imc_font_size(); ?>;"><?= $BMI->get_imc() ?></span><br>
        <?= $BMI->get_imc_comment() ?>
    </p>
</section>
