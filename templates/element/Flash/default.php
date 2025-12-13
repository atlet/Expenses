<?php
$class = 'alert alert-dismissible fade show flash-message';

if (!empty($params['class'])) {
    $class .= ' ' . $params['class'];
} elseif (isset($key)) {
    switch ($key) {
        case 'success':
            $class .= ' alert-success';
            break;
        case 'error':
            $class .= ' alert-danger';
            break;
        case 'warning':
            $class .= ' alert-warning';
            break;
        case 'info':
        default:
            $class .= ' alert-info';
            break;
    }
}
?>
<div class="<?= h($class) ?>" role="alert">
    <div class="d-flex">
        <div>
            <?php
            $icon = 'ti ti-info-circle';
            if (isset($key)) {
                switch ($key) {
                    case 'success':
                        $icon = 'ti ti-check';
                        break;
                    case 'error':
                        $icon = 'ti ti-alert-circle';
                        break;
                    case 'warning':
                        $icon = 'ti ti-alert-triangle';
                        break;
                }
            }
            ?>
            <i class="<?= $icon ?> icon alert-icon"></i>
        </div>
        <div>
            <?= h($message) ?>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>