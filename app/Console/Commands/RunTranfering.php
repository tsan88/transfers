<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\Transfer;
use \App\Account;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class RunTranfering extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfering:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Running planned transfers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Start transfering...');
        // Get transfers with status {...} and executed_date is empty
        $transfers = $this->getTransferToRun();
        $this->info('Transfers to run: (' . count($transfers) . ') items.id: [' . implode(',', $transfers->pluck('id')->values()->toArray()) . ']');

        // Update transfer status to 'executing'
        $transfers->each(function ($transfer) {
            $this->info('The transfer(' . $transfer->id . ') starting...');
            $transfer->status = 'executing';
            $transfer->save();
        });

        // Update Accounts
        $transfers->each(function ($transfer) {
            $this->info('The transfer(' . $transfer->id . ') from ' . $transfer->accountOwner->id . ' to ' . $transfer->recipient->id . ', summ ' . $transfer->value . ' executing...');
            $transfer->accountOwner->value -= $transfer->value;
            $transfer->recipient->value += $transfer->value;

            if ($transfer->accountOwner->value < 0) {
                $this->error('Account ' . $transfer->accountOwner->id . ' will less then 0 by run the trunsfer ' . $transfer->id);
                return false;
            }

            $transfer->accountOwner->save();
            $transfer->recipient->save();
        });

        // Update transfer status and set executed_date
        $transfers->each(function ($transfer) {
            $transfer->status = 'completed';
            $transfer->save();
            $this->info('The transfer(' . $transfer->id . ') is done!');
        });

        $this->info('Transfering successfull!');
    }

    private function getTransferToRun(): Collection
    {
        return Transfer::with('accountOwner', 'recipient')
            ->where('status', 'planned')
            ->where('plane_date', '<=', Carbon::now())
            ->get();
    }
}
