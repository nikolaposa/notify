<?php

declare(strict_types=1);

namespace Notifier\Channel\Email;

use Notifier\Exception\SendingMessageFailed;

interface Mailer
{
    /**
     * @throws SendingMessageFailed
     */
    public function send(EmailMessage $message): void;
}
