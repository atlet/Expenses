<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExpenseSplit $expenseSplit
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Expense Split'), ['action' => 'edit', $expenseSplit->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Expense Split'), ['action' => 'delete', $expenseSplit->id], ['confirm' => __('Are you sure you want to delete # {0}?', $expenseSplit->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Expense Splits'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Expense Split'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="expenseSplits view content">
            <h3><?= h($expenseSplit->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Expense') ?></th>
                    <td><?= $expenseSplit->hasValue('expense') ? $this->Html->link($expenseSplit->expense->title, ['controller' => 'Expenses', 'action' => 'view', $expenseSplit->expense->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Person') ?></th>
                    <td><?= $expenseSplit->hasValue('person') ? $this->Html->link($expenseSplit->person->name, ['controller' => 'People', 'action' => 'view', $expenseSplit->person->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($expenseSplit->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Share Ratio') ?></th>
                    <td><?= $this->Number->format($expenseSplit->share_ratio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($expenseSplit->created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>