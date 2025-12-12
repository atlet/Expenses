<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-file-invoice-dollar me-2"></i><?= __('Expenses') ?></h1>
        <?= $this->Html->link(
            '<i class="fas fa-plus me-2"></i>' . __('New Expense'),
            ['action' => 'add'],
            ['class' => 'btn btn-success', 'escape' => false]
        ) ?>
    </div>

    <?php if (empty($expenses->toArray())): ?>
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-inbox fa-3x mb-3 d-block text-muted"></i>
            <h4><?= __('No expenses yet') ?></h4>
            <p class="mb-4"><?= __('Start by adding your first expense') ?></p>
            <?= $this->Html->link(
                '<i class="fas fa-plus-circle me-2"></i>' . __('Add First Expense'),
                ['action' => 'add'],
                ['class' => 'btn btn-success btn-lg', 'escape' => false]
            ) ?>
        </div>
    <?php else: ?>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-calendar me-2"></i><?= __('Date') ?></th>
                                <th><i class="fas fa-tag me-2"></i><?= __('Category') ?></th>
                                <th><i class="fas fa-file-alt me-2"></i><?= __('Title') ?></th>
                                <th><i class="fas fa-building me-2"></i><?= __('Supplier') ?></th>
                                <th class="text-end"><i class="fas fa-euro-sign me-2"></i><?= __('Amount') ?></th>
                                <th class="text-end"><i class="fas fa-percent me-2"></i><?= __('Commission') ?></th>
                                <th class="text-end"><i class="fas fa-calculator me-2"></i><?= __('Total') ?></th>
                                <th><i class="fas fa-user me-2"></i><?= __('Paid By') ?></th>
                                <th><i class="fas fa-users me-2"></i><?= __('Split Between') ?></th>
                                <th class="text-center"><i class="fas fa-check-circle me-2"></i><?= __('Status') ?></th>
                                <th class="text-center"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($expenses as $expense): ?>
                                <tr>
                                    <td>
                                        <span class="text-nowrap">
                                            <?= h($expense->expense_date->format('d.m.Y')) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($expense->expense_category): ?>
                                            <span class="badge" style="background-color: <?= h($expense->expense_category->color) ?>">
                                                <i class="fas <?= h($expense->expense_category->icon) ?> me-1"></i>
                                                <?php
                                                $locale = \Cake\I18n\I18n::getLocale();
                                                echo $locale === 'en_US' ? h($expense->expense_category->name_en) : h($expense->expense_category->name);
                                                ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-question me-1"></i><?= __('Uncategorized') ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?= h($expense->title) ?></strong>
                                        <?php if ($expense->notes): ?>
                                            <br><small class="text-muted"><?= h($expense->notes) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= $expense->supplier ? h($expense->supplier->name) : '<span class="text-muted">-</span>' ?>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge bg-info"><?= number_format($expense->amount, 2) ?> €</span>
                                    </td>
                                    <td class="text-end">
                                        <?php if ($expense->commission > 0): ?>
                                            <span class="badge bg-warning text-dark"><?= number_format($expense->commission, 2) ?> €</span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <strong class="text-primary"><?= number_format($expense->amount + $expense->commission, 2) ?> €</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">
                                            <i class="fas fa-user me-1"></i><?= h($expense->paid_by->name) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <small>
                                            <?php
                                            $names = [];
                                            foreach ($expense->expense_splits as $split) {
                                                $names[] = h($split->person->name);
                                            }
                                            echo implode(', ', $names);
                                            ?>
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($expense->is_paid): ?>
                                            <span class="badge bg-success" title="<?= __('Paid on') ?>: <?= h($expense->paid_date ? $expense->paid_date->format('d.m.Y') : '-') ?>">
                                                <i class="fas fa-check-circle me-1"></i><?= __('Paid') ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times-circle me-1"></i><?= __('Unpaid') ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <?= $this->Html->link(
                                                '<i class="fas fa-eye"></i>',
                                                ['action' => 'view', $expense->id],
                                                [
                                                    'class' => 'btn btn-sm btn-info',
                                                    'escape' => false,
                                                    'title' => __('View')
                                                ]
                                            ) ?>
                                            <?= $this->Html->link(
                                                '<i class="fas fa-edit"></i>',
                                                ['action' => 'edit', $expense->id],
                                                [
                                                    'class' => 'btn btn-sm btn-warning',
                                                    'escape' => false,
                                                    'title' => __('Edit')
                                                ]
                                            ) ?>
                                            <?= $this->Form->postLink(
                                                '<i class="fas fa-trash"></i>',
                                                ['action' => 'delete', $expense->id],
                                                [
                                                    'confirm' => __('Are you sure you want to delete this expense?'),
                                                    'class' => 'btn btn-sm btn-danger',
                                                    'escape' => false,
                                                    'title' => __('Delete')
                                                ]
                                            ) ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="6" class="text-end"><strong><?= __('Total') ?>:</strong></td>
                                <td class="text-end">
                                    <strong class="text-primary fs-5">
                                        <?php
                                        $total = 0;
                                        foreach ($expenses as $expense) {
                                            $total += $expense->amount + $expense->commission;
                                        }
                                        echo number_format($total, 2);
                                        ?> €
                                    </strong>
                                </td>
                                <td colspan="4"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .table td {
        vertical-align: middle;
    }

    .badge {
        font-weight: 500;
        padding: 0.4em 0.6em;
    }

    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
</style>