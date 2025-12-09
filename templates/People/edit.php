<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-user-edit me-2"></i>Uredi osebo</h1>
        <?= $this->Html->link(
            '<i class="fas fa-arrow-left me-2"></i>Nazaj',
            ['action' => 'index'],
            ['class' => 'btn btn-secondary', 'escape' => false]
        ) ?>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i>Podatki o osebi</h5>
                </div>
                <div class="card-body">
                    <?= $this->Form->create($person, ['class' => 'needs-validation']) ?>

                    <div class="mb-4">
                        <?= $this->Form->control('name', [
                            'label' => [
                                'text' => '<i class="fas fa-user me-2"></i>Ime in priimek',
                                'escape' => false,
                                'class' => 'form-label fw-bold'
                            ],
                            'class' => 'form-control form-control-lg',
                            'placeholder' => 'Npr. Janez Novak',
                            'required' => true
                        ]) ?>
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>Vnesite polno ime osebe, ki sodeluje pri delitvi stroškov.
                        </small>
                    </div>

                    <div class="mb-4">
                        <?= $this->Form->control('email', [
                            'label' => [
                                'text' => '<i class="fas fa-envelope me-2"></i>E-poštni naslov',
                                'escape' => false,
                                'class' => 'form-label fw-bold'
                            ],
                            'class' => 'form-control form-control-lg',
                            'placeholder' => 'janez.novak@example.com',
                            'type' => 'email',
                            'required' => false
                        ]) ?>
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>Opcijsko - e-poštni naslov za obvestila in kontakt.
                        </small>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2 justify-content-end">
                        <?= $this->Html->link(
                            '<i class="fas fa-times me-2"></i>Prekliči',
                            ['action' => 'index'],
                            ['class' => 'btn btn-secondary', 'escape' => false]
                        ) ?>
                        <?= $this->Form->button(
                            '<i class="fas fa-save me-2"></i>Posodobi osebo',
                            [
                                'class' => 'btn btn-warning',
                                'type' => 'submit',
                                'escape' => false,
                                'escapeTitle' => false
                            ]
                        ) ?>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>

            <!-- Danger zone -->
            <div class="card border-danger mt-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Nevarno območje</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        <strong>Opozorilo:</strong> Brisanje osebe bo izbrisalo tudi vse povezane stroške, delitve in plačila.
                    </p>
                    <?= $this->Form->postLink(
                        '<i class="fas fa-trash me-2"></i>Izbriši to osebo',
                        ['action' => 'delete', $person->id],
                        [
                            'confirm' => 'Ali ste PREPRIČANI, da želite izbrisati ' . $person->name . '? Vsi povezani podatki bodo izgubljeni!',
                            'class' => 'btn btn-danger',
                            'escape' => false,
                            'escapeTitle' => false
                        ]
                    ) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
    }
</style>