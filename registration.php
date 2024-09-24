<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration form</title>
    
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST["submit"])){
            $fullname = $_POST["fullname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $repeat_password = $_POST["repeat_password"];
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $errors = [];
            if (empty($fullname)or empty($email)or empty($password) or empty($repeat_password)){
                array_push($errors, "All fields are required");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                array_push($errors, "Email is not valid");
            }
            if (strlen($password)<8){
                array_push($errors, "Password must be at least 8 charactes long");
            }
            if($password!==$repeat_password){
                array_push($errors, "Password does not match");
            }
            if (count($errors)>0){
                foreach ($errors as $error){
                    echo "<div class='alert alert-danger'>$error</div>"; 
                }
            }else{
                require_once "database.php";
                $stmt = $conn->prepare("INSERT INTO login(Name,password, Email) VALUES (?, ?, ?)");
                $stmt->bind_param("sss",$name, $password, $email);
            
                // Sample data
                $name =  $fullname;
             
                $email =  $email;
                $password = $passwordHash;
            
                $stmt->execute();
            }
        }
        ?>
        <form action="" method="post">
        <div class="form-group">
        <input type="text" class="form-control" name="fullname" placeholder="full name">
    </div>
    <div class="form-group">
        <input type="email"class="form-control" name="email" placeholder="email">
    </div>
    <div class="form-group">
        <input type="password" class="form-control"name="password" placeholder="password">
    </div>
    <div class="form-group">
        <input type="text"class="btn btn-primary" name="repeat_password" placeholder="repeat_password">
    </div> <div class="form-btn">
        <input type="submit" value="Register" name="submit">  
    </div>
    </div>

        </form>
        <?php
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "srabonty";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

if (!$conn){
    die("Something went worng;");
}
?>
</body>
</html>