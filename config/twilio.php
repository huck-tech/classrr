<?php
return [
    'sid' => getenv('TWILIO_SID') ?: '',
    'token' => getenv('TWILIO_TOKEN') ?: '',
    'from' => getenv('TWILIO_FROM') ?: '',
];