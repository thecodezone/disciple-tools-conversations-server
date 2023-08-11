<?php

return [
    'configs' => [
        [
            /*
             * This package supports multiple webhook receiving endpoints. If you only have
             * one endpoint receiving webhooks, you can use 'default'.
             */
            'name' => 'facebook-page-comments',

            /*
             * The label to display in the admin panel.
             */
            'label' => 'Facebook Page Comments',

            /*
             * We expect that every webhook call will be signed using a secret. This secret
             * is used to verify that the payload has not been tampered with.
             */
            'signing_secret' => env('WEBHOOK_CLIENT_SECRET'),

            /*
             * The name of the header containing the signature.
             */
            'signature_header_name' => 'X-Hub-Signature',

            /*
             *  This class will verify that the content of the signature header is valid.
             *
             * It should implement \Spatie\WebhookClient\SignatureValidator\SignatureValidator
             */
            'signature_validator' => \Spatie\WebhookClient\SignatureValidator\DefaultSignatureValidator::class,

            /*
             * This class determines if the webhook call should be stored and processed.
             */
            'webhook_profile' => \App\Http\Webhooks\FacebookPage\CommentProfile::class,

            /*
             * This class determines the response on a valid webhook call.
             */
            'webhook_response' => \App\Http\Webhooks\FacebookPage\CommentResponse::class,

            /*
             * The classname of the model to be used to store webhook calls. The class should
             * be equal or extend Spatie\WebhookClient\Models\WebhookCall.
             */
            'webhook_model' => \Spatie\WebhookClient\Models\WebhookCall::class,

            /*
             * The class name of the channel repository used to fetch data from the service..
             */
            'repository' => \App\Repositories\FacebookRepository::class,

            /*
             * The class that is responsible for providing settings fields to the admin interface.
             */
            'settings' => \App\Http\Webhooks\FacebookPage\PageSettings::class,

            /*
             * In this array, you can pass the headers that should be stored on
             * the webhook call model when a webhook comes in.
             *
             * To store all headers, set this value to `*`.
             */
            'store_headers' => [

            ],

            /*
             * The class name of the job that will process the webhook request.
             *
             * This should be set to a class that extends \Spatie\WebhookClient\Jobs\ProcessWebhookJob.
             */
            'process_webhook_job' => '',
        ],
    ],

    [
        /*
             * This package supports multiple webhook receiving endpoints. If you only have
             * one endpoint receiving webhooks, you can use 'default'.
             */
        'name' => 'facebook-page-messages',

        /*
         * The label to display in the admin panel.
         */
        'label' => 'Facebook Page Messages',

        /*
         * We expect that every webhook call will be signed using a secret. This secret
         * is used to verify that the payload has not been tampered with.
         */
        'signing_secret' => env('WEBHOOK_CLIENT_SECRET'),

        /*
         * The name of the header containing the signature.
         */
        'signature_header_name' => 'X-Hub-Signature',

        /*
         *  This class will verify that the content of the signature header is valid.
         *
         * It should implement \Spatie\WebhookClient\SignatureValidator\SignatureValidator
         */
        'signature_validator' => \Spatie\WebhookClient\SignatureValidator\DefaultSignatureValidator::class,

        /*
         * This class determines if the webhook call should be stored and processed.
         */
        'webhook_profile' => \App\Http\Webhooks\FacebookPage\MessageProfile::class,

        /*
         * This class determines the response on a valid webhook call.
         */
        'webhook_response' => \App\Http\Webhooks\FacebookPage\MessageResponse::class,

        /*
         * The classname of the model to be used to store webhook calls. The class should
         * be equal or extend Spatie\WebhookClient\Models\WebhookCall.
         */
        'webhook_model' => \Spatie\WebhookClient\Models\WebhookCall::class,

        /*k
         * The class that is responsible for providing settings fields to the admin interface.
         */
        'settings' => \App\Http\Webhooks\FacebookPage\PageSettings::class,

        /*
         * In this array, you can pass the headers that should be stored on
         * the webhook call model when a webhook comes in.
         *
         * To store all headers, set this value to `*`.
         */
        'store_headers' => [

        ],

        /*
         * The class name of the job that will process the webhook request.
         *
         * This should be set to a class that extends \Spatie\WebhookClient\Jobs\ProcessWebhookJob.
         */
        'process_webhook_job' => '',
    ],

    /*
     * The integer amount of days after which models should be deleted.
     *
     * 7 deletes all records after 1 week. Set to null if no models should be deleted.
     */
    'delete_after_days' => 30,
];
