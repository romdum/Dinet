<div class="extraInfoConsultation">
    <label for="patientConsultation">Patient :</label>
    <select id="patientConsultation" class="" name="patient_id">
        <?php foreach( get_users( ['role__not_in' => ['administrator']] ) as $user ): ?>
            <option <?= @$_GET['patient_id'] == $user->ID ? 'selected' : '' ?> value="<?= $user->ID ?>">
                <?= $user->first_name . ' ' . $user->last_name ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
