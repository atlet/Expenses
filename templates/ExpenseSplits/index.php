<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ExpenseSplit> $expenseSplits
 */
?>
<div class="expenseSplits index content">
    <?= $this->Html->link(__('New Expense Split'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Expense Splits') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('expense_id') ?></th>
                    <th><?= $this->Paginator->sort('person_id') ?></th>
                    <th><?= $this->Paginator->sort('share_ratio') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($expenseSplits as $expenseSplit): ?>
                <tr>
                    <td><?= $this->Number->format($expenseSplit->id) ?></td>
                    <td><?= $expenseSplit->hasValue('expense') ? $this->Html->link($expenseSplit->expense->title, ['controller' => 'Expenses', 'action' => 'view', $expenseSplit->expense->id]) : '' ?></td>
                    <td><?= $expenseSplit->hasValue('person') ? $this->Html->link($expenseSplit->person->name, ['controller' => 'People', 'action' => 'view', $expenseSplit->person->id]) : '' ?></td>
                    <td><?= $this->Number->format($expenseSplit->share_ratio) ?></td>
                    <td><?= h($expenseSplit->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $expenseSplit->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $expenseSplit->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $expenseSplit->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $expenseSplit->id),
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