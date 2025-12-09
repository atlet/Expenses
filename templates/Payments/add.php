<div class="container mt-4">
    <h1 class="mb-4">Novo plačilo dolga</h1>

    <div class="card">
        <div class="card-body">
            <?= $this->Form->create($payment) ?>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <?= $this->Form->control('from_person_id', [
                        'label' => 'Od (plačnik)',
                        'class' => 'form-select',
                        'options' => $people,
                        'empty' => 'Izberite osebo'
                    ]) ?>
                </div>

                <div class="col-md-3 mb-3">
                    <?= $this->Form->control('to_person_id', [
                        'label' => 'Za (prejemnik)',
                        'class' => 'form-select',
                        'options' => $people,
                        'empty' => 'Izberite osebo'
                    ]) ?>
                </div>

                <div class="col-md-3 mb-3">
                    <?= $this->Form->control('amount', [
                        'label' => 'Znesek (€)',
                        'class' => 'form-control',
                        'type' => 'number',
                        'step' => '0.01',
                        'placeholder' => '0.00'
                    ]) ?>
                </div>

                <div class="col-md-3 mb-3">
                    <?= $this->Form->control('payment_date', [
                        'label' => 'Datum plačila',
                        'class' => 'form-control',
                        'type' => 'date',
                        'default' => date('Y-m-d')
                    ]) ?>
                </div>
            </div>

            <div class="mb-3">
                <?= $this->Form->control('notes', [
                    'label' => 'Opombe',
                    'class' => 'form-control',
                    'type' => 'textarea',
                    'rows' => 2
                ]) ?>
            </div>

            <div class="d-flex gap-2">
                <?= $this->Form->button('Shrani plačilo', ['class' => 'btn btn-primary']) ?>
                <?= $this->Html->link('Prekliči', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
            </div>

            <?= $this->Form->end() ?>
        </div>
    </div>
</div>