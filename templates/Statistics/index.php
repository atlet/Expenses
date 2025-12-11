<?php

/**
 * templates/Statistics/index.php
 *
 * Expects variables set by `StatisticsController::index()`:
 * - $totalExpenses (int)
 * - $totalAmount (object/array with key 'total' or numeric)
 * - $paidExpenses (int)
 * - $unpaidExpenses (int)
 * - $expensesByCategory (array)
 * - $expensesByPerson (array)
 * - $monthlyTrend (array)
 * - $topExpenses (array of Entities)
 */

$totalAmountValue = 0;
if (isset($totalAmount)) {
    if (is_object($totalAmount) && isset($totalAmount->total)) {
        $totalAmountValue = $totalAmount->total;
    } elseif (is_array($totalAmount) && isset($totalAmount['total'])) {
        $totalAmountValue = $totalAmount['total'];
    } else {
        $totalAmountValue = (float)$totalAmount;
    }
}

$categoryLabels = [];
$categoryTotals = [];
$categoryColors = [];

foreach ($expensesByCategory ?? [] as $c) {
    $label = $c['category_name'] ?? ($c['category_name_en'] ?? ('#' . ($c['category_id'] ?? '')));
    $categoryLabels[] = $label;
    $categoryTotals[] = (float)($c['total'] ?? 0);
    $color = $c['category_color'] ?? null;
    if (!$color) {
        // fallback color palette
        $palette = ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1', '#17a2b8', '#fd7e14', '#20c997'];
        $idx = count($categoryColors) % count($palette);
        $color = $palette[$idx];
    }
    $categoryColors[] = $color;
}

$personLabels = [];
$personTotals = [];
foreach ($expensesByPerson ?? [] as $p) {
    $personLabels[] = $p['person_name'] ?? ('#' . ($p['person_id'] ?? ''));
    $personTotals[] = (float)($p['total'] ?? 0);
}

$monthlyLabels = [];
$monthlyTotals = [];
foreach ($monthlyTrend ?? [] as $m) {
    // Expecting 'month' like YYYY-MM
    $monthlyLabels[] = $m['month'];
    $monthlyTotals[] = (float)($m['total'] ?? 0);
}
?>

<!-- Add this style block near the top of templates/Statistics/index.php -->
<style>
    /* Chart wrapper ensures canvas cannot grow indefinitely */
    .chart-wrapper {
        position: relative;
        width: 100%;
        height: 180px;
        /* default height for larger charts */
        max-height: 360px;
    }

    /* Smaller chart height (people chart) */
    .chart-wrapper.chart-small {
        height: 140px;
        max-height: 240px;
    }

    /* Ensure canvas fills the wrapper */
    .chart-wrapper canvas {
        width: 100% !important;
        height: 100% !important;
    }
