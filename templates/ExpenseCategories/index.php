<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-tags me-2"></i><?= __('Categories') ?></h1>
        <?= $this->Html->link(
            '<i class="fas fa-plus me-2"></i>' . __('New Category'),
            ['action' => 'add'],
            ['class' => 'btn btn-primary', 'escape' => false]
        ) ?>
    </div>

    <?php if (empty($categories->toArray())): ?>
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-tags fa-3x mb-3 d-block text-muted"></i>
            <h4><?= __('No categories yet') ?></h4>
            <p class="mb-4"><?= __('Create categories to organize your expenses') ?></p>
            <?= $this->Html->link(
                '<i class="fas fa-plus-circle me-2"></i>' . __('Add First Category'),
                ['action' => 'add'],
                ['class' => 'btn btn-primary btn-lg', 'escape' => false]
            ) ?>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($categories as $category): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 category-card" style="border-left: 4px solid <?= h($category->color) ?>;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-2">
                                        <span class="badge" style="background-color: <?= h($category->color) ?>">
                                            <i class="fas <?= h($category->icon) ?> me-2"></i>
                                            <?= h($category->name) ?>
                                        </span>
                                    </h5>
                                    <?php if ($category->description): ?>
                                        <p class="card-text text-muted small mb-2">
                                            <?= h($category->description) ?>
                                        </p>
                                    <?php endif; ?>
                                    <div class="small text-muted">
                                        <i class="fas fa-sort-numeric-down me-1"></i>
                                        <?= __('Order') ?>: <?= h($category->sort_order) ?>
                                    </div>
                                </div>
                                <div>
                                    <?php if ($category->is_active): ?>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-times"></i>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <?= $this->Html->link(
                                    '<i class="fas fa-edit me-1"></i>' . __('Edit'),
                                    ['action' => 'edit', $category->id],
                                    ['class' => 'btn btn-sm btn-warning', 'escape' => false]
                                ) ?>
                                <?= $this->Form->postLink(
                                    '<i class="fas fa-trash me-1"></i>' . __('Delete'),
                                    ['action' => 'delete', $category->id],
                                    [
                                        'confirm' => __('Are you sure you want to delete this category?'),
                                        'class' => 'btn btn-sm btn-danger',
                                        'escape' => false
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
    .category-card {
        transition: all 0.3s ease;
        border: 1px solid #dee2e6;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .badge {
        font-weight: 500;
        padding: 0.5em 0.75em;
        font-size: 0.9rem;
    }
</style>