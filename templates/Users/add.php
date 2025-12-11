<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-user-plus me-2"></i><?= __('Add User') ?></h1>
        <?= $this->Html->link(
            '<i class="fas fa-arrow-left me-2"></i>' . __('Back'),
            ['action' => 'index'],
            ['class' => 'btn btn-secondary', 'escape' => false]
        ) ?>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i><?= __('User Information') ?></h5>
                </div>
                <div class="card-body">
                    <?= $this->Form->create($user) ?>

                    <h6 class="mb-3 text-primary">
                        <i class="fas fa-lock me-2"></i><?= __('Login Credentials') ?>
                    </h6>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('username', [
                                'label' => [
                                    'text' => '<i class="fas fa-user me-2"></i>' . __('Username'),
                                    'escape' => false,
                                    'class' => 'form-label fw-bold'
                                ],
                                'class' => 'form-control',
                                'placeholder' => __('e.g., jnovak'),
                                'required' => true
                            ]) ?>
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i><?= __('Used for login') ?>
                            </small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('password', [
                                'label' => [
                                    'text' => '<i class="fas fa-key me-2"></i>' . __('Password'),
                                    'escape' => false,
                                    'class' => 'form-label fw-bold'
                                ],
                                'class' => 'form-control',
                                'type' => 'password',
                                'placeholder' => __('Minimum 6 characters'),
                                'required' => true
                            ]) ?>
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i><?= __('Choose a strong password') ?>
                            </small>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="mb-3 text-primary">
                        <i class="fas fa-address-card me-2"></i><?= __('Personal Information') ?>
                    </h6>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('first_name', [
                                'label' => [
                                    'text' => '<i class="fas fa-user me-2"></i>' . __('First Name'),
                                    'escape' => false,
                                    'class' => 'form-label fw-bold'
                                ],
                                'class' => 'form-control',
                                'placeholder' => __('First name'),
                                'required' => true
                            ]) ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('last_name', [
                                'label' => [
                                    'text' => '<i class="fas fa-user me-2"></i>' . __('Last Name'),
                                    'escape' => false,
                                    'class' => 'form-label fw-bold'
                                ],
                                'class' => 'form-control',
                                'placeholder' => __('Last name'),
                                'required' => true
                            ]) ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->control('email', [
                            'label' => [
                                'text' => '<i class="fas fa-envelope me-2"></i>' . __('Email Address'),
                                'escape' => false,
                                'class' => 'form-label fw-bold'
                            ],
                            'class' => 'form-control',
                            'type' => 'email',
                            'placeholder' => 'user@example.com',
                            'required' => true
                        ]) ?>
                    </div>

                    <hr class="my-4">

                    <h6 class="mb-3 text-primary">
                        <i class="fas fa-cog me-2"></i><?= __('Settings') ?>
                    </h6>

                    <div class="mb-3">
                        <?= $this->Form->control('role', [
                            'label' => [
                                'text' => '<i class="fas fa-user-tag me-2"></i>' . __('Role'),
                                'escape' => false,
                                'class' => 'form-label fw-bold'
                            ],
                            'class' => 'form-select',
                            'options' => [
                                'user' => __('User'),
                                'admin' => __('Administrator')
                            ],
                            'required' => true
                        ]) ?>
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            <strong><?= __('User') ?>:</strong> <?= __('Can view and manage expenses') ?><br>
                            <i class="fas fa-info-circle me-1"></i>
                            <strong><?= __('Administrator') ?>:</strong> <?= __('Full access including user management') ?>
                        </small>
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
                            <br>
                            <small class="text-muted">
                                <?= __('Inactive users cannot log in') ?>
                            </small>
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
                            '<i class="fas fa-save me-2"></i>' . __('Create User'),
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