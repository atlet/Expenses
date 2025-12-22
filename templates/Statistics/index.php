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
                    <i class="fas fa-euro-sign fa-3x text-success mb-3"></i>
                    <h2 class="mb-0"><?= number_format($totalAmount->total ?? 0, 2) ?> €</h2>
                    <p class="text-muted mb-0"><?= __('Total Amount') ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <h2 class="mb-0"><?= number_format($paidExpenses) ?></h2>
                    <p class="text-muted mb-0"><?= __('Paid') ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-danger">
                <div class="card-body text-center">
                    <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                    <h2 class="mb-0"><?= number_format($unpaidExpenses) ?></h2>
                    <p class="text-muted mb-0"><?= __('Unpaid') ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Expenses by Category -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie me-2"></i><?= __('Expenses by Category') ?>
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($expensesByCategory)): ?>
                        <p class="text-muted text-center py-5"><?= __('No data available') ?></p>
                    <?php else: ?>
                        <canvas id="categoryChart"></canvas>

                        <div class="mt-4">
                            <table class="table table-sm">
                                <tbody>
                                    <?php foreach ($expensesByCategory as $item): ?>
                                        <tr>
                                            <td>
                                                <?php if ($item['category_id']): ?>
                                                    <span class="badge" style="background-color: <?= h($item['category_color']) ?>">
                                                        <i class="fas <?= h($item['category_icon']) ?> me-1"></i>
                                                        <?= h($item['category_name']) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">
                                                        <?= __('Uncategorized') ?>
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end"><?= h($item['count']) ?> <?= __('expenses') ?></td>
                                            <td class="text-end">
                                                <strong><?= number_format($item['total'], 2) ?> €</strong>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Expenses by Person -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-users me-2"></i><?= __('Expenses by Person') ?>
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($expensesByPerson)): ?>
                        <p class="text-muted text-center py-5"><?= __('No data available') ?></p>
                    <?php else: ?>
                        <canvas id="personChart"></canvas>

                        <div class="mt-4">
                            <table class="table table-sm">
                                <tbody>
                                    <?php foreach ($expensesByPerson as $item): ?>
                                        <tr>
                                            <td>
                                                <i class="fas fa-user me-2"></i>
                                                <strong><?= h($item['person_name']) ?></strong>
                                            </td>
                                            <td class="text-end"><?= h($item['count']) ?> <?= __('expenses') ?></td>
                                            <td class="text-end">
                                                <strong><?= number_format($item['total'], 2) ?> €</strong>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Trend -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i><?= __('Monthly Trend (Last 12 Months)') ?>
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($monthlyTrend)): ?>
                        <p class="text-muted text-center py-5"><?= __('No data available') ?></p>
                    <?php else: ?>
                        <canvas id="trendChart"></canvas>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Expenses -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-trophy me-2"></i><?= __('Top 10 Largest Expenses') ?>
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($topExpenses)): ?>
                        <p class="text-muted text-center py-3"><?= __('No data available') ?></p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th><?= __('Date') ?></th>
                                        <th><?= __('Category') ?></th>
                                        <th><?= __('Title') ?></th>
                                        <th><?= __('Paid By') ?></th>
                                        <th class="text-end"><?= __('Amount') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($topExpenses as $index => $expense): ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-secondary"><?= $index + 1 ?></span>
                                            </td>
                                            <td><?= h($expense->expense_date->format('d.m.Y')) ?></td>
                                            <td>
                                                <?php if ($expense->expense_category): ?>
                                                    <span class="badge" style="background-color: <?= h($expense->expense_category->color) ?>">
                                                        <i class="fas <?= h($expense->expense_category->icon) ?> me-1"></i>
                                                        <?= h($expense->expense_category->name) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary"><?= __('Uncategorized') ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= h($expense->title) ?></td>
                                            <td><?= h($expense->paid_by->name) ?></td>
                                            <td class="text-end">
                                                <strong class="text-primary"><?= number_format($expense->total, 2) ?> €</strong>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php //debug($expensesByCategory); ?>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (!empty($expensesByCategory)): ?>
            // Category Chart
            const categoryCtx = document.getElementById('categoryChart');
            if (categoryCtx) {
                new Chart(categoryCtx, {
                    type: 'doughnut',
                    data: {
                        labels: [
                            <?php
                            $locale = \Cake\I18n\I18n::getLocale();
                            foreach ($expensesByCategory as $item) {
                                if ($item['category_id']) {
                                    echo "'" . $item['category_name'] . "',";
                                } else {
                                    echo "'" . __('Uncategorized') . "',";
                                }
                            }
                            ?>
                        ],
                        datasets: [{
                            data: [<?php foreach ($expensesByCategory as $item) echo $item['total'] . ','; ?>],
                            backgroundColor: [
                                <?php foreach ($expensesByCategory as $item) {
                                    echo "'" . ($item['category_color'] ?? '#6c757d') . "',";
                                } ?>
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        aspectRatio: 2,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
        <?php endif; ?>

        <?php if (!empty($expensesByPerson)): ?>
            // Person Chart
            const personCtx = document.getElementById('personChart');
            if (personCtx) {
                new Chart(personCtx, {
                    type: 'bar',
                    data: {
                        labels: [<?php foreach ($expensesByPerson as $item) echo "'" . h($item['person_name']) . "',"; ?>],
                        datasets: [{
                            label: '<?= __('Amount') ?> (€)',
                            data: [<?php foreach ($expensesByPerson as $item) echo $item['total'] . ','; ?>],
                            backgroundColor: '#198754'
                        }]
                    },
                    options: {
                        responsive: true,
                        aspectRatio: 2,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        <?php endif; ?>

        <?php if (!empty($monthlyTrend)): ?>
            // Trend Chart
            const trendCtx = document.getElementById('trendChart');
            if (trendCtx) {
                new Chart(trendCtx, {
                    type: 'line',
                    data: {
                        labels: [<?php foreach ($monthlyTrend as $item) echo "'" . h($item['month']) . "',"; ?>],
                        datasets: [{
                            label: '<?= __('Amount') ?> (€)',
                            data: [<?php foreach ($monthlyTrend as $item) echo $item['total'] . ','; ?>],
                            borderColor: '#0dcaf0',
                            backgroundColor: 'rgba(13, 202, 240, 0.1)',
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        aspectRatio: 2,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        <?php endif; ?>
    });
</script>