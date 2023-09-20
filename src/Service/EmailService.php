<?php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Swift_Message;

class EmailService
{

    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send($to, $data, $htmlTemplate,$titre,$image)
    {

        $email = (new TemplatedEmail())
            ->from('abellifa@myleasy.com')
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject("J4R - ".$titre)
            ->htmlTemplate($htmlTemplate)

            // pass variables (name => value) to the template
            ->context([
                'data' => $data,
                'image' =>$image
            ]);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            dd($e);
        }

    }
   

}
