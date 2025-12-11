<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-users-cog me-2"></i><?= __('User Management') ?></h1>
        <?= $this->Html->link(
            '<i class="fas fa-user-plus me-2"></i>' . __('Add User'),
            ['action' => 'add'],
            ['class' => 'btn btn-success', 'escape' => false]
        ) ?>
    </div>

    <?php if (empty($users->toArray())): ?>
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-users fa-3x mb-3 d-block text-muted"></i>
            <h4><?= __('No users yet') ?></h4>
            <p class="mb-4"><?= __('Add users to give them access to the system') ?></p>
            <?= $this->Html->link(
                '<i class="fas fa-plus-circle me-2"></i>' . __('Add First User'),
                ['action' => 'add'],
                ['class' => 'btn btn-success btn-lg', 'escape' => false]
            ) ?>
        </div>
    <?php else: ?>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-user me-2"></i><?= __('Username') ?></th>
                                <th><i class="fas fa-id-card me-2"></i><?= __('Name') ?></th>
                                <th><i class="fas fa-envelope me-2"></i><?= __('Email') ?></th>
                                <th><i class="fas fa-user-tag me-2"></i><?= __('Role') ?></th>
                                <th><i class="fas fa-clock me-2"></i><?= __('Last Login') ?></th>
                                <th class="text-center"><i class="fas fa-toggle-on me-2"></i><?= __('Status') ?></th>
                                <th class="text-center"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td>
                                        <strong><?= h($user->username) ?></strong>
                                        <?php if ($authUser && $authUser->getIdentifier() == $user->id): ?>
                                            <span class="badge bg-info ms-2">
                                                <i class="fas fa-user-circle"></i> <?= __('You') ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= h($user->first_name . ' ' . $user->last_name) ?></td>
                                    <td>
                                        <a href="mailto:<?= h($user->email) ?>">
                                            <?= h($user->email) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php if ($user->role === 'admin'): ?>
                                            <span class="badge bg-danger">
                                                <i class="fas fa-crown me-1"></i><?= __('Admin') ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-primary">
                                                <i class="fas fa-user me-1"></i><?= __('User') ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($user->last_login): ?>
                                            <small class="text-muted">
                                                <?= $user->last_login->format('d.m.Y H:i') ?>
                                            </small>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($user->is_active): ?>
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i><?= __('Active') ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-ban me-1"></i><?= __('Inactive') ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <?= $this->Html->link(
                                                '<i class="fas fa-edit"></i>',
                                                ['action' => 'edit', $user->id],
                                                [
                                                    'class' => 'btn btn-sm btn-warning',
                                                    'escape' => false,
                                                    'title' => __('Edit')
                                                ]
                                            ) ?>
                                            <?php if ($authUser && $authUser->getIdentifier() != $user->id): ?>
                                                <?= $this->Form->postLink(
                                                    '<i class="fas fa-trash"></i>',
                                                    ['action' => 'delete', $user->id],
                                                    [
                                                        'confirm' => __('Are you sure you want to delete this user?'),
                                                        'class' => 'btn btn-sm btn-danger',
                                                        'escape' => false,
                                                        'title' => __('Delete')
                                                    ]
                                                ) ?>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="alert alert-info mt-4">
            <i class="fas fa-info-circle me-2"></i>
            <strong><?= __('Note') ?>:</strong> <?= __('Only administrators can manage users. Regular users can only edit their own profile.') ?>
        </div>
    <?php endif; ?>
</div>