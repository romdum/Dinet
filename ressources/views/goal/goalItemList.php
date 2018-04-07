<?php /** @var \Dinet\Goal\Goal $goal */ ?>
<?php if( $goal->isDone() ): ?>
	<li class="goalDone" data-id="<?= $goal->getId() ?>">
		<?= \Dinet\Goal\UI::getCheckIcon() ?>
		<?= $goal->getDescription(); ?>
	</li>
<?php else: ?>
	<li data-id="<?= $goal->getId() ?>">
		<?= \Dinet\Goal\UI::getUncheckIcon() ?>
		<?= $goal->getDescription(); ?>
	</li>
<?php endif; ?>
