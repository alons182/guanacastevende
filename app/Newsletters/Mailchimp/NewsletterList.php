<?php namespace App\Newsletters\Mailchimp;


use App\Newsletters\NewsletterList as NewsletterListInterface;
use Mailchimp;

class NewsletterList implements NewsletterListInterface {

    /**
     * @var Mailchimp
     */
    protected $mailchimp;

    protected $list = [
        'Guanacaste Vende' => '26da74adbd'
    ];

    function __construct(Mailchimp $mailchimp)
    {
        $this->mailchimp = $mailchimp;
    }


    /**
     * @param $listName
     * @param $email
     * @param $fname
     * @param $lname
     * @return mixed
     */
    public function subscribeTo($listName, $email, $fname, $lname)
    {
       return $this->mailchimp->lists->subscribe(
            $this->list[$listName],
            ['email'=> $email],
            ['FNAME'=> $fname,'LNAME'=> $lname], // merge vars
            'html', //email type
            false, // require double opt in?
            true //update existing customers
       );
    }

    /**
     * @param $listName
     * @param $email
     * @return mixed
     */
    public function unsubscribeFrom($listName, $email)
    {
        return $this->mailchimp->lists->subscribe(
            $this->list[$listName],
            ['email'=> $email],
            false, // delete the member permanently
            false, // send goodbye email?
            false // send unsubscribe notification email?

        );
    }
}