<?php namespace App\Providers;

use App\Activity;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider {


    /**
     * Bootstrap the application services.
     *
     * @internal param ProductRepository $productRepository
     * @param ProductRepository $productRepository
     * @param CategoryRepository $categoryRepository
     */

	public function boot(ProductRepository $productRepository, CategoryRepository $categoryRepository)
	{

        view()->composer('categories/partials._list', function($view) use ($categoryRepository){

            $view->with('categories', $categoryRepository->getParents());
        });


        view()->composer('layouts/partials._header', function($view){
            $view->with('currentUser', Auth::user());
        });

        view()->composer('profiles/show', function($view) {
            $view->with('currentUser', Auth::user());
        });
        view()->composer('profiles/favorites', function($view) {
            $view->with('currentUser', Auth::user());
        });
        view()->composer('profiles/edit', function($view) {
            $view->with('currentUser', Auth::user());
        });
        view()->composer('profiles/reviews', function($view){
            $view->with('currentUser', Auth::user());
        });

        view()->composer('products/payment', function($view) {
            $view->with('currentUser', Auth::user());
        });
        view()->composer('products/show', function($view) {
            $view->with('currentUser', Auth::user());
        });


        view()->composer('admin/dashboard/index', function($view) {
            $view->with('currentUser', Auth::user());
        });
        view()->composer('admin/layouts/partials._navbar', function($view) {
            $view->with('currentUser', Auth::user());
        });

        /*view()->composer('pages/partials.products', function($view) use ($productRepository){
            $view->with('products', $productRepository->getFeatured());
        });

        view()->composer('layouts/partials.header', function($view) use ($productRepository){
            $view->with('products', $productRepository->getFeatured());
        });

        view()->composer('admin/dashboard/index', function($view) {
            $view->with('currentUser', Auth::user());
        });
        view()->composer('admin/layouts/partials._navbar', function($view) {
            $view->with('currentUser', Auth::user());
        });*/
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{

	}

}
