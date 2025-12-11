<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-plus-circle me-2"></i><?= __('New Supplier') ?></h1>
        <?= $this->Html->link(
            '<i class="fas fa-arrow-left me-2"></i>' . __('Back'),
            ['action' => 'index'],
            ['class' => 'btn btn-secondary', 'escape' => false]
        ) ?>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body">
                    <?= $this->Form->create($supplier) ?>

                    <h5 class="mb-3"><i class="fas fa-building me-2"></i><?= __('Company Information') ?></h5>

                    <div class="mb-3">
                        <?= $this->Form->control('name', [
                            'label' => [
                                'text' => '<i class="fas fa-building me-2"></i>' . __('Company Name'),
                                'escape' => false,
                                'class' => 'form-label fw-bold'
                            ],
                            'class' => 'form-control',
                            'placeholder' => __('e.g., Telekom Slovenia'),
                            'required' => true
                        ]) ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('contact_person', [
                                'label' => [
                                    'text' => '<i class="fas fa-user me-2"></i>' . __('Contact Person'),
                                    'escape' => false,
                                    'class' => 'form-label fw-bold'
                                ],
                                'class' => 'form-control',
                                'placeholder' => __('Full name')
                            ]) ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('tax_number', [
                                'label' => [
                                    'text' => '<i class="fas fa-hashtag me-2"></i>' . __('Tax Number'),
                                    'escape' => false,
                                    'class' => 'form-label fw-bold'
                                ],
                                'class' => 'form-control',
                                'placeholder' => __('VAT/Tax ID')
                            ]) ?>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3"><i class="fas fa-address-book me-2"></i><?= __('Contact Details') ?></h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('email', [
                                'label' => [
                                    'text' => '<i class="fas fa-envelope me-2"></i>' . __('Email'),
                                    'escape' => false,
                                    'class' => 'form-label fw-bold'
                                ],
                                'class' => 'form-control',
                                'type' => 'email',
                                'placeholder' => 'info@company.com'
                            ]) ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('phone', [
                                'label' => [
                                    'text' => '<i class="fas fa-phone me-2"></i>' . __('Phone'),
                                    'escape' => false,
                                    'class' => 'form-label fw-bold'
                                ],
                                'class' => 'form-control',
                                'placeholder' => '+386 1 234 5678'
                            ]) ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->control('address', [
                            'label' => [
                                'text' => '<i class="fas fa-map-marker-alt me-2"></i>' . __('Address'),
                                'escape' => false,
                                'class' => 'form-label fw-bold'
                            ],
                            'class' => 'form-control',
                            'type' => 'textarea',
                            'rows' => 2,
                            'placeholder' => __('Street, City, Postal Code')
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
                            'placeholder' => __('Additional notes')
                        ]) ?>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <?= $this->Form->checkbox('is_active', [
                                'id' => 'is-active-checkbox',
                                'class' => 'form-check-input',
                                'role' => 'switch',
                                'checked' => true
                            ]) ?>
                            <label class="form-check-label" for="is-active-checkbox">
                                <i class="fas fa-check-circle me-1"></i><?= __('Active') ?>
                            </label>
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
                            '<i class="fas fa-save me-2"></i>' . __('Save Supplier'),
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
    </div>
</div>