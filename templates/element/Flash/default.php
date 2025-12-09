<?php
$class = 'alert alert-dismissible fade show flash-message';
$iconClass = 'fas fa-info-circle';

if (!empty($params['class'])) {
    $class .= ' ' . $params['class'];
} elseif (isset($key)) {
    switch ($key) {
        case 'success':
            $class .= ' alert-success';
            $iconClass = 'fas fa-check-circle';
            break;
        case 'error':
            $class .= ' alert-danger';
            $iconClass = 'fas fa-exclamation-circle';
            break;
        case 'warning':
            $class .= ' alert-warning';
            $iconClass = 'fas fa-exclamation-triangle';
            break;
        case 'info':
        default:
            $class .= ' alert-info';
            break;
    }
}
?>
<div class="<?= h($class) ?>" role="alert">
    <i class="<?= $iconClass ?> me-2"></i>
    <?= h($message) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>