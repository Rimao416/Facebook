<?php
    $connect=new PDO("mysql:host=localhost;dbname=testing","root","");
    session_start();
    $error='';
    $next_action='';
    
    if(isset($_POST["action"])){
        if($_POST["action"]=='email'){
            if($_POST["user_email"] != ''){
                $data=array(':user_email' => $_POST["user_email"]);
                $query="SELECT * FROM register_user WHERE user_email= :user_email";
                $statement=$connect->prepare($query);
                $statement->execute($data);
                $total_row=$statement->rowCount();
                if($total_row==0){
                    $error="Email Adress Not Found";
                }else{
                    $result=$statement->fetchAll();
                        $_SESSION['user_email']=$_POST['user_email'];
                    foreach($result as $row){
                        $_SESSION['register_user_id']=$row['register_user_id'];
                        $_SESSION['user_name']=$row['user_name'];
                        $_SESSION['user_password']=$row['user_password'];
                    }
                    $next_action='password';
                }
            }else{
                $error='Email Adress Is Required';
                $next_action='email';
            }
        }if($_POST['action']=='password'){
            if($_POST['user_password'] != ''){
                if(password_verify($_POST['user_password'],$_SESSION['user_password'])){
                    $login_otp=rand(100000,999999);
                    $data=array(
                        ':user_id' => $_SESSION['register_user_id'],
                        ':login_otp' => $login_otp,
                        ':last_activity' => date('d-m-y h:i:s')
                    );  
                    $query="INSERT INTO login_data(user_id, login_otp, last_activity) VALUES (:user_id, :login_otp, :last_activity)";
                    $statement=$connect->prepare($query);
                    if($statement->execute($data)){

                        $_SESSION['login_id'] = $connect->lastInsertId();
                        $_SESSION['login_otp'] = $login_otp;


                        $headers = "MIME-Version: 1.0"."\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
                        $headers .= 'From: Omarkayumba12344445@gmail.com'."\r\n". 'Reply-to: Omarkayumbzsdqdq@gmail.com'."\r\n".'X-Mailer:PHP/'.phpversion();
                        $message='<!doctype html>
                            <html lang="fr">
                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                                <meta http-equiv="X-UA-Compatible" content="ie-edge">
                                <title>Document</title>
                            </head>
                            <body>
                                <div class="container">
                                Verification code For Login<br/>
                                For verify your login details, enter this verification code when prompted: <br/>
                                '.$login_otp.'
                            </div>
                            </body>
                            </html>';
                            $result=mail("dido@gmail.com","omarkayumba12345@gmail.com",$message,$headers);    
                            $erreur=''; 
                            $next_action='otp';



                    }else{
                        $error='erreur';
                        $next_action='password';
                    }
                }else{
                    $error='faux mot de passe';
                    $next_action='password';
                }
            }else{
                $error='Password is required';
                $next_action='password';
            }
        }
        if($_POST['action']=='otp'){
            if($_POST['user_otp'] !=''){
                if($_SESSION['login_otp']==$_POST['user_otp']){
                    $_SESSION['user_id']=$_SESSION['register_user_id'];
                    unset($_SESSION['user_email']);
                    unset($_SESSION['register_user_id']);
                    unset($_SESSION['user_password']);
                    unset($_SESSION['login_otp']);
                
                }else{
                    $error='Wrong OTP Number';
                    $next_action='OTP';
                }                

            }else{
                $error='OTP Number is required';
                $next_action='otp';
            }
        }
        $output=array(
            'error' =>$error,
            'next_action'=>$next_action
        );

        echo json_encode($output);
    }
?>