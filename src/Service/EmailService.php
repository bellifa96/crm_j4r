<?php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class EmailService
{

    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendNew($tos, $createur_ticket, $data, $htmlTemplate, $titre, $image)

    {


        foreach ($tos as $to) {
            $email = (new TemplatedEmail())
                ->from('abellifa@myleasy.com')
                ->to($to)
                ->cc('J.rodrigues@j4r.fr', $createur_ticket)
                //->bcc($createur_ticket)
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject("Création du ticket " . $data->getTitle() . "-" . $data->getId())
                ->htmlTemplate($htmlTemplate)

                // pass variables (name => value) to the template
                ->context([
                    'data' => $data,
                    'image' => $image,
                    'var' => 'variable',
                    'drapo' => -1,

                ]);

            try {
                $this->mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                dd($e);
            }
        }
    }
    public function sendAssigend($to, $emailUser, $data, $htmlTemplate, $titre, $image, $drapo)

    {
        $titleMessage = "";
        if ($drapo == 2) {
            $titleMessage = "Confirmer la résolution" . $data->getTitle() . "-" . $data->getId();
        } else {
            $titleMessage = "Pris en charge " . $data->getTitle() . "-" . $data->getId();
        }

        $email = (new TemplatedEmail())
            ->from('abellifa@myleasy.com')
            ->to($to)
            //->cc('J.rodrigues@j4r.fr', $emailUser)
            ->cc($emailUser)
            //->bcc($createur_ticket)
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($titleMessage)
            ->htmlTemplate($htmlTemplate)

            // pass variables (name => value) to the template
            ->context([
                'data' => $data,
                'drapo' => $drapo
            ]);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            dd($e);
        }
    }
    public function sendInformation($to, $emailUser, $data, $htmlTemplate, $titre, $message_information, $drapo)

    {

        $email = (new TemplatedEmail())
            ->from('abellifa@myleasy.com')
            ->to($to)
            //->cc('J.rodrigues@j4r.fr', $emailUser)
            ->cc($emailUser)
            //->bcc($createur_ticket)
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject("Demande d'information " . $data->getTitle() . "-" . $data->getId())
            ->htmlTemplate($htmlTemplate)

            // pass variables (name => value) to the template
            ->context([
                'data' => $data,
                'drapo' => $drapo,
                'message_information' => $message_information
            ]);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            dd($e);
        }
    }
    public function sendMessageRefus($to, $emailUser, $data, $htmlTemplate, $titre, $message_information, $drapo)

    {

        $email = (new TemplatedEmail())
            ->from('abellifa@myleasy.com')
            ->to($to)
            //->cc('J.rodrigues@j4r.fr', $emailUser)
            ->cc($emailUser)
            //->bcc($createur_ticket)
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject("J4R - " . $titre)
            ->htmlTemplate($htmlTemplate)

            // pass variables (name => value) to the template
            ->context([
                'data' => $data,
                'drapo' => $drapo,
                'message_information' => $message_information
            ]);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            dd($e);
        }
    }
    public function sendTicketResolu($to, $emailUser, $data, $htmlTemplate, $titre, $message_information, $drapo)

    {

        $email = (new TemplatedEmail())
            ->from('abellifa@myleasy.com')
            ->to($to)
            //->cc('J.rodrigues@j4r.fr', $emailUser)
            ->cc($emailUser)
            //->bcc($createur_ticket)
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($data->getTitle() . "-" . $data->getId() . " Résolu")
            ->htmlTemplate($htmlTemplate)

            // pass variables (name => value) to the template
            ->context([
                'data' => $data,
                'drapo' => $drapo,
                'message_information' => $message_information
            ]);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            dd($e);
        }
    }
}
