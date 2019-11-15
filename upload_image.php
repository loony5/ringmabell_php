<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id'];
    $photo = $_POST['photo'];

    $path = "profile_image/$id.jpeg";
    $finalPath = "http://".$path;

    require_once 'connect.php';

    $sql = "update users_table set photo = '$finalPath' where id='$id'";

    if (mysqli_query($conn, $sql)) {

        // file_put contentes : 이미지 저장
        if (file_put_contents($path, base64_decode($photo))) {

            $result['success'] = "1";
            $result['message'] = "success";

            echo json_encode($result);
            mysqli_close($conn);

        } else {

            $result['success'] = "0";
            $result['message'] = "error";

            echo json_encode($result);
            mysqli_close($conn);

        }

    }

}

?>