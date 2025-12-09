<?php

declare(strict_types=1);

namespace App\Controller;

class DashboardController extends AppController {
    public function index() {
        // Pridobi vse osebe
        $peopleTable = $this->fetchTable('People');
        $balances = $peopleTable->getBalances();

        $suggestedSettlements = $peopleTable->getSuggestedSettlements();        

        $this->set(compact('balances', 'suggestedSettlements'));
    }
}
