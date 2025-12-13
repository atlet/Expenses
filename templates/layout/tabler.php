<?php
$cakeDescription = 'Expense Tracker';
?>
<!DOCTYPE html>
<html lang="<?= \Cake\I18n\I18n::getLocale() === 'en_US' ? 'en' : 'sl' ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <!-- Tabler CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">

    <!-- Font Awesome (for additional icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --tblr-primary: #206bc4;
            --tblr-secondary: #626976;
            --tblr-success: #2fb344;
            --tblr-info: #4299e1;
            --tblr-warning: #f76707;
            --tblr-danger: #d63939;
        }

        body {
            background-color: #f4f6fa;
        }

        /* Navbar fixes */
        .navbar-brand-image {
            height: 2rem;
        }

        .navbar {
            background-color: #fff;
            border-bottom: 1px solid rgba(98, 105, 118, 0.16);
        }

        /* Sidebar */
        .navbar-vertical.navbar-expand-md {
            width: 15rem;
            position: fixed;
            top: 3.5rem;
            left: 0;
            bottom: 0;
            z-index: 1030;
            overflow-y: auto;
            background-color: #fff;
            border-right: 1px solid rgba(98, 105, 118, 0.16);
        }

        @media (max-width: 767.98px) {
            .navbar-vertical.navbar-expand-md {
                width: 100%;
                position: fixed;
                top: 3.5rem;
                left: -100%;
                transition: left 0.3s ease;
                z-index: 1040;
            }

            .navbar-vertical.navbar-expand-md.show {
                left: 0;
            }
        }

        /* Main content area */
        .page-wrapper {
            min-height: 100vh;
        }

        @media (max-width: 767.98px) {
            .page-wrapper {
                padding-left: 0;
            }
        }

        .page-body {
            /*padding: 1.5rem 0;*/
        }

        /* Remove extra padding from container */
        .page-body>.container-fluid {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        /* Navigation */
        .nav-link-icon {
            width: 1.5rem;
            height: 1.5rem;
            margin-right: 0.5rem;
        }

        .nav-link.active {
            background-color: rgba(32, 107, 196, 0.06);
            color: var(--tblr-primary);
            font-weight: 600;
        }

        /* Dropdown improvements */
        .dropdown-item-icon {
            width: 1.25rem;
            display: inline-block;
            text-align: center;
            margin-right: 0.5rem;
        }

        .dropdown-menu-arrow::before {
            content: "";
            position: absolute;
            top: -6px;
            right: 12px;
            width: 12px;
            height: 12px;
            background: white;
            border-left: 1px solid rgba(98, 105, 118, 0.16);
            border-top: 1px solid rgba(98, 105, 118, 0.16);
            transform: rotate(45deg);
        }

        /* Avatar improvements */
        .avatar-title {
            font-size: 1.25rem;
        }

        /* Language dropdown spacing */
        .navbar-nav .nav-item.me-3 {
            margin-right: 1rem !important;
        }

        /* Card improvements */
        .card {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        /* Flash messages */
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

        /* Footer */
        footer.footer {
            padding: 1.5rem 0;
            border-top: 1px solid rgba(98, 105, 118, 0.16);
            background-color: #fff;
        }

        @media (max-width: 767.98px) {
            footer.footer {
                margin-left: 0;
            }
        }

        /* Mobile menu toggle */
        .navbar-toggler {
            border: none;
            padding: 0.25rem 0.5rem;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        /* Backdrop for mobile menu */
        .navbar-backdrop {
            display: none;
            position: fixed;
            top: 3.5rem;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1035;
        }

        .navbar-backdrop.show {
            display: block;
        }

        /* Custom scrollbar for sidebar */
        .navbar-vertical::-webkit-scrollbar {
            width: 6px;
        }

        .navbar-vertical::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .navbar-vertical::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        .navbar-vertical::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Ensure proper spacing for page content */
        .page-content {
            padding: 0;
        }

        /* Badge improvements */
        .badge {
            font-weight: 500;
        }
    </style>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>

<body>
    <div class="page">
        <!-- Navbar -->
        <header class="navbar navbar-expand-md navbar-light sticky-top d-print-none">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" id="navbar-toggler">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href="<?= $this->Url->build('/') ?>">
                        <i class="ti ti-receipt me-2"></i>
                        <?= $cakeDescription ?>
                    </a>
                </h1>

                <div class="navbar-nav flex-row order-md-last">
                    <!-- Language Switcher -->
                    <div class="nav-item dropdown me-3">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open language menu">
                            <span class="avatar avatar-sm">
                                <?php
                                $currentLocale = \Cake\I18n\I18n::getLocale();
                                if ($currentLocale === 'sl_SI') {
                                    echo '<span class="avatar-title">🇸🇮</span>';
                                } else {
                                    echo '<span class="avatar-title">🇬🇧</span>';
                                }
                                ?>
                            </span>
                            <div class="d-none d-xl-block ps-2">
                                <div class="small text-muted">
                                    <?= $currentLocale === 'sl_SI' ? 'SLO' : 'ENG' ?>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <?= $this->Html->link(
                                '<span class="me-2">🇬🇧</span>English',
                                ['controller' => 'Language', 'action' => 'switch', '?' => ['locale' => 'en_US']],
                                ['class' => 'dropdown-item', 'escape' => false]
                            ) ?>
                            <?= $this->Html->link(
                                '<span class="me-2">🇸🇮</span>Slovenščina',
                                ['controller' => 'Language', 'action' => 'switch', '?' => ['locale' => 'sl_SI']],
                                ['class' => 'dropdown-item', 'escape' => false]
                            ) ?>
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <span class="avatar avatar-sm" style="background-image: url(https://ui-avatars.com/api/?name=<?= urlencode($authUser ? $authUser->username : 'U') ?>&background=206bc4&color=fff)"></span>
                            <div class="d-none d-xl-block ps-2">
                                <div><?= $authUser ? h($authUser->first_name . ' ' . $authUser->last_name) : 'User' ?></div>
                                <div class="mt-1 small text-muted">
                                    <?= $authUser && $authUser->role === 'admin' ? __('Administrator') : __('User') ?>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <div class="dropdown-header">
                                <span class="text-muted small"><?= __('Signed in as') ?></span><br>
                                <strong><?= $authUser ? h($authUser->username) : 'User' ?></strong>
                            </div>
                            <div class="dropdown-divider"></div>
                            <?= $this->Html->link(
                                '<i class="ti ti-user dropdown-item-icon"></i>' . __('My Profile'),
                                ['controller' => 'Users', 'action' => 'profile'],
                                ['class' => 'dropdown-item', 'escape' => false]
                            ) ?>
                            <?php if ($authUser && $authUser->role === 'admin'): ?>
                                <?= $this->Html->link(
                                    '<i class="ti ti-users dropdown-item-icon"></i>' . __('User Management'),
                                    ['controller' => 'Users', 'action' => 'index'],
                                    ['class' => 'dropdown-item', 'escape' => false]
                                ) ?>
                            <?php endif; ?>
                            <div class="dropdown-divider"></div>
                            <?= $this->Html->link(
                                '<i class="ti ti-logout dropdown-item-icon"></i>' . __('Logout'),
                                ['controller' => 'Users', 'action' => 'logout'],
                                ['class' => 'dropdown-item text-danger', 'escape' => false]
                            ) ?>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Mobile Backdrop -->
        <div class="navbar-backdrop" id="navbar-backdrop"></div>

        <!-- Sidebar -->
        <aside class="navbar navbar-vertical navbar-expand-md navbar-light" id="sidebar">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="navbar-nav pt-lg-3">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <?= $this->Html->link(
                                '<span class="nav-link-icon"><i class="ti ti-dashboard"></i></span>
                                <span class="nav-link-title">' . __('Dashboard') . '</span>',
                                ['controller' => 'Dashboard', 'action' => 'index'],
                                [
                                    'class' => 'nav-link' . ($this->request->getParam('controller') === 'Dashboard' ? ' active' : ''),
                                    'escape' => false
                                ]
                            ) ?>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle <?= in_array($this->request->getParam('controller'), ['Expenses', 'ExpenseCategories', 'Suppliers']) ? 'show active' : '' ?>"
                                href="#navbar-expenses"
                                data-bs-toggle="dropdown"
                                data-bs-auto-close="false"
                                role="button"
                                aria-expanded="<?= in_array($this->request->getParam('controller'), ['Expenses', 'ExpenseCategories', 'Suppliers']) ? 'true' : 'false' ?>">
                                <span class="nav-link-icon"><i class="ti ti-receipt"></i></span>
                                <span class="nav-link-title"><?= __('Expenses') ?></span>
                            </a>
                            <div class="dropdown-menu <?= in_array($this->request->getParam('controller'), ['Expenses', 'ExpenseCategories', 'Suppliers']) ? 'show' : '' ?>" id="navbar-expenses">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <?= $this->Html->link(
                                            '<span class="dropdown-item-icon"><i class="ti ti-list"></i></span>' . __('All Expenses'),
                                            ['controller' => 'Expenses', 'action' => 'index'],
                                            [
                                                'class' => 'dropdown-item' . ($this->request->getParam('controller') === 'Expenses' && $this->request->getParam('action') === 'index' ? ' active' : ''),
                                                'escape' => false
                                            ]
                                        ) ?>
                                        <?= $this->Html->link(
                                            '<span class="dropdown-item-icon"><i class="ti ti-plus"></i></span>' . __('Add Expense'),
                                            ['controller' => 'Expenses', 'action' => 'add'],
                                            [
                                                'class' => 'dropdown-item' . ($this->request->getParam('controller') === 'Expenses' && $this->request->getParam('action') === 'add' ? ' active' : ''),
                                                'escape' => false
                                            ]
                                        ) ?>
                                        <div class="dropdown-divider"></div>
                                        <?= $this->Html->link(
                                            '<span class="dropdown-item-icon"><i class="ti ti-tag"></i></span>' . __('Categories'),
                                            ['controller' => 'ExpenseCategories', 'action' => 'index'],
                                            [
                                                'class' => 'dropdown-item' . ($this->request->getParam('controller') === 'ExpenseCategories' ? ' active' : ''),
                                                'escape' => false
                                            ]
                                        ) ?>
                                        <?= $this->Html->link(
                                            '<span class="dropdown-item-icon"><i class="ti ti-building-store"></i></span>' . __('Suppliers'),
                                            ['controller' => 'Suppliers', 'action' => 'index'],
                                            [
                                                'class' => 'dropdown-item' . ($this->request->getParam('controller') === 'Suppliers' ? ' active' : ''),
                                                'escape' => false
                                            ]
                                        ) ?>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Payments -->
                        <li class="nav-item">
                            <?= $this->Html->link(
                                '<span class="nav-link-icon"><i class="ti ti-coin"></i></span>
                                <span class="nav-link-title">' . __('Payments') . '</span>',
                                ['controller' => 'Payments', 'action' => 'index'],
                                [
                                    'class' => 'nav-link' . ($this->request->getParam('controller') === 'Payments' ? ' active' : ''),
                                    'escape' => false
                                ]
                            ) ?>
                        </li>

                        <!-- Recurring Expenses -->
                        <li class="nav-item">
                            <?= $this->Html->link(
                                '<span class="nav-link-icon"><i class="ti ti-repeat"></i></span>
                                <span class="nav-link-title">' . __('Recurring Expenses') . '</span>',
                                ['controller' => 'RecurringExpenses', 'action' => 'index'],
                                [
                                    'class' => 'nav-link' . ($this->request->getParam('controller') === 'RecurringExpenses' ? ' active' : ''),
                                    'escape' => false
                                ]
                            ) ?>
                        </li>

                        <!-- People -->
                        <li class="nav-item">
                            <?= $this->Html->link(
                                '<span class="nav-link-icon"><i class="ti ti-users"></i></span>
                                <span class="nav-link-title">' . __('People') . '</span>',
                                ['controller' => 'People', 'action' => 'index'],
                                [
                                    'class' => 'nav-link' . ($this->request->getParam('controller') === 'People' ? ' active' : ''),
                                    'escape' => false
                                ]
                            ) ?>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle <?= $this->request->getParam('controller') === 'Statistics' ? 'show active' : '' ?>"
                                href="#navbar-reports"
                                data-bs-toggle="dropdown"
                                data-bs-auto-close="false"
                                role="button"
                                aria-expanded="<?= $this->request->getParam('controller') === 'Statistics' ? 'true' : 'false' ?>">
                                <span class="nav-link-icon"><i class="ti ti-chart-bar"></i></span>
                                <span class="nav-link-title"><?= __('Reports') ?></span>
                            </a>
                            <div class="dropdown-menu <?= $this->request->getParam('controller') === 'Statistics' ? 'show' : '' ?>" id="navbar-reports">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <?= $this->Html->link(
                                            '<span class="dropdown-item-icon"><i class="ti ti-chart-line"></i></span>' . __('Statistics'),
                                            ['controller' => 'Statistics', 'action' => 'index'],
                                            [
                                                'class' => 'dropdown-item' . ($this->request->getParam('controller') === 'Statistics' ? ' active' : ''),
                                                'escape' => false
                                            ]
                                        ) ?>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item-divider"></li>

                        <?php if ($authUser && $authUser->role === 'admin'): ?>
                            <li class="nav-item">
                                <?= $this->Html->link(
                                    '<span class="nav-link-icon"><i class="ti ti-settings"></i></span>
                                    <span class="nav-link-title">' . __('Settings') . '</span>',
                                    ['controller' => 'Users', 'action' => 'index'],
                                    [
                                        'class' => 'nav-link' . ($this->request->getParam('controller') === 'Users' && $this->request->getParam('action') === 'index' ? ' active' : ''),
                                        'escape' => false
                                    ]
                                ) ?>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </aside>

        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <div class="page-body">
                <div class="container-fluid">
                    <!-- Flash Messages -->
                    <?= $this->Flash->render() ?>

                    <!-- Page Content -->
                    <?= $this->fetch('content') ?>
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-lg-auto ms-lg-auto">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    <a href="#" class="link-secondary">
                                        <i class="ti ti-help"></i> <?= __('Help') ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    © <?= date('Y') ?>
                                    <a href="<?= $this->Url->build('/') ?>" class="link-secondary"><?= $cakeDescription ?></a>
                                </li>
                                <li class="list-inline-item">
                                    <?= __('Made with') ?> <i class="ti ti-heart text-red"></i> <?= __('using CakePHP') ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Tabler Core -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>

    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const toggler = document.getElementById('navbar-toggler');
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('navbar-backdrop');

            if (toggler && sidebar && backdrop) {
                toggler.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    backdrop.classList.toggle('show');
                });

                backdrop.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    backdrop.classList.remove('show');
                });
            }

            // Auto-hide flash messages after 5 seconds
            const flashMessages = document.querySelectorAll('.flash-message, .alert');
            flashMessages.forEach(function(message) {
                setTimeout(function() {
                    message.style.animation = 'slideOutRight 0.3s ease-out';
                    setTimeout(function() {
                        message.remove();
                    }, 300);
                }, 5000);
            });
        });
    </script>

    <?= $this->fetch('script') ?>
</body>

</html>