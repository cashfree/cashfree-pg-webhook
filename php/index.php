<?php

$inputJSON = file_get_contents('php://input');

$expectedSig = getallheaders()['x-webhook-signature'];
$ts = getallheaders()['x-webhook-timestamp'];

if(!isset($expectedSig) || !isset($ts)){
    echo "Bad Request";
    die();
}

$currTS=time();
$timeDiff =  ($currTS * 1000 - $ts)/1000;
if($timeDiff > 300){
    echo "Bad request";
    die();
}

$computeSig = computeSignature($ts, $inputJSON);
$matches = $expectedSig == $computeSig;

echo $matches . "</br>";

function computeSignature($ts, $rawBody){
    $signStr = $ts . $rawBody;
    $key = "b85928b6c8f941c0ff8b8252ce040280305a3f3c";
    $computeSig = base64_encode(hash_hmac('sha256', $signStr, $key, true));
    return $computeSig;
}
?>