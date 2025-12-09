<div class="container mt-4">
    <h1 class="mb-4">Nov strošek</h1>

    <div class="card">
        <div class="card-body">
            <?= $this->Form->create($expense) ?>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <?= $this->Form->control('title', [
                        'label' => 'Naziv stroška',
                        'class' => 'form-control',
                        'placeholder' => 'Npr. Internet december 2024'
                    ]) ?>
                </div>

                <div class="col-md-6 mb-3">
                    <?= $this->Form->control('expense_date', [
                        'label' => 'Datum',
                        'class' => 'form-control',
                        'type' => 'date',
                        'default' => date('Y-m-d')
                    ]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <?= $this->Form->control('amount', [
                        'label' => 'Znesek (€)',
                        'class' => 'form-control',
                        'type' => 'number',
                        'step' => '0.01',
                        'placeholder' => '0.00'
                    ]) ?>
                </div>

                <div class="col-md-4 mb-3">
                    <?= $this->Form->control('commission', [
                        'label' => 'Provizija (€)',
                        'class' => 'form-control',
                        'type' => 'number',
                        'step' => '0.01',
                        'default' => 0,
                        'placeholder' => '0.00'
                    ]) ?>
                </div>

                <div class="col-md-4 mb-3">
                    <?= $this->Form->control('paid_by_id', [
                        'label' => 'Plačal',
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

            <div class="mb-3">
                <?= $this->Form->control('notes', [
                    'label' => 'Opombe',
                    'class' => 'form-control',
                    'type' => 'textarea',
                    'rows' => 3
                ]) ?>
            </div>

            <div class="d-flex gap-2">
                <?= $this->Form->button('Shrani strošek', ['class' => 'btn btn-success']) ?>
                <?= $this->Html->link('Prekliči', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
            </div>

            <?= $this->Form->end() ?>
        </div>
    </div>
</div>