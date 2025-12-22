<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-user me-2"></i><?= h($person->name) ?></h1>
        <div>
            <?= $this->Html->link(
                '<i class="fas fa-edit me-2"></i>' . __('Edit'),
                ['action' => 'edit', $person->id],
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
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i><?= __('Basic Information') ?></h5>
                </div>
                <div class="card-body text-center">
                    <i class="fas fa-user-circle fa-5x text-info mb-3"></i>
                    <h4><?= h($person->name) ?></h4>
                    <?php if ($person->email): ?>
                        <p class="text-muted mb-3">
                            <i class="fas fa-envelope me-2"></i><?= h($person->email) ?>
                        </p>
                    <?php endif; ?>

                    <hr>

                    <div class="row text-center">
                        <div class="col-4">
                            <h3 class="text-primary"><?= count($person->expenses) ?></h3>
                            <small class="text-muted"><?= __('Paid expenses') ?></small>
                        </div>
                        <div class="col-4">
                            <h3 class="text-success"><?= count($person->payments_from) ?></h3>
                            <small class="text-muted"><?= __('Completed payments') ?></small>
                        </div>
                        <div class="col-4">
                            <h3 class="text-warning"><?= count($person->expense_splits) ?></h3>
                            <small class="text-muted"><?= __('Paid expenses') ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-file-invoice-dollar me-2"></i><?= __('Last Paid Expenses') ?></h5>
                </div>
                <div class="card-body">
                    <?php if (empty($person->expenses)): ?>
                        <p class="text-muted text-center py-3"><?= __('No expenses paid yet') ?></p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th><?= __('Date') ?></th>
                                        <th><?= __('Title') ?></th>
                                        <th class="text-end"><?= __('Amount') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (array_slice($person->expenses, 0, 5) as $expense): ?>
                                        <tr>
                                            <td><?= h($expense->expense_date->format('d.m.Y')) ?></td>
                                            <td><?= h($expense->title) ?></td>
                                            <td class="text-end"><?= number_format($expense->amount + $expense->commission, 2) ?> €</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-money-bill-transfer me-2"></i><?= __('Last Payments') ?></h5>
                </div>
                <div class="card-body">
                    <?php if (empty($person->payments_from)): ?>
                        <p class="text-muted text-center py-3"><?= __('No payments completed yet') ?></p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th><?= __('Date') ?></th>
                                        <th><?= __('Recipient') ?></th>
                                        <th class="text-end"><?= __('Amount') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (array_slice($person->payments_from, 0, 5) as $payment): ?>
                                        <tr>
                                            <td><?= h($payment->payment_date->format('d.m.Y')) ?></td>
                                            <td><?= h($payment->to_person->name) ?></td>
                                            <td class="text-end text-success"><?= number_format($payment->amount, 2) ?> €</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>