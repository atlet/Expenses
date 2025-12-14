<!DOCTYPE html>
<html lang="<?= \Cake\I18n\I18n::getLocale() === 'en_US' ? 'en' : 'sl' ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= __('Login') ?> - <?= __('Expense Tracker') ?></title>

    <!-- Tabler CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6fa;
        }

        .page-center {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1rem;
        }

        .login-container {
            width: 100%;
            max-width: 26rem;
        }

        .card-login {
            box-shadow: 0 0 2rem rgba(0, 0, 0, 0.1);
            border: none;
        }

        .brand-logo {
            font-size: 3rem;
            color: #206bc4;
            margin-bottom: 1rem;
        }

        .form-control:focus {
            border-color: #206bc4;
            box-shadow: 0 0 0 0.25rem rgba(32, 107, 196, 0.25);
        }

        .btn-primary {
            background-color: #206bc4;
            border-color: #206bc4;
        }

        .btn-primary:hover {
            background-color: #1a5ba8;
            border-color: #1a5ba8;
        }

        .language-switcher {
            position: absolute;
            top: 1rem;
            right: 1rem;
        }

        .alert {
            border-radius: 0.5rem;
        }
    </style>
</head>

<body class="d-flex flex-column">

    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="login-container">
                <div class="text-center mb-4">
                    <div class="brand-logo">
                        <i class="ti ti-receipt"></i>
                    </div>
                    <h1 class="h2 mb-3"><?= __('Expense Tracker') ?></h1>
                </div>

                <div class="card card-md">
                    <div class="card-body">
                        <h2 class="h2 text-center mb-4"><?= __('Sign in to your account to continue') ?></h2>
                        <?= $this->Flash->render() ?>

                        <?= $this->Form->create(null, ['class' => 'login-form']) ?>

                        <?= $this->Form->control('username', ['placeholder' => __('your@email.com'), 'label' => __('Username')]) ?>
                        <?= $this->Form->control('password', ['placeholder' => __('Your password'), 'label' => __('Password')]) ?>
                        <?= $this->Form->control('remember', ['type' => 'checkbox', 'label' => __('Remember me on this device')]) ?>

                        <?= $this->Form->button('<i class="ti ti-login me-2"></i>' . 'Sign in', [
                            'class' => 'btn btn-primary w-100',
                            'escape' => false,
                            'escapeTitle' => false
                        ]) ?>

                        <?= $this->Form->end() ?>
                    </div>
                </div>

                <div class="text-center text-muted mt-3">
                    <small>
                        <i class="ti ti-info-circle"></i>
                        <?= __('Default credentials') ?>: <code>admin</code> / <code>admin123</code>
                    </small>
                </div>

                <div class="text-center text-muted mt-4">
                    <small>
                        © <?= date('Y') ?> <?= __('Expense Tracker') ?>. <?= __('All rights reserved') ?>.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabler Core -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>

    <script>
        // Focus on username field
        document.addEventListener('DOMContentLoaded', function() {
            const usernameField = document.querySelector('input[name="username"]');
            if (usernameField) {
                usernameField.focus();
            }
        });
    </script>
</body>

</html>