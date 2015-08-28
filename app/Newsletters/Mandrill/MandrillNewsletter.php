<?php namespace App\Newsletters\Mandrill;



use Mandrill;

class MandrillNewsletter {

    /**
     * @var Mandrill
     */
    protected $mandrill;


    function __construct(Mandrill $mandrill)
    {

        $this->mandrill = $mandrill;
    }


    /**
     * @param $email
     * @param null $name
     * @return array
     *
     */
    public function send($email, $name = null)
    {
        /*$template_name = 'libermall';
        $template_content = array(
            array(
                'name' => 'test',
                'content' => 'test'
            )
        );
        $message = array(
            'html' => 'test',
            'text' => 'test',
            'subject' => 'Información',
            'from_email' => 'info@guanacastevende.com',
            'from_name' => 'Guanacaste Vende',
            'to' => array(
                array(
                    'email' => $email,
                    'name' => $name,
                    'type' => 'to'
                )
            )

        );*/
        $template_name = 'libermall';
        $template_content = array(
            array(
                'name' => '',
                'content' => ''
            )
        );
        $message = array(
            'html' => '',
            'text' => '',
            'subject' => 'Informacion Guanacaste Vende',
            'from_email' => 'info@guanacastevende.com',
            'from_name' => 'Guanacaste Vende',
            'to' => array(
                array(
                    'email' => $email,
                    'name' => $name,
                    'type' => 'to'
                )
            ),
            'headers' => array('Reply-To' => $email));


       return $this->mandrill->messages->sendTemplate($template_name, $template_content, $message);
    }




}