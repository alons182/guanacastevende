<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TagRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller {

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var TagRepository
     */
    private $tagRepository;

    /**
     * @param UserRepository $userRepository
     * @param ProductRepository $productRepository
     * @param CategoryRepository $categoryRepository
     * @param TagRepository $tagRepository
     */
    function __construct(UserRepository $userRepository, ProductRepository $productRepository, CategoryRepository $categoryRepository, TagRepository $tagRepository)
    {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

        $tu = $this->userRepository->getTotal();
        $tp = $this->productRepository->getTotal();
        $tc = $this->categoryRepository->getTotal();
        $tt = $this->tagRepository->getTotal();

        return View('admin.dashboard.index')->with(compact('tu','tp','tc','tt'));
	}



}
