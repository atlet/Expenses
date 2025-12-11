<div class="container-fluid mt-4">
    <h1 class="mb-4"><i class="fas fa-chart-bar me-2"></i><?= __('Statistics') ?></h1>
    
    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <i class="fas fa-file-invoice-dollar fa-3x text-primary mb-3"></i>
                    <h2 class="mb-0"><?= number_format($totalExpenses) ?></h2>
                    <p class="text-muted mb-0"><?= __('Total Expenses') ?></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fas fa-euro-sign fa-3x text-success mb-3"></i