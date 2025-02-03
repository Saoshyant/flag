<?php
    require("config.php");

    if(!isset($_GET["parent_id"]) || !is_numeric($_GET["parent_id"])) {
        header("HTTP/1.1 400 Bad Request");
        die("Request inválido");
    }

    $query = $db->prepare("
        SELECT
            c1.category_id,
            c1.name,
            c2.name AS parent_name
        FROM
            categories AS c1
        INNER JOIN
            categories AS c2 ON(c1.parent_id  = c2.category_id)
        WHERE
            c1.parent_id = ?
    ");

    $query->execute([
        $_GET["parent_id"]
    ]);

    $subcategories = $query->fetchAll( PDO::FETCH_ASSOC );

    if( empty($subcategories) ) {
        header("HTTP/1.1 404 Not Found");
        die("Página não existe");
    }
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <title><?php echo $subcategories[0]["parent_name"]; ?></title>
    </head>
    <body>
        <main>
            <h1><?php echo $subcategories[0]["parent_name"]; ?></h1>
            <ul>
<?php
    foreach($subcategories as $subcategory) {
        echo '
                <li>
                    <a href="products.php?category_id=' .$subcategory["category_id"]. '">' .$subcategory["name"]. '</a>
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