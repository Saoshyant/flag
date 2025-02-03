<?php
    require("config.php");

    if(!isset($_GET["product_id"]) || !is_numeric($_GET["product_id"])) {
        header("HTTP/1.1 400 Bad Request");
        die("Request inválido");
    }

    $query = $db->prepare("
        SELECT product_id, name, description, price, stock, image, category_id
        FROM products
        WHERE product_id = ?
    ");

    $query->execute([
        $_GET["product_id"]
    ]);

    $product = $query->fetch( PDO::FETCH_ASSOC );

    if( empty($product) ) {
        header("HTTP/1.1 404 Not Found");
        die("Página não existe");
    }
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <title><?php echo $product["name"]; ?></title>
        <style>
            main {
                max-width: 980px;
                margin: 0 auto;
                display: grid;
                grid-template-columns: 2fr 1fr;
            }
            
            main > div:first-child img {
                width: 100%;
            }
        </style>
    </head>
    <body>
        <h1><?php echo $product["name"]; ?></h1>
        <main>
            <div>
                <div><?php echo $product["description"]; ?></div>
                <div>
                    <img src="images/<?php echo $product["image"]; ?>" alt="">
                </div>
            </div>
            <div>
                <div><?php echo $product["price"]; ?> €</div>
                <form method="post" action="cart.php">
                    <div>
                        <label>
                            Quantidade
                            <input
                                type="number"
                                name="quantity"
                                required
                                min="1"
                                max="<?php echo $product["stock"]; ?>"
                                value="1"
                            >
                        </label>
                        <input type="hidden" name="product_id" value="<?php echo $product["product_id"]; ?>">
                        <button type="submit" name="send">Adicionar ao Cesto</button>
                    </div>
                </form>
            </div>
        </main>
        <nav>
            <a href="products.php?category_id=<?php echo $product["category_id"]; ?>">
                Voltar à Listagem
            </a>
        </nav>
    </body>
</html>