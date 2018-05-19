<?php
/**
 * @var array $display
 * @var array $goals
 * @var \Dinet\Goal\Goal $goal
 */
?>

<section class="goal" style="<?= @$_GET['page'] === 'dinet_patient_record' ? 'margin-bottom: 1rem;' : '' ?>">
    <header>
        <h2>Objectifs</h2>
    </header>
    <?php if( isset( $display ) && isset( $display['addGoal'] ) && $display['addGoal'] ): ?>
        <input type="text" id="newGoalInput" placeholder="Nouvel objectif">
        <input type="button" value="Ajouter" class="button button-primary" id="addGoalBtn">
        <input type="hidden" value="<?= $_GET['patient_id'] ?>" id="patient_id">
    <?php endif; ?>
    <ul id="goalList" style="<?= @$_GET['page'] === 'dinet_patient_record' ? 'max-height: 340px' : '' ?>">
        <?php foreach( $goals as $goal ): ?>
            <?php include \Dinet\UtilPath::getViewsPath('goal/goalItemList' ); ?>
        <?php endforeach; ?>
    </ul>
</section>
