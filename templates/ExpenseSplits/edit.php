<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExpenseSplit $expenseSplit
 * @var string[]|\Cake\Collection\CollectionInterface $expenses
 * @var string[]|\Cake\Collection\CollectionInterface $people
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $expenseSplit->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $expenseSplit->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Expense Splits'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="expenseSplits form content">
            <?= $this->Form->create($expenseSplit) ?>
            <fieldset>
                <legend><?= __('Edit Expense Split') ?></legend>
                <?php
                    echo $this->Form->control('expense_id', ['options' => $expenses]);
                    echo $this->Form->control('person_id', ['options' => $people]);
                    echo $this->Form->control('share_ratio');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
