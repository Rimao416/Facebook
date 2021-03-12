<?php
       $connect=new PDO("mysql:host=localhost;dbname=testing","root","");
    include('function.php');
    session_start();
    if(isset($_POST['action'])){
        if($_POST['action'] == 'create'){
            $data=array(
                'user_id' => $_SESSION['user_id'],
                'post_content' => html_entity_decode(clean_text($_POST['content'])),
                'post_code' => md5(uniqid()),
                'post_datetime' =>get_date()
            );
            $query="INSERT INTO posts_table (user_id, post_content, post_code, post_datetime) VALUES (:user_id,:post_content,:post_code,:post_datetime)";
            $statement=$connect->prepare($query);
            $statement->execute($data);
           /* $output=array(
                'content'=>html_entity_decode(clean_text($_POST['content'])),
                'user_image'=>Get_user_avatar($_SESSION["user_id"],$connect),
                'user_name'=>$_SESSION["user_name"]);
           */     //echo json_encode($output);
       }
//       echo Get_user_name($connect,$_SESSION['user_id'])+" a pu";
$output='';       
$output .="
       <div class='panel panel-default'>
       <div class='panel-heading'>
           <div class='row'>
               <div class='col-md-9'>
                   ".Get_user_avatar_big($_SESSION["user_id"],$connect)." &nbsp;<a href='#'><b>".Get_user_name($connect,$_SESSION["user_id"])."</b></a> <span class='text-muted'>has share post</span>
               </div>
           </div>
       </div>
       <div class='panel-body' style='font-size:20px;'>
           ".$_POST['content']."
       </div>
   </div>
       ";
       echo $output;
       if($_POST['action']=='load_url_content'){
           $html=file_get_contents_url($_POST["url"][0]); 
           $doc=new DOMDocument();
           @$doc->loadHTML($html);
           $nodes=$doc->getElementsByTagName('title');
           $title=$nodes->item(0)->nodeValue;
           $description='';
           $media='';
           $link=$_POST['url'][0];
           $metas=$doc->getElementsByTagName('meta');
           for($i=0;$i<$metas.length;$i++){
               $meta_tag=$metas->item($i);
               if($meta_tag->getAttribute('name')=='description'){
                   $description=$meta_tag->getAttribute('content');
               }
               if($meta_tag->getAttribute('property')=='og:description'){
                   $description = $meta_tag->getAttribute('content');

               }
               if($meta_tag->getAttribute('name')=='twitter:description'){
                   $description=$meta_tag->getAttribute('content');

               }
               if($meta_tag->getAttribute('property')=='og:video:url'){
                   $media='
                    <div class="embed-responsive embed-responsive-16by9"><i frame
                    class="embed-responsive-item" src="'.$meta_tag->getAttribute('content').'"></iframe>
                    </div>
                   ';
               }
               if($media==''){
                   if($meta_tag->getAttribute('property')=='og:image'){
                       $media='
                        <div align="center"><img src="'.$meta_tag->getAttribute('content').'" class="img-responsive"/></div>
                       ';
                   }
               }
           }
           if($media==''){
                $media='<div align="center"><img src="avatar/not-found.png" class="img-responsive"/></div>';
          }
          $output =array(
                'title'=>$title,
                'description'=>$description,
                'media'=>$media,
                'link'=>$link

          );
          echo json_encode($output);
       }
    }
?>