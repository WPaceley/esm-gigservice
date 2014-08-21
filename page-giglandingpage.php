<?php
	/* 
	* Template Name: Gig Landing Page
	*/
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Eastman Gig Service</title>

    <link href="wp-content/themes/gigservice/css/bootstrap.min.css" rel="stylesheet">
    <link href="wp-content/themes/gigservice/css/cover.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="site-wrapper">
        
      <div class="site-wrapper-inner">

        <div class="cover-container">
            
          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">Eastman Gig Service</h3>
              <ul class="nav masthead-nav">
                <li><a href="https://www.esm.rochester.edu/iml/blog/faq">FAQ</a></li>
                <li><a href="https://www.esm.rochester.edu/iml/blog/gig-service-contact">Contact</a></li>
                <li class="active"><?php if ( is_user_logged_in() ) { ?>
					<a href="<?php echo wp_logout_url(); ?>" title="Logout">Logout</a>
 				<?php } else {
    				echo '<a href="http://www.esm.rochester.edu/iml/blog/wp-login.php" id="login-header">Log In</a>';
				} ?></li>
              </ul>
            </div>
          </div>

          <div class="inner cover">
            <h1 class="cover-heading">Hire an Eastman musician.</h1>
            <p class="lead">The Eastman School of Music is known in the Rochester community for providing excellent musicians for local events and occasions. The Gig Service helps connect current Eastman students with local clients searching for musicians.</p>
            <p class="lead">
              <a href="https://www.esm.rochester.edu/iml/blog/student-home/" class="btn btn-lg btn-esm">Find Gigs</a>
            <a href="https://www.esm.rochester.edu/iml/blog/client-home/" class="btn btn-lg btn-esm">Hire Musicians</a>
            </p>
          </div>

		  <div class="mastfoot">
    	  	<div class="inner">
        		<a href="http://www.esm.rochester.edu/iml/">Institute for Music Leadership</a> | 
            	<a href="http://www.esm.rochester.edu/iml/careers/">Careers and Professional Development</a>
        	</div>
    	  </div>
          
        </div>

      </div>
      
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="wp-content/themes/gigservice/js/bootstrap.min.js"></script>
  </body>
</html>
