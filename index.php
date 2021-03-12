<?php
session_start();
if(isset($_SESSION['user_id'])){
    header('location:home.php');
}
include('function.php');


$connect=new PDO("mysql:host=localhost;dbname=testing","root","");
    $message='';
    $error_user_name='';
    $error_user_email='';
    $error_user_password='';
    if(isset($_POST['register'])){
        if(empty($_POST['user_name'])){
            $error_user_name="<label class='text-danger'>Entrez le nom</label>";
        }else{
            $user_name=trim($_POST['user_name']);
            $user_name=htmlspecialchars($user_name);
        }
        if(empty($_POST['user_email'])){
            $error_user_name="<label class='text-danger'>Entrez le mail</label>";
        }else{
            $user_email=trim($_POST['user_email']);
            if(!filter_var($user_email,FILTER_VALIDATE_EMAIL)){
                $error_user_email="<label class='text-danger'>Entrez le mail valide</label>";
            }

        }
        if(empty($_POST['user_password'])){
            $error_user_password='<label class="text-danger">Entrez le mot de passe</label>';
        }else{
            $user_password=trim($_POST['user_password']);
            $user_password=password_hash($user_password,PASSWORD_DEFAULT);
        }
        if($error_user_name=='' && $error_user_email =='' && $error_user_password==''){
            $user_activation_code=md5(rand());
            $user_otp=rand(100000,999999);
            $data=array(
                ':user_name'=>$user_name,
                ':user_email'=>$user_email,
                ':user_password'=>$user_password,
                ':user_activation_code'=>$user_activation_code,
                ':user_email_status' => 'not_verified',
                ':user_otp'=>$user_otp
                );
        $query="INSERT INTO register_user(user_name, user_email, user_password, user_activation_code, user_email_status, user_otp) SELECT * FROM 
        (SELECT :user_name, :user_email, :user_password, :user_activation_code, :user_email_status, :user_otp) AS tmp WHERE NOT EXISTS (SELECT
        user_email FROM register_user WHERE user_email =:user_email) LIMIT 1";
        $statement=$connect->prepare($query);
        $statement->execute($data);
        if($connect->lastInsertID()==0){
            $message="<label class='text-danger'>Email Already Register</label>";
        }else{
            $user_avatar=make_avatar(strtoupper($user_name[0]));
            $query="UPDATE register_user SET user_avatar=? WHERE register_user_id=?";
            $statement=$connect->prepare($query);
            $statement->execute(array($user_avatar,$connect->lastInsertID()));
            $headers = "MIME-Version: 1.0"."\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
            $headers .= 'From: Omarkayumba12345@gmail.com'."\r\n". 'Reply-to: Omarkayumba12345@gmail.com'."\r\n".'X-Mailer:PHP/'.phpversion();
            $message='<!doctype html>
                <html lang="fr">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie-edge">
                    <title>Document</title>
                </head>
                <body>
                    <p>For verify your email address, enter this verification code when prompted: <b>'.$user_otp.'</b>.</p>
                </body>
                </html>';
                $result=mail($user_email,"omarkayumba12345@gmail.com",$message,$headers);
                if($result==1){
                    echo "<script>alert('Verifie Ta boite mail pour le code de vérification')</script>";
                    header('location:email_verify.php?code='.$user_activation_code);        
                }else{
                    echo "<script>alert('erreur')</script>";
                }
    
        }   
        }
    }    


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'enregistrement</title>
    <script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <br>
    <div class="container">
        <h3 align="center">PHP Registration with Email Verification using OTP</h3>

        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Registration</h3>
            </div>
            <div class="panel-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="">Enter Your Name</label>
                        <input type="text" name="user_name" class="form-control">
                        <?php echo $error_user_name ?>
                    </div>
                    <div class="form-group">
                        <label for="">Enter Your Email</label>
                        <input type="email" name="user_email" class="form-control">
                        <?php echo $error_user_email ?>
                    </div>
                    <div class="form-group">
                        <label for="">Enter Your Password</label>
                        <input type="password" name="user_password" class="form-control">
                        <?php echo $error_user_password ?>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="register" class="btn btn-success" value="Click to register">
                        <a href="resend_email_otp.php" class="btn btn-default">Resend OTP</a>
                        <a href="login.php">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>