<?php

namespace App\Console\Commands;

use App\Product;
use Carbon\Carbon;
use App\Mailers\ContactMailer;
use Illuminate\Console\Command;
use App\Repositories\ProductRepository;

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
    public function __construct(ContactMailer $mailer, ProductRepository $productRepository)
    {
        $this->mailer = $mailer;
        $this->productRepository = $productRepository;
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
        $countDeleted = 0;
        $arrProductsIna = [];
        $arrProductsDel = [];
        foreach($products as $product)
        {
            $differenceDays = $product->created_at->diffInDays(Carbon::now());

            if($differenceDays >= 30 && $product->published == 1)
            {
                $product->published = 0;
                $product->save();
                $countInactive++;
                $arrProductsIna[]= $product->name;
            }
            /*if($differenceDays >= 60 && $product->published == 0)
            {
                $arrProductsDel[]= $product->name;
                $this->productRepository->destroy($product->id);
                $countDeleted++;
            }*/

        }

        $this->info('Done, ' . $countInactive.' Inactive Products - '.$countDeleted.' Delete Products' );
       
        try {
            $this->mailer->infoProductsInnactive(['productsIna'=> $arrProductsIna, 'productsDel'=> $arrProductsDel, 'innactives' => $countInactive,'deleted' => $countDeleted ]);
        }catch (Swift_RfcComplianceException $e)
        {
            Log::error($e->getMessage());
        }
    }
}
