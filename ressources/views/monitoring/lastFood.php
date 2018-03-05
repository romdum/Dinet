<?php
/**
 * @var \Dinet\Monitoring\ConsumptionListCtrl $ConsumptionList
 * @var \Dinet\Monitoring\Consumption $consumption
 * @var \Dinet\Patient\Patient $Patient
 * @var int $limit
 * @var array $display
 */
?>
<section class="dinet_last_food">
    <header>
        <h2>Dernières consommations</h2>
    </header>
    <table class="dinet_last_food_table widefat striped" id="table_last_food">
        <thead>
            <tr>
                <th>Date</th>
                <th><?= __('Nom') ?></th>
                <th>Quantité (g)</th>

                <?php if( ! isset( $display['hungryLevel'] ) || $display['hungryLevel'] ): ?>
                    <th>Niveau de faim</th>
                <?php endif; ?>

                <?php if( ! isset( $display['feelingBefore'] ) || $display['feelingBefore'] ): ?>
                    <th>Émotion avant</th>
                <?php endif; ?>

                <?php if( ! isset( $display['feelingAfter'] ) || $display['feelingAfter'] ): ?>
                    <th>Émotion après</th>
                <?php endif; ?>

                <?php if( ! isset( $display['trash'] ) || $display['trash'] ): ?>
                    <th></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody class="dinet_last_food_table_body">
            <?php foreach ( $ConsumptionList->getConsumptionList()->getList() as $consumption ): ?>
                <?php include \Dinet\UtilPath::getViewsPath( 'monitoring/lastFoodRow' ); ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
