<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-user-plus me-2"></i><?= __('New Person') ?></h1>
        <?= $this->Html->link(
            '<i class="fas fa-arrow-left me-2"></i>' . __('Back'),
            ['action' => 'index'],
            ['class' => 'btn btn-secondary', 'escape' => false]
        ) ?>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i><?= __('Person Details') ?></h5>
                </div>
                <div class="card-body">
                    <?= $this->Form->create($person, ['class' => 'needs-validation']) ?>

                    <div class="mb-4">
                        <?= $this->Form->control('name', [
                            'label' => [
                                'text' => '<i class="fas fa-user me-2"></i>' . __('Name and Surname'),
                                'escape' => false,
                                'class' => 'form-label fw-bold'
                            ],
                            'class' => 'form-control form-control-lg',
                            'placeholder' => __('e.g. Janez Novak'),
                            'required' => true
                        ]) ?>
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i><?= __('Enter the full name of the person participating in cost sharing.') ?>
                        </small>
                    </div>

                    <div class="mb-4">
                        <?= $this->Form->control('email', [
                            'label' => [
                                'text' => '<i class="fas fa-envelope me-2"></i>' . __('Email Address'),
                                'escape' => false,
                                'class' => 'form-label fw-bold'
                            ],
                            'class' => 'form-control form-control-lg',
                            'placeholder' => __('janez.novak@example.com'),
                            'type' => 'email',
                            'required' => false
                        ]) ?>
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i><?= __('Optional - email address for notifications and contact.') ?>
                        </small>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2 justify-content-end">
                        <?= $this->Html->link(
                            '<i class="fas fa-times me-2"></i>' . __('Cancel'),
                            ['action' => 'index'],
                            ['class' => 'btn btn-secondary', 'escape' => false]
                        ) ?>
                        <?= $this->Form->button(
                            '<i class="fas fa-save me-2"></i>' . __('Save Person'),
                            [
                                'class' => 'btn btn-info',
                                'type' => 'submit',
                                'escape' => false,
                                'escapeTitle' => false
                            ]
                        ) ?>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>

            <!-- Info box -->
            <div class="alert alert-info mt-4" role="alert">
                <h5 class="alert-heading"><i class="fas fa-lightbulb me-2"></i><?= __('Useful Tips') ?></h5>
                <hr>
                <ul class="mb-0">
                    <li><?= __('When you add a person, they will be automatically available for cost sharing.') ?></li>
                    <li><?= __('You can edit or remove a person at any time in the people list.') ?></li>
                    <li><?= __('The email address is optional, but recommended for notifications.') ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #0dcaf0;
        box-shadow: 0 0 0 0.25rem rgba(13, 202, 240, 0.25);
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
    }
</style>