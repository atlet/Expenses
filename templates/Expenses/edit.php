<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-plus-circle me-2"></i><?= __('Edit Expense') ?></h1>
        <?= $this->Html->link(
            '<i class="fas fa-arrow-left me-2"></i>' . __('Back'),
            ['action' => 'index'],
            ['class' => 'btn btn-secondary', 'escape' => false]
        ) ?>
    </div>

    <div class="card">
        <div class="card-body">
            <?= $this->Form->create($expense) ?>

            <div class="row">
                <!-- Leva stran -->
                <div class="col-md-6">
                    <h5 class="mb-3"><i class="fas fa-info-circle me-2"></i><?= __('Basic Information') ?></h5>

                    <div class="mb-3">
                        <?= $this->Form->control('title', [
                            'label' => [
                                'text' => '<i class="fas fa-file-alt me-2"></i>' . __('Expense Title'),
                                'escape' => false,
                                'class' => 'form-label fw-bold'
                            ],
                            'class' => 'form-control',
                            'placeholder' => __('e.g., Internet December 2024'),
                            'required' => true
                        ]) ?>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->control('expense_category_id', [
                            'label' => [
                                'text' => '<i class="fas fa-tag me-2"></i>' . __('Category'),
                                'escape' => false,
                                'class' => 'form-label fw-bold'
                            ],
                            'class' => 'form-select',
                            'options' => $categories,
                            'empty' => __('Select category'),
                            'required' => false
                        ]) ?>
                        <small class="text-muted">
                            <?= $this->Html->link(
                                '<i class="fas fa-plus-circle me-1"></i>' . __('Add new category'),
                                ['controller' => 'ExpenseCategories', 'action' => 'add'],
                                ['escape' => false, 'target' => '_blank']
                            ) ?>
                        </small>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->control('supplier_id', [
                            'label' => [
                                'text' => '<i class="fas fa-building me-2"></i>' . __('Supplier'),
                                'escape' => false,
                                'class' => 'form-label fw-bold'
                            ],
                            'class' => 'form-select',
                            'options' => $suppliers,
                            'empty' => __('Select supplier (optional)'),
                            'required' => false
                        ]) ?>
                        <small class="text-muted">
                            <?= $this->Html->link(
                                '<i class="fas fa-plus-circle me-1"></i>' . __('Add new supplier'),
                                ['controller' => 'Suppliers', 'action' => 'add'],
                                ['escape' => false, 'target' => '_blank']
                            ) ?>
                        </small>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->control('expense_date', [
                            'label' => [
                                'text' => '<i class="fas fa-calendar me-2"></i>' . __('Expense Date'),
                                'escape' => false,
                                'class' => 'form-label fw-bold'
                            ],
                            'class' => 'form-control',
                            'type' => 'date',
                            'default' => date('Y-m-d'),
                            'required' => true
                        ]) ?>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->control('notes', [
                            'label' => [
                                'text' => '<i class="fas fa-sticky-note me-2"></i>' . __('Notes'),
                                'escape' => false,
                                'class' => 'form-label fw-bold'
                            ],
                            'class' => 'form-control',
                            'type' => 'textarea',
                            'rows' => 3,
                            'placeholder' => __('Additional notes (optional)')
                        ]) ?>
                    </div>
                </div>

                <!-- Desna stran -->
                <div class="col-md-6">
                    <h5 class="mb-3"><i class="fas fa-euro-sign me-2"></i><?= __('Financial Details') ?></h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('amount', [
                                'label' => [
                                    'text' => '<i class="fas fa-money-bill me-2"></i>' . __('Amount') . ' (€)',
                                    'escape' => false,
                                    'class' => 'form-label fw-bold'
                                ],
                                'class' => 'form-control',
                                'type' => 'number',
                                'step' => '0.01',
                                'placeholder' => '0.00',
                                'required' => true
                            ]) ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('commission', [
                                'label' => [
                                    'text' => '<i class="fas fa-percent me-2"></i>' . __('Commission') . ' (€)',
                                    'escape' => false,
                                    'class' => 'form-label fw-bold'
                                ],
                                'class' => 'form-control',
                                'type' => 'number',
                                'step' => '0.01',
                                'default' => 0,
                                'placeholder' => '0.00'
                            ]) ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->control('paid_by_id', [
                            'label' => [
                                'text' => '<i class="fas fa-user me-2"></i>' . __('Paid By'),
                                'escape' => false,
                                'class' => 'form-label fw-bold'
                            ],
                            'class' => 'form-select',
                            'options' => $people,
                            'empty' => __('Select person'),
                            'required' => true
                        ]) ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-users me-2"></i><?= __('Split Between') ?>:
                        </label>
                        <div class="row">
                            <?php foreach ($people as $id => $name): ?>
                                <div class="col-md-6 mb-2">
                                    <div class="form-check">
                                        <?= $this->Form->checkbox("split_people.{$id}", [
                                            'value' => $id,
                                            'id' => "split-{$id}",
                                            'class' => 'form-check-input',
                                            'checked' => in_array($id, $selectedPeople)
                                        ]) ?>
                                        <label class="form-check-label" for="split-<?= $id ?>">
                                            <?= h($name) ?>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3"><i class="fas fa-check-circle me-2"></i><?= __('Payment Status') ?></h5>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <?= $this->Form->checkbox('is_paid', [
                                'id' => 'is-paid-checkbox',
                                'class' => 'form-check-input',
                                'role' => 'switch'
                            ]) ?>
                            <label class="form-check-label" for="is-paid-checkbox">
                                <i class="fas fa-check-circle me-1"></i><?= __('Mark as paid') ?>
                            </label>
                        </div>
                    </div>

                    <div id="paid-date-field" style="display: none;">
                        <?= $this->Form->control('paid_date', [
                            'label' => [
                                'text' => '<i class="fas fa-calendar-check me-2"></i>' . __('Payment Date'),
                                'escape' => false,
                                'class' => 'form-label fw-bold'
                            ],
                            'class' => 'form-control',
                            'type' => 'date',
                            'default' => date('Y-m-d')
                        ]) ?>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2 justify-content-end">
                <?= $this->Html->link(
                    '<i class="fas fa-times me-2"></i>' . __('Cancel'),
                    ['action' => 'index'],
                    ['class' => 'btn btn-secondary', 'escape' => false]
                ) ?>
                <?= $this->Form->button(
                    '<i class="fas fa-save me-2"></i>' . __('Update Expense'),
                    [
                        'class' => 'btn btn-success',
                        'type' => 'submit',
                        'escape' => false,
                        'escapeTitle' => false
                    ]
                ) ?>
            </div>

            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isPaidCheckbox = document.getElementById('is-paid-checkbox');
        const paidDateField = document.getElementById('paid-date-field');

        if (isPaidCheckbox && paidDateField) {
            isPaidCheckbox.addEventListener('change', function() {
                paidDateField.style.display = this.checked ? 'block' : 'none';
            });

            // Trigger on load
            if (isPaidCheckbox.checked) {
                paidDateField.style.display = 'block';
            }
        }
    });
</script>

<style>
    .form-label {
        margin-bottom: 0.5rem;
    }

    .form-check-input:checked {
        background-color: #198754;
        border-color: #198754;
    }

    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
</style>