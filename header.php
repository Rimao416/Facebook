<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header('location:login.php');
    }
    $connect=new PDO("mysql:host=localhost;dbname=testing","root","");
    include ('function.php');
    if(isset($_POST['searchBtn'])){

      $search_query=preg_replace("#[^a-z 0-9?!]#i","",$_POST['searchbar']);
      header('location:search.php?query='.urlencode($search_query).'');
      
    }

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'enregistrement</title>
    
<!--    <script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.en-GB.min.js" integrity="sha512-r4PTBIGgQtR/xq0SN3wGLfb96k78dj41nrK346r2pKckVWc/M+6ScCPZ9xz0IcTF65lyydFLUbwIAkNLT4T1MA==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />
-->
<link rel="stylesheet" href="style.css">
<script src="jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

</head>
<body>

    <div class="container">

    <nav class="navbar navbar-default">
    <div class="container-fluid">
			    <div class="navbar-header">
			      	<a class="navbar-brand" href="home.php">Webslesson</a>
			    </div>

   <form class="navbar-form navbar-left" method="post">
    <div class="input-group">
    <input type="text" class="form-control" id="searchbar" name="searchbar" placeholder="Search" autocomplete="off" />
    <div class="input-group-btn">
			    			<button class="btn btn-default" type="submit" name="searchBtn" id="searchBtn">
			    				<i class="glyphicon glyphicon-search"></i>
			    			</button>
		</div>
    </div>
    <div id="countryList" style="position:absolute;width:235px;z-index:1001;"></div>
  </form>
  <ul class="nav navbar-nav navbar-right">

<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="friend_request_area">
    <span id="unseen_friend_request_area"></span>
    <i class="fa fa-user-plus fa-2" aria-hidden="true"></i>
    <span class="caret"></span>
  </a>
  <ul class="dropdown-menu" id="friend_request_list" style="width: 400px; max-height: 400px;">

  </ul>
</li>

<li><a href="profile.php?action=view"><?php echo Get_user_avatar($_SESSION["user_id"], $connect); ?> <b>Profile</b></a></li>
<li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
</ul>
</nav>
 </div>
</body>
</html>