<?php
session_start();
require_once ("public/Helper/DynamoDB.php");
require_once ("public/Helper/S3.php");
require_once ("public/Helper/helper.php");

use Google\Cloud\Firestore\FieldValue;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //clear alert error array
    unset($_SESSION['alerts']);
    //make alert error array
    $Alerts = array();

    /*** Register form ***/
    if ($_POST['Register'] == "Register") {

        $documents = data_Scan([
            'TableName' => 'users',
        ]);
        if (empty($_POST['email'])) {
            $Alerts['email_error'] = "email is required";
        } else {
            if ($documents['Count'] !== 0) {
                for ($i = 0; $i < $documents['Count']; $i++) {
                    if ($_POST["email"] === $documents['Items'][$i]['email']['S']) {
                        $Alerts['email_error'] = "The email already exists";
                    } else {
                        $_POST['email'] = test_input($_POST["email"]);
                    }
                }
            }
        }
        if (empty($_POST['username'])) {
            $Alerts['username_error'] = "username is required";
        } else {
            if ($documents['Count'] !== 0) {
                for ($i = 0; $i < $documents['Count']; $i++) {
                    if ($_POST["username"] === $documents['Items'][$i]['user_name']['S']) {
                        $Alerts['username_error'] = "The User name already exists";
                    } else {
                        $_POST['username'] = test_input($_POST["username"]);
                    }
                }
            }
        }
        if (empty($_POST['password'])) {
            $Alerts['password_error'] = "Password is required";
        } else {
            $_POST['password'] = password_hash($_POST["password"], PASSWORD_DEFAULT);
        }
        if (count($Alerts) > 0) {
            $_SESSION['alerts'] = $Alerts;
            header('Location: /register');
            exit();
        } else {

            put_Item([
                'Item' => [
                    'email' => [
                        'S' => $_POST['email'],
                    ],
                    'user_name' => [
                        'S' => $_POST['username'],
                    ],
                    'password' => [
                        'S' => $_POST['password'],
                    ],
                ],
                'ReturnConsumedCapacity' => 'TOTAL',
                'TableName' => 'users',
            ]);
            header('Location: /');
            exit();
        }

    }
    /*** Login form ***/
    if ($_POST['Login'] == "Login") {
        $documents = data_Query([
            'ExpressionAttributeValues' => [
                ':v1' => [
                    'S' => $_POST["email"],
                ],
            ],
            'KeyConditionExpression' => 'email = :v1',
            'TableName' => 'users',
        ]);
        if (empty($_POST['email'])) {
            $Alerts['email_error'] = "ID is required";
        } else {
            $_POST['email'] = test_input($_POST["email"]);
        }
        if (empty($_POST['Password'])) {
            $Alerts['Password_error'] = "Password is required";
        } else {
            $_POST['Password'] = test_input($_POST["Password"]);
        }
        if ($documents['Count'] === 0) {
            $Alerts['Login_Error'] = "ID or password is invalid";
        }
        if (count($Alerts) > 0) {
            $_SESSION['alerts'] = $Alerts;
            header('Location: /');
            exit();
        } else {
            if ($_POST["email"] === $documents['Items'][0]['email']['S'] && password_verify($_POST["Password"], $documents['Items'][0]['password']['S'])) {
                $_SESSION['user']['email'] = $documents['Items'][0]['email']['S'];
                header("Location: /Mainpage");
            } else {
                $Alerts['Login_Error'] = "ID or password is invalid";
                $_SESSION['alerts'] = $Alerts;
                header("Location: /");
            }
        }
        exit();
    }


    if ($_POST['subscribe'] == "subscribe") {

        put_Item([
            'Item' => [
                'email' => [
                    'S' => $_POST['email'],
                ],
                'subscription_id' => [
                    'S' => $_POST['subscription_id'],
                ],
                'title' => [
                    'S' => $_POST['title'],
                ],
                'artist' => [
                    'S' => $_POST['artist'],
                ],
                'year' => [
                    'N' => $_POST['year'],
                ],
                'img_s3_location' => [
                    'S' => $_POST['img_s3_location'],
                ],

            ],
            'ReturnConsumedCapacity' => 'TOTAL',
            'TableName' => 'subscription',
        ]);
        header("Location: /Mainpage");



    }

    if ($_POST['remove'] == "remove") {

        $key = [
            'Item' => [
                'email' => [
                    'S' => $_POST['email'],
                ],
                'subscription_id' => [
                    'S' => $_POST['subscription_id'],
                ],
            ]
        ];

        music_DeleteItemByKey("subscription", $key);
        header("Location: /Mainpage");
    }

}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
