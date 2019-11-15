<?php
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        // 안드로이드에서 POST로 가져온 값을 넣는다.
        $email = $_POST['email'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];


        // password는 암호화된 단반향 해시함수 password_hash로 변환해서 넣는다.
        $password = password_hash($password, PASSWORD_DEFAULT);

        require_once 'connect.php';

        // users_table에서 입력값의 email과 같은 데이터가 있는지 뽑아내는 sql문
        $query = "select * from users_table where email = '$email'";

        // mysql에 연결해서 sql문 넣기
        $res = mysqli_query($conn, $query);

        // 검색해서 나온 데이터의 행이 1일때, (데이터가 있으면)
        if(mysqli_num_rows($res) == 1) {

            // key : success value : 2 -> 가입된 데이터가 이미 있다.
            $result["success"] = "2";
            $result["message"] = "exist";

            echo json_encode($result);
            mysqli_close($conn);

        // 검색된 데이터가 없으면, 데이터를 추가한다.
        } else {

            $sql = "insert into users_table(email, name, password, phone) values ('$email','$name','$password', '$phone')";

            if(mysqli_query($conn, $sql)){
    
                // mysql 쿼리문이 제대로 작동을 하면, result에 담아서 json형식으로 담는다.
                // key : success value : 1 -> 가입성공!
                $result["success"] = "1";
                $result["message"] = "success";
    
                echo json_encode($result);
                mysqli_close($conn);


            // 쿼리문이 작동하지 않으면, error
            } else {
    
                $result["success"] = "0";
                $result["message"] = "error";
    
                echo json_encode($result);
                mysqli_close($conn);
    
            }


        }
       
    }
?>