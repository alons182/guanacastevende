<?php namespace App\Mailers;


class ContactMailer extends Mailer{

    protected $listLocalEmail = ['alonso@avotz.com'];
    protected $listProductionEmail = ['info@guanacastevende.com'];
    protected $listAdministration = ['administrador@guanacastevende.com'];

    public function contact($data)
    {
        $view = 'emails.contact.contact';
        $subject = 'Información desde formulario de contacto de Guanacaste vende';
        $emailTo = $this->listProductionEmail;

        return $this->sendTo($emailTo, $subject, $view, $data);
    }

    public function newProductCreated($data)
    {
        $view = 'emails.contact.newProduct';
        $subject = 'Información desde el sitio Guanacaste Vende - Nuevo Articulo Creado';
        $emailTo = $this->listAdministration;

        return $this->sendTo($emailTo, $subject, $view, $data);
    }
    public function paymentConfirmation($data)
    {
        $view = 'emails.contact.paymentConfirmation';
        $subject = 'Información desde el sitio Guanacaste Vende - Confirmación de pago';
        $emailTo = $data['email'];

        return $this->sendTo($emailTo, $subject, $view, $data);
    }

    public function welcome($data)
    {
        $view = 'emails.contact.welcome';
        $subject = 'Información desde el sitio Guanacaste Vende - Bienvenido';
        $emailTo = $data['email'];
        return $this->sendTo($emailTo, $subject, $view, $data);
    }
    public function newCommentPublished($data)
    {
       
        $view = 'emails.contact.newComment';
        $subject = 'Información desde el sitio Guanacaste Vende - Nueva Pregunta publicada en tu producto';
        $emailTo = $data['email'];

        return $this->sendTo($emailTo, $subject, $view, $data);
    }
    public function infoProductsInnactive($data)
    {
       
        $view = 'emails.contact.infoInnactiveProducts';
        $subject = 'Información desde el sitio Guanacaste Vende - Productos inactivos (30 dias)';
        $emailTo = $this->listAdministration;

        return $this->sendTo($emailTo, $subject, $view, $data);
    }
} 