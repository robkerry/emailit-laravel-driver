<?php

namespace RobKerry\EmailitLaravelDriver;

use Illuminate\Mail\Mailable;
use Symfony\Component\Mime\Email;

trait EmailitTrait
{
    public function emailit() {
        if ($this instanceof Mailable && $this->driver() === 'emailit') {
            $this->withSymfonyMessage(function (Email $message) {});
        }
        return $this;
    }

    protected function driver(): string
    {
        return function_exists('config') ? config('mail.default') : env('MAIL_MAILER');
    }
}
