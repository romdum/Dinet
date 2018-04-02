<?php
/**
 * @var array $display
 * @var array $goals
 * @var \Dinet\Goal\Goal $goal
 */
?>
<section class="goal">
    <header>
        <h2>Objectifs</h2>
    </header>
    <?php if( isset( $display ) && isset( $display['addGoal'] ) && $display['addGoal'] ): ?>
        <input type="text" id="newGoalInput" placeholder="Nouvel objectif">
        <input type="button" value="Ajouter" class="button button-primary" id="addGoalBtn">
        <input type="hidden" value="<?= $_GET['patient_id'] ?>" id="patient_id">
    <?php endif; ?>
    <ul id="goalList">
        <?php foreach( $goals as $goal ): ?>
            <li>
                <?= $goal->getDescription(); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
