<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?=  __('Payments') ?></h1>
        <?= $this->Html->link(__('+ New Payment'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    </div>

    <div class="card">
        <?php if (empty($payments)): ?>
            <div class="card-body">
                <p class="text-center text-muted py-5"><?= __('No payments recorded yet') ?></p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th><?=  __('Date') ?></th>
                            <th><?=  __('From') ?></th>
                            <th class="text-center"></th>
                            <th><?=  __('To') ?></th>
                            <th class="text-end"><?=  __('Amount') ?></th>
                            <th><?=  __('Notes') ?></th>
                            <th class="text-center"><?= __('Actions') ?></th>
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
                                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $payment->id], [
                                        'confirm' => __('Are you sure?'),
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