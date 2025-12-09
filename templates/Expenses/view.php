<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Expense $expense
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Expense'), ['action' => 'edit', $expense->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Expense'), ['action' => 'delete', $expense->id], ['confirm' => __('Are you sure you want to delete # {0}?', $expense->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Expenses'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Expense'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="expenses view content">
            <h3><?= h($expense->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($expense->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Paid By') ?></th>
                    <td><?= $expense->hasValue('paid_by') ? $this->Html->link($expense->paid_by->name, ['controller' => 'People', 'action' => 'view', $expense->paid_by->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($expense->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($expense->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Commission') ?></th>
                    <td><?= $this->Number->format($expense->commission) ?></td>
                </tr>
                <tr>
                    <th><?= __('Expense Date') ?></th>
                    <td><?= h($expense->expense_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($expense->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($expense->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($expense->notes)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Expense Splits') ?></h4>
                <?php if (!empty($expense->expense_splits)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Expense Id') ?></th>
                            <th><?= __('Person Id') ?></th>
                            <th><?= __('Share Ratio') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($expense->expense_splits as $expenseSplit) : ?>
                        <tr>
                            <td><?= h($expenseSplit->id) ?></td>
                            <td><?= h($expenseSplit->expense_id) ?></td>
                            <td><?= h($expenseSplit->person_id) ?></td>
                            <td><?= h($expenseSplit->share_ratio) ?></td>
                            <td><?= h($expenseSplit->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ExpenseSplits', 'action' => 'view', $expenseSplit->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ExpenseSplits', 'action' => 'edit', $expenseSplit->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'ExpenseSplits', 'action' => 'delete', $expenseSplit->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $expenseSplit->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>