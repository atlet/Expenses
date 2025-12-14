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
    <?= $this->Html->css('custom'); ?>

    <!-- Font Awesome (for additional icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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

                        <li class="nav-item">
                            <?= $this->Html->link(
                                '<span class="nav-link-icon"><i class="ti ti-list"></i></span>
                                <span class="nav-link-title">' . __('Expenses') . '</span>',
                                ['controller' => 'Expenses', 'action' => 'index'],
                                [
                                    'class' => 'nav-link' . ($this->request->getParam('controller') === 'Expenses' ? ' active' : ''),
                                    'escape' => false
                                ]
                            ) ?>
                        </li>

                        <li class="nav-item">
                            <?= $this->Html->link(
                                '<span class="nav-link-icon"><i class="ti ti-tag"></i></span>
                                <span class="nav-link-title">' . __('Categories') . '</span>',
                                ['controller' => 'ExpenseCategories', 'action' => 'index'],
                                [
                                    'class' => 'nav-link' . ($this->request->getParam('controller') === 'ExpenseCategories' ? ' active' : ''),
                                    'escape' => false
                                ]
                            ) ?>
                        </li>

                        <li class="nav-item">
                            <?= $this->Html->link(
                                '<span class="nav-link-icon"><i class="ti ti-building-store"></i></span>
                                <span class="nav-link-title">' . __('Suppliers') . '</span>',
                                ['controller' => 'Suppliers', 'action' => 'index'],
                                [
                                    'class' => 'nav-link' . ($this->request->getParam('controller') === 'Suppliers' ? ' active' : ''),
                                    'escape' => false
                                ]
                            ) ?>
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

                        <li class="nav-item">
                            <?= $this->Html->link(
                                '<span class="nav-link-icon"><i class="ti ti-chart-line"></i></span>
                                <span class="nav-link-title">' . __('Statistics') . '</span>',
                                ['controller' => 'Statistics', 'action' => 'index'],
                                [
                                    'class' => 'nav-link' . ($this->request->getParam('controller') === 'Statistics' ? ' active' : ''),
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