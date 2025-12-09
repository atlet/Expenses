<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\RecurringExpenseSplit> $recurringExpenseSplits
 */
?>
<div class="recurringExpenseSplits index content">
    <?= $this->Html->link(__('New Recurring Expense Split'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Recurring Expense Splits') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('recurring_expense_id') ?></th>
                    <th><?= $this->Paginator->sort('person_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recurringExpenseSplits as $recurringExpenseSplit): ?>
                <tr>
                    <td><?= $this->Number->format($recurringExpenseSplit->id) ?></td>
                    <td><?= $recurringExpenseSplit->hasValue('recurring_expense') ? $this->Html->link($recurringExpenseSplit->recurring_expense->title, ['controller' => 'RecurringExpenses', 'action' => 'view', $recurringExpenseSplit->recurring_expense->id]) : '' ?></td>
                    <td><?= $recurringExpenseSplit->hasValue('person') ? $this->Html->link($recurringExpenseSplit->person->name, ['controller' => 'People', 'action' => 'view', $recurringExpenseSplit->person->id]) : '' ?></td>
                    <td><?= h($recurringExpenseSplit->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $recurringExpenseSplit->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $recurringExpenseSplit->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $recurringExpenseSplit->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $recurringExpenseSplit->id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>