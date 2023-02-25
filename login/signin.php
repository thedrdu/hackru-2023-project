<!DOCTYPE html>
<html lang="en">

    <!-- author: Raghunandan Wable -->
    
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!--Bootstrap-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

       <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

       <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

        <link href = "./signin.css" rel = "stylesheet" >
        
        <title>
            PAS: Gene Disease Codes
        </title>
    </head>
    <body class = "gradient-custom">

    <section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">
          <section>
            <h3 class="mb-5">Welcome Back!</h3>
              <form action = "signin.inc.php" method = "POST">
                <div class="form-outline mb-1">
                  <label class="form-label" for="typeEmailX-2">Rutgers Scarletmail Email</label>
                  <input name = "user_email" type="email" id="typeEmailX-2" pattern=".+@scarletmail\.rutgers\.edu" placeholder = "example@scarletmail.rutgers.edu" class="form-control form-control-lg" />
                </div>

                <div class="form-outline mb-4">
                  <label class="form-label" for="typePasswordX-2">Rutgers NETID</label>
                  <input name = "netid" type="text" id="ID" pattern="[a-zA-Z0-9]*" placeholder = "abc123" class="form-control form-control-lg" />
                </div>

                <div class="form-outline mb-4">
                  <label class="form-label" for="typePasswordX-2">Password</label>
                  <input name = "pwd" type="password" id="typePasswordX-2" minlength="10" placeholder = " Minimum 10 characters including atleast one number" pattern = "^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" class="form-control form-control-lg" />
                </div>

                <button class="btn btn-primary btn-lg btn-block" type="submit" name = "submit">Sign-In</button>
              </form>

            <h6 class = "pt-5"> Don't have an account? <a href = "./signup.php"> Sign-Up </a> </h6>
            </section>

            <?php
            
            if ( isset($_GET["error"]) ){
              if ( $_GET["error"] == "noInput" ){
                echo "</br>";
                echo "<p>Please ensure all fields are filled before proceedig!</p>";
              } else if ( $_GET["error"] == "emailNotExist" ){
                echo "</br>";
                echo "<p>An account with this email does not exist!<p>";
              } else if ( $_GET["error"] == "wrongPassword" ){
                echo "</br>";
                echo "<p>Please check your password!</p>";
              } else if ( $_GET["error"] == "notValidated" ){
                echo "</br>";
                echo "<p>Please wait for your account to be validated!</p>";
              } else if ( $_GET["error"] == "stmtFailed" ){
                echo "</br>";
                echo "<p>Something unexpected happened, please try again!</p>";
              } 
            }

            ?>            




          </div>
        </div>
      </div>
    </div>
  </div>
</section>

    </body>
</html>