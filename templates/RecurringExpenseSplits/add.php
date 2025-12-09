<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RecurringExpenseSplit $recurringExpenseSplit
 * @var \Cake\Collection\CollectionInterface|string[] $recurringExpenses
 * @var \Cake\Collection\CollectionInterface|string[] $people
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Recurring Expense Splits'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="recurringExpenseSplits form content">
            <?= $this->Form->create($recurringExpenseSplit) ?>
            <fieldset>
                <legend><?= __('Add Recurring Expense Split') ?></legend>
                <?php
                    echo $this->Form->control('recurring_expense_id', ['options' => $recurringExpenses]);
                    echo $this->Form->control('person_id', ['options' => $people]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
