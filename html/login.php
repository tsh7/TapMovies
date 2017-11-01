<?php
session_start();
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login - Tap Movies</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/modern-business.css" rel="stylesheet">

  </head>

  <body>

    <!-- Navigation -->
    
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.html">Tap Movies</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.html">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="gen.html">Generes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="atoz.html">A-Z List</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                My Account
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio">
                <a class="dropdown-item" href="login.php">Login</a>
                <a class="dropdown-item" href="registration.php">Register</a>
              </div>
            </li>
            
          </ul>
        </div>
      </div>
    </nav><header>
	
	<center>
		<div class="container">
        <?php
			if(!empty($sessData['userLoggedIn']) && !empty($sessData['userID'])){
				include 'user.php';
				$user = new User();
				$conditions['where'] = array(
					'id' => $sessData['userID'],
				);
				$conditions['return_type'] = 'single';
				$userData = $user->getRows($conditions);
		?>
        <h2>Welcome <?php echo $userData['first_name']; ?>!</h2>
        <a href="userAccount.php?logoutSubmit=1" class="logout">Logout</a>
		<div class="col-md-4">
			<p><b>Name: </b><?php echo $userData['first_name'].' '.$userData['last_name']; ?></p>
            <p><b>Email: </b><?php echo $userData['email']; ?></p>
            <p><b>Phone: </b><?php echo $userData['phone']; ?></p>
		</div>
		<div class="col-md-4">
        <?php }else{ ?>
		<h2>Login to Your Account</h2>
        <?php echo !empty($statusMsg)?'<p class="'.$statusMsgType.'">'.$statusMsg.'</p>':''; ?>
	
		<div class="col-md-4">
			<form action="userAccount.php" method="post">
				<input type="email" name="email" placeholder="EMAIL" required="" class="form-control"/><br />
				<input type="password" name="password" placeholder="PASSWORD" required="" class="form-control"/><br />
	
					<input type="submit" title="Login" name="loginSubmit" value="LOGIN" class="btn btn-primary" /><br />
				</div>
			</form>
			</div>
		<div class="col-md-4">
            <p>Don't have an account? <a href="registration.php">Register</a></p>
		</div>
        <?php } ?>
	</div>
			
</center>
    </header>

    <!-- Page Content -->
    <div class="container">
		<div class="row">
			<div class="col-md-12">
				
			</div>
		</div>
    
      <!-- /.row -->

      <!-- Portfolio Section -->
    
      <!-- /.row -->

      <!-- Features Section -->
      <!-- /.row -->

      <hr>

      <!-- Call to Action Section -->
      <div class="row mb-4">
        <div class="col-md-8">
          <p> Have Any Questions??  </p>
        </div>
        <div class="col-md-4">
          <a class="btn btn-lg btn-secondary btn-block" href="#">Contact Us</a>
        </div>
      </div>

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Tap Movies 2017</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

  </body>

</html>
