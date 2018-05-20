<?php
    $defaultHeaders = [
        'Suivi poids et ressenti',
        'Suivi biologique et traitement',
        'Evolution concernant son alimentation / réalisation des objectifs',
        'Evolution concernant son activité physique',
        'Education nutritionnelle et nouveaux objectifs négociés',
        'Documents remis'
    ]
?>
<table class="table table-bordered">
    <?php foreach( $defaultHeaders as $header ): ?>
        <tr>
            <th class="table-active"><?= $header ?></th>
            <td style="min-width: 100px;max-width: 600px;"></td>
        </tr>
    <?php endforeach; ?>
</table>

