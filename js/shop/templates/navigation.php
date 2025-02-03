<?php
    $cart_count = 0;
    if(isset($_SESSION["cart"])) {
        foreach($_SESSION["cart"] as $item) {
            $cart_count = $cart_count + $item["quantity"];
        }
    }
?>
            <nav>
<?php
    if(isset($_SESSION["user_id"])) {
        
        /* obter o primeiro nome da pessoa separando tudo pelos espaços */
        $name_parts = explode(" ", $_SESSION["user_name"]);

        echo '
            Olá ' .$name_parts[0]. '!
            <a href="logout.php">Efectuar Logout</a>
        ';
    }
    else {
        echo '
            <a href="register.php">Criar Conta</a>
            <a href="login.php">Efectuar Login</a>
        ';
    }
?>
                <a href="cart.php">Carrinho (<?php echo $cart_count; ?>)</a>
            </nav>
