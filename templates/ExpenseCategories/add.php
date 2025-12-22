<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-plus-circle me-2"></i><?= __('New Category') ?></h1>
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
                    <?= $this->Form->create($category) ?>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('name', [
                                'label' => [
                                    'text' => '<i class="fas fa-tag me-2"></i>' . __('Name'),
                                    'escape' => false,
                                    'class' => 'form-label fw-bold'
                                ],
                                'class' => 'form-control',
                                'placeholder' => __('e.g., Internet'),
                                'required' => true
                            ]) ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->control('description', [
                            'label' => [
                                'text' => '<i class="fas fa-align-left me-2"></i>' . __('Description'),
                                'escape' => false,
                                'class' => 'form-label fw-bold'
                            ],
                            'class' => 'form-control',
                            'type' => 'textarea',
                            'rows' => 3,
                            'placeholder' => __('Brief description of this category')
                        ]) ?>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <?= $this->Form->control('color', [
                                'label' => [
                                    'text' => '<i class="fas fa-palette me-2"></i>' . __('Color'),
                                    'escape' => false,
                                    'class' => 'form-label fw-bold'
                                ],
                                'class' => 'form-control form-control-color',
                                'type' => 'color',
                                'default' => '#6c757d'
                            ]) ?>
                            <small class="text-muted"><?= __('Pick a color to identify this category') ?></small>
                        </div>

                        <div class="col-md-4 mb-3">
                            <?= $this->Form->control('icon', [
                                'label' => [
                                    'text' => '<i class="fas fa-icons me-2"></i>' . __('Icon'),
                                    'escape' => false,
                                    'class' => 'form-label fw-bold'
                                ],
                                'class' => 'form-control',
                                'placeholder' => 'fa-wifi',
                                'type' => 'text'
                            ]) ?>
                            <small class="text-muted">
                                <?= __('Font Awesome icon') ?>
                                <a href="https://fontawesome.com/icons" target="_blank">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </small>
                        </div>

                        <div class="col-md-4 mb-3">
                            <?= $this->Form->control('sort_order', [
                                'label' => [
                                    'text' => '<i class="fas fa-sort-numeric-down me-2"></i>' . __('Sort Order'),
                                    'escape' => false,
                                    'class' => 'form-label fw-bold'
                                ],
                                'class' => 'form-control',
                                'type' => 'number',
                                'default' => 0
                            ]) ?>
                            <small class="text-muted"><?= __('Lower numbers appear first') ?></small>
                        </div>
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
                            '<i class="fas fa-save me-2"></i>' . __('Save Category'),
                            [
                                'class' => 'btn btn-primary',
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