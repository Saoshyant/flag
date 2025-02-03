<?php
require("config.php");

header("Content-Type: application/json");

if(isset($_POST["request"])) {
    
    if($_POST["request"] === "removeProduct" && is_numeric($_POST["product_id"])) {

        unset( $_SESSION["cart"][ $_POST["product_id"] ] );

        header("HTTP/1.1 202 Accepted");

        echo '{"message":"Accepted"}';
    }
    elseif(
        $_POST["request"] === "changeQuantity" &&
        is_numeric($_POST["product_id"]) &&
        intval($_POST["quantity"]) > 0 &&
        isset($_SESSION["cart"][ $_POST["product_id"] ]) &&
        $_SESSION["cart"][ $_POST["product_id"] ]["stock"] >= intval($_POST["quantity"])
    ) {
        /* se passou todas aquelas validações, alterar a quantidade no carrinho */
        $_SESSION["cart"][ $_POST["product_id"] ]["quantity"] = intval($_POST["quantity"]);
        
        header("HTTP/1.1 202 Accepted");

        echo '{"message":"Accepted"}';
    }
    else {
        header("HTTP/1.1 400 Bad Request");
    
        echo '{"message":"Bad Request"}';
    }
}
else {
    header("HTTP/1.1 400 Bad Request");
    
    echo '{"message":"Bad Request"}';
}
