<?php
    /**
     * @var \Dinet\Monitoring\Consumption $consumption
     * @var array $display
     */
?>

<tr class="">
    <td><?= date_format( date_create( $consumption->getDate() ), 'd-m-Y H:i' ) ?></td>
    <td><?= $consumption->getFood()->designation ?></td>
    <td><?= $consumption->getQuantity() ?></td>

    <?php if( ! isset( $display['hungryLevel'] ) || $display['hungryLevel'] ): ?>
        <td><?= $consumption->getHungryLevel() !== 0 ? $consumption->getHungryLevel() . ' / 10' : '' ?></td>
    <?php endif; ?>

    <?php if( ! isset( $display['feelingBefore'] ) || $display['feelingBefore'] ): ?>
        <td><?= $consumption->getFeelingBefore() ?></td>
    <?php endif; ?>

    <?php if( ! isset( $display['feelingAfter'] ) || $display['feelingAfter'] ): ?>
        <td><?= $consumption->getFeelingAfter() ?></td>
    <?php endif; ?>

    <?php if( ! isset( $display['trash'] ) || $display['trash'] ): ?>
        <td>
            <button type="button" class="btn-delete" data-food-user-id="<?= $consumption->getId() ?>" name="delete-food">
                <span class="dashicons dashicons-trash"></span>
            </button>
        </td>
    <?php endif; ?>
</tr>
