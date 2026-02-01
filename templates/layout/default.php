<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'Sledilnik stroškov pisarne';
?>
<!DOCTYPE html>
<html lang="sl">

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <!-- Custom CSS -->
    <?= $this->Html->css('styles') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <?= $this->Html->link(
                '<i class="fas fa-receipt"></i>' . $cakeDescription,
                '/',
                ['class' => 'navbar-brand', 'escape' => false]
            ) ?>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <?= $this->Html->link(
                            '<i class="fas fa-home me-1"></i>' . __('Dashboard'),
                            ['controller' => 'Dashboard', 'action' => 'index'],
                            [
                                'class' => 'nav-link' . ($this->request->getParam('controller') === 'Dashboard' ? ' active' : ''),
                                'escape' => false
                            ]
                        ) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(
                            '<i class="fas fa-file-invoice-dollar me-1"></i>Stroški',
                            ['controller' => 'Expenses', 'action' => 'index'],
                            [
                                'class' => 'nav-link' . ($this->request->getParam('controller') === 'Expenses' ? ' active' : ''),
                                'escape' => false
                            ]
                        ) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(
                            '<i class="fas fa-money-bill-transfer me-1"></i>Plačila',
                            ['controller' => 'Payments', 'action' => 'index'],
                            [
                                'class' => 'nav-link' . ($this->request->getParam('controller') === 'Payments' ? ' active' : ''),
                                'escape' => false
                            ]
                        ) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(
                            '<i class="fas fa-chart-bar me-1"></i>' . __('Statistics'),
                            ['controller' => 'Statistics', 'action' => 'index'],
                            [
                                'class' => 'nav-link' . ($this->request->getParam('controller') === 'Statistics' ? ' active' : ''),
                                'escape' => false
                            ]
                        ) ?>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="settingsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-cog me-1"></i>Nastavitve
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="settingsDropdown">
                            <li>
                                <?= $this->Html->link(
                                    '<i class="fas fa-rotate me-2"></i>Ponavljajoči stroški',
                                    ['controller' => 'RecurringExpenses', 'action' => 'index'],
                                    ['class' => 'dropdown-item', 'escape' => false]
                                ) ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    '<i class="fas fa-users me-2"></i>Osebe',
                                    ['controller' => 'People', 'action' => 'index'],
                                    ['class' => 'dropdown-item', 'escape' => false]
                                ) ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    '<i class="fas fa-building me-2"></i>' . __('Suppliers'),
                                    ['controller' => 'Suppliers', 'action' => 'index'],
                                    ['class' => 'dropdown-item', 'escape' => false]
                                ) ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    '<i class="fas fa-tag me-2"></i>' . __('Categories'),
                                    ['controller' => 'ExpenseCategories', 'action' => 'index'],
                                    ['class' => 'dropdown-item', 'escape' => false]
                                ) ?>
                            </li>
                        </ul>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-globe me-1"></i>
                            <?php
                            $currentLocale = \Cake\I18n\I18n::getLocale();
                            echo $currentLocale === 'sl_SI' ? 'Slovenščina' : 'English';
                            ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                            <li>
                                <?= $this->Html->link(
                                    '<i class="fas fa-flag me-2"></i>English',
                                    ['controller' => 'Language', 'action' => 'switch', '?' => ['locale' => 'en_US']],
                                    ['class' => 'dropdown-item', 'escape' => false]
                                ) ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    '<i class="fas fa-flag me-2"></i>Slovenščina',
                                    ['controller' => 'Language', 'action' => 'switch', '?' => ['locale' => 'sl_SI']],
                                    ['class' => 'dropdown-item', 'escape' => false]
                                ) ?>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-plus-circle me-1"></i>Novo
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <?= $this->Html->link(
                                    '<i class="fas fa-file-invoice me-2"></i>Nov strošek',
                                    ['controller' => 'Expenses', 'action' => 'add'],
                                    ['class' => 'dropdown-item', 'escape' => false]
                                ) ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    '<i class="fas fa-hand-holding-dollar me-2"></i>Novo plačilo',
                                    ['controller' => 'Payments', 'action' => 'add'],
                                    ['class' => 'dropdown-item', 'escape' => false]
                                ) ?>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    '<i class="fas fa-user-plus me-2"></i>Nova oseba',
                                    ['controller' => 'People', 'action' => 'add'],
                                    ['class' => 'dropdown-item', 'escape' => false]
                                ) ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    '<i class="fas fa-repeat me-2"></i>Nov ponavljajoči strošek',
                                    ['controller' => 'RecurringExpenses', 'action' => 'add'],
                                    ['class' => 'dropdown-item', 'escape' => false]
                                ) ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    '<i class="fas fa-tag me-2"></i>' . __('Category'),
                                    ['controller' => 'ExpenseCategories', 'action' => 'add'],
                                    ['class' => 'dropdown-item', 'escape' => false]
                                ) ?>
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    '<i class="fas fa-building me-2"></i>' . __('Supplier'),
                                    ['controller' => 'Suppliers', 'action' => 'add'],
                                    ['class' => 'dropdown-item', 'escape' => false]
                                ) ?>
                            </li>
                        </ul>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>
                            <?php if ($authUser): ?>
                                <?= h($authUser->username) ?>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li class="dropdown-header">
                                <i class="fas fa-user me-2"></i>
                                <?php if ($authUser): ?>
                                    <?= h($authUser->first_name . ' ' . $authUser->last_name) ?>
                                <?php endif; ?>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    '<i class="fas fa-user-circle me-2"></i>' . __('My Profile'),
                                    ['controller' => 'Users', 'action' => 'profile'],
                                    ['class' => 'dropdown-item', 'escape' => false]
                                ) ?>
                            </li>
                            <?php if ($authUser && $authUser->role === 'admin'): ?>
                                <li>
                                    <?= $this->Html->link(
                                        '<i class="fas fa-users-cog me-2"></i>' . __('User Management'),
                                        ['controller' => 'Users', 'action' => 'index'],
                                        ['class' => 'dropdown-item', 'escape' => false]
                                    ) ?>
                                </li>
                            <?php endif; ?>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <?= $this->Html->link(
                                    '<i class="fas fa-sign-out-alt me-2"></i>' . __('Logout'),
                                    ['controller' => 'Users', 'action' => 'logout'],
                                    ['class' => 'dropdown-item text-danger', 'escape' => false]
                                ) ?>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="flash-messages-container">
        <?= $this->Flash->render() ?>
    </div>

    <!-- Main Content -->
    <main class="main">
        <?= $this->fetch('content') ?>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-receipt me-2"></i><?= $cakeDescription ?></h5>
                    <p class="text-muted">Enostavno vodenje in delitev skupnih stroškov pisarne.</p>
                </div>
                <div class="col-md-3">
                    <h6>Hitre povezave</h6>
                    <ul class="list-unstyled">
                        <li><?= $this->Html->link(__('Dashboard'), ['controller' => 'Dashboard', 'action' => 'index']) ?></li>
                        <li><?= $this->Html->link('Stroški', ['controller' => 'Expenses', 'action' => 'index']) ?></li>
                        <li><?= $this->Html->link('Plačila', ['controller' => 'Payments', 'action' => 'index']) ?></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Informacije</h6>
                    <p class="text-muted small mb-0">
                        Powered by CakePHP 5<br>
                        © <?= date('Y') ?> Vse pravice pridržane
                    </p>
                </div>
            </div>
            <hr class="my-3">
            <div class="row">
                <div class="col text-center text-muted small">
                    <p class="mb-0">
                        <i class="fas fa-code me-1"></i>Razvito z ❤️ za lažje upravljanje skupnih stroškov
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script>
        // Auto-hide flash messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessages = document.querySelectorAll('.flash-message, .message');
            flashMessages.forEach(function(message) {
                message.classList.add('flash-message');
                setTimeout(function() {
                    message.style.animation = 'slideOutRight 0.3s ease-out';
                    setTimeout(function() {
                        message.remove();
                    }, 300);
                }, 5000);
            });
        });

        // Confirmation for delete actions
        document.querySelectorAll('form[method="post"]').forEach(function(form) {
            const button = form.querySelector('button[type="submit"]');
            if (button && (button.textContent.includes('Izbriši') || button.textContent.includes('Delete'))) {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Ali ste prepričani, da želite izbrisati ta vnos?')) {
                        e.preventDefault();
                    }
                });
            }
        });

        // Add loading state to buttons on form submit
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn && !form.hasAttribute('data-no-loading')) {
                    submitBtn.disabled = true;
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Nalagam...';

                    // Re-enable after 3 seconds as fallback
                    setTimeout(function() {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }, 3000);
                }
            });
        });

        // Tooltips initialization (if using Bootstrap tooltips)
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>

    <?= $this->fetch('script') ?>
</body>

</html>