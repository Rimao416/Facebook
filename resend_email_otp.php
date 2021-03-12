<?php
    $connect=new PDO("mysql:host=localhost;dbname=testing","root","");
    $message='';
    session_start();
    if(isset($_SESSION['user_id'])){
        header('location:home.php');
    }
    if(isset($_POST['resend'])){
        if(empty($_POST['user_email'])){
            $message="<div class='alert alert-danger'>Email Adress is required</div>";
        }else{
            $data=array(
                ':user_email' => trim($_POST["user_email"])
            );
            $query="SELECT * FROM register_user WHERE user_email=:user_email";
            $statement=$connect->prepare($query);
            $statement->execute($data);
            if($statement->rowCount()>0){
                $result=$statement->fetchAll();
                foreach($result as $row){
                    if($row['user_email_status']=='verified'){
                        $message='<div class="alert alert-info">L\'adresse mail est déjà verifiée, allez vous connecter</div>';
                    }else{
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
                                <p>For verify your email address, enter this verification code when prompted: <b>'.$row['user_otp'].'</b>.</p>
                            </body>
                            </html>';
                            $result=mail($row['user_email'],"omarkayumba12345@gmail.com",$message,$headers);
                            if($result==1){
                                echo "<script>alert('Verifie Ta boite mail pour le code de vérification')</script>";
                                echo '<script>window.location.replace("email_verify.php?code='.$row["user_activation_code"].'");</script>';
                            }else{
                                echo "<script>alert('erreur')</script>";
                            }

                    }
                }
            }else{
                $message='<div class="alert alert-danger">Email Adress not found</div>';
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
  <!--  <script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">--> 
    <script src="jquery.min.js"></script>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

</head>
<body>
    <br>
    <div class="container">
        <h3 align="center">Resend Email Verification OTP in PHP Registration</h3>
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Resend Email Verification OTP</h3>
            </div>
            <div class="panel-body">
                <?php echo $message; ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="">Enter Your Mail</label>
                        <input type="email" name="user_email" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="resend" class="btn btn-success" value="Send">
                    </div>
                </form>
            </div>
        </div>
    </div>







</body>
</html>