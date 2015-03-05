<?php
require_once 'db.php';
session_start();
if( $_SERVER['REQUEST_METHOD'] == "POST") {
  $error = "";
  if( !isset( $_POST['name'],$_POST['college'],$_POST['password'],$_POST['email'],$_POST['number'],$_POST['age']) ) {
    $error = "One of the fields is missing";
    $_SESSION['err'] = $error;
    //header("Location:register.php");
  }
  if( strlen( $_POST['name'] ) > 50 || strlen( $_POST['password'] ) > 50 ) {
    $error = "name or password is too long(max 50)";
    $_SESSION['err'] = $error;
    //header("Location:register.php");
  }
  $name = mysql_real_escape_string( $_POST[ 'name' ] );
  $password = strip_tags( $_POST[ 'password' ] );
  $college = strip_tags( trim( $_POST[ 'college' ] ) );
  if ( preg_match( '/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/', $_POST[ 'email' ] ) ) {
    $error = "email is invalid";
    $_SESSION['err'] = $error;
    //header("Location:register.php");
  }
  $email = trim( $_POST[ 'email' ] );
  /*if(!(is_int($_POST['number'])&&is_int($_POST['age']))) {
    $error = "Age and number must be numeric";
    $_SESSION['err'] = $error;
    //header("Location:register.php");
  }*/
  $number = $_POST['number'];
  $age = $_POST['age'];
  //http://www.sanwebe.com/2013/03/basic-php-mysqli-usage
  $query = "SELECT * FROM `users` "
            . "WHERE name=?";
  $stmt = $db_connection->prepare($query);
  $stmt->bind_param("s",$name);
  $stmt->execute();
  $result = $stmt->get_result();
  $result = $result->fetch_array();
  $stmt->close();
  if (count($result) != 0) {
        $error = "Username already taken! Please choose another!".var_dump($result);
        $_SESSION['err'] = $error;
        //header("Location:register.php");
    }
  if(!isset($_SESSION['err'])){
    $len = 32;
    $salt = mcrypt_create_iv($len);
    $hash = hash('sha256',$pass.$salt);
    $query = "INSERT INTO `users` (`name`,`college`,`number`,`age`,`pass`,`salt`) ".
    "VALUES (?,?,?,?,?,?)";
    //http://stackoverflow.com/questions/2552545/mysqli-prepared-statements-error-reporting
    $stmt = $db_connection->prepare($query);
    if(false===$stmt) {
      die('prepare() failed: ' . htmlspecialchars($mysqli->error));
    }
    $rc = $stmt->bind_param("ssssss", $name, $college, $number,$age,$hash,$salt);
    if(false===$rc) {
      die('bind_param() failed: ' . htmlspecialchars($stmt->error));
    }
    $stmt->execute();
    if(false===$rc) {
      die('execute() failed: ' . htmlspecialchars($stmt->error));
    }
    $_SESSION['user'] = $name;
    //echo $stmt->error;
    //echo "Done";
    $stmt->close();
    header('Location:profile.php');
  }
}
?>
<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" href="regstyle.css">
</head>
<body>
<header>
  <div class = "err">
    <?php
      if( isset( $_SESSION['err'] ) ) {
        echo $_SESSION['err'];
        unset( $_SESSION['err'] );
      }
    ?>
  </div>
</header>
	<div class="box">
	  <form action="register.php" method="post">
		<ul class="list">
			<li class="main"><strong>Registration Form:</strong></li>
			<li>Name: <input class="inp" type="text" name="name" value="<?php if(isset($_POST['name'])){echo $_POST['name'];} ?>"/></li>
			<li>Password: <input class="inp" type="password" name ="password"/></li>
			<li>College: <input class="inp" type="text" name="<?php if(isset($_POST['name'])){echo $_POST['college'];}?>" value="college"/></li>
			<li>Email: <input class="inp" type="email" name="email" value="<?php if(isset($_POST['name'])){echo $_POST['email'];}?>"/></li>
			<li>Number: <input class="inp" type="number" name="number" value="<?php if(isset($_POST['name'])){echo $_POST['number'];}?>"/></li>
			<li>Age: <input class="inp" type="number" name="age" value="<?php if(isset($_POST['name'])){echo $_POST['age'];}?>"/></li>
		</ul>
		<center><input class="button" type="submit" value="Register"/></center>
	  </form>
	</div>

</body>
</html>
