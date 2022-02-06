<?php

namespace interfaces;

interface UserEmailSenderInterface
{
    /**
     * @param string $oldEmail
     * @param string $newEmail
     *
     * @return void
     *
     * @throws EmailSendException
     */
    public function sendEmailChangedNotification(string $oldEmail, string $newEmail): void;
}
