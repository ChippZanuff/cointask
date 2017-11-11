<?php

namespace App\Console\Commands;

use App\Coin;
use App\Entity\BitcoinExchangeRate;
use App\Repositories\BitcoinRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BitcoinExchangeRateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'script:bitcoin-exchange-rate-saver';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var BitcoinRepositoryInterface
     */
    private $bitcoinRepository;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(BitcoinRepositoryInterface $bitcoinRepository)
    {
        parent::__construct();
        $this->bitcoinRepository = $bitcoinRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $time_start = microtime(true);
        $result = $this->bitcoinRepository->getExchangeRates();
        $this->output->progressStart(count($result));

        $name = \config('app.bitcoin_exchange_rate_provider_name');

        Log::info('Provider name: ' . $name);

        array_reduce($result, function($carry, BitcoinExchangeRate $bitcoinExchangeRate){
            Log::info('found currency: ' . $bitcoinExchangeRate->getCurrency() . ' exchange rate: ' . $bitcoinExchangeRate->getExchangeRate());
            Coin::create($bitcoinExchangeRate->toArray());
            $this->output->progressAdvance();
        });

        $this->output->progressFinish();

        $time_end = microtime(true);
        $time = $time_end - $time_start;
        Log::info('Script execution time is: ' . $time);
    }
}
