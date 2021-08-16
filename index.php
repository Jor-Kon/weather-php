<?php
require_once "config.php";

$email = "";
$password = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter email.";
    } else{
        $email = $input_email;
    }
    $input_password = trim($_POST["password"]);
    if(empty($input_password)){
        $password_err = "Please enter password.";
    } else{
        $password = $input_password;
    }

    if(empty($email_err) && empty($password_err)){
        $sql = "SELECT password FROM users WHERE email = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            $param_email = $email;

            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                $correct_password = $row["password"];

                if($correct_password == $password){
                    header("location: create.php");
                    exit();
                }else{
                    echo "Wrong password!";
                }
                
            } else{
                echo "error";
            }
        }

        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Weather php app</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</head>

<body>
    <div class="mx-auto" style="width: 600px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mx-auto" style="width: 100px;">Sign in</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err;?></span>
                        </div>
                        <div class="mt-3">
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="create.php" class="btn btn-secondary ml-2">Sign up</a>
                        </div>


                    <!-- <div class="form-group">
                        <label>Sign in</label>
                        <h2 class="pull-left">Sign up</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Sign up</a>
                    </div> -->
                    
                </div>
            </div>        
        </div>
    </div>
</body>
</html>