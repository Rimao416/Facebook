<?php
    include('header.php');
    $message='';

    if(isset($_POST['edit'])){
        
        
        if(empty($_POST['user_name'])){
           $message='<div class="alert alert-danger">Name is required</div>';
           
        }
        else{
            if(isset($_FILES['user_avatar']['name'])){
                $image_name=$_FILES['user_avatar']['name'];
                $valid_extensions=array('jpg','jpeg','png');
                $tempory_location=$_FILES['user_avatar']['tmp_name'];
                $extension=pathinfo($image_name, PATHINFO_EXTENSION);
                if(in_array($extension,$valid_extensions)){
                    $updload_path='avatar/'.time().'.'.$extension;
                    move_uploaded_file($tempory_location,$updload_path);
                    $user_avatar=$updload_path;
                }else{
                    $message .='<div class="alert alert-danger">Only Jpg, .Jpeg and Png Image Allowed to upload</div>';
 
                }
            }else{
                $user_avatar=$_POST['hidden_user_avatar'];
            }
            if($message==''){
                $data=array(
                ':user_name'=>$_POST["user_name"],
                ':user_avatar'=>$user_avatar,
                ':user_gender'=>$_POST['user_gender'],
                ':user_address'=>$_POST['user_address'],
                ':user_city'=>$_POST['user_city'],
                ':user_zipcode'=>$_POST['user_zipcode'],
                ':user_state'=>$_POST['user_state'],
                ':user_country'=>$_POST["user_country"],
                ':register_user_id'=>$_SESSION['user_id']
                );
                $query="UPDATE register_user SET user_name=:user_name, user_avatar=:user_avatar,
                user_gender=:user_gender, user_address=:user_address, user_city=:user_city, user_zipcode=:user_zipcode, user_state=:user_state, user_country=:user_country WHERE register_user_id=:register_user_id";
                $statement=$connect->prepare($query);
                $statement->execute($data);
                header("location:profile.php?action=view&success=1");
                
            }
        }
        
        
    }

?>
<div class="row">
    <div class="col-md-9">
        <?php
            if(isset($_GET['action'])){

                if($_GET['action']=="view"){
                    if(isset($_GET["success"])){
                        echo '<div class="alert alert-success">Profile mis à jour</div>';
                    }
                    ?>    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-9">
                                    Profile Details
                                </div>
                                <div class="col-md-3" align="right">
                                    <a href="profile.php?action=edit" class="btn btn-success btn-xs">Edit</a>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                        <?php echo $message ?>
                            <?php 
                                echo Get_user_profile_data_html($_SESSION['user_id'],$connect);
                            ?>
                        </div>
                    </div>
                <?php
                }
                if($_GET['action'] =='edit'){
                    $query=$connect->prepare("SELECT * FROM register_user WHERE register_user_id=?"); 
                    $query->execute(array($_SESSION['user_id']));
                    $result=$query->fetchAll();
                    foreach($result as $row){
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-9">
                                        Edit Profile
                                    </div>
                                    <div class="col-md-3" align="right">
                                        <a href="profile.php?action=view" class="btn btn-primary btn-xs">View</a>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form method="post" enctype="multipart/form-data">
                                    <?php
                                        include 'edit.php';
                                    ?>
                                </form>
                            </div>
                        </div>

                    <?php 
                    }

                }
                

            }
            ?>
    </div>
    <div class="col-md-3">
    </div>
</div>