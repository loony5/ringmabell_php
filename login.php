<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        // 안드로이드에서 받아온 POST 값을 변수에 담는다.
        $email = $_POST['email'];
        $password = $_POST['password'];

        // mysql 연결
        require_once 'connect.php';

        $sql = "select * from users_table where email = '$email'";

        $response = mysqli_query($conn, $sql);

        $result = array();
        $result['login'] = array();

        if(mysqli_num_rows($response) == 1) {

            $row = mysqli_fetch_assoc($response);

            if(password_verify($password, $row['password'])){

                $index['name'] = $row['name'];
                $index['email'] = $row['email'];
                $index['phone'] = $row['phone'];
                $index['photo'] = $row['photo'];
                $index['id'] = $row['id'];

                array_push($result['login'], $index);

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
