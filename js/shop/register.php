<?php
    require("config.php");

    $query = $db->prepare("
        SELECT code, name
        FROM countries
        ORDER BY name
    ");

    $query->execute();

    $countries = $query->fetchAll( PDO::FETCH_ASSOC );

    /* criar um array simples de códigos para usar na validação do formulário */
    $country_codes = [];
    foreach($countries as $country) {
        $country_codes[] = $country["code"];
    }

    if( isset($_POST["send"]) ) {

        /* sanitizar cada elemento do formulário para prevenir XSS */
        foreach($_POST as $key => $value) {
            $_POST[ $key ] = trim(htmlspecialchars(strip_tags($value)));
        }

        if(
            mb_strlen($_POST["name"]) >= 3 &&
            mb_strlen($_POST["name"]) <= 60 &&
            mb_strlen($_POST["address"]) >= 10 &&
            mb_strlen($_POST["address"]) <= 120 &&
            mb_strlen($_POST["city"]) >= 3 &&
            mb_strlen($_POST["city"]) <= 40 &&
            mb_strlen($_POST["postal_code"]) >= 4 &&
            mb_strlen($_POST["postal_code"]) <= 20 &&
            mb_strlen($_POST["vat_code"]) >= 9 &&
            mb_strlen($_POST["vat_code"]) <= 11 &&
            mb_strlen($_POST["password"]) >= 8 &&
            mb_strlen($_POST["password"]) <= 1000 &&
            filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) &&
            $_POST["password"] === $_POST["repeat_password"] &&
            in_array($_POST["country"], $country_codes) &&
            isset( $_POST["agrees"] )
        ) {
            $message = "Conta criada com sucesso";

            $query = $db->prepare("
                INSERT INTO users
                (name, email, password, address, city, postal_code, country, vat_code)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $result = $query->execute([
                $_POST["name"],
                $_POST["email"],
                password_hash($_POST["password"], PASSWORD_DEFAULT),
                $_POST["address"],
                $_POST["city"],
                $_POST["postal_code"],
                $_POST["country"],
                $_POST["vat_code"]
            ]);
            
            if($result) {
                $_SESSION["user_id"] = $db->lastInsertId();
                header("Location: cart.php");
            }
            else {
                $message = "Esta conta já existe";
            }
        }
        else {
            $message = "Informação obrigatória não preenchida correctamente";
        }
    }
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <title>Criar Conta</title>
    </head>
    <body>
        <h1>Criar Conta</h1>
<?php
    if(isset($message)) {
        echo '<p role="alert">' .$message. '</p>';
    }
?>
        <p>Se já tem uma conta de utilizador, <a href="login.php">efectue login</a>.</p>
        <form method="post" action="register.php">
            <div>
                <label>
                    Nome
                    <input type="text" name="name" required minlength="3" maxlength="60">
                </label>
            </div>
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
                <label>
                    Repetir Password
                    <input type="password" name="repeat_password" required minlength="8" maxlength="1000">
                </label>
            </div>
            <div>
                <label>
                    Morada
                    <input type="text" name="address" required minlength="10" maxlength="120">
                </label>
            </div>
            <div>
                <label>
                    Cidade
                    <input type="text" name="city" required minlength="3" maxlength="40">
                </label>
            </div>
            <div>
                <label>
                    Código Postal
                    <input type="text" name="postal_code" required minlength="4" maxlength="20">
                </label>
            </div>
            <div>
                <label>
                    País
                    <select name="country">
<?php
    foreach($countries as $country) {

        $selected = "";
        if($country["code"] === "pt") {
            $selected = " selected";
        }

        echo '
                        <option value="' .$country["code"]. '"' .$selected. '>' .$country["name"]. '</option>
        ';
    }
?>  
                    </select>
                </label>
            </div>
            <div>
                <label>
                    NIF
                    <input type="text" name="vat_code" required minlength="9" maxlength="11">
                </label>
            </div>
            <div>
                <label>
                    <input type="checkbox" name="agrees" required>
                    Concordo com os termos e condições
                </label>
            </div>
            <div>
                <button type="submit" name="send">Registar</button>
            </div>
        </form>
    </body>
</html>