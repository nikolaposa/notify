<?php

/*
 * This file is part of the Notify package.
 *
 * Copyright (c) Nikola Posa <posa.nikola@gmail.com>
 *
 * For full copyright and license information, please refer to the LICENSE file,
 * located at the package root folder.
 */

namespace Notify\Contact;

/**
 * @author Nikola Posa <posa.nikola@gmail.com>
 */
class PhoneContact extends BaseContact
{
    protected function filter($phoneNumber)
    {
        $phoneNumber = trim($phoneNumber);

        return $phoneNumber;
    }
}
