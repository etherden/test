<?php

interface NotifierSenderInterface
{
    public function send(string $recipient, string $message): void;
}

final class EmailSender implements NotifierSenderInterface
{
    public function send(string $recipient, string $message): void
    {
        if (!filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email');
        }

        // отправка email
    }
}

final class SmsSender implements NotifierSenderInterface
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
    public function __construct(private NotifierSenderInterface $sender) {}

    public function notify(string $recipient, string $message): void
    {
        $this->sender->send($recipient, $message);
        echo "status=sent\n";
    }
}

$service = new NotificationService(new EmailSender());
$service->notify('user@example.com', 'Hello!');

$service = new NotificationService(new SmsSender());
$service->notify('+33612345678', 'Hello!');
