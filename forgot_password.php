<?php
        $connect=new PDO("mysql:host=localhost;dbname=testing","root","");
        $message='';
        session_start();
        if(isset($_POST['submit'])){
            if(empty($_POST['user_email'])){
                $message='<div class="alert alert-danger">Email Adress is required</div>';

            }else{
                    $data=array(
                        ':user_email' => trim($_POST['user_email'])
                    );  
                    $query="SELECT * FROM register_user WHERE user_email=:user_email";
                    $statement=$connect->prepare($query);
                    $statement->execute($data);
                    if($statement->rowCount()>0){
                        $result=$statement->fetchAll();
                        foreach($result as $row){
                            if($row['user_email_status']=='not verified'){
                                $message='<div clas="alert alert-info">Aventurier</div>';
                            }else{
                                $user_otp=rand(100000,999999);
                                
                                $sub_query="UPDATE register_user SET user_otp='".$user_otp."' WHERE register_user_id='".$row["register_user_id"]."'";
                                $connect->query($sub_query);
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
                                    <span class="preheader" style="color:transparent;display:none;height:0;max-height:0;max-width:0;opacity:0;overflow:hidden;mso-hide:all;visibility:hidden;width;0;">'.$message.'</span>
                                        <div class="container">
                                        '.$user_otp.'<br/>
                                    </div>
                                    </body>
                                    </html>';
                                    $result=mail($row['user_email'],"omarkayumba12345@gmail.com",$message,$headers);     
                                    if($result==1){
                                        echo "<script>alert('ENVOYE')</script>";
                                        echo '<script>window.location.replace("forgot_password.php?step2=1&code='.$row["user_activation_code"].'")</script>';
                                    }                   


                            }
                        }
                    }else{
                        $message='<div class="alert alert-danger">Email Address not found in our DTB</div>';
                    }

            }
        }
        if(isset($_POST['check_otp'])){
            if(empty($_POST['user_otp']))
            {
                $message='<div class="alert alert-danger">Enter OTP Number</div>';
            }else
            {
                $data=array(
                    ':user_activation_code' => $_POST['user_code'],
                    ':user_otp'             => $_POST['user_otp']
                );
                $query="SELECT * FROM register_user WHERE user_activation_code= :user_activation_code AND user_otp=:user_otp";
                $statement=$connect->prepare($query);
                $statement->execute($data);
                if($statement->rowCount() > 0){
                    echo '<script>window.location.replace("forgot_password?step3=1&code='.$_POST["user_code"].'")</script>';
                }else{
                    echo '<div class="alert alert-danger">WRONG OTP Number</div>';

                }
            }
        }
        if(isset($_POST['change_password'])){
            $new_password=$_POST['user_password'];
            $confirm_password=$_POST['confirm_password'];
            if($new_password == $confirm_password){

                $query= "UPDATE register_user SET user_password=? WHERE user_activation_code=?";
                $connect->query($query);
                $connect->execute(array(password_hash($new_password,PASSWORD_DEFAULT)),$_POST['user_code']);
                echo '<script>window.location.replace("login.php?reset_password=success")</script>';

            
            }else{
                $message='<div class="alert alert-danger">Les deux mots de passe ne correspondent pas</div>';
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
        <h3 align="center">Forgot Password script in PHP Using OTP</h3>
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Resend Email Verification OTP</h3>
            </div>
            <div class="panel-body">
            <?php echo $message ?>
                <?php
                    if(isset($_GET['step1'])){
                ?>
                        <form method="POST">
                            <div class="form-group">
                                <label for="">Enter Your Mail</label>
                                <input type="text" name="user_email" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-success" value="Send">
                            </div>
                        </form>

                    <?php
                    }
                    if(isset($_GET['step2'],$_GET['code'])){

                    
                    ?>
                    <form method="POST">
                        <div class="form-group">
                            <label for="">Enter OTP Number</label>
                            <input type="text" name="user_otp" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="user_code" value="<? echo $_GET['code']?>">
                            <input type="submit" name="user_otp" class="btn btn-success" value="senddd">
                        </div>
                    </form>
                    <?php
                    }
                    if(isset($_GET['step3'],$_GET['code'])){
                        ?>
                        <form method="POST">
                            <div class="form-group">
                                <label for="">Entrez le nouveau mot de passe</label>
                                <input type="password" name="user_password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Confirmez le nouveau mot de passe</label>
                                <input type="password" name="confirm_password" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="user_code" value="<?php echo $_GET['code']; ?>">
                                <input type="submit" name="change_password" class="btn btn-success" value="Change">
                            </div>
                        </form>
                    <?php
                    }
                    ?>
                
            </div>
        </div>
    </div>







</body>
</html>