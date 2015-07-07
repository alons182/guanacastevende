<?php namespace App\Mailers;


class ContactMailer extends Mailer{

    protected $listLocalEmail = ['alonso@avotz.com'];
    protected $listProductionEmail = ['info@guanacastevende.com'];

    public function contact($data)
    {
        $view = 'emails.contact.contact';
        $subject = 'Información desde formulario de contacto de Guanacaste vende';
        $emailTo = $this->listLocalEmail;

        return $this->sendTo($emailTo, $subject, $view, $data);
    }
    public function comment($data)
    {
        $view = 'emails.contact.comment';
        $subject = 'Información desde formulario de publicidad de Sueños de vida';
        $emailTo = $data['ad_email'];

        return $this->sendTo($emailTo, $subject, $view, $data);
    }

} 