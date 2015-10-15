<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\PaymentRequest;
use App\Http\Requests\ProductFrontRequest;

use App\Mailers\ContactMailer;
use App\Option;
use App\Repositories\CategoryRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\PhotoRepository;
use App\Repositories\ProductRepository;
use App\Tag;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;


class ProductsController extends Controller {

    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var PhotoRepository
     */
    private $photoRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var PaymentRepository
     */
    private $paymentRepository;
    /**
     * @var ContactMailer
     */
    private $mailer;

    /**
     * @param ProductRepository $productRepository
     * @param PhotoRepository $photoRepository
     * @param CategoryRepository $categoryRepository
     * @param PaymentRepository $paymentRepository
     * @param ContactMailer $mailer
     */
    function __construct(ProductRepository $productRepository, PhotoRepository $photoRepository, CategoryRepository $categoryRepository, PaymentRepository $paymentRepository, ContactMailer $mailer)
    {
        $this->productRepository = $productRepository;
        $this->middleware('auth', ['only' => ['create', 'store', 'edit', 'update','Paid','postPaid', 'destroy']]);
        $this->photoRepository = $photoRepository;
        $this->categoryRepository = $categoryRepository;
        $this->paymentRepository = $paymentRepository;
        $this->mailer = $mailer;

        $this->acquirerId = 99;
        $this->commerceId = 7574;
        $this->mallId = 1;
        $this->purchaseCurrencyCode = 188; //colones - 840 dolares
        $this->terminalCode = 00000000;
        $this->vectorInicializacion = "4760916219954089";
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param $category
     * @return Response
     */
    public function index(Request $request)
    {

        $search = array_add($request->all(), 'published', 1);

        $products = $this->productRepository->getall($search);
        $q = (isset($search['q'])) ? $search['q'] : '';

        return view('products.index')->with(compact('products', 'q'));
    }

    public function search(Request $request, $category = null)
    {

        $search = array_add($request->all(), 'published', 1);

        //if ($search['q'] == '') return view('categories.index');
        if (isset($search['q']) || ! $category)
            $products = $this->productRepository->getAll($search);
        else
            $products = $this->productRepository->findByCategory($category);

        $q = (isset($search['q'])) ? $search['q'] : '';

        return view('products.index')->with(compact('products', 'q', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        $categories_list = $this->categoryRepository->getParents();//Category::lists('name', 'id');
        $tags_list = Tag::select('icon','name', 'price', 'id')->get();
        $options_list = Option::select('name','description', 'price', 'id')->get();
        return View('products.create')->with(compact('categories_list', 'tags_list','options_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductFrontRequest $request
     * @return Response
     */
    public function store(ProductFrontRequest $request)
    {
        $input = $request->all();

        $product = $this->productRepository->store($input, Auth()->user());




        if ($product->option_id == 0 && $product->tags->count() == 0 )
        {
            $this->productRepository->update_state($product->id, 2);
            flash('Producto Creado correctamente');
            $this->mailer->newProductCreated(['user'=> Auth()->user(),'product' => $product, 'profile' => Auth()->user()->profile ]);
            return Redirect()->route('profile.show', Auth()->user()->username);
        }




        return Redirect()->route('product_payment',$product->id);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        $product = $this->productRepository->findById($id);

        $photos = $this->photoRepository->getPhotos($product->id);

        return view('products.show')->with(compact('product', 'photos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $product = $this->productRepository->findById($id);

        if (auth()->user()->id != $product->user_id) return redirect()->home();

        $categories_list = $this->categoryRepository->getParentsAndChildrenList(true);//Category::lists('name', 'id')->all();

        $tags_list = Tag::select('name', 'price', 'id')->get();
        $options_list = Option::select('name','description', 'price', 'id')->get();

        $selected_categories = $product->categories()->select('categories.id AS id')->lists('id')->all();
        $selected_tags = $product->tags()->select('tags.id AS id')->lists('id')->all();

        return view('products.edit')->with(compact('product', 'categories_list', 'tags_list','options_list', 'selected_categories', 'selected_tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param ProductFrontRequest $request
     * @return Response
     */
    public function update($id, ProductFrontRequest $request)
    {

        $this->productRepository->update($id, $request->all());

        Flash('Producto Actualizado');

        return Redirect()->route('profile.show', Auth()->user()->username);
    }

    /**
     * Get view for paid options
     * @param $productId
     * @return \Illuminate\View\View
     */
    public function payment($productId)
    {

        list($product, $items, $total) = $this->getPurchasedOptions($productId);



        return view('products.payment')->with(compact('product','items', 'total'));
    }



    /**
     * Post paid options
     * @param PaymentRequest $request
     * @return \Illuminate\View\View
     */
    public function purchase(PaymentRequest $request, $productId)
    {
        $input = $request->all();
        $purchaseOperationNumber = $this->getUniqueNumber();
        //$purchaseOperationNumber = $this->getToken(11);


        list($product, $items, $total) = $this->getPurchasedOptions($productId);


        $llaveVPOSCryptoPub = "-----BEGIN PUBLIC KEY-----\n".
            "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDTJt+hUZiShEKFfs7DShsXCkoq\n".
            "TEjv0SFkTM04qHyHFU90Da8Ep1F0gI2SFpCkLmQtsXKOrLrQTF0100dL/gDQlLt0\n".
            "Ut8kM/PRLEM5thMPqtPq6G1GTjqmcsPzUUL18+tYwN3xFi4XBog4Hdv0ml1SRkVO\n".
            "DRr1jPeilfsiFwiO8wIDAQAB\n".
            "-----END PUBLIC KEY-----";

        $llaveComercioFirmaPriv = "-----BEGIN RSA PRIVATE KEY-----\n".
            "MIICXAIBAAKBgQDI71jf/WkPdDuSPmArJFaxmvg1F+nQ7X26jkvVxDaFY57ZQlGq\n".
            "S1wxiHE8dr06mz0vGdW0PLVggNo0aOKQXLuvyiV9QxHYpd4VPjKglMItA2ae11Qg\n".
            "Xom0AoRDSR6+18lkFZpxXUY9KExjhL5dOIQXbnS7eVRjRfmrS5JnPeK8OwIDAQAB\n".
            "AoGAUpwUrgJBb1kaJMYAQ7xs6BgOc8WhG4SIbGqUQw6oW67ZX/kkGh9hh/vQkks/\n".
            "ARlRzkuQ0MkkyMgw7dsxSqjVgHTWaw0/Rh92VhXeFsi7GiGZgN0Zsnenujhye56Z\n".
            "h8KNJc1gAihWTPbRi2dxzXFUyr6yO2MDNRbk6JQLidnvQAECQQD75aiRZHybJWHE\n".
            "hL/rvpKYgcXiwZyKjj1fpTyjOw16PL2obpCHYjiuTF+ikTHRFv81GrgHLyvyVamb\n".
            "/xQd3miBAkEAzDUwyGHGKcRalIwCV/hTm6hSDUBG2wfCVwuHZdcqtrzpq79+P3aq\n".
            "W05vlF6Hf2yGGcKopAVd/t7+tmCSAklmuwJAePUo4tgr9ZwXvHQ6bIuQfWcjjOWH\n".
            "tAjlc742xfMfX6k3MWAWSsxhh2DpM3khQNQYLHnuEJUYNz/nOB9em5EnAQJBAMKt\n".
            "5u7x/6hr8Grzu3xAWvznkCnf4G0JzaWMcS2O3sLOAPtimSpJqAlaEpfhMs4xGPtQ\n".
            "D9Qm5cCIuU4HbMtPTOcCQFIFEnv4VvtGJwWPSIQr6jxpL4Z+NA3sy8gWcZwKnWzp\n".
            "72jjGx/YBW6qheLJUImAuVVS/7Tm6XztdkWMYT38fJo=\n".
            "-----END RSA PRIVATE KEY-----";


        $array_send['acquirerId']= $this->acquirerId;
        $array_send['commerceId']= $this->commerceId;
        $array_send['commerceMallId']= $this->mallId;
        $array_send['terminalCode']= $this->terminalCode;

        $array_send['purchaseAmount']= $total;
        $array_send['purchaseCurrencyCode']= $this->purchaseCurrencyCode;
        $array_send['purchaseOperationNumber']= $purchaseOperationNumber;

        $array_send['billingAddress']=  $input["address"];
        $array_send['billingCity']= $input["city"];
        $array_send['billingState']= $input["state"];
        $array_send['billingCountry']= $input["country"];
        $array_send['billingZIP']= $input["zipcode"];

        $array_send['billingPhone']= $input["telephone"];
        $array_send['billingEMail']= $input["email"];
        $array_send['billingFirstName']= $input["first_name"];
        $array_send['billingLastName']= $input["last_name"];
        $array_send['language']= "SP"; //En español

        //Setear un arreglo de cadenas con los parámetros que serán devueltos //por el componente
        $array_get['XMLREQ']="";
        $array_get['DIGITALSIGN']="";
        $array_get['SESSIONKEY']="";



        VPOSSend($array_send,$array_get,$llaveVPOSCryptoPub,$llaveComercioFirmaPriv,$this->vectorInicializacion);

        $idAcquirer = $this->acquirerId;
        $idCommerce = $this->commerceId;


        return view('products.purchase')->with(compact('product','items', 'total','input','array_get','idAcquirer','idCommerce'));

    }

    public function purchaseResponse(Request $request)
    {
        $input = $request->all();
        //dd($input);

        //list($product, $items, $total) = $this->getPurchasedOptions($input["product_id"]);


        $llaveVPOSSignaturePub = "-----BEGIN PUBLIC KEY-----\n".
            "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCvJS8zLPeePN+fbJeIvp/jjvLW\n".
            "Aedyx8UcfS1eM/a+Vv2yHTxCLy79dEIygDVE6CTKbP1eqwsxRg2Z/dI+/e14WDRs\n".
            "g0QzDdjVFIuXLKJ0zIgDw6kQd1ovbqpdTn4wnnvwUCNpBASitdjpTcNTKONfXMtH\n".
            "pIs4aIDXarTYJGWlyQIDAQAB\n".
            "-----END PUBLIC KEY-----";

        $llaveComercioCifradoPriv = "-----BEGIN RSA PRIVATE KEY-----\n".
            "MIICXQIBAAKBgQCr3xnDYPtCdJ1X/OtLGp01EPkAd2cOieqLKXSrbdNHuOLkpBMY\n".
            "xw89IrWVKFDJREiaGTJ79FYvgzGSmo2FT/SW1Ecv3TIqIM75eMomWQho7l5s9Qsa\n".
            "1xfx3FZrUnnYS2MUAJfTTXww8SPB8RkRPRk8zOUh0IvvpI9xJFywPhII1wIDAQAB\n".
            "AoGAAWiFlIVB6cx80ZC/+NCSAzJNaASScpsMsfE4BIOU3JyWN1tk0Koo5M5ZAIzh\n".
            "BJUrpx+Xu05IOoFvsYzUpgf+sA5COAWogqjs8OD7M5zJu66lnAmb6KwJ9bpL4aOx\n".
            "rR/ZfjzRK1am7C4LH4MSwUa2YxVbkf5EKhyuWU21+61dp0kCQQDcBn7CzRonTpTg\n".
            "9DcwPCowfi/QdTYw7x4cedBG/h+Bm7b7hF8qGWtQyOez8Tm0ciYt7sWBGHLYnQLq\n".
            "UwSAfyUVAkEAx/kMsUMQPlcC5u7q37HNGb6Kvpeqg4jCdxwKUtdWzzR9xAw6ijvC\n".
            "yEFSR4Qo1JyyoYLTkaPuzpZuMsASEcvJOwJBAL3LDIVVDv5hFqOFhiWhgHMcJnqW\n".
            "4QwM99hwa20RwHO4snr7kGtsSdoBs3zQ1IoG/VAZ61yUjlyz89PVkMiW5JECQQCQ\n".
            "Gb21tvfrlFP5Cc2i6MM9e/sLIMu1AUXxAvnFfHuH0PGX5qAAoNPZ7ohWFLw/ibOH\n".
            "g3jmCFW79NbwJ0xeGpWlAkBb+equG3spXxEIO8JI8Z3CA9jvPpXKchqSifLxfRPi\n".
            "zwd0jVnxjJ5uJGOUZkfvLWCG4bdiAWdn3pDGTugkgiW3\n".
            "-----END RSA PRIVATE KEY-----";

        $arrayIn['IDACQUIRER'] = (isset($input['IDACQUIRER'])) ? $input['IDACQUIRER'] : "";
        $arrayIn['IDCOMMERCE'] = (isset($input['IDCOMMERCE'])) ? $input['IDCOMMERCE'] : "";
        $arrayIn['XMLRES'] = (isset($input["XMLRES"])) ? $input["XMLRES"] : "";
        $arrayIn['DIGITALSIGN']=  (isset($input["DIGITALSIGN"])) ? $input["DIGITALSIGN"] : "";
        $arrayIn['SESSIONKEY']= (isset($input['SESSIONKEY'])) ? $input['SESSIONKEY'] : "";

        $arrayOut= "";

        if(VPOSResponse($arrayIn,$arrayOut,$llaveVPOSSignaturePub,$llaveComercioCifradoPriv ,$this->vectorInicializacion)){
            //$arrayOut['authorizationResult']= $resultadoAutorizacion;
            //$arrayOut['authorizationCode']= $codigoAutorizacion;
            //dd($arrayOut);
            flash('ok');
        }else{
         //Puede haber un problema de mala configuración de las llaves
         //vector deinicializacion o el VPOS no ha enviado valores correctos
            //dd("Puede haber un problema de mala configuración de las llaves o vector deinicializacion o el VPOS no ha enviado valores correctos");
            //flash('ok');
           flash('Puede haber un problema de mala configuración de las llaves o vector de inicializacion o el VPOS no ha enviado valores correctos');
        }


        return view('products.purchase-response')->with(compact('input','arrayOut'));

    }
    /**
     * Post paid options
     * @param PaymentRequest $request
     * @return \Illuminate\View\View
     */
    public function postPayment(PaymentRequest $request)
    {
        $input = $request->all();

        $payment = $this->paymentRepository->store($input);

        flash('Producto Creado correctamente');

        return Redirect()->route('profile.show', Auth()->user()->username);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->productRepository->destroy($id);

        Flash('Producto Eliminado');

        return Redirect()->route('profile.show', Auth()->user()->username);
    }

    /**
     *Save one product in your favorites
     * @param $productId
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveFavorites($productId, Request $request)
    {

        $user = auth()->user();

        $productIds = $user->favorites()->lists('product_id')->all();
        $productIds[] = $productId;
        //dd($productIds);
        $user->favorites()->sync($productIds);

        //flash('Propiedad Guardada en tus favoritos!');

        //return Redirect()->route('profile_favorites', $user->username);

    }

    /**
     *Delete one product from favorites
     * @param $productId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteFavorites($productId)
    {
        $user = auth()->user();

        $user->favorites()->detach($productId);

        //flash('Propiedad eliminada de tus favoritos!');

        //return Redirect()->route('profile_favorites', $user->username);
    }

    /**
     * @param $productId
     * @return array
     */
    private function getPurchasedOptions($productId)
    {
        $product = $this->productRepository->findById($productId);
        $option = ($product->option_id) ? Option::findOrFail($product->option_id) : null;
        $items = [];
        $total = 0;
        if ($option) {
            $optionItem = [

                'name' => $option->name,
                'price' => $option->price,
                'priceDollar' => number_format($option->price / 530, 2)
            ];

            if ($product->option_id == 4) {
                $priceTag = ($product->tags->count()) ? $product->tags->first()->price : 0;
                $optionItem['price'] = $priceTag;
                $optionItem['priceDollar'] = number_format($option->price / 530, 2);
                $optionItem['name'] .= ($product->tags->count()) ? ' Etiqueta: ' . $product->tags->first()->name : 'No escogio etiqueta';

            }


            $items[] = $optionItem;

        }

        foreach ($items as $item) {
            $total += $item['price'];
        }
        return array($product, $items, $total);
    }
    private function crypto_rand_secure($min, $max) {
        $range = $max - $min;
        if ($range < 0) return $min; // not so random...
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    private function getToken($length){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        for($i=0;$i<$length;$i++){
            $token .= $codeAlphabet[$this->crypto_rand_secure(0,strlen($codeAlphabet))];
        }
        return $token;
    }

    /**
     * @return string
     */
    private function getUniqueNumber()
    {
        $d = date("d");
        $m = date("m");
        $y = date("Y");
        $t = time();
        $dmt = $d + $m + $y + $t;
        $ran = rand(0, 10000000);
        $dmtran = $dmt + $ran;
        $un = uniqid();
        $dmtun = $dmt . $un;
        $mdun = md5($dmtran . $un);
        $sort = substr($mdun, 21);
        return $sort;
    }
}
