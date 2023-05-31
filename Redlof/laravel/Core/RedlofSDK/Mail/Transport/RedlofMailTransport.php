<?php

namespace Redlof\Core\RedlofSDK\Mail\Transport;

use Illuminate\Mail\Transport\Transport;
use Swift_Mime_SimpleMessage;
use GuzzleHttp;

class RedlofMailTransport extends Transport
{
    public function __construct()
    {
    }

    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        // Make a post request using Guzzle
        $client = new GuzzleHttp\Client(['base_uri' => env("REDLOF_API", 'https://redlof.think201.com/')]);

        $body_plain = strip_tags(preg_replace('/<style(.*)<\/style>/s', '', $message->getBody()));

        // Get attachements and create object to send
        $attachments = [];
        $swift_attachments = $message->getChildren();
        foreach($swift_attachments as $key => $swift_attachment)
        {
            array_push($attachments, [
                'name' => 'file-'.$key,
                'contents' => $swift_attachment->getBody(),
                // Todo: find better way to get file name
                'filename' => $swift_attachment->getHeaders()->get('content-type')->getParameters()['name'],
            ]);
        }

        $multipart = [
            [
                'name'  => 'from',
                'contents' => implode(',', array_keys($message->getFrom()))
            ],
            [
                'name'  => 'subject',
                'contents' => $message->getSubject()
            ],
            [
                'name'  => 'body_html',
                'contents' => $message->getBody()
            ],
            [
                'name'  => 'body_plain',
                'contents' => $body_plain
            ],
            [
                'name'  => 'app_name',
                'contents' => config('app.name')
            ],
            [
                'name'  => 'originator',
                'contents' => env('APP_URL')
            ],
            [
                'name'  => 'redlof_key',
                'contents' => env('REDLOF_KEY')
            ],
            [
                'name'  => 'redlof_secret',
                'contents' => env('REDLOF_SECRET')
            ],
            [
                'name'  => 'redlof_project_key',
                'contents' => env('REDLOF_PROJECT_KEY')
            ],
        ];

        $multipart = array_merge($multipart, $attachments);

        // Get list of all recipients
        $email_list = $message->getTo();

        if (is_array($message->getCc())) {
            $email_list = array_merge($email_list, $message->getCc());
        }

        if (is_array($message->getBcc())) {
            $email_list = array_merge($email_list, $message->getBcc());
        }

        // Send mail to each recipient
        foreach ($email_list as $email => $value) {
        
            try {

                $res = $client->request('POST', '/api/mails', [
                    'multipart' => array_merge($multipart, [
                        [
                            'name'  => 'to',
                            'contents' => $email
                        ],
                    ]),
                ]);
    
            } catch (\Exception $e) {
    
                throw new \EntityNotFoundException($e->getMessage());
            }
        }
    }
}