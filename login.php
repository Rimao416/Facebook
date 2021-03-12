<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'enregistrement</title>
    
<!--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

</head>
<body>
<br>
    <div class="container">
        <h3 align="center">PHP Registration with Email Verification using OTP</h3>

        <br>

        <?php
        if(isset($_GET['register'])){
            if($_GET['register']=='success'){
                echo '<h1 class="text-success">Email Successfully Verified, Registration Process Completed...</h1>';
                echo '<h4>Vous serez rédiger vers la page de connexion</h4>';
                echo '<script>function pageRedirect(){
                    window.location.replace("login.php");   
                    
                }
                setTimeout("pageRedirect()",5000);
                </script>';
            }
        }
        if(isset($_GET['reset_password'])){
            if($_GET['reset_password']='success'){
                echo '<h1 class="text-success">Password Change Avec Success</h1>';
            }
        }
        ?>
        <div class="row">
            <div class="col-md-3">&nbsp</div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Login</h3>
                    </div>
                    <div class="panel-body">
                        <form method="POST" id="login_form">
                            <div class="form-group" id="email_area">
                                <label for="">Entrez l'Adresse Mail</label>
                                <input type="text" name="user_email" id="user_email" class="form-control">
                                <span id="user_email_error" class="text-danger"> </span>
                            </div>
                            <div class="form-group" id="password_area" style="display:none;">
                                <label for="">Entrez le mot de passe</label>
                                <input type="password" name="user_password" id="user_password" class="form-control">
                                <span id="user_password_error" class="text-danger"></span>
                            </div>
                            <div class="form-group" id="otp_area" style="display:none;">
                                <label for="">Entrez le numero OTP</label>
                                <input type="text" name="user_otp" id="user_otp" class="form-control">
                                <span id="user_otp_error" class="text-danger"></span>
                            </div>
                            <div class="form-group" align="right">
                                <input type="hidden" name="action" id="action" value="email">
                                <input type="submit" name="next" id="next" class="btn btn-primary" value="next">
                            </div>
                        </form>
                    </div>
                </div>
                <div align="center">
                    <b> <a href="forgot_password.php?step1=1">Forgot Password?</a> </b>
                </div>
            </div>


        </div>

        </div>
        <script src="jquery.min.js"></script>
<!--<script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>-->
  <script>
    $(function(){
        $('#login_form').on('submit',function(event){
            event.preventDefault();
            var action=$('#action').val();
            $.ajax({
                url:"login_verify.php",
                method:"POST",
                data:$(this).serialize(),
                dataType:'json',
                beforeSend:function()
                {
                    $('#next').attr('disabled','disabled')
                },
                success:function(data){
                    $('#next').attr('disabled',false);
                    if(action =='email'){
                        if(data.error != ''){
                            $('#user_email_error').text(data.error);
                        }
                        else
                        {
                            $('input:hidden').attr('value','password')
                            $('#user_email_error').text('');
                            $('#email_area').css('display','none');
                            $('#password_area').css('display','block');
                            
                        }
                    }else if(action == 'password'){
                        if(data.error != ''){
                            $('#user_password_error').text(data.error);
                        }else{
                            $('input:hidden').attr('value','otp')
                            $('#user_password_error').text('');
                            $('#password_area').css('display','none');
                            $('#otp_area').css('display','block');
                        }
                    }else{
                        if(data.error != ''){
                            $('#user_otp_error').text(data.error);
                        }else{
                            window.location.replace('home.php');
                        }
                    }
                }
            })
        })
    })
</script>
</body>
</html>
