<?php
require_once 'bootstrap/bootstrap.php';
$pageTitle = 'Register';
top_module($pageTitle);
nav_module($pageTitle)
?>
<form class="formtable center" action="Post-validation" method="post" enctype="multipart/form-data">
    <h1>Sign Up</h1>
    <span class="formrow">
    <label class="formcell" for="email">Email:</label>
    <input class="formcell" type="email" name="email" id="email"><br>
    </span>
    <?php if (isset ($_SESSION['alerts']['email_error']))
        echo '<p class="error">' . $_SESSION['alerts']['email_error'] . '</p>'; ?>
        <span class="formrow">
    <label class="formcell" for="username">Username:</label>
    <input class="formcell" type="text" name="username" id="username"><br>
        </span>
    <?php if (isset ($_SESSION['alerts']['username_error']))
        echo '<p class="error">' . $_SESSION['alerts']['username_error'] . '</p>'; ?>
        <span class="formrow">
    <label class="formcell" for="password">Password:</label>
    <input class="formcell" type="password" name="password" id="password"><br>
        </span>
    <?php if (isset ($_SESSION['alerts']['password_error']))
        echo '<p class="error">' . $_SESSION['alerts']['password_error'] . '</p>'; ?>
        <span class="formrow">

    <button class="formcell" type="submit" value="Register" id="Register" name='Register'>Register</button>
</form>
<?php
end_module($pageTitle)
    ?>