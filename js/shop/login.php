<?php
    require("config.php");

    if(isset($_POST["send"])) {
        
        foreach($_POST as $key => $value) {
            $_POST[$key] = trim(htmlspecialchars(strip_tags($value)));
        }
        
        if(
            filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) &&
            mb_strlen($_POST["password"]) >= 8 &&
            mb_strlen($_POST["password"]) <= 1000
        ) {
            $query = $db->prepare("
                SELECT user_id, name, password
                FROM users
                WHERE email = ?
            ");
            $query->execute([
                $_POST["email"]
            ]);

            $user = $query->fetch();
            
            if(
                !empty($user) &&
                password_verify($_POST["password"], $user["password"])
            ) {
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["user_name"] = $user["name"];
                header("Location: cart.php");
            }
            else {
                $message = "Dados incorrectos";                
            }
        }
        else {
            $message = "Dados incorrectos";
        }
    }
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <title>Efectuar Login</title>
    </head>
    <body>
        <h1>Efectuar Login</h1>
<?php
    if(isset($message)) {
        echo '<p role="alert">' .$message. '</p>';
    }
?>
        <p>Se ainda não tem conta de utilizador, <a href="register.php">efectue registo</a>.</p>
        <form method="post" action="login.php">
            <div>
                <label>
                    Email
                    <input type="email" name="email" required>
                </label>
            </div>
            <div>
                <label>
                    Password
                    <input type="password" name="password" required minlength="8" maxlength="1000">
                </label>
            </div>
            <div>
                <button type="submit" name="send">Login</button>
            </div>
        </form>
    </body>
</html>