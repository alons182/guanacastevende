<?php namespace App\Mailers;


class ContactMailer extends Mailer{

    protected $listLocalEmail = ['alonso@avotz.com'];
    protected $listProductionEmail = ['info@guanacastevende.com'];
    protected $listAdministration = ['administrador@guanacastevende.com'];

    public function contact($data)
    {
        $view = 'emails.contact.contact';
        $subject = 'Información desde formulario de contacto de Guanacaste vende';
        $emailTo = $this->listLocalEmail;

        return $this->sendTo($emailTo, $subject, $view, $data);
    }

    public function newProductCreated($data)
    {
        $view = 'emails.contact.newProduct';
        $subject = 'Información desde el sitio Guanacaste Vende - Nuevo Articulo Creado';
        $emailTo = $this->listAdministration;

        return $this->sendTo($emailTo, $subject, $view, $data);
    }

} 