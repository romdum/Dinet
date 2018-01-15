<section class="patient_record">
    <header>
        <h2>Informations du patient</h2>
    </header>
    <form class="patient_record_form" id="patient_form" action="<?= admin_url('admin-post.php?action=post_save_patient') ?>" method="post">
        <div class="patient_record_form_group">
            <label for="login">Identifiant :</label>
            <input id="login" type="text" name="login" value="<?= $Patient->get_login() ?>" disabled>
        </div>
        <div class="patient_record_form_group">
            <label for="firstname">Prénom :</label>
            <input id="firstname" type="text" name="firstname" value="<?= $Patient->get_first_name() ?>">
        </div>
        <div class="patient_record_form_group">
            <label for="lastname">Nom :</label>
            <input id="lastname" type="text" name="lastname" value="<?= $Patient->get_last_name() ?>">
        </div>
        <div class="patient_record_form_group">
            <label for="weight">Poids :</label>
            <input id="weight" type="text" name="weight" value="<?= $Patient->get_weight() ?>">
        </div>
        <div class="patient_record_form_group">
            <label for="height">Taille :</label>
            <input id="height" type="text" name="height" value="<?= $Patient->get_height() ?>">
        </div>
        <div class="patient_record_form_group">
            <label for="phone">Téléphone :</label>
            <input id="phone" type="text" name="phone" value="<?= $Patient->get_phone() ?>">
        </div>
        <div class="patient_record_form_group">
            <label for="obs">Observations :</label>
            <textarea id="obs" form="patient_form" name="obs"><?= $Patient->get_observation() ?></textarea>
        </div>
        <input type="submit" class="button button-primary" value="Enregistrer">
        <input type="hidden" name="user_id" value="<?= $Patient->get_user_id() ?>">
    </form>
</section>
