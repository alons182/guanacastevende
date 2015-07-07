<?php namespace App\Mailers;

use Illuminate\Mail\Mailer as Mail;

abstract class Mailer {


    /**
     * @var \Illuminate\Mail\Mailer
     */
    private $mail;

    /**
     * @param Mail $mail
     */
    function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }

    /**
     * @param $emailTo
     * @param $subject
     * @param $view
     * @param array $data
     */
    public function sendTo($emailTo, $subject, $view, $data = [])
    {

        $this->mail->queue($view,$data,function ($message) use($emailTo, $subject)
        {

            $message->to($emailTo)
                ->subject($subject);

        });




    }
} 