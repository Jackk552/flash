

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlashPoint</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    
    <div class="wrapper">
        <form action="register.php" method="post" name="form">
          <h1>FlashPoint!</h1>
           <h3>Sign-Up</h3>
          
           
           <div class="input_container">
            <div class="contain_input">
                <input type="text" autocomplete="off" placeholder="Enter Username" name="username" required style="padding: 5px;"></input>
            </div>
          </div>  
      
          <div class="input_container">
            <div class="contain_input">
                <input type="text" autocomplete="off" placeholder="Enter First Name" name="first_name" required style="padding: 5px;">
            </div>
          </div>
      
          <div class="input_container">
            <div class="contain_input">
                <input type="text" autocomplete="off" placeholder="Enter Last Name" name="last_name" required style="padding: 5px;">
            </div>
          </div>
      
          <div class="input_container">
            <div class="contain_input">
              <input type="Password" autocomplete="off" placeholder="Enter Password"value="" id="myInput"  id="Password" name="password" required style="padding: 5px;">
            </div>
          </div>
      
          <div class="show_pass"> 
            <div class="Show-password">
              <input type="checkbox" onclick="myFunction()">Show Password</input> 
            </div>
          
          
          </div>
              <div class="container">
            <input type="submit" name="signUp" value="Log-in" class="submit">
              </div>
      
         
        
      
          <div class="waterhell">
             <p></p>Already have an account? <a href="index.php ">Sign-Up</a></p>
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