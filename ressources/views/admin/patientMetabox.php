<select class="" name="patient_id">
    <?php foreach( get_users() as $user ): ?>
        <option value="<?= $user->ID ?>"><?= $user->first_name . ' ' . $user->last_name ?></option>
    <?php endforeach; ?>
</select>
