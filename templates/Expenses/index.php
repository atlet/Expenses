<?php
$this->Paginator->setTemplates([
    'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
    'current' => '<li class="page-item active" aria-current="page"><span class="page-link">{{text}}</span></li>',
    'prevActive' => '<li class="page-item"><a class="page-link" rel="prev" href="{{url}}" aria-label="Prejšnja stran">{{text}}</a></li>',
    'nextActive' => '<li class="page-item"><a class="page-link" rel="next" href="{{url}}" aria-label="Naslednja stran">{{text}}</a></li>',
    'prevDisabled' => '<li class="page-item disabled"><span class="page-link" aria-disabled="true" aria-label="Prejšnja stran">{{text}}</span></li>',
    'nextDisabled' => '<li class="page-item disabled"><span class="page-link" aria-disabled="true" aria-label="Naslednja stran">{{text}}</span></li>',
    'ellipsis' => '<li class="page-item disabled"><span class="page-link">&hellip;</span></li>',
]);
?>
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-file-invoice-dollar me-2"></i><?= __('Expenses') ?></h1>
        <?= $this->Html->link(
            '<i class="fas fa-plus me-2"></i>' . __('New Expense'),
            ['action' => 'add'],
            ['class' => 'btn btn-success', 'escape' => false]
        ) ?>
    </div>

    <div class="card card-body mb-4">
        <?= $this->Form->create(null, ['type' => 'get', 'url' => ['action' => 'index']]) ?>
        <div class="row g-3 align-items-end">
            <?php foreach (['date_from' => 'Datum od', 'date_to' => 'Datum do'] as $key => $label): ?>
                <div class="col-md-2"><?= $this->Form->control($key, ['type' => 'date', 'label' => $label, 'value' => $filters[$key] ?? '', 'class' => 'form-control']) ?></div>
            <?php endforeach; ?>
            <?php foreach (['expense_category_id' => ['Kategorija', $categories], 'supplier_id' => ['Dobavitelj', $suppliers], 'paid_by_id' => ['Plačal', $people], 'status' => ['Status', ['paid' => __('Paid'), 'unpaid' => __('Unpaid')]]] as $key => [$label, $options]): ?>
                <div class="col-md-2"><?= $this->Form->control($key, ['type' => 'select', 'label' => $label, 'options' => $options, 'empty' => 'Vsi', 'value' => $filters[$key] ?? '', 'class' => 'form-select']) ?></div>
            <?php endforeach; ?>
            <div class="col-12 d-flex gap-2">
                <?= $this->Form->button('Filtriraj', ['class' => 'btn btn-primary']) ?>
                <?= $this->Html->link('Počisti filtre', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>

    <?php if (empty($expenses->toArray())): ?>
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-inbox fa-3x mb-3 d-block text-muted"></i>
            <h4><?= __('Ni stroškov za izbrane filtre') ?></h4>
            <p class="mb-4"><?= __('Spremenite ali počistite filtre.') ?></p>
            <?= $this->Html->link(
                '<i class="fas fa-plus-circle me-2"></i>' . __('Add First Expense'),
                ['action' => 'add'],
                ['class' => 'btn btn-success btn-lg', 'escape' => false]
            ) ?>
        </div>
    <?php else: ?>
        <div class="card">
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
                                            <?= h($expense->expense_category->name) ?>
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
                            <td colspan="6" class="text-end"><strong>Skupaj po filtrih:</strong></td>
                            <td class="text-end">
                                <strong class="text-primary fs-5">
                                    <?= number_format((float)$filteredTotal, 2) ?> €
                                </strong>
                            </td>
                            <td colspan="4"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <nav class="mt-3 d-flex flex-wrap justify-content-between align-items-center gap-3" aria-label="Strani stroškov">
            <ul class="pagination mb-0">
                <?= $this->Paginator->prev('‹') ?>
                <?= $this->Paginator->numbers(['modulus' => 5, 'first' => 1, 'last' => 1]) ?>
                <?= $this->Paginator->next('›') ?>
            </ul>
            <p class="text-muted mb-0"><?= $this->Paginator->counter('Stran {{page}} od {{pages}} · {{count}} stroškov') ?></p>
        </nav>
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