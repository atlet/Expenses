<?php
declare(strict_types=1);
namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use App\Service\RecurringExpenseGenerator;

class RecurringExpensesGenerateCommand extends Command
{
    public static function defaultName(): string
    {
        return 'recurring_expenses generate';
    }

    public function execute(Arguments $args, ConsoleIo $io): ?int
    {
        $added = $skipped = $errors = 0;
        $generator = new RecurringExpenseGenerator();
        foreach ($this->fetchTable('RecurringExpenses')->find()->where(['is_active' => true])->all() as $item) {
            try {
                if ($generator->generate((int)$item->id)) {
                    $added++;
                } else {
                    $skipped++;
                }
            } catch (\Throwable $e) {
                $errors++;
                $io->err("Recurring expense {$item->id}: {$e->getMessage()}");
            }
        }
        $io->out("Added: $added; skipped: $skipped; errors: $errors");
        return $errors ? static::CODE_ERROR : static::CODE_SUCCESS;
    }
}
