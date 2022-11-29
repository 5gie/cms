<?php

namespace Src\Helpers;

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class Mail
{
    /**
     * TODO: add this
     */
    public static function send($email, $title, $message, $text)
    {
        return true;
        // $transport = Transport::fromDsn('smtp://localhost');
        // $mailer = new Mailer($transport);

        // $email = (new Email())
        //     ->from('kontakt@kchmielewski.pl') // TODO get it from settings
        //     ->to($email)
        //     //->replyTo('fabien@example.com')
        //     //->priority(Email::PRIORITY_HIGH)
        //     ->subject($title)
        //     ->text($text)
        //     ->html($message);

        // return $mailer->send($email);
    }
}




