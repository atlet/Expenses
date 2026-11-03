<?php
$this->Paginator->setTemplates([
    'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
    'current' => '<li class="page-item active" aria-current="page"><span class="page-link">{{text}}</span></li>',
    'prevActive' => '<li class="page-item"><a class="page-link" rel="prev" href="{{url}}" aria-label="Prejšnja stran">{{text}}</a></li>',
    'nextActive' => '<li class="page-item"><a class="page-link" rel="next" href="{{url}}" aria-label="Naslednja stran">{{text}}</a></li>',
    'prevDisabled' => '<li class="page-item disabled"><span class="page-link" aria-disabled="true" aria-label="Prejšnja stran">{{text}}</span></li>',
    'nextDisabled' => '<li class="page-item disabled"><span class="page-link" aria-disabled="true" aria-label="Naslednja stran">{{text}}</span></li>',
    'ellipsis' => '<li class="page-item disabled"><span class="page-link">&hellip;</span></li>',
]);
?>
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?=  __('Payments') ?></h1>
        <?= $this->Html->link(__('+ New Payment'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    </div>

    <div class="card">
        <?php if (count($payments) === 0): ?>
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
    <?php if (count($payments) > 0): ?>
        <nav class="mt-3 d-flex flex-wrap justify-content-between align-items-center gap-3" aria-label="Strani plačil">
            <ul class="pagination mb-0">
                <?= $this->Paginator->prev('‹') ?>
                <?= $this->Paginator->numbers(['modulus' => 5, 'first' => 1, 'last' => 1]) ?>
                <?= $this->Paginator->next('›') ?>
            </ul>
            <p class="text-muted mb-0"><?= $this->Paginator->counter('Stran {{page}} od {{pages}} · {{count}} plačil') ?></p>
        </nav>
    <?php endif; ?>

</div>