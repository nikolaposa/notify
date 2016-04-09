<?php

/**
 * This file is part of the Notify package.
 *
 * Copyright (c) Nikola Posa <posa.nikola@gmail.com>
 *
 * For full copyright and license information, please refer to the LICENSE file,
 * located at the package root folder.
 */

namespace Notify\Message\Handler;

use Notify\Message\MessageInterface;

/**
 * @author Nikola Posa <posa.nikola@gmail.com>
 */
interface HandlerInterface
{
    /**
     * @param MessageInterface $message
     * @return void
     */
    public function send(MessageInterface $message);
}