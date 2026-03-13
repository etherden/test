<?php

interface NotifierSender
{
    public function send(string $recipient, string $message): void;
}

final class EmailSender implements NotifierSender
{
    public function send(string $recipient, string $message): void
    {
        if (!filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email');
        }

        // отправка email
    }
}

final class SmsSender implements NotifierSender
{
    public function send(string $recipient, string $message): void
    {
        if (!preg_match('/^\+?[0-9]{10,15}$/', $recipient)) {
            return;
        }

        // отправка SMS
    }
}

final class NotificationService
{
    public function __construct(private NotifierSender $sender) {}

    public function notify(string $recipient, string $message): void
    {
        $this->sender->send($recipient, $message);
    }
}

try {
    $service = new NotificationService(new EmailSender());
    $service->notify('user@example.com', 'Hello!');
} catch (\Throwable) {
    $service = new NotificationService(new SmsSender());
    $service->notify('+33612345678', 'Hello!');
}
