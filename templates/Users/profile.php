<div class="container mt-4">
    <h1 class="mb-4"><i class="fas fa-user-circle me-2"></i><?= __('My Profile') ?></h1>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-user-circle fa-5x text-primary"></i>
                    </div>
                    <h4><?= h($user->first_name . ' ' . $user->last_name) ?></h4>
                    <p class="text-muted mb-2">@<?= h($user->username) ?></p>
                    <p class="text-muted mb-3">
                        <i class="fas fa-envelope me-1"></i><?= h($user->email) ?>
                    </p>

                    <?php if ($user->role === 'admin'): ?>
                        <span class="badge bg-danger mb-3">
                            <i class="fas fa-crown me-1"></i><?= __('Administrator') ?>
                        </span>
                    <?php else: ?>
                        <span class="badge bg-primary mb-3">
                            <i class="fas fa-user me-1"></i><?= __('User') ?>
                        </span>
                    <?php endif; ?>

                    <hr>

                    <div class="text-start">
                        <p class="mb-2">
                            <i class="fas fa-calendar-plus me-2 text-muted"></i>
                            <small><?= __('Member since') ?>: <strong><?= $user->created->format('d.m.Y') ?></strong></small>
                        </p>
                        <?php if ($user->last_login): ?>
                            <p class="mb-0">
                                <i class="fas fa-clock me-2 text-muted"></i>
                                <small><?= __('Last login') ?>: <strong><?= $user->last_login->format('d.m.Y H:i') ?></strong></small>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i><?= __('Edit Profile') ?></h5>
                </div>
                <div class="card-body">
                    <?= $this->Form->create($user) ?>

                    <h6 class="mb-3 text-primary">
                        <i class="fas fa-user me-2"></i><?= __('Personal Information') ?>
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
                            'required' => true
                        ]) ?>
                    </div>

                    <hr class="my-4">

                    <h6 class="mb-3 text-primary">
                        <i class="fas fa-lock me-2"></i><?= __('Change Password') ?>
                    </h6>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <?= __('Leave password field blank if you don\'t want to change it') ?>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->control('password', [
                            'label' => [
                                'text' => '<i class="fas fa-key me-2"></i>' . __('New Password'),
                                'escape' => false,
                                'class' => 'form-label fw-bold'
                            ],
                            'class' => 'form-control',
                            'type' => 'password',
                            'placeholder' => __('Enter new password'),
                            'value' => '',
                            'required' => false
                        ]) ?>
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-1"></i><?= __('Minimum 6 characters recommended') ?>
                        </small>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2 justify-content-end">
                        <?= $this->Form->button(
                            '<i class="fas fa-save me-2"></i>' . __('Save Changes'),
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