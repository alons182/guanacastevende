<?php

namespace App\Console\Commands;

use App\Product;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckDays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'guanacastevende:checkDays';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica que un articulo halla cumplido los 30 dias gratis';

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
        $products = Product::all();
        $countInactive = 0;

        foreach($products as $product)
        {
            $differenceDays = $product->created_at->diffInDays(Carbon::now());

            if($differenceDays >= 30)
            {
                $product->published = 0;
                $product->save();
                $countInactive++;
            }

        }

        $this->info('Done, ' . $countInactive.' Inactive Products' );
    }
}
