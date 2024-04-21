<?php

require 'vendor/autoload.php';

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\S3\Exception\S3Exception;
use Aws\Credentials\CredentialProvider;
use Aws\S3\S3Client;
use Exception;

function seed()
{
    /*** Configuration ***/
    $region = 'us-east-1';
    $config = aws_Config();

    /*** DynamoDB table  ***/
    $DDbClient = new DynamoDbClient($config);

    /*** User ***/

    $tableName = 'users';
    $tableCheck = false;

    //Check User table exists else create
    $listResult = $DDbClient->listTables([
    ]);
    //loop through table list to find music table
    foreach ($listResult['TableNames'] as $item) {
        if ($item == $tableName) {
            $tableCheck = true;
        }

    }
    //if table does not exist create it
    if (!$tableCheck) {
        try {

            $tableResult = $DDbClient->createTable([
                'AttributeDefinitions' => [
                    [
                        'AttributeName' => 'email',
                        'AttributeType' => 'S',
                    ],
                    [
                        'AttributeName' => 'user_name',
                        'AttributeType' => 'S',
                    ],
                ],
                'KeySchema' => [
                    [
                        'AttributeName' => 'email',
                        'KeyType' => 'HASH',
                    ],
                    [
                        'AttributeName' => 'user_name',
                        'KeyType' => 'RANGE',
                    ],
                ],
                'ProvisionedThroughput' => [
                    'ReadCapacityUnits' => 5,
                    'WriteCapacityUnits' => 5,
                ],
                'TableName' => $tableName,
            ]);
            $DDbClient->waitUntil("TableExists", ['TableName' => $tableName]);


        } catch (DynamoDbException $e) {
            echo $e->getMessage();
        }
    }

    try {
        $scanResult = $DDbClient->scan([
            'ExpressionAttributeNames' => [
                '#E' => 'email',
                '#U' => 'user_name',
            ],
            'ExpressionAttributeValues' => [
                ':e' => [
                    'S' => 's32735040@student.rmit.edu.au',
                ],
            ],
            'FilterExpression' => 'email = :e',
            'ProjectionExpression' => '#E, #U',
            'TableName' => $tableName,
        ]);
    } catch (DynamoDbException $e) {
        $e->getMessage();
    }

    if ($scanResult['Count'] === 0) {
        $DDbClient->batchWriteItem([
            'RequestItems' => [
                $tableName => [
                    [
                        'PutRequest' => [
                            'Item' => [
                                'email' => [
                                    'S' => 's32735040@student.rmit.edu.au',
                                ],
                                'user_name' => [
                                    'S' => 'Ryan Bullock0',
                                ],
                                'password' => [
                                    'S' => password_hash('012345', PASSWORD_DEFAULT),
                                ],
                            ],
                        ],
                    ],
                    [
                        'PutRequest' => [
                            'Item' => [
                                'email' => [
                                    'S' => 's32735041@student.rmit.edu.au',
                                ],
                                'user_name' => [
                                    'S' => 'Ryan Bullock1',
                                ],
                                'password' => [
                                    'S' => password_hash('123456', PASSWORD_DEFAULT),
                                ],
                            ],
                        ],
                    ],
                    [
                        'PutRequest' => [
                            'Item' => [
                                'email' => [
                                    'S' => 's32735042@student.rmit.edu.au',
                                ],
                                'user_name' => [
                                    'S' => 'Ryan Bullock2',
                                ],
                                'password' => [
                                    'S' => password_hash('234567', PASSWORD_DEFAULT),
                                ],
                            ],
                        ],
                    ],
                    [
                        'PutRequest' => [
                            'Item' => [
                                'email' => [
                                    'S' => 's32735043@student.rmit.edu.au',
                                ],
                                'user_name' => [
                                    'S' => 'Ryan Bullock3',
                                ],
                                'password' => [
                                    'S' => password_hash('345678', PASSWORD_DEFAULT),
                                ],
                            ],
                        ],
                    ],
                    [
                        'PutRequest' => [
                            'Item' => [
                                'email' => [
                                    'S' => 's32735044@student.rmit.edu.au',
                                ],
                                'user_name' => [
                                    'S' => 'Ryan Bullock4',
                                ],
                                'password' => [
                                    'S' => password_hash('456789', PASSWORD_DEFAULT),
                                ],
                            ],
                        ],
                    ],
                    [
                        'PutRequest' => [
                            'Item' => [
                                'email' => [
                                    'S' => 's32735045@student.rmit.edu.au',
                                ],
                                'user_name' => [
                                    'S' => 'Ryan Bullock5',
                                ],
                                'password' => [
                                    'S' => password_hash('567890', PASSWORD_DEFAULT),
                                ],
                            ],
                        ],
                    ],
                    [
                        'PutRequest' => [
                            'Item' => [
                                'email' => [
                                    'S' => 's32735046@student.rmit.edu.au',
                                ],
                                'user_name' => [
                                    'S' => 'Ryan Bullock6',
                                ],
                                'password' => [
                                    'S' => password_hash('678901', PASSWORD_DEFAULT),
                                ],
                            ],
                        ],
                    ],
                    [
                        'PutRequest' => [
                            'Item' => [
                                'email' => [
                                    'S' => 's32735047@student.rmit.edu.au',
                                ],
                                'user_name' => [
                                    'S' => 'Ryan Bullock7',
                                ],
                                'password' => [
                                    'S' => password_hash('789012', PASSWORD_DEFAULT),
                                ],
                            ],
                        ],
                    ],
                    [
                        'PutRequest' => [
                            'Item' => [
                                'email' => [
                                    'S' => 's32735048@student.rmit.edu.au',
                                ],
                                'user_name' => [
                                    'S' => 'Ryan Bullock8',
                                ],
                                'password' => [
                                    'S' => password_hash('890123', PASSWORD_DEFAULT),
                                ],
                            ],
                        ],
                    ],
                    [
                        'PutRequest' => [
                            'Item' => [
                                'email' => [
                                    'S' => 's32735049@student.rmit.edu.au',
                                ],
                                'user_name' => [
                                    'S' => 'Ryan Bullock9',
                                ],
                                'password' => [
                                    'S' => password_hash('901234', PASSWORD_DEFAULT),
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

    }

    /*** MUSIC ***/

    $tableName = 'music';
    $tableCheck = false;

    //Check Music table exists else create
    $listResult = $DDbClient->listTables([
    ]);
    //loop through table list to find music table
    foreach ($listResult['TableNames'] as $item) {
        if ($item == $tableName) {
            $tableCheck = true;
        }

    }
    //if table does not exist create it
    if (!$tableCheck) {
        try {

            $tableResult = $DDbClient->createTable([
                'AttributeDefinitions' => [
                    [
                        'AttributeName' => 'title',
                        'AttributeType' => 'S',
                    ],
                    [
                        'AttributeName' => 'artist',
                        'AttributeType' => 'S',
                    ],
                ],
                'KeySchema' => [
                    [
                        'AttributeName' => 'title',
                        'KeyType' => 'HASH',
                    ],
                    [
                        'AttributeName' => 'artist',
                        'KeyType' => 'RANGE',
                    ],
                ],
                'ProvisionedThroughput' => [
                    'ReadCapacityUnits' => 5,
                    'WriteCapacityUnits' => 5,
                ],
                'TableName' => $tableName,
            ]);
            $DDbClient->waitUntil("TableExists", ['TableName' => $tableName]);
        } catch (DynamoDbException $e) {
            echo $e->getMessage();
        }
    }
    // scan table to see if there is content in it
    try {
        $scanResult = $DDbClient->scan([
            'ExpressionAttributeNames' => [
                '#T' => 'title',
                '#A' => 'artist',
            ],
            'ExpressionAttributeValues' => [
                ':a' => [
                    'S' => 'John Lennon',
                ],
            ],
            'FilterExpression' => 'artist = :a',
            'ProjectionExpression' => '#T, #A',
            'TableName' => $tableName,
        ]);
    } catch (DynamoDbException $e) {
        echo $e->getMessage();
    }
    //if no contact in table add content
    if (count($scanResult['Items']) === 0) {
        try {
            // Read the JSON file  
            $json = file_get_contents('../seed/a2.json');

            // Decode the JSON file 
            $json_data = json_decode($json, true);

            for ($i = 0; $i < count($json_data['songs']); $i++) {


                $response = $DDbClient->putItem([
                    'Item' => [
                        'title' => [
                            'S' => $json_data['songs'][$i]['title'],
                        ],
                        'artist' => [
                            'S' => $json_data['songs'][$i]['artist'],
                        ],
                        'year' => [
                            'N' => $json_data['songs'][$i]['year'],
                        ],
                        'web_url' => [
                            'S' => $json_data['songs'][$i]['web_url'],
                        ],
                        'img_url' => [
                            'S' => $json_data['songs'][$i]['img_url'],
                        ],
                    ],
                    'ReturnConsumedCapacity' => 'TOTAL',
                    'TableName' => $tableName,
                ]);

            }
            ;
        } catch (DynamoDbException $e) {
            echo $e->getMessage();
        }
    }
    ;
    /*** S3 Bucket  ***/
    $s3client = new S3Client($config);

    $bucketName = 'artist-images-s3273504';

    //check bucket exists
    try {
        $contents = $s3client->listObjectsV2([
            'Bucket' => $bucketName,
            'MaxKeys' => 1,
        ]);
    } catch (Exception $e) {
        //create bucket if doesn't exist
        try {
            $contents = $s3client->createBucket([
                'Bucket' => $bucketName,
                'CreateBucketConfiguration' => ['LocationConstraint' => $region],
                'ObjectOwnership' => 'BucketOwnerPreferred'
            ]);
            //Remove public block
            $result = $s3client->deletePublicAccessBlock([
                'Bucket' => $bucketName, // REQUIRED
            ]);
            //Set bucket public settings
            $result = $s3client->putBucketAcl([
                'ACL' => 'public-read',
                'Bucket' => $bucketName, // REQUIRED
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();

        }
    }

    //scan Music table and insert artist image to S3
    if ($contents['Name'] == $bucketName || $contents['Location'] == '/' . $bucketName) {
        if ($contents['KeyCount'] === 0 || $contents['Location'] == '/' . $bucketName) {
            try {
                //get music info
                $imageURLResult = $DDbClient->scan([
                    'TableName' => $tableName,
                ]);
                //loop through music info and download image
                foreach ($imageURLResult['Items'] as $imageURL) {
                    $imgName = 'artist image ' . $imageURL['artist']['S'] . '.jpg';
                    $imgObject = file_get_contents($imageURL['img_url']['S']);
                    try {
                        //upload image to S3
                        $s3client->putObject([
                            'Body' => $imgObject,
                            'Bucket' => $bucketName,
                            'Key' => $imgName,
                            'ContentType' => 'image/jpg',
                        ]);
                        //set ACL for image
                        $result = $s3client->putObjectAcl([
                            'ACL' => 'public-read',
                            'Bucket' => $bucketName,
                            'Key' => $imgName,
                        ]);

                        //update music table with img url for S3
                        $result = $DDbClient->updateItem([
                            'ExpressionAttributeNames' => [
                                '#I' => 'img_s3_location',
                            ],
                            'ExpressionAttributeValues' => [
                                ':i' => [
                                    'S' => 'https://artist-images-s3273504.s3.amazonaws.com/' . $imgName,
                                ],
                            ],
                            'Key' => [
                                'artist' => [
                                    'S' => $imageURL['artist']['S'],
                                ],
                                'title' => [
                                    'S' => $imageURL['title']['S'],
                                ],
                            ],
                            'ReturnValues' => 'ALL_NEW',
                            'TableName' => $tableName,
                            'UpdateExpression' => 'SET #I = :i',
                        ]);

                    } catch (Exception $exception) {
                        echo $e->getMessage();
                        exit("Please fix error with file upload before continuing.");
                    }
                }


            } catch (DynamoDbException $e) {
                echo $e->getMessage();
            } catch (S3Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    /*** MUSIC ***/

    $tableName = 'subscription';
    $tableCheck = false;

    //Check Music table exists else create
    $listResult = $DDbClient->listTables([
    ]);
    //loop through table list to find music table
    foreach ($listResult['TableNames'] as $item) {
        if ($item == $tableName) {
            $tableCheck = true;
        }

    }
    //if table does not exist create it
    if (!$tableCheck) {
        try {

            $tableResult = $DDbClient->createTable([
                'AttributeDefinitions' => [
                    [
                        'AttributeName' => 'email',
                        'AttributeType' => 'S',
                    ],
                    [
                        'AttributeName' => 'subscription_id',
                        'AttributeType' => 'S',
                    ],
                ],
                'KeySchema' => [
                    [
                        'AttributeName' => 'email',
                        'KeyType' => 'HASH',
                    ],
                    [
                        'AttributeName' => 'subscription_id',
                        'KeyType' => 'RANGE',
                    ],
                ],
                'ProvisionedThroughput' => [
                    'ReadCapacityUnits' => 5,
                    'WriteCapacityUnits' => 5,
                ],
                'TableName' => $tableName,
            ]);
            $DDbClient->waitUntil("TableExists", ['TableName' => $tableName]);
        } catch (DynamoDbException $e) {
            echo $e->getMessage();
        }
    }

}
?>