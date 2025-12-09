<div class="container mt-4">
    <h1 class="mb-4">Nov ponavljajoči se strošek</h1>

    <div class="card">
        <div class="card-body">
            <?= $this->Form->create($recurringExpense) ?>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <?= $this->Form->control('title', [
                        'label' => 'Naziv (npr. Internet)',
                        'class' => 'form-control'
                    ]) ?>
                </div>

                <div class="col-md-6 mb-3">
                    <?= $this->Form->control('day_of_month', [
                        'label' => 'Dan v mesecu',
                        'class' => 'form-select',
                        'options' => array_combine(range(1, 28), array_map(fn($n) => "{$n}. dan", range(1, 28)))
                    ]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <?= $this->Form->control('amount', [
                        'label' => 'Znesek (€)',
                        'class' => 'form-control',
                        'type' => 'number',
                        'step' => '0.01'
                    ]) ?>
                </div>

                <div class="col-md-4 mb-3">
                    <?= $this->Form->control('commission', [
                        'label' => 'Provizija (€)',
                        'class' => 'form-control',
                        'type' => 'number',
                        'step' => '0.01',
                        'default' => 0
                    ]) ?>
                </div>

                <div class="col-md-4 mb-3">
                    <?= $this->Form->control('paid_by_id', [
                        'label' => 'Plača',
                        'class' => 'form-select',
                        'options' => $people,
                        'empty' => 'Izberite osebo'
                    ]) ?>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Deli med:</label>
                <div class="row">
                    <?php foreach ($people as $id => $name): ?>
                        <div class="col-md-4">
                            <div class="form-check">
                                <?= $this->Form->checkbox("split_people.{$id}", [
                                    'value' => $id,
                                    'id' => "split-{$id}",
                                    'class' => 'form-check-input',
                                    'checked' => true
                                ]) ?>
                                <label class="form-check-label" for="split-<?= $id ?>">
                                    <?= h($name) ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="d-flex gap-2">
                <?= $this->Form->button('Shrani', ['class' => 'btn btn-warning']) ?>
                <?= $this->Html->link('Prekliči', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
            </div>

            <?= $this->Form->end() ?>
        </div>
    </div>
</div>