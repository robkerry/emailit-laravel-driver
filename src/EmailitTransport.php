<?php

namespace RobKerry\EmailitLaravelDriver;

use Illuminate\Support\Facades\Http;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\RawMessage;

class EmailitTransport implements TransportInterface
{
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function send(RawMessage $message, Envelope $envelope = null): ?SentMessage
    {
        $payload = [];

        $payload['text'] = $message->getTextBody();
        $payload['html'] = $message->getHtmlBody();

        $payload['from'] = $this->getFrom($message);
        $payload['reply_to'] = $this->getReplyTo($message);

        $payload['to'] = $this->getTo($message);

        $payload['subject'] = $message->getSubject();

        $payload['attachments'] = $this->getAttachments($message);

        $api_path = $this->config->protocol.'://'.$this->config->host.'/'.$this->config->api_path;
        $api_endpoint = $api_path.'/emails';
        $api_key = $this->config->api_key;

        $response = Http::withToken($api_key)->retry(3, 500)->post($api_endpoint, $payload);

        if ($response->failed()) {
            $message = $response->body() ?? 'No error message provided';
            throw new TransportException($message, $response->status());
        }
        return new SentMessage($message, $envelope);
    }

    protected function getFrom(RawMessage $message): string
    {
        $from = $message->getFrom();

        if (count($from) > 0) {
            return ($from[0]->getName() === null) ? $from[0]->getAddress() : $from[0]->getName().' <'.$from[0]->getAddress().'>';
        }
        return config('mail.from.name').' <'.config('mail.from.address').'>';
    }

    protected function getReplyTo(RawMessage $message): string
    {
        $reply_to = $message->getReplyTo();

        if (count($reply_to) > 0) {
            return ($reply_to[0]->getName() === null) ? $reply_to[0]->getAddress() : $reply_to[0]->getName().' <'.$reply_to[0]->getAddress().'>';
        }
        return config('mail.from.name').' <'.config('mail.from.address').'>';
    }

    protected function getTo(RawMessage $message): string
    {
        $to = $message->getTo();

        if (count($to) > 0) {
            return ($to[0]->getName() === null) ? $to[0]->getAddress() : $to[0]->getName().' <'.$to[0]->getAddress().'>';
        }
    }

    protected function getAttachments(RawMessage $message): array
    {
        $attachments = [];

        foreach ($message->getAttachments() as $attachment) {
            $attachments[] = [
                'filename' => $attachment->getPreparedHeaders()->get('content-disposition')?->getParameter('filename'),
                'content' => $attachment->getBody(),
                'content_type' => $attachment->getMediaType(),
            ];
        }

        return $attachments;
    }

    public function __toString(): string
    {
        return 'emailit';
    }
}
