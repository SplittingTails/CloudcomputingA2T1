<?php
require_once 'bootstrap/bootstrap.php';
$pageTitle = 'Main Page';
top_module($pageTitle);
nav_module($pageTitle);
?>
<?php if (isset($_SESSION['user'])) { ?>
    <div style="text-align: center;">
        <h1> Welcome to the Main Page</h1>
        User Name:

        <?php echo $_SESSION['user']['email'] ?>


        <h1>Subscriptions</h1>
        <div class="center">
            <?php
            $birthKey = [
                'Key' => [
                    'email' => [
                        'S' => $_SESSION['user']['email'],
                    ],
                ],
            ];

            $subscriptionResult = music_Query("subscription", $birthKey);
            if ($subscriptionResult['Count'] === 0) {
                echo 'No Subscriptions';
            } else {
                echo '<table class="center">';
                foreach ($subscriptionResult["Items"] as $key) {
                    echo '<form action="Post-validation" method="post">';
                    echo '<tr>';
                    echo '<td>' . $key['title']['S'] . '</td><td>' . $key['artist']['S'] . '</td><td>' . $key['year']['N'] . '</td><td><button class="formcell center" type="submit" value="remove" id="remove" name=\'remove\'>Remove</button></td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td colspan="4"><image src=\'' . $key['img_s3_location']['S'] . '\' alt=\'artist image\'</td>';
                    echo '</tr>';
                    echo '<input type="hidden" name="img_s3_location" id="img_s3_location" value="' . $key['img_s3_location']['S'] . '">';
                    echo '<input type="hidden" name="email" id="email" value="' . $_SESSION['user']['email'] . '">';
                    echo '<input type="hidden" name="subscription_id" id="subscription_id" value="' . $key['subscription_id']['S'] . '">';
                    echo '</form>';

                }
                echo '</table>';
            }
            ?>
        </div>
        <h1>Query</h1>
        <div class="Query">
            <form class="formtable center" action="Mainpage" method="post">
            <span class="formrow">
                <label class="formcell" for="title">Title: </label>
                <input class="formcell" type="text" name="title" id="title">
                <label class="formcell" for="year">Year: </label>
                <input class="formcell" type="number" name="year" id="year">
                <label class="formcell" for="artist">Artist: </label>
                <input class="formcell" type="text" name="artist" id="artist">
                </span>
                <span class="formrow">
                <button class="formcell" type="submit" value="query" id="query" name='query'>Query</button>
                </span>
            </form>
            <?php
            /*** Login form ***/
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                $keys = [];
                $result;
                if ($_POST['query'] == "query") {

                    if (!empty($_POST['title'])) {
                        $keys["title"] = [
                            'title' => [
                                'S' => $_POST['title']
                            ],
                        ];

                        #$FilterExpression = 'title = ' . $_POST['title'];
                    }
                    if (!empty($_POST['year'])) {
                        $keys["year"] = [
                            'year' => [
                                'N' => $_POST['year']
                            ],
                        ];
                    }
                    if (!empty($_POST['artist'])) {

                        $keys["artist"] = [
                            'artist' => [
                                'S' => $_POST['artist']
                            ],
                        ];


                    }


                    if (Count($keys) > 0) {
                        $result = music_Scan('music', $keys);
                        if ($result['Count'] === 0) {
                            echo "No result is retrieved. Please query again";
                        } else {

                            echo '<table class="center">';
                            foreach ($result["Items"] as $key) {
                                echo '<form action="Post-validation" method="post">';
                                echo '<tr>';
                                echo '<td>' . $key['title']['S'] . '</td><td>' . $key['artist']['S'] . '</td><td>' . $key['year']['N'] . '</td><td><button class="formcell center" type="submit" value="subscribe" id="subscribe" name=\'subscribe\'>subscribe</button></td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '<td colspan="4"><image src=\'' . $key['img_s3_location']['S'] . '\' alt=\'artist image\'</td>';
                                echo '</tr>';
                                echo '<input type="hidden" name="title" id="title" value="' . $key['title']['S'] . '">';
                                echo '<input type="hidden" name="artist" id="artist" value="' . $key['artist']['S'] . '">';
                                echo '<input type="hidden" name="year" id="year" value="' . $key['year']['N'] . '">';
                                echo '<input type="hidden" name="img_s3_location" id="img_s3_location" value="' . $key['img_s3_location']['S'] . '">';
                                echo '<input type="hidden" name="email" id="email" value="' . $_SESSION['user']['email'] . '">';
                                echo '<input type="hidden" name="subscription_id" id="subscription_id" value="' . uniqid() . '">';
                                echo '</form>';

                            }
                            echo '</table>';

                        }
                    } else {
                        echo "You have not entered any values to search";
                    }

                }
            }
            ?>
        </div>
    </div>
<?php } else {
    header('Location: /');
} ?>
<?php
end_module($pageTitle)
    ?>