<!DOCTYPE html>
<html lang="<?= \Cake\I18n\I18n::getLocale() === 'en_US' ? 'en' : 'sl' ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= __('Login') ?> - <?= __('Expense Tracker') ?></title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .login-container {
            max-width: 450px;
            width: 100%;
            padding: 0 20px;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .login-header i {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .login-body {
            padding: 40px 30px;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
            transition: transform 0.2s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
        }

        .form-control {
            border-left: none;
        }

        .flash-message {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class="fas fa-receipt"></i>
                <h2 class="mb-0"><?= __('Expense Tracker') ?></h2>
                <p class="mb-0 mt-2"><?= __('Sign in to continue') ?></p>
            </div>

            <div class="login-body">
                <?= $this->Flash->render() ?>

                <?= $this->Form->create(null, ['class' => 'login-form']) ?>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-user me-2"></i><?= __('Username') ?>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user"></i>
                        </span>
                        <?= $this->Form->control('username', [
                            'label' => false,
                            'class' => 'form-control',
                            'placeholder' => __('Enter username'),
                            'required' => true,
                            'autofocus' => true
                        ]) ?>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        <i class="fas fa-lock me-2"></i><?= __('Password') ?>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <?= $this->Form->control('password', [
                            'label' => false,
                            'type' => 'password',
                            'class' => 'form-control',
                            'placeholder' => __('Enter password'),
                            'required' => true
                        ]) ?>
                    </div>
                </div>

                <?= $this->Form->button(
                    '<i class="fas fa-sign-in-alt me-2"></i>' . __('Login'),
                    [
                        'class' => 'btn btn-primary btn-login w-100',
                        'escape' => false,
                        'escapeTitle' => false
                    ]
                ) ?>

                <?= $this->Form->end() ?>

                <div class="text-center mt-4">
                    <small class="text-muted">
                        <?= __('Default credentials') ?>: <strong>admin</strong> / <strong>admin123</strong>
                    </small>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <small class="text-white">
                © <?= date('Y') ?> <?= __('Expense Tracker') ?>
            </small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>