<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-building me-2"></i><?= __('Suppliers') ?></h1>
        <?= $this->Html->link(
            '<i class="fas fa-plus me-2"></i>' . __('New Supplier'),
            ['action' => 'add'],
            ['class' => 'btn btn-success', 'escape' => false]
        ) ?>
    </div>

    <?php if (empty($suppliers->toArray())): ?>
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-building fa-3x mb-3 d-block text-muted"></i>
            <h4><?= __('No suppliers yet') ?></h4>
            <p class="mb-4"><?= __('Add suppliers to track who you pay expenses to') ?></p>
            <?= $this->Html->link(
                '<i class="fas fa-plus-circle me-2"></i>' . __('Add First Supplier'),
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
                                <th><i class="fas fa-building me-2"></i><?= __('Name') ?></th>
                                <th><i class="fas fa-user me-2"></i><?= __('Contact Person') ?></th>
                                <th><i class="fas fa-envelope me-2"></i><?= __('Email') ?></th>
                                <th><i class="fas fa-phone me-2"></i><?= __('Phone') ?></th>
                                <th><i class="fas fa-hashtag me-2"></i><?= __('Tax Number') ?></th>
                                <th class="text-center"><?= __('Status') ?></th>
                                <th class="text-center"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($suppliers as $supplier): ?>
                                <tr>
                                    <td>
                                        <strong><?= h($supplier->name) ?></strong>
                                        <?php if ($supplier->notes): ?>
                                            <br><small class="text-muted"><?= h($supplier->notes) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= h($supplier->contact_person) ?: '<span class="text-muted">-</span>' ?></td>
                                    <td>
                                        <?php if ($supplier->email): ?>
                                            <a href="mailto:<?= h($supplier->email) ?>">
                                                <?= h($supplier->email) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($supplier->phone): ?>
                                            <a href="tel:<?= h($supplier->phone) ?>">
                                                <?= h($supplier->phone) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= h($supplier->tax_number) ?: '<span class="text-muted">-</span>' ?></td>
                                    <td class="text-center">
                                        <?php if ($supplier->is_active): ?>
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i><?= __('Active') ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-times-circle me-1"></i><?= __('Inactive') ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <?= $this->Html->link(
                                                '<i class="fas fa-edit"></i>',
                                                ['action' => 'edit', $supplier->id],
                                                [
                                                    'class' => 'btn btn-sm btn-warning',
                                                    'escape' => false,
                                                    'title' => __('Edit')
                                                ]
                                            ) ?>
                                            <?= $this->Form->postLink(
                                                '<i class="fas fa-trash"></i>',
                                                ['action' => 'delete', $supplier->id],
                                                [
                                                    'confirm' => __('Are you sure you want to delete this supplier?'),
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
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>