<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Seznam stroškov</h1>
        <?= $this->Html->link('+ Nov strošek', ['action' => 'add'], ['class' => 'btn btn-success']) ?>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Datum</th>
                            <th>Naziv</th>
                            <th class="text-end">Znesek</th>
                            <th class="text-end">Provizija</th>
                            <th class="text-end">Skupaj</th>
                            <th>Plačal</th>
                            <th>Deljeno med</th>
                            <th class="text-end">Delež/os.</th>
                            <th class="text-center">Akcije</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($expenses as $expense): ?>
                            <tr>
                                <td><?= h($expense->expense_date->format('d.m.Y')) ?></td>
                                <td><?= h($expense->title) ?></td>
                                <td class="text-end"><?= number_format($expense->amount, 2) ?> €</td>
                                <td class="text-end"><?= number_format($expense->commission, 2) ?> €</td>
                                <td class="text-end"><strong><?= number_format($expense->amount + $expense->commission, 2) ?> €</strong></td>
                                <td><?= h($expense->paid_by->name) ?></td>
                                <td>
                                    <?php
                                    $names = [];
                                    foreach ($expense->expense_splits as $split) {
                                        $names[] = h($split->person->name);
                                    }
                                    echo implode(', ', $names);
                                    ?>
                                </td>
                                <td class="text-end text-primary">
                                    <strong>
                                        <?= number_format(($expense->amount + $expense->commission) / count($expense->expense_splits), 2) ?> €
                                    </strong>
                                </td>
                                <td class="text-center">
                                    <?= $this->Html->link('Uredi', ['action' => 'edit', $expense->id], ['class' => 'btn btn-sm btn-warning']) ?>
                                    <?= $this->Form->postLink('Izbriši', ['action' => 'delete', $expense->id], [
                                        'confirm' => 'Ali ste prepričani?',
                                        'class' => 'btn btn-sm btn-danger'
                                    ]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>