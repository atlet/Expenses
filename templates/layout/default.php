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
    <style>
        :root {
            --primary-color: #0d6efd;
            --success-color: #198754;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #0dcaf0;
            --dark-color: #212529;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.25rem;
        }

        .navbar-brand i {
            margin-right: 8px;
        }

        main {
            flex: 1;
            padding-bottom: 3rem;
        }

        .card {
            border: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .12), 0 1px 2px rgba(0, 0, 0, .24);
            transition: all 0.3s cubic-bezier(.25, .8, .25, 1);
            margin-bottom: 1.5rem;
        }

        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, .16), 0 3px 6px rgba(0, 0, 0, .23);
        }

        .card-header {
            font-weight: 600;
            border-bottom: 2px solid rgba(0, 0, 0, .1);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .badge {
            padding: 0.5em 0.75em;
            font-weight: 500;
        }

        .btn {
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, .2);
        }

        .alert {
            border: none;
            border-left: 4px solid;
        }

        .alert-success {
            background-color: #d1e7dd;
            border-left-color: var(--success-color);
            color: #0f5132;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-left-color: var(--danger-color);
            color: #842029;
        }

        .alert-warning {
            background-color: #fff3cd;
            border-left-color: var(--warning-color);
            color: #664d03;
        }

        .alert-info {
            background-color: #cff4fc;
            border-left-color: var(--info-color);
            color: #055160;
        }

        footer {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
            padding: 2rem 0;
            margin-top: auto;
        }

        /* Flash messages styling */
        .flash-message {
            position: fixed;
            top: 70px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            max-width: 500px;
            animation: slideInRight 0.3s ease-out;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Responsive table */
        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.875rem;
            }

            .card {
                margin-bottom: 1rem;
            }
        }

        /* Loading spinner */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 0.2em;
        }

        /* Form styling */
        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        /* Navigation active state */
        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0.25rem;
        }

        /* Stats cards */
        .stat-card {
            background: linear-gradient(135deg, var(--primary-color) 0%, #0a58ca 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stat-card p {
            margin: 0;
            opacity: 0.9;
        }
    </style>

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
                            '<i class="fas fa-rotate me-1"></i>Ponavljajoči stroški',
                            ['controller' => 'RecurringExpenses', 'action' => 'index'],
                            [
                                'class' => 'nav-link' . ($this->request->getParam('controller') === 'RecurringExpenses' ? ' active' : ''),
                                'escape' => false
                            ]
                        ) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(
                            '<i class="fas fa-users me-1"></i>Osebe',
                            ['controller' => 'People', 'action' => 'index'],
                            [
                                'class' => 'nav-link' . ($this->request->getParam('controller') === 'People' ? ' active' : ''),
                                'escape' => false
                            ]
                        ) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(
                            '<i class="fas fa-users me-1"></i>' . __('Suppliers'),
                            ['controller' => 'Suppliers', 'action' => 'index'],
                            [
                                'class' => 'nav-link' . ($this->request->getParam('controller') === 'Suppliers' ? ' active' : ''),
                                'escape' => false
                            ]
                        ) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(
                            '<i class="fas fa-users me-1"></i>' . __('Categories'),
                            ['controller' => 'ExpenseCategories', 'action' => 'index'],
                            [
                                'class' => 'nav-link' . ($this->request->getParam('controller') === 'ExpenseCategories' ? ' active' : ''),
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