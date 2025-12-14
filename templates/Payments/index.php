<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Evidenca plačil dolgov</h1>
        <?= $this->Html->link('+ Novo plačilo', ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    </div>

    <div class="card">
        <?php if (empty($payments)): ?>
            <div class="card-body">
                <p class="text-center text-muted py-5">Še ni evidentiranih plačil</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Datum</th>
                            <th>Od</th>
                            <th class="text-center"></th>
                            <th>Za</th>
                            <th class="text-end">Znesek</th>
                            <th>Opombe</th>
                            <th class="text-center">Akcije</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payments as $payment): ?>
                            <tr>
                                <td><?= h($payment->payment_date->format('d.m.Y')) ?></td>
                                <td><strong><?= h($payment->from_person->name) ?></strong></td>
                                <td class="text-center">→</td>
                                <td><strong><?= h($payment->to_person->name) ?></strong></td>
                                <td class="text-end">
                                    <span class="badge bg-success"><?= number_format($payment->amount, 2) ?> €</span>
                                </td>
                                <td><?= h($payment->notes) ?></td>
                                <td class="text-center">
                                    <?= $this->Form->postLink('Izbriši', ['action' => 'delete', $payment->id], [
                                        'confirm' => 'Ali ste prepričani?',
                                        'class' => 'btn btn-sm btn-danger'
                                    ]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>