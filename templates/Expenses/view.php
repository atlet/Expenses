<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>
            <i class="fas fa-file-invoice me-2"></i><?= h($expense->title) ?>
        </h1>
        <div>
            <?= $this->Html->link(
                '<i class="fas fa-edit me-2"></i>' . __('Edit'),
                ['action' => 'edit', $expense->id],
                ['class' => 'btn btn-warning', 'escape' => false]
            ) ?>
            <?= $this->Html->link(
                '<i class="fas fa-arrow-left me-2"></i>' . __('Back'),
                ['action' => 'index'],
                ['class' => 'btn btn-secondary', 'escape' => false]
            ) ?>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Expense Details -->
        <div class="col-lg-8 mb-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i><?= __('Expense Details') ?></h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong><i class="fas fa-calendar me-2"></i><?= __('Date') ?>:</strong><br>
                            <span class="fs-5"><?= h($expense->expense_date->format('d.m.Y')) ?></span>
                        </div>
                        <div class="col-md-6">
                            <strong><i class="fas fa-check-circle me-2"></i><?= __('Status') ?>:</strong><br>
                            <?php if ($expense->is_paid): ?>
                                <span class="badge bg-success fs-6">
                                    <i class="fas fa-check-circle me-1"></i><?= __('Paid') ?>
                                </span>
                                <?php if ($expense->paid_date): ?>
                                    <small class="d-block text-muted mt-1">
                                        <?= __('on') ?> <?= h($expense->paid_date->format('d.m.Y')) ?>
                                    </small>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="badge bg-danger fs-6">
                                    <i class="fas fa-times-circle me-1"></i><?= __('Unpaid') ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($expense->expense_category): ?>
                        <div class="mb-3">
                            <strong><i class="fas fa-tag me-2"></i><?= __('Category') ?>:</strong><br>
                            <span class="badge" style="background-color: <?= h($expense->expense_category->color) ?>; font-size: 1rem;">
                                <i class="fas <?= h($expense->expense_category->icon) ?> me-1"></i>
                                <?= h($expense->expense_category->name) ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <?php if ($expense->supplier): ?>
                        <div class="mb-3">
                            <strong><i class="fas fa-building me-2"></i><?= __('Supplier') ?>:</strong><br>
                            <?= h($expense->supplier->name) ?>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <strong><i class="fas fa-user me-2"></i><?= __('Paid By') ?>:</strong><br>
                        <span class="badge bg-primary fs-6">
                            <?= h($expense->paid_by->name) ?>
                        </span>
                    </div>

                    <div class="mb-3">
                        <strong><i class="fas fa-users me-2"></i><?= __('Split Between') ?>:</strong><br>
                        <?php foreach ($expense->expense_splits as $split): ?>
                            <span class="badge bg-secondary me-1">
                                <?= h($split->person->name) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($expense->notes): ?>
                        <div class="mb-3">
                            <strong><i class="fas fa-sticky-note me-2"></i><?= __('Notes') ?>:</strong><br>
                            <p class="mt-2"><?= nl2br(h($expense->notes)) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Attachments Section -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-paperclip me-2"></i><?= __('Attachments') ?></h5>
                </div>
                <div class="card-body">
                    <!-- Upload Form -->
                    <div class="mb-4">
                        <?= $this->Form->create(null, [
                            'url' => ['controller' => 'ExpenseAttachments', 'action' => 'upload', $expense->id],
                            'type' => 'file',
                            'class' => 'upload-form'                            
                        ]) ?>

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-upload me-2"></i><?= __('Upload Files') ?>
                            </label>
                            <?= $this->Form->file('files[]', [
                                'class' => 'form-control',
                                'multiple' => true,
                                'accept' => '.pdf,.jpg,.jpeg,.png,.gif,.webp,.xlsx,.xls,.doc,.docx',
                                'id' => 'file-input'
                            ]) ?>
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                <?= __('Allowed types') ?>: PDF, Images, Excel, Word. <?= __('Max size') ?>: 10MB
                            </small>
                        </div>

                        <?= $this->Form->button(
                            '<i class="fas fa-cloud-upload-alt me-2"></i>' . __('Upload'),
                            ['class' => 'btn btn-success', 'escape' => false, 'escapeTitle' => false]
                        ) ?>

                        <?= $this->Form->end() ?>
                    </div>

                    <hr>

                    <!-- List of Attachments -->
                    <?php if (empty($expense->expense_attachments)): ?>
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-file fa-3x mb-3 d-block"></i>
                            <p><?= __('No attachments yet') ?></p>
                        </div>
                    <?php else: ?>
                        <div class="list-group">
                            <?php foreach ($expense->expense_attachments as $attachment): ?>
                                <div class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas <?= $attachment->getIcon() ?> fa-2x <?= $attachment->getColorClass() ?>"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1"><?= h($attachment->filename) ?></h6>
                                            <small class="text-muted">
                                                <i class="fas fa-hdd me-1"></i><?= $attachment->getFormattedSize() ?>
                                                <span class="mx-2">•</span>
                                                <i class="fas fa-user me-1"></i><?= h($attachment->uploader->username) ?>
                                                <span class="mx-2">•</span>
                                                <i class="fas fa-clock me-1"></i><?= $attachment->created->format('d.m.Y H:i') ?>
                                            </small>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <?php if (str_starts_with($attachment->mime_type, 'image/') || $attachment->mime_type === 'application/pdf'): ?>
                                                <?= $this->Html->link(
                                                    '<i class="fas fa-eye"></i>',
                                                    ['controller' => 'ExpenseAttachments', 'action' => 'view', $attachment->id],
                                                    [
                                                        'class' => 'btn btn-sm btn-info',
                                                        'escape' => false,
                                                        'title' => __('View'),
                                                        'target' => '_blank'
                                                    ]
                                                ) ?>
                                            <?php endif; ?>
                                            <?= $this->Html->link(
                                                '<i class="fas fa-download"></i>',
                                                ['controller' => 'ExpenseAttachments', 'action' => 'download', $attachment->id],
                                                [
                                                    'class' => 'btn btn-sm btn-primary',
                                                    'escape' => false,
                                                    'title' => __('Download')
                                                ]
                                            ) ?>
                                            <?= $this->Form->postLink(
                                                '<i class="fas fa-trash"></i>',
                                                ['controller' => 'ExpenseAttachments', 'action' => 'delete', $attachment->id],
                                                [
                                                    'confirm' => __('Are you sure you want to delete this file?'),
                                                    'class' => 'btn btn-sm btn-danger',
                                                    'escape' => false,
                                                    'title' => __('Delete')
                                                ]
                                            ) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right Column - Financial Summary -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-calculator me-2"></i><?= __('Financial Summary') ?></h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td><strong><?= __('Amount') ?>:</strong></td>
                            <td class="text-end"><?= number_format($expense->amount, 2) ?> €</td>
                        </tr>
                        <tr>
                            <td><strong><?= __('Commission') ?>:</strong></td>
                            <td class="text-end"><?= number_format($expense->commission, 2) ?> €</td>
                        </tr>
                        <tr class="border-top">
                            <td><strong><?= __('Total') ?>:</strong></td>
                            <td class="text-end">
                                <h4 class="mb-0 text-primary">
                                    <?= number_format($expense->amount + $expense->commission, 2) ?> €
                                </h4>
                            </td>
                        </tr>
                        <tr class="border-top">
                            <td><strong><?= __('Share per Person') ?>:</strong></td>
                            <td class="text-end">
                                <span class="badge bg-info fs-6">
                                    <?= number_format(($expense->amount + $expense->commission) / count($expense->expense_splits), 2) ?> €
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i><?= __('Timeline') ?></h5>
                </div>
                <div class="card-body">
                    <ul class="timeline">
                        <li>
                            <i class="fas fa-plus-circle text-success"></i>
                            <strong><?= __('Created') ?>:</strong><br>
                            <small><?= $expense->created->format('d.m.Y H:i') ?></small>
                        </li>
                        <?php if ($expense->modified != $expense->created): ?>
                            <li>
                                <i class="fas fa-edit text-warning"></i>
                                <strong><?= __('Modified') ?>:</strong><br>
                                <small><?= $expense->modified->format('d.m.Y H:i') ?></small>
                            </li>
                        <?php endif; ?>
                        <?php if ($expense->is_paid && $expense->paid_date): ?>
                            <li>
                                <i class="fas fa-check-circle text-success"></i>
                                <strong><?= __('Paid') ?>:</strong><br>
                                <small><?= $expense->paid_date->format('d.m.Y') ?></small>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .timeline {
        list-style: none;
        padding-left: 0;
    }

    .timeline li {
        padding: 10px 0 10px 30px;
        position: relative;
        border-left: 2px solid #dee2e6;
    }

    .timeline li:last-child {
        border-left: 0;
    }

    .timeline li i {
        position: absolute;
        left: -10px;
        background: white;
        padding: 2px;
    }

    .list-group-item {
        transition: all 0.3s ease;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }
</style>