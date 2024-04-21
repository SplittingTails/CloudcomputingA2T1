<?php
require 'vendor/autoload.php';
use Aws\DynamoDb\DynamoDbClient;
use Aws\Credentials\CredentialProvider;


function DynamoDbClient(): DynamoDbClient
{
    /*** Configuration ***/

    $config = aws_Config();


    /*** DynamoDB table  ***/
    return new DynamoDbClient($config);

}

function data_Query(array $query): AWS\Result
{
    $DDbClient = DynamoDbClient();
    $result = $DDbClient->query($query);

    return $result;
}

function data_Scan(array $scan): AWS\Result
{
    $DDbClient = DynamoDbClient();
    $result = $DDbClient->scan($scan);
    return $result;
}

function put_Item(array $item): void
{
    $DDbClient = DynamoDbClient();
    $DDbClient->putItem($item);
}


function music_Scan(string $tableName, array $keys)
{
    $DDbClient = DynamoDbClient();

    $expressionAttributeValues = [];
    $expressionAttributeNames = [];
    $filterExpression = "";
    $index = 1;
    foreach ($keys as $name => $value) {
        if ($index > 1) {
            $filterExpression .= " AND ";
        }
        $filterExpression .= "#" . array_key_first($value) . " = :v$index,";
        $filterExpression = substr($filterExpression, 0, -1);
        $expressionAttributeNames["#" . array_key_first($value)] = array_key_first($value);
        $hold = array_pop($value);
        $expressionAttributeValues[":v$index"] = [
            array_key_first($hold) => array_pop($hold),
        ];
        $index++;
    }

    $query = [
        'ExpressionAttributeValues' => $expressionAttributeValues,
        'ExpressionAttributeNames' => $expressionAttributeNames,
        'FilterExpression' => $filterExpression,
        'TableName' => $tableName,
    ];
    #return $query;
    return $DDbClient->scan($query);

}

$birthKey = [
    'Key' => [
        'year' => [
            'N' => "$birthYear",
        ],
    ],
];


function music_Query(string $tableName, $key)
{
    $DDbClient = DynamoDbClient();
    $expressionAttributeValues = [];
    $expressionAttributeNames = [];
    $keyConditionExpression = "";
    $index = 1;
    foreach ($key as $name => $value) {
        $keyConditionExpression .= "#" . array_key_first($value) . " = :v$index,";
        $expressionAttributeNames["#" . array_key_first($value)] = array_key_first($value);
        $hold = array_pop($value);
        $expressionAttributeValues[":v$index"] = [
            array_key_first($hold) => array_pop($hold),
        ];
    }
    $keyConditionExpression = substr($keyConditionExpression, 0, -1);
    $query = [
        'ExpressionAttributeValues' => $expressionAttributeValues,
        'ExpressionAttributeNames' => $expressionAttributeNames,
        'KeyConditionExpression' => $keyConditionExpression,
        'TableName' => $tableName,
    ];
    return $DDbClient->query($query);
}

function music_DeleteItemByKey(string $tableName, array $key)
{
    $DDbClient = DynamoDbClient();
    $DDbClient->deleteItem([
        'Key' => $key['Item'],
        'TableName' => $tableName,
    ]);
}

function music_ListTables(string $tableName): bool
{
    $DDbClient = DynamoDbClient();
    $tableCheck = false;
    $listResult = $DDbClient->listTables([
    ]);
    //loop through table list to find music table
    foreach ($listResult['TableNames'] as $item) {
        if ($item == $tableName) {
            $tableCheck = true;
        }

    }
    return $tableCheck;
}


?>