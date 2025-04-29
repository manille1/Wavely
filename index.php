<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wavely.</title>
</head>
<body>
    <?php
        $componentName = !empty($_GET['component'])
        ? htmlspecialchars($_GET['component'], ENT_QUOTES, 'UTF-8')
        : 'feed';

        if (!empty($_SESSION['auth'])) {
            if (!isset($_GET['component'])){
                $componentName = 'feed';
            }

            if(file_exists("Controller/$componentName.php")){
                require "Controller/$componentName.php";
            } else {
                require "Controller/feed.php";
                throw new Exception("Component '$componentName' does not exist, sorry !");
            }

        } else {
            require "Controller/login.php";
            throw new Exception("Component '$componentName' does not exist");
        }
    ?>
</body>
</html>