<?php
return [
// set your paypal credential
    'client_id' => env('PAYPAL_CLIENT_ID'), //'AXma8QrmgMj2AQyYWycfhe3mMazW-qsI0hNtUJ78bbASWFIuWn7HDd11D1MLbuAcqC1ryok7vyFi-xyI',
    'secret' => env('PAYPAL_SECRET'), //'EK0RCJxHWNUWIg3GTCQDDpbs7wVI5AlrLWxoZ8nqGVEgNPszRQVwkW856k9PO8SkQxnPvEkFpVnDDqSm',

    /**
     * SDK configuration
     */
    'config' => [
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => env('PAYPAL_MODE', 'sandbox'),

        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 30,

        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,

        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',

        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'INFO',
    ]
];