<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class NewsletterListServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
            'App\Newsletters\NewsletterList',
            'App\Newsletters\Mailchimp\MailchimpNewsletter'
            );
	}

}
