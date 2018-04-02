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
    <?php endif; ?>
    <ul>
        <?php foreach( $goals as $goal ): ?>
            <li>
                <?php $goal->getDescription(); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
