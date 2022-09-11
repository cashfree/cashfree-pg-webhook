# Introduction
This project contains code to handle Cashfree Webhooks in the popular PHP. 
The steps to verify the webhook remain same.

```
php -S localhost:8080
```

1. Fetch Raw JSON and the headers
```php
<?php

$inputJSON = file_get_contents('php://input');

$expectedSig = getallheaders()['x-webhook-signature'];
$ts = getallheaders()['x-webhook-timestamp'];

if(!isset($expectedSig) || !isset($ts)){
    echo "Bad Request";
    die();
}

```

2. Compute signature and verify
```php

function computeSignature($ts, $rawBody){
    $signStr = $ts . $rawBody;
    $key = "b85928b6c8f941c0ff8b8252ce040280305a3f3c";
    $computeSig = base64_encode(hash_hmac('sha256', $signStr, $key, true));
    return $computeSig;
}

```