<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= __('Recurring Expenses') ?></h1>
        <?= $this->Html->link(__('+ New Recurring Expense'), ['action' => 'add'], ['class' => 'btn btn-warning']) ?>
    </div>

    <?php if (!empty($reminders)): ?>
        <div class="alert alert-warning mb-4">
            <h5 class="alert-heading">⏰ <?= __('Reminders') ?></h5>
            <p><?= __('The following expenses require your attention:') ?></p>
            <?php foreach ($recurringExpenses as $recurring): ?>
                <?php if (in_array($recurring->id, $reminders)): ?>
                    <div class="d-flex justify-content-between align-items-center bg-white p-2 rounded mb-2">
                        <div>
                            <strong><?= h($recurring->title) ?></strong>
                            <small class="text-muted">
                                (<?= number_format($recurring->amount + $recurring->commission, 2) ?> €)
                            </small>
                        </div>
                        <?= $this->Form->postLink(
                            __('Add for this month'),
                            ['action' => 'createExpense', $recurring->id],
                            ['class' => 'btn btn-sm btn-success']
                        ) ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($recurringExpenses as $recurring): ?>
            <div class="col-md-6 mb-4">
                <div class="card <?= in_array($recurring->id, $reminders) ? 'border-warning' : '' ?>">
                    <div class="card-header <?= in_array($recurring->id, $reminders) ? 'bg-warning' : 'bg-light' ?>">
                        <h5 class="mb-0">
                            <?= h($recurring->title) ?>
                            <?php if (in_array($recurring->id, $reminders)): ?>
                                <span class="badge bg-danger"><?= __('Need attention') ?></span>
                            <?php endif; ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <strong><?= __('Amount:') ?></strong> <?= number_format($recurring->amount, 2) ?> €
                            + <?= number_format($recurring->commission, 2) ?> € <?= __('commission') ?>
                        </p>
                        <p class="mb-2">
                            <strong><?= __('Repetition:') ?></strong> <?= __('Every') ?> <?= h($recurring->day_of_month) ?>. <?= __('day of the month') ?>
                        </p>
                        <p class="mb-2">
                            <strong><?= __('Paid by:') ?></strong> <?= h($recurring->paid_by->name) ?>
                        </p>
                        <p class="mb-2">
                            <strong><?= __('Split Between:') ?></strong>
                            <?php
                            $names = [];
                            foreach ($recurring->recurring_expense_splits as $split) {
                                $names[] = h($split->person->name);
                            }
                            echo implode(', ', $names);
                            ?>
                        </p>
                        <?php if ($recurring->last_added_date): ?>
                            <p class="mb-2 text-muted">
                                <small><?= __('Last added:') ?> <?= h($recurring->last_added_date->format('d.m.Y')) ?></small>
                            </p>
                        <?php endif; ?>

                        <div class="d-flex gap-2 mt-3">
                            <?= $this->Form->postLink(
                                __('Add now'),
                                ['action' => 'createExpense', $recurring->id],
                                ['class' => 'btn btn-success btn-sm']
                            ) ?>
                            <?= $this->Form->postLink(
                                __('Delete'),
                                ['action' => 'delete', $recurring->id],
                                [
                                    'confirm' => __('Are you sure?'),
                                    'class' => 'btn btn-danger btn-sm'
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>