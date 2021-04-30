<?php
namespace App\Notification;

use App\Entity\Contact;
use Twig\Environment;

class ContactNotification
{
    /**
     * Undocumented variable
     *
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * Undocumented variable
     *
     * @var Environment
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->renderer = $renderer;
        $this->mailer = $mailer;
        
    }
    public function notify(Contact $contact)
    {
        $message = (new \Swift_Message('Agence : ' . $contact->getProperty()->getTitle()))
        ->setFrom('noreplay@agence.fr')
        ->setTo('contact@agence.fr')
        ->setReplyTo($contact->getEmail())
        ->setBody($this->renderer->render('emails/contact.html.twig', [
            'contact' => $contact
        ]), 'text/html')
        ;

        $this->mailer->send($message);
    }
}