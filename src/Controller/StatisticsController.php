<?php

declare(strict_types=1);

namespace App\Controller;

class StatisticsController extends AppController {
    public function index() {
        $expensesTable = $this->fetchTable('Expenses');
        $peopleTable = $this->fetchTable('People');

        // Osnovne statistike
        $totalExpenses = $expensesTable->find()->count();
        $totalAmount = $expensesTable->find()
            ->select(['total' => 'SUM(amount + commission)'])
            ->first();

        $paidExpenses = $expensesTable->find()
            ->where(['is_paid' => true])
            ->count();

        $unpaidExpenses = $expensesTable->find()
            ->where(['is_paid' => false])
            ->count();

        // Stroški po kategorijah
        $expensesByCategory = $expensesTable->find()
            ->select([
                'category_id' => 'expense_category_id',
                'category_name' => 'expense_categories.name',
                'category_color' => 'expense_categories.color',
                'category_icon' => 'expense_categories.icon',
                'total' => 'SUM(Expenses.amount + Expenses.commission)',
                'count' => 'COUNT(Expenses.id)',
            ])
            ->leftJoin('expense_categories', ['expense_categories.id = Expenses.expense_category_id'])
            ->group(['expense_category_id'])
            ->order(['total' => 'DESC'])
            ->toArray();

        // Stroški po osebah
        $expensesByPerson = $expensesTable->find()
            ->select([
                'person_id' => 'paid_by_id',
                'person_name' => 'PaidBy.name',
                'total' => 'SUM(Expenses.amount + Expenses.commission)',
                'count' => 'COUNT(Expenses.id)',
            ])
            ->contain(['PaidBy'])
            ->group(['paid_by_id'])
            ->order(['total' => 'DESC'])
            ->toArray();

        // Mesečni trend (zadnjih 12 mesecev)
        $monthlyTrend = $expensesTable->find()
            ->select([
                'month' => "strftime('%Y-%m', expense_date)",
                'total' => 'SUM(amount + commission)',
                'count' => 'COUNT(id)',
            ])
            ->where([
                'expense_date >=' => date('Y-m-d', strtotime('-12 months')),
            ])
            ->group(["strftime('%Y-%m', expense_date)"])
            ->order(['month' => 'ASC'])
            ->toArray();

        // Top 10 največjih stroškov
        $topExpenses = $expensesTable->find()
            ->contain(['PaidBy', 'ExpenseCategories'])
            ->select($expensesTable)
            ->select(['total' => '(Expenses.amount + Expenses.commission)'])
            ->select(['PaidBy.name'])
            ->order(['total' => 'DESC'])
            ->limit(10)
            ->toArray();

        $this->set(compact(
            'totalExpenses',
            'totalAmount',
            'paidExpenses',
            'unpaidExpenses',
            'expensesByCategory',
            'expensesByPerson',
            'monthlyTrend',
            'topExpenses'
        ));
    }
}
