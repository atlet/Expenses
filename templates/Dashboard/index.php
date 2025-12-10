<div class="container-fluid mt-4">
    <h1 class="mb-4"><?= __('Dashboard') ?></h1>

    <div class="row">
        <!-- Skupno stanje -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><?= __('Total balance') ?></h5>
                </div>
                <div class="card-body">
                    <?php foreach ($balances as $personId => $balance): ?>
                        <div class="mb-3 p-3 bg-light rounded">
                            <h6 class="fw-bold"><?= h($balance['name']) ?></h6>
                            <small class="text-muted">
                                <?= __('Paid') ?>: <strong><?= number_format($balance['paid'], 2) ?> €</strong><br>
                                <?= __('Their share') ?>: <strong><?= number_format($balance['owes'], 2) ?> €</strong>
                            </small>
                            <div class="mt-2">
                                <?php if ($balance['balance'] >= 0): ?>
                                    <span class="badge bg-success">
                                        <?= __('Claim') ?>: <?= number_format(abs($balance['balance']), 2) ?> €
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger">
                                        <?= __('Debt') ?>: <?= number_format(abs($balance['balance']), 2) ?> €
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Dolgovi med osebami -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><?= __('Who owes whom') ?></h5>
                </div>
                <div class="card-body">
                    <?php if (empty($suggestedSettlements)): ?>
                        <div class="text-center text-success">
                            <i class="fas fa-check-circle fa-3x mb-2"></i>
                            <p><?= __('All debts are settled!') ?> 🎉</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($suggestedSettlements as $debt): ?>
                            <div class="alert alert-warning mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><?= h($debt['from_name']) ?></strong>
                                        →
                                        <strong><?= h($debt['to_name']) ?></strong>
                                    </div>
                                    <span class="badge bg-danger"><?= number_format($debt['amount'], 2) ?> €</span>
                                </div>
                                <?= $this->Form->postLink(
                                    'Označi kot plačano',
                                    ['controller' => 'Payments', 'action' => 'add'],
                                    [
                                        'class' => 'btn btn-sm btn-success mt-2 w-100',
                                        'data' => [
                                            'from_person_id' => $debt['from_id'],
                                            'to_person_id' => $debt['to_id'],
                                            'amount' => $debt['amount'],
                                            'payment_date' => date('Y-m-d')
                                        ]
                                    ]
                                ) ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Hitre akcije -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><?= __('Quick actions') ?></h5>
                </div>
                <div class="card-body">
                    <?= $this->Html->link(
                        '+ ' . __('New expense'),
                        ['controller' => 'Expenses', 'action' => 'add'],
                        ['class' => 'btn btn-success w-100 mb-2']
                    ) ?>
                    <?= $this->Html->link(
                        '+ ' . __('New payment'),
                        ['controller' => 'Payments', 'action' => 'add'],
                        ['class' => 'btn btn-primary w-100 mb-2']
                    ) ?>
                    <?= $this->Html->link(
                        '+ ' . __('New person'),
                        ['controller' => 'People', 'action' => 'add'],
                        ['class' => 'btn btn-info w-100 mb-2']
                    ) ?>
                    <?= $this->Html->link(
                        __('Recurring expenses'),
                        ['controller' => 'RecurringExpenses', 'action' => 'index'],
                        ['class' => 'btn btn-warning w-100']
                    ) ?>
                </div>
            </div>
        </div>
    </div>
</div>