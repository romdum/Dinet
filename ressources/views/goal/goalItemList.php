<?php /** @var \Dinet\Goal\Goal $goal */ ?>

<li class="<?= $goal->isDone() ? 'goalDone' : '' ?>" data-id="<?= $goal->getId() ?>">
    <?= $goal->isDone() ? \Dinet\Goal\UI::getCheckIcon() : \Dinet\Goal\UI::getUncheckIcon() ?>
    <span class="goalDescription <?=  $goal->isDone() ? 'goalDoneDescription' : '' ?>"><?= $goal->getDescription(); ?></span>
    <span class="goalDate hidden"><?= $goal->getDate() ?></span>
</li>

