<?php

define('MP', 1048576);

function filterRequest($requestname)
{
    return htmlspecialchars(strip_tags($_POST[$requestname]));
}

function userImageUpload($imageRequest, $folder)
{
    global $msgError;

    //$imageName = rand(0, 10000) . $_FILES[$imageRequest]['name'];
    $imageName = $_FILES[$imageRequest]['name'];
    $imagetmp = $_FILES[$imageRequest]['tmp_name'];
    $imageSize = $_FILES[$imageRequest]['size'];
    $allowExt = array('jpg', 'jpeg', 'png', 'gif', 'webp', 'mp4');
    $strToArray = explode('.',  $imageName);
    $extension = end($strToArray);
    $extension = strtolower($extension);

    if (!empty($imageName) && !in_array($extension, $allowExt)) {
        $msgError[] = 'extension error';
    }

    if ($imageSize > 20 * MP) {
        $msgError[] = 'image over size';
    }

    if (empty($msgError)) {
        move_uploaded_file($imagetmp, '../upload/' . $folder . '/' . $imageName);
        return $imageName;
    } else {
        return 'failed';
        echo '<pre>';
        print_r($msgError);
        echo '</pre>';
    }
}

function checkAuthenticate()
{
    if (isset($_SERVER['PHP_AUTH_USER'])  && isset($_SERVER['PHP_AUTH_PW'])) {

        if ($_SERVER['PHP_AUTH_USER'] != "amrsoly" ||  $_SERVER['PHP_AUTH_PW'] != "Ekka2010") {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Page Not Found';
            exit;
        }
    } else {
        exit;
    }
}


// (
//     reset id function

//     Set @num := 0;
//     Update `workout_exercise` SET `we_id` = @num := (@num+1);
//     ALTER TABLE `workout_exercise` AUTO_INCREMENT = 1;
// )
