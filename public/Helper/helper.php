<?php
function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function aws_Config():array {

    $region = 'us-east-1';
    $key = '';
    $secret = '';
    $token = "";
    $region = 'us-east-1';
    $config = [
        'region' => $region,
        'version' => 'latest',
        'credentials' => new \Aws\Credentials\Credentials($key, $secret, $token)

    ];

    return $config;
}
