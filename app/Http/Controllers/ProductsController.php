<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Option;
use App\Comment;
use App\Category;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Mailers\ContactMailer;
use Swift_RfcComplianceException;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Repositories\PhotoRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Http\Requests\CommentFrontRequest;
use App\Http\Requests\ProductFrontRequest;
use PayPal\PayPalAPI\SetExpressCheckoutReq;
use PayPal\CoreComponentTypes\BasicAmountType;
use PayPal\EBLBaseComponents\PaymentDetailsType;
use PayPal\PayPalAPI\DoExpressCheckoutPaymentReq;
use PayPal\PayPalAPI\GetExpressCheckoutDetailsReq;
use PayPal\PayPalAPI\SetExpressCheckoutRequestType;
use PayPal\EBLBaseComponents\PaymentDetailsItemType;
use PayPal\Service\PayPalAPIInterfaceServiceService;
use PayPal\PayPalAPI\DoExpressCheckoutPaymentRequestType;
use PayPal\PayPalAPI\GetExpressCheckoutDetailsRequestType;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use PayPal\EBLBaseComponents\SetExpressCheckoutRequestDetailsType;
use PayPal\EBLBaseComponents\DoExpressCheckoutPaymentRequestDetailsType;


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

        $this->acquirerId = 12;//99;
        $this->commerceId = 6221;//7574;
        $this->mallId = 1;
        $this->purchaseCurrencyCode = 188; //colones - 840 dolares
        $this->terminalCode = 00000000;
        $this->vectorInicializacion = "3293707751578678";//"4760916219954089";

        //paypal
        $this->modeApiPaypal = "live";
        $this->userApiPaypal = "oporto_api1.avotz.com";
        $this->passwordApiPaypal = "QFPRMSAFMD9PF39Y";
        $this->signatureApiPaypal = "AhGNifOfpUYJzHqWRIdZJhJXCY44AKAInw3g1Cymr8yFklI034BgKdUs";

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

        $search = array_add($request->all(), 'published', [1,4]);

        $products = $this->productRepository->getall($search);
        $q = (isset($search['q'])) ? $search['q'] : '';

        return view('products.index')->with(compact('products', 'q'));
    }

    public function search(Request $request, $category = null)
    {

        $search = array_add($request->all(), 'published', [1,4]);

        //if ($search['q'] == '') return view('categories.index');
        if (isset($search['q']) || ! $category)
            $products = $this->productRepository->getAll($search);
        else
            list($products, $category) = $this->productRepository->findByCategory($category);

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
            $this->productRepository->update_state($product->id, 2); // 0:inactivo 1:publicado 2:en espera 3:inactivo(pago rechazado o denegado)
            flash('Producto Creado correctamente');

            try {
                $this->mailer->newProductCreated(['user'=> Auth()->user(),'product' => $product, 'profile' => Auth()->user()->profile ]);
            }catch (Swift_RfcComplianceException $e)
            {
                Log::error($e->getMessage());
            }


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
        $product = $this->productRepository->publishedOrSelledById($id);
        $comments = $product->comments()->where('comment_id', '=', 0)->paginate(5);
        $photos = $this->photoRepository->getPhotos($product->id);

        if(Auth()->user() /*&& Auth()->user()->id == $product->user_id*/)
        {
            $commentsNotViewed = $product->comments()->notViewed()->where('user_id', '=', Auth()->user()->id)->get();
            foreach ($commentsNotViewed  as $comment) {
                $comment->viewed = true;
                $comment->save();
            }
        }
     
        return view('products.show')->with(compact('product', 'photos','comments'));
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
     * Purchase VPOS
     * @param PaymentRequest $request
     * @param $productId
     * @return $this
     */
    public function purchase(PaymentRequest $request, $productId)
    {
        $input = $request->all();
        $purchaseOperationNumber = $this->getUniqueNumber();
        //$purchaseOperationNumber = $this->getToken(11);


        list($product, $items, $total, $totalDollar) = $this->getPurchasedOptions($productId);

        $llaveVPOSCryptoPub = "-----BEGIN PUBLIC KEY-----\n".
            "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC0t0Cnbne8gQoeGK4nG6O3zfwh\n".
            "q8u9Wp5zHjyVYbvx2zudSOlBnJ5qU74BcTGypbn6W7jjvSNE7AmncOAVh4RxuRXO\n".
            "+bINFIyQ7/ErH/v1YpDFk8knC/NuvFpfHqhJ/5j2I8y+WmyF0MZmGtm074nUGv4d\n".
            "qlbUMT9aYUQ+RzMO7QIDAQAB\n".
            "-----END PUBLIC KEY-----";
        /*llave testing*/
        /*$llaveVPOSCryptoPub = "-----BEGIN PUBLIC KEY-----\n".
            "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDTJt+hUZiShEKFfs7DShsXCkoq\n".
            "TEjv0SFkTM04qHyHFU90Da8Ep1F0gI2SFpCkLmQtsXKOrLrQTF0100dL/gDQlLt0\n".
            "Ut8kM/PRLEM5thMPqtPq6G1GTjqmcsPzUUL18+tYwN3xFi4XBog4Hdv0ml1SRkVO\n".
            "DRr1jPeilfsiFwiO8wIDAQAB\n".
            "-----END PUBLIC KEY-----";*/

        $llaveComercioFirmaPriv = "-----BEGIN RSA PRIVATE KEY-----\n".
            "MIICWwIBAAKBgQC5mWVuDSSaRIT7P5C+5kFprVUDzVt8dt0GFSI7yvpNf2yRoKGi\n".
            "ezftNyfXVnz5WeX8bZGQgo6HEWZUQQGLwZ5XqC9hZ0gYH8m3sfpWCGO7S8NnTdls\n".
            "UYUjmlQL/vGGLEyNLUWwejtbidOPklQQdo0NQqUfEJQG2QtvX12z2ScgiwIDAQAB\n".
            "AoGAX9b4a5XZ2tebG+q9IfbgvGNHTUlT/readrOfE+VCz5YHSEP8c1zRims65ZXB\n".
            "vzlO68TgsBDa7KBtiQBwfeyjiJskuYZLEyfktC5i01SEoS8/VepC6mkuOYj3h7zp\n".
            "DD7vQy6VwuPghOp/lhOlS1WQrKJ/0U8mDpjpshuBhZjoB4ECQQDeUfEbCelRI/fO\n".
            "lwn2+/zIQU4d4oN4zKPrJZQSOanERdafwQljLp8Uyi7mGlzrcGxDGzM4prp97OlL\n".
            "ghmERQFrAkEA1bdWpXCRJ4Rb6B2dUP5IAhb10YmNFnFXT46vNAQOwZgp5gBWWT6B\n".
            "R4ofRnycLXKD9N6KORdMdFo3L2koZA+FYQJAVbkW1KwvsL/Dr38BsqBbSgQUUOWk\n".
            "eBHAKs1kmNpvIWUkapkOO5YgdO24w7Tqm0XQGNgGGhP/2Mpe8mSJ3jyVXQJANCS1\n".
            "WUwrvk6G9g0zsu03uHrNo0BCUjV5LgoMKU7MIuPzZRC0ALZFaKUEmHgSyuvj0jzx\n".
            "0JgkqUbRrBmmJzO6QQJASvj9N11j7DRNRoQdxFy0LX1hXVJfCXKewxF7QmKUVG1F\n".
            "m08UwlregO0uKRDERRxx/jYWXB2Zw4dWZ5XuMRFnrw==\n".
            "-----END RSA PRIVATE KEY-----";
        /*llave testing*/
        /*$llaveComercioFirmaPriv = "-----BEGIN RSA PRIVATE KEY-----\n".
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
            "-----END RSA PRIVATE KEY-----";*/

        //$total = "75";
        $array_send['acquirerId']= $this->acquirerId;
        $array_send['commerceId']= $this->commerceId;
        $array_send['commerceMallId']= $this->mallId;
        $array_send['terminalCode']= $this->terminalCode;

        $array_send['purchaseAmount']= $total . "00";
        $array_send['purchaseCurrencyCode']= $this->purchaseCurrencyCode;
        $array_send['purchaseOperationNumber']= $purchaseOperationNumber;


        $array_send['billingAddress']=  $input["address"];
        $array_send['billingCity']= $input["city"];
        $array_send['billingState']= $input["state"];
        $array_send['billingCountry']= $input["country"];
        $array_send['billingZIP']= ($input["zipcode"]=="") ? "50101" : $input["zipcode"];

        $array_send['billingPhone']= $input["telephone"];
        $array_send['billingEMail']= $input["email"];
        $array_send['billingFirstName']= $input["first_name"];
        $array_send['billingLastName']= $input["last_name"];
        $array_send['language']= "SP"; //En español
        $array_send['reserved2']= $productId;


        //Setear un arreglo de cadenas con los parámetros que serán devueltos //por el componente
        $array_get['XMLREQ']="";
        $array_get['DIGITALSIGN']="";
        $array_get['SESSIONKEY']="";



        VPOSSend($array_send,$array_get,$llaveVPOSCryptoPub,$llaveComercioFirmaPriv,$this->vectorInicializacion);

        $idAcquirer = $this->acquirerId;
        $idCommerce = $this->commerceId;

        $paymentMethod = 1;

        return view('products.purchase')->with(compact('product','items', 'total','input','array_get','idAcquirer','idCommerce','paymentMethod'));

    }


    /**
     * Purchase VPOS Response
     * @param Request $request
     * @return $this
     */
    public function purchaseResponse(Request $request)
    {
        $input = $request->all();


        $llaveVPOSSignaturePub = "-----BEGIN PUBLIC KEY-----\n".
            "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCtvXnikeSS+H/Qs/51iL3ZYPfz\n".
            "KW94WUAz7IdZIOIcuG1zLIR3kUNUc/vdSmW120dwkIleB6pl4cVT5nDewBFJCzTS\n".
            "W6jGaWaryzl7xS3ZToKTHpVeQr3avN7H+Om9TfsccY7gBV3IOIauTg9xIpDjIg52\n".
            "fUcfyPq+Bhw0cWkDUQIDAQAB\n".
            "-----END PUBLIC KEY-----";
        /*llave testing*/
        /*$llaveVPOSSignaturePub = "-----BEGIN PUBLIC KEY-----\n".
            "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCvJS8zLPeePN+fbJeIvp/jjvLW\n".
            "Aedyx8UcfS1eM/a+Vv2yHTxCLy79dEIygDVE6CTKbP1eqwsxRg2Z/dI+/e14WDRs\n".
            "g0QzDdjVFIuXLKJ0zIgDw6kQd1ovbqpdTn4wnnvwUCNpBASitdjpTcNTKONfXMtH\n".
            "pIs4aIDXarTYJGWlyQIDAQAB\n".
            "-----END PUBLIC KEY-----";*/

        $llaveComercioCifradoPriv = "-----BEGIN RSA PRIVATE KEY-----\n".
            "MIICXQIBAAKBgQDUFykzdsyPZyhb+O+dV4j6pokD7kqV3GSu0hNsxf3VCBCLO6Tb\n".
            "Ozg/TNoOx9cjFbYBRieHhPB61BN/hh0GVSyxF8QJ1gG7QzK5eMtFrgeANrEzlo2J\n".
            "Tvm6G6dXbGP1ojdlbVsaYdp72b8HNdpWDqEmqGnpoBgZVDe32+5ZPE0NCwIDAQAB\n".
            "AoGAdAEvEe0auh0MYDHqrb7hN2e7baD6vrlLgKt64HXy/oBovB8lbpwXidf5NTht\n".
            "Hc2UPWIn4OH/vs8c0xWB7qLLzBlnuW2IXd3tdQW6smkk7CkULfyWhiGQCg0d0cRt\n".
            "Rlc/AETHRkWpkNW6UkpVfRJ+gwz9HDlwKZip6hwq8DKzexECQQD/FKdBvEmskafZ\n".
            "zn08tKXXbX97Q7ipCf3yKe72RxXYfr6XmU/w7ltWSfMuxJ/YpKn4NYeB2041jQnO\n".
            "XIrMtXhfAkEA1NrX4Q9UF1r1oay5VQEr8bV9vSEH8DViHJt0L6ydtaht5zqQJOhd\n".
            "79S4H8SZ283pktnrF11Lfg3i5pU3rZHa1QJAIipYBLv9ejnAK7I2oAzqMaKe8pmt\n".
            "gCawduEa+q2mxWqkiJWmWXTzkukww1DewBu+EFrLHZ+MKCwN5jAK/0RHLQJBALSj\n".
            "rMXBPno7pW25qecsAWE1xyn0mEoQ49ynSOkUsxrxf6PWnXHVCbN5cXD0ZiaWD32j\n".
            "FtJTSLgHjOJnDENvHqkCQQC+dZLZD4fcH/hYAmNyJtrvMWb8BKZNYI91BxJ5S4uM\n".
            "liv104HjblITA/M5Agk30FPOG6HSZ1zsPDRm6BvDaYE6\n".
            "-----END RSA PRIVATE KEY-----";
        /*llave testing*/
        /*$llaveComercioCifradoPriv = "-----BEGIN RSA PRIVATE KEY-----\n".
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
            "-----END RSA PRIVATE KEY-----";*/

        $arrayIn['IDACQUIRER'] = (isset($input['IDACQUIRER'])) ? $input['IDACQUIRER'] : "";
        $arrayIn['IDCOMMERCE'] = (isset($input['IDCOMMERCE'])) ? $input['IDCOMMERCE'] : "";
        $arrayIn['XMLRES'] = (isset($input["XMLRES"])) ? $input["XMLRES"] : "";
        $arrayIn['DIGITALSIGN']= (isset($input["DIGITALSIGN"])) ? $input["DIGITALSIGN"] : "";
        $arrayIn['SESSIONKEY']= (isset($input['SESSIONKEY'])) ? $input['SESSIONKEY'] : "";

        $arrayOut= "";

        if(VPOSResponse($arrayIn,$arrayOut,$llaveVPOSSignaturePub,$llaveComercioCifradoPriv ,$this->vectorInicializacion)){


            $authorizationResult = $arrayOut['authorizationResult'];
            $purchaseOperationNumber = $arrayOut['purchaseOperationNumber'];
            $idProduct = $arrayOut['reserved2'];

            list($product, $items, $total) = $this->getPurchasedOptions($idProduct);

            if($authorizationResult == 00)
            {
                //guardamos la operacion en db si no existe ya el mismo numero de operación
                $exitsPayment = $this->paymentRepository->findByOperationNumber($purchaseOperationNumber);

                if(! $exitsPayment)
                    $payment = $this->paymentRepository->store(['product_id' => $product->id,'purchaseOperationNumber'=>$purchaseOperationNumber]);

                //actualizamos el estado del producto recien ingresado a publicado
                $this->productRepository->update_state($product->id, 1); // 0:inactivo 1:publicado 2:en espera 3:inactivo(pago rechazado o denegado)

                // informamos via email del producto recien creado y su confirmacion de pago
                try {
                    $this->mailer->paymentConfirmation(['email' => Auth()->user()->email, 'product' => $product, 'items' => $items, 'total' => $total]);
                }catch (Swift_RfcComplianceException $e)
                {
                    Log::error($e->getMessage());
                }

            }
            if($authorizationResult == 01)
            {

                //actualizamos el estado del producto recien ingresado inactivo si el pago fue denegado
                if($product->published != 1)
                    $this->productRepository->update_state($product->id, 3); // 0:inactivo 1:publicado 2:en espera 3:inactivo(pago rechazado o denegado)

               // flash('La operación ha sido denegada en el Banco Emisor');

            }
            if($authorizationResult == 05)
            {

                //actualizamos el estado del producto recien ingresado inactivo si el pago fue rechazado
               if($product->published != 1)
                    $this->productRepository->update_state($product->id, 3); // 0:inactivo 1:publicado 2:en espera 3:inactivo(pago rechazado o denegado)

                //flash('La operación ha sido rechazada');



            }


        }else{

           flash('Respuesta Inválida');

        }
        Log::info('results of VPOS: '.json_encode($arrayOut));


        return view('products.purchase-response')->with(compact('items','total','authorizationResult','purchaseOperationNumber'));

    }

    /**
     * Purchase Paypal
     * @param PaymentRequest $request
     * @param $productId
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function purchasePaypal(PaymentRequest $request, $productId)
    {
        $input = $request->all();

        list($product, $items, $total, $totalDollar) = $this->getPurchasedOptions($productId);

        if($input['payment_method'] == 2)
        {

            $config = array(
                'mode' => $this->modeApiPaypal,
                'acct1.UserName' => $this->userApiPaypal,
                'acct1.Password' => $this->passwordApiPaypal,
                'acct1.Signature' => $this->signatureApiPaypal,
                

            );

            // Create request details

            $setECReqDetails = new SetExpressCheckoutRequestDetailsType();

            // descripcion del item comprado
            $descriptionPayment = "";
            $total = 0;

            if($product->option_id)
            {

                $option = Option::findOrFail($product->option_id);

                $descriptionPayment .= $option->name. ' '.$option->price;
                $total += $option->price;
            }
            if($product->tags->count())
            {
                $descriptionPayment .= ' - Etiqueta: '. $product->tags->first()->name. ' ' .$product->tags->first()->price;
                $total += $product->tags->first()->price;
            }


            $itemAmount = new BasicAmountType('USD', $totalDollar);

            $itemDetails = new PaymentDetailsItemType();
            $itemDetails->Name = $descriptionPayment;
            $itemDetails->Amount = $itemAmount;
            $itemDetails->Quantity = 1;

            $paymentDetails = new PaymentDetailsType();
            $paymentDetails->PaymentDetailsItem[0] = $itemDetails;

            $setECReqDetails->PaymentDetails[0] = $paymentDetails;

            $setECReqDetails->OrderTotal = $itemAmount;
            $setECReqDetails->OrderDescription = $descriptionPayment;
            //$setECReqDetails->PaymentAction = "Sale";
            //$setECReqDetails->cppheaderbackcolor = "#000000";

            $setECReqDetails->CancelURL = route('product_payment',$productId);
            $setECReqDetails->ReturnURL = route('paypal_receipt');

            $setECReqDetails->Custom = $productId;

            $setECReqType = new SetExpressCheckoutRequestType();
            $setECReqType->SetExpressCheckoutRequestDetails = $setECReqDetails;

            // Create request
            $setECReq = new SetExpressCheckoutReq();
            $setECReq->SetExpressCheckoutRequest = $setECReqType;


            // Perform request
            $paypalService = new PayPalAPIInterfaceServiceService($config);
            $setECResponse = $paypalService->SetExpressCheckout($setECReq);

            $tokenPaypal = $setECResponse->Token;

            // Check results
            if($setECResponse->Ack == 'Success') {


             

            }else
            {
                flash('Respuesta Inválida');
                return redirect()->back();
            }

            Log::info('results of PAYPAL: '.json_encode($setECResponse));
        }

        $paymentMethod = 2;

        return view('products.purchase')->with(compact('product','items', 'total', 'totalDollar','input','tokenPaypal','paymentMethod'));
    }


    /**
     * Purchase Paypal Response
     * @param Request $request
     * @return $this
     */
    public function purchasePaypalResponse(Request $request)
    {


        $config = array(
            'mode' => $this->modeApiPaypal,
            'acct1.UserName' => $this->userApiPaypal,
            'acct1.Password' => $this->passwordApiPaypal,
            'acct1.Signature' => $this->signatureApiPaypal
            

        );
        //getExpressCheckout
        $getExpressCheckoutDetailsRequest = new GetExpressCheckoutDetailsRequestType($request->token);

        $getExpressCheckoutReq = new GetExpressCheckoutDetailsReq();
        $getExpressCheckoutReq->GetExpressCheckoutDetailsRequest = $getExpressCheckoutDetailsRequest;

        $paypalService = new PayPalAPIInterfaceServiceService($config);

        $getECResponse = $paypalService->GetExpressCheckoutDetails($getExpressCheckoutReq);


        //DoExpressCheckout
        $DoECRequestDetails = new DoExpressCheckoutPaymentRequestDetailsType();
        $DoECRequestDetails->PayerID = $request->PayerID;
        $DoECRequestDetails->Token =  $request->token;

        $DoECRequestDetails->PaymentDetails[0] = $getECResponse->GetExpressCheckoutDetailsResponseDetails->PaymentDetails[0];
        //$DoECRequestDetails->PaymentAction = "Sale";

        $DoECRequest = new DoExpressCheckoutPaymentRequestType();
        $DoECRequest->DoExpressCheckoutPaymentRequestDetails = $DoECRequestDetails;


        $DoECReq = new DoExpressCheckoutPaymentReq();
        $DoECReq->DoExpressCheckoutPaymentRequest = $DoECRequest;


        $DoECResponse = $paypalService->DoExpressCheckoutPayment($DoECReq);


        $purchaseOperationNumber = "";

        //dd($DoECResponse);

        list($product, $items, $total) = $this->getPurchasedOptions($getECResponse->GetExpressCheckoutDetailsResponseDetails->Custom);

        if($DoECResponse->Ack == 'Success') {
            $purchaseOperationNumber = $DoECResponse->DoExpressCheckoutPaymentResponseDetails->PaymentInfo[0]->TransactionID;

            //guardamos la operacion en db si no existe ya el mismo numero de operación
            $exitsPayment = $this->paymentRepository->findByOperationNumber($purchaseOperationNumber);

            if(! $exitsPayment)
                $payment = $this->paymentRepository->store(['product_id' => $product->id,'purchaseOperationNumber'=>$purchaseOperationNumber]);

            //actualizamos el estado del producto recien ingresado a publicado
            $this->productRepository->update_state($product->id, 1); // 0:inactivo 1:publicado 2:en espera 3:inactivo(pago rechazado o denegado)

            // informamos via email del producto recien creado y su confirmacion de pago
            try {
                $this->mailer->paymentConfirmation(['email' => Auth()->user()->email, 'product' => $product, 'items' => $items, 'total' => $total]);
            }catch (Swift_RfcComplianceException $e)
            {
                Log::error($e->getMessage());
            }

        }else{

            //actualizamos el estado del producto recien ingresado inactivo si el pago fue denegado
            $this->productRepository->update_state($product->id, 3); // 0:inactivo 1:publicado 2:en espera 3:inactivo(pago rechazado o denegado)
        }

        $authorizationResult = $DoECResponse->Ack;

        Log::info('results of PAYPAL: '.json_encode($DoECResponse));


        return view('products.purchase-response')->with(compact('items','total','authorizationResult','purchaseOperationNumber'));

    }
    /**
     * Post paid options
     * @param PaymentRequest $request
     * @return \Illuminate\View\View
     */
    /*public function postPayment(PaymentRequest $request)
    {
        $input = $request->all();

        $payment = $this->paymentRepository->store($input);

        flash('Producto Creado correctamente');

        return Redirect()->route('profile.show', Auth()->user()->username);

    }*/

    /**
     * Mark selled a product.
     *
     * @param  int $id
     * @return Response
     */
    public function selled($id)
    {
        $this->productRepository->update_state($id, 4);

        Flash('Producto Vendido');

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


    public function saveComment(CommentFrontRequest $request, $productId)
    {
        $input = $request->all();
        $user = auth()->user();

        $product = $this->productRepository->findById($productId);

        $comment = New Comment;
        $comment->comment_id = (isset($input['comment_id'])) ? $input['comment_id'] : 0;
        $comment->storeCommentForUser((isset($input['user_to_respond'])) ? $input['user_to_respond'] :$product->user->id, $user->id, $input['body'], $productId);

      
        try {
  
            $this->mailer->newCommentPublished(['email' => (isset($input['author'])) ? $input['author'] : $product->user->email, 'product' => $product]);
            

        }catch (Swift_RfcComplianceException $e)
        {
            Log::error($e->getMessage());
        }

        return Redirect()->route('product_path', $product->id);
        
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
        $totalDollar = 0;
        if ($option) {
            $optionItem = [

                'name' => $option->name,
                'price' => $option->price,
                'priceDollar' => number_format($option->price / 540, 2)
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
            $totalDollar += $item['priceDollar'];
        }
        return array($product, $items, $total, $totalDollar);
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
