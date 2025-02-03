<?php
    require("config.php");

    if(!isset($_GET["category_id"]) || !is_numeric($_GET["category_id"])) {
        header("HTTP/1.1 400 Bad Request");
        die("Request inválido");
    }

    $query = $db->prepare("
        SELECT
            products.product_id,
            products.name,
            products.image,
            categories.name AS category
        FROM
            products
        INNER JOIN
            categories USING(category_id)
        WHERE
            products.category_id = ?
    ");

    $query->execute([
        $_GET["category_id"]
    ]);

    $products = $query->fetchAll( PDO::FETCH_ASSOC );

    if( empty($products) ) {
        header("HTTP/1.1 404 Not Found");
        die("Página não existe");
    }
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <title><?php echo $products[0]["category"]; ?></title>
        <style>
            .products {
                list-style-type: none;
                display: grid;
                grid-template-columns: 1fr 1fr 1fr;
                grid-gap: 20px;
            }

            .products li {
                text-align: center;
            }

            .products li img {
                width: 100%;
            }
        </style>
    </head>
    <body>
        <main>
            <h1><?php echo $products[0]["category"]; ?></h1>
            <ul class="products">
<?php
    foreach($products as $product) {
        echo '
                <li>
                    <a href="productdetail.php?product_id=' .$product["product_id"]. '">
                        <img src="images/' .$product["image"]. '" alt="">
                        ' .$product["name"]. '
                    </a>
                </li>
        ';
    }
?>
            </ul>
<?php
    require("templates/navigation.php");
?>
        </main>
    </body>
</html>