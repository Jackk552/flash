


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> 
  <title>FlashPoint</title>
</head>
  <!-- Custom Styles -->
<body>
    

<div class="wrapper">
  <form action="register.php" method="post" name="form">
    <h1>FlashPoint!</h1>
     <h3>Sign-In</h3>
    <div class="input_container">
      <div class="contain_input">
          <input type="text" autocomplete="off" placeholder="Enter Username" name="username" required style="padding: 5px;"></input>
          <i class='bx bxs-user' id="user_icon"></i>
      </div>
    </div>  
 
    <div class="input_container">

      <div class="contain_input">
        <input type="Password" autocomplete="off" placeholder="Enter Password"value="" id="myInput"  id="Password" name="password" required style="padding: 5px;">
        <i class='bx bxs-lock-alt' id="pass_icon"></i>
      </div>
    </div>


    <div class="show_pass"> 
      <div class="Show-password">
        <input type="checkbox" onclick="myFunction()">Show Password</input> 
      </div>
    <div class="forgot_pass"> 
      <a href="" >Forgot Password?</a>
    </div>
    
    </div>
        <div class="container">
      <input type="submit" name="signIn" value="Log-in" class="submit" >
        </div>

   
  

    <div class="waterhell">
       <p></p>Don't have an account? <a href="signup.php">Register</a></p>
       </br>
    </div>
    </br>
    <h3>
      <marquee>
        <p style="color:white">Self-Assessment Application for ICT Students</p>
      </marquee>
    </h3>
  </form>
</div>
  <script>
  function myFunction()
  {
    var x = document.getElementById("myInput");
    if (x.type === "password")
    {
      x.type = "text";
    }
    else
    {
      x.type = "password";
    }
  } 
</script>
</body>
 </html>