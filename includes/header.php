<?php 
  include ( './includes/functions.php' );
  include('./includes/connection.php');
  include ( './includes/Mobile_Detect.php' ) ; // for android detect //////
  session_start();
  $you_loged_in = false;
  $detect       = new Mobile_Detect();
  if ($detect->isMobile()) {
    // android mobile //
    $mobile = true;
  } else {
    // disktop //
    $mobile = false;
  }
  /// check if loged in ///
  if (isset($_SESSION['username'])) {
    $you_loged_in = true;
  } else {
    $you_loged_in   = false;
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="includes/images/website_icon.png">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>VideoTube &bull; <?php echo page_title( 'Share Your Videos with the World!' ); ?></title>

    <!-- Bootstrap -->
    <link href="./includes/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--v Custom style for the header spically the navbar -->
    <link href="./includes/css/customStyle.css" rel="stylesheet">
    <!-- My Style -->
    <link href="./includes/css/myStyle.css?3.9" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="clearfix">
   <div role="navbar" class="blog-masthead  navbar-default" id="nav_style">
        <?php if ($mobile) {
          echo '<h2 class="pull-right" style="margin-top: 6px;margin-bottom: 0;'. 
            'margin-right: 30px; color: #ccf0ff66">Familytube</h2>';
        }else {
          echo '<h3 class="pull-right" style="margin-top: 6px;margin-bottom: 0;'. 
            'margin-right: 20px; color: #ccf0ff66">Familytube</h3>';
        }?>
        <!-- For toggle buttom -->
        <div class="navbar-header" style="float: left;" id="toggle_button">
                <button type="button" style="background: #428BCA; border: none;" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar" style="background: #000"></span>
                  <span class="icon-bar" style="background: #000"></span>
                  <span class="icon-bar" style="background: #000"></span>
                </button>

          </div>
          <!-- End toggle buttom -->
        <div class="container-fluid" style="width: <?php if ($you_loged_in) echo '70'; else echo '65'; ?>%; margin: 0 auto;">
          
          <div class="blog-nav navbar-collapse collapse" id="navbar" style="float: left;">
            <div class="nav navbar-nav">
               <!-- Search Form -->
              <form action="./search.php" style="padding-top: 9px; padding-left: 10px; " 
                class="navbar-right" id="search_form" method="post">

                  <input style="background: #eff9fd;border: none; border-radius: 5px;padding-right: 40px;width: 40%;" 
                    type="text" name="search_box" placeholder="Search about something" onfocus="focusFunction()" 
                      onblur="onblurFunction()" id="search_box" />

                  <button type="submit" style="position: relative;right: 30px;width: 5% ;border: none; background: #eff9fd;" 
                    class="glyphicon glyphicon-search"></button>
              </form>
              <!-- End Search Form -->
              <a class="blog-nav-item nav_element <?php if ($page == 'home') echo 'active';  ?>" href="index.php">HOME</a>
              <a class="blog-nav-item nav_element <?php if ($page == 'popular_videos') echo 'active';  ?>" href="popularVideos.php">POPULAR VIDEOS</a>
              <a class="blog-nav-item nav_element <?php if ($page == 'latest_videos') echo 'active';  ?>" href="latestVideos.php">LATEST VIDEOS</a>
              <a class="blog-nav-item nav_element <?php if ($page == 'members') echo 'active';  ?>" href="members.php">MEMBERS</a>
              <?php if (!$you_loged_in) {
                      if ($page == 'login') echo '<a class="blog-nav-item nav_element active" href="login.php">LOGIN</a>';
                      else echo '<a class="blog-nav-item nav_element " href="login.php">LOGIN</a>';
              } else {
                  if ($page == 'profile') echo '<a class="blog-nav-item nav_element active" href="profile.php">PROFILE</a>';
                  else echo '<a class="blog-nav-item nav_element" href="profile.php">PROFILE</a>';
                  echo '<a class="blog-nav-item nav_element" href="includes/logout.php">LOGOUT</a>';
                } ?>
              
            </div>
          </div>
  
        </div> 
      </div>