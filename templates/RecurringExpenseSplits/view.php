<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RecurringExpenseSplit $recurringExpenseSplit
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Recurring Expense Split'), ['action' => 'edit', $recurringExpenseSplit->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Recurring Expense Split'), ['action' => 'delete', $recurringExpenseSplit->id], ['confirm' => __('Are you sure you want to delete # {0}?', $recurringExpenseSplit->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Recurring Expense Splits'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Recurring Expense Split'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="recurringExpenseSplits view content">
            <h3><?= h($recurringExpenseSplit->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Recurring Expense') ?></th>
                    <td><?= $recurringExpenseSplit->hasValue('recurring_expense') ? $this->Html->link($recurringExpenseSplit->recurring_expense->title, ['controller' => 'RecurringExpenses', 'action' => 'view', $recurringExpenseSplit->recurring_expense->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Person') ?></th>
                    <td><?= $recurringExpenseSplit->hasValue('person') ? $this->Html->link($recurringExpenseSplit->person->name, ['controller' => 'People', 'action' => 'view', $recurringExpenseSplit->person->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($recurringExpenseSplit->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($recurringExpenseSplit->created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>