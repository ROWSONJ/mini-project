<?php
    require_once 'conn.php';
    
    if(isset($_POST['login'])){
        
        $email = $_POST['email'];
        $password = $_POST['password'];

        if(empty($email)){
            $_SESSION['error'] = 'Please enter your email';
            header("location: login.php");
        }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['error'] = 'Please enter a valid email address';
            header("location: login.php");
        }else if(empty($password)){
            $_SESSION['error'] = 'Please enter your password';
            header("location: login.php");
        }else if(strlen($_POST['password'])>20 || strlen($_POST['password']) <6 ){
            $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 6 ถึง 20 ตัวอักษร';
            header("location: login.php");
        } else{
            try{
                $conn = conndb();
                $check_data = $conn->prepare("SELECT * FROM users WHERE email = :email");
                $check_data->bindParam(":email", $email);
                $check_data->execute();
                $row = $check_data->fetch(PDO::FETCH_ASSOC);

                if($check_data->rowCount() > 0){

                    if($email == $row['email']){
                        if(password_verify($password, $row['password'])){
                            $_SESSION['user_login'] = $row['user_id'];
                            header("location: profile.php");
                        }else{
                            $_SESSION['error'] = 'Wrong password!';
                            header("location: login.php");
                        }
                    }else{
                        $_SESSION['error'] = 'Wrong email!';
                            header("location: login.php");
                    }
                }else{
                    $_SESSION['error'] = "No account in system! <a href='register.php' >register</a>";
                    header("location: register.php");
                }

            }catch(PDOException $e){ 
                echo $e->getMessage();
            }
        }
        
    }
?>