</style>

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
                    <h2 class="mb-0"><?= number_format($totalAmountValue, 2) ?></h2>
                    <p class="text-muted mb-0"><?= __('Total Amount') ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-3x text-info mb-3"></i>
                    <h2 class="mb-0"><?= number_format($paidExpenses) ?></h2>
                    <p class="text-muted mb-0"><?= __('Paid Expenses') ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="fas fa-exclamation-circle fa-3x text-warning mb-3"></i>
                    <h2 class="mb-0"><?= number_format($unpaidExpenses) ?></h2>
                    <p class="text-muted mb-0"><?= __('Unpaid Expenses') ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-lg-6 mb-3">
            <div class="card h-100">
                <div class="card-header">
                    <strong><?= __('Monthly Trend (last 12 months)') ?></strong>
                </div>
                <div class="card-body">
                    <div class="chart-wrapper">
                        <canvas id="monthlyTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-3">
            <div class="card mb-3">
                <div class="card-header">
                    <strong><?= __('Expenses by Category') ?></strong>
                </div>
                <div class="card-body">
                    <canvas id="categoriesChart" height="180"></canvas>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <strong><?= __('Expenses by Person') ?></strong>
                </div>
                <div class="card-body">
                    <canvas id="peopleChart" height="140"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Expenses -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <strong><?= __('Top 10 Expenses') ?></strong>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th><?= __('Date') ?></th>
                                    <th><?= __('Category') ?></th>
                                    <th><?= __('Person') ?></th>
                                    <th><?= __('Description') ?></th>
                                    <th class="text-end"><?= __('Amount') ?></th>
                                    <th><?= __('Status') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($topExpenses as $e):
                                    $amount = (float)($e->total ?? ($e->amount + ($e->commission ?? 0)));
                                    $cat = $e->expense_category ? ($e->expense_category->name ?? $e->expense_category->name_en ?? '') : ($e->expense_category_id ?? '');
                                    $person = $e->paid_by ? ($e->paid_by->name ?? '') : ($e->paid_by_id ?? '');
                                    $desc = $e->title ?? $e->description ?? $e->note ?? '';
                                    if (!empty($e->expense_date)) {
                                        if (is_object($e->expense_date) && method_exists($e->expense_date, 'format')) {
                                            $date = $e->expense_date->format('Y-m-d');
                                        } else {
                                            $date = (string)$e->expense_date;
                                        }
                                    } else {
                                        $date = '';
                                    }
                                    $paid = !empty($e->is_paid);
                                ?>
                                    <tr>
                                        <td><?= h($date) ?></td>
                                        <td><?= h($cat) ?></td>
                                        <td><?= h($person) ?></td>
                                        <td><?= h($desc) ?></td>
                                        <td class="text-end"><?= number_format($amount, 2) ?> €</td>
                                        <td>
                                            <?php if ($paid): ?>
                                                <span class="badge bg-success"><?= __('Paid') ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark"><?= __('Unpaid') ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if (empty($topExpenses)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted"><?= __('No expenses found.') ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function() {
        // Data prepared in PHP, safe to JSON encode
        const monthlyLabels = <?= json_encode($monthlyLabels) ?>;
        const monthlyTotals = <?= json_encode($monthlyTotals) ?>;

        const categoryLabels = <?= json_encode($categoryLabels) ?>;
        const categoryTotals = <?= json_encode($categoryTotals) ?>;
        const categoryColors = <?= json_encode($categoryColors) ?>;

        const personLabels = <?= json_encode($personLabels) ?>;
        const personTotals = <?= json_encode($personTotals) ?>;

        // Monthly Trend - Line chart
        const ctxMonthly = document.getElementById('monthlyTrendChart').getContext('2d');
        new Chart(ctxMonthly, {
            type: 'line',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Amount',
                    data: monthlyTotals,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0,123,255,0.08)',
                    fill: true,
                    tension: 0.2,
                    pointRadius: 3,
                    pointBackgroundColor: '#007bff'
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            callback: v => v + ' €'
                        },
                        beginAtZero: true
                    }
                },
                maintainAspectRatio: false
            }
        });

        // Categories - Pie chart
        const ctxCat = document.getElementById('categoriesChart').getContext('2d');
        new Chart(ctxCat, {
            type: 'pie',
            data: {
                labels: categoryLabels,
                datasets: [{
                    data: categoryTotals,
                    backgroundColor: categoryColors
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'right'
                    }
                },
                maintainAspectRatio: false
            }
        });

        // People - Horizontal bar chart
        const ctxPeople = document.getElementById('peopleChart').getContext('2d');
        new Chart(ctxPeople, {
            type: 'bar',
            data: {
                labels: personLabels,
                datasets: [{
                    label: 'Amount',
                    data: personTotals,
                    backgroundColor: '#17a2b8'
                }]
            },
            options: {
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            callback: v => v + ' €'
                        },
                        beginAtZero: true
                    }
                },
                maintainAspectRatio: false
            }
        });
    })();
</script>