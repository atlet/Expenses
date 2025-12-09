<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-users me-2"></i>Sodelavci</h1>
        <?= $this->Html->link(
            '<i class="fas fa-user-plus me-2"></i>Nova oseba',
            ['action' => 'add'],
            ['class' => 'btn btn-info', 'escape' => false]
        ) ?>
    </div>

    <?php if (empty($people)): ?>
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-users fa-3x mb-3 d-block"></i>
            <h4>Še ni dodanih oseb</h4>
            <p class="mb-4">Začnite z dodajanjem oseb, ki bodo sodelovale pri delitvi stroškov.</p>
            <?= $this->Html->link(
                '<i class="fas fa-plus-circle me-2"></i>Dodaj prvo osebo',
                ['action' => 'add'],
                ['class' => 'btn btn-info btn-lg', 'escape' => false]
            ) ?>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($people as $person): ?>
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="card h-100 person-card">
                        <div class="card-body text-center">
                            <div class="person-avatar mb-3">
                                <i class="fas fa-user-circle fa-4x text-info"></i>
                            </div>
                            <h5 class="card-title mb-2"><?= h($person->name) ?></h5>
                            <?php if ($person->email): ?>
                                <p class="card-text text-muted small mb-3">
                                    <i class="fas fa-envelope me-1"></i><?= h($person->email) ?>
                                </p>
                            <?php else: ?>
                                <p class="card-text text-muted small mb-3">
                                    <i class="fas fa-envelope-open me-1"></i>Brez e-pošte
                                </p>
                            <?php endif; ?>

                            <!-- Statistics -->
                            <div class="person-stats bg-light rounded p-2 mb-3">
                                <div class="row text-center">
                                    <div class="col-6 border-end">
                                        <small class="text-muted d-block">Stroški</small>
                                        <strong><?= count($person->expenses) ?></strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Plačila</small>
                                        <strong><?= count($person->payments_from) ?></strong>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2 justify-content-center">
                                <?= $this->Html->link(
                                    '<i class="fas fa-edit"></i>',
                                    ['action' => 'edit', $person->id],
                                    [
                                        'class' => 'btn btn-sm btn-warning',
                                        'escape' => false,
                                        'title' => 'Uredi'
                                    ]
                                ) ?>
                                <?= $this->Html->link(
                                    '<i class="fas fa-eye"></i>',
                                    ['action' => 'view', $person->id],
                                    [
                                        'class' => 'btn btn-sm btn-info',
                                        'escape' => false,
                                        'title' => 'Poglej'
                                    ]
                                ) ?>
                                <?= $this->Form->postLink(
                                    '<i class="fas fa-trash"></i>',
                                    ['action' => 'delete', $person->id],
                                    [
                                        'confirm' => 'Ali ste prepričani, da želite izbrisati ' . $person->name . '?',
                                        'class' => 'btn btn-sm btn-danger',
                                        'escape' => false,
                                        'title' => 'Izbriši'
                                    ]
                                ) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .person-card {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .person-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .person-avatar {
        transition: all 0.3s ease;
    }

    .person-card:hover .person-avatar i {
        transform: scale(1.1);
        color: #0a58ca !important;
    }

    .person-stats {
        font-size: 0.875rem;
    }
</style>