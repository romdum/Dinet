<?php
/**
 * @var array $consultations
 * @var \Dinet\Consultation\Model\Consultation $consultation
 */
?>
<section class="patient_consultation">
    <header>
        <h2>Consultations</h2>
        <a href="<?= admin_url('post-new.php?post_type=consultation&patient_id=' . $_GET['patient_id'] ) ?>" class="button button-primary">Ajouter</a>
    </header>
    <table class="widefat striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Titre</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach( $consultations as $consultation ): ?>
                <tr>
                    <td><?= $consultation->getDate() ?></td>
                    <td><a href="<?= get_edit_post_link( $consultation->getId() ) ?>"><?= $consultation->getTitle() ?></a></td>
                    <td class="alignright">
                        <a href="<?= get_edit_post_link( $consultation->getId() ) ?>&download=1">
                            <span class="dashicons dashicons-download"></span>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
