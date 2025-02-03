<?php
    require("config.php");

    $query = $db->prepare("
        SELECT category_id, name
        FROM categories
        WHERE parent_id = 0
    ");

    $query->execute();

    $categories = $query->fetchAll( PDO::FETCH_ASSOC );
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <title>Mega Ultra Akea</title>
    </head>
    <body>
        <main>
            <ul>
<?php
    foreach($categories as $category) {
        echo '
                <li>
                    <a href="subcategories.php?parent_id=' .$category["category_id"]. '">' .$category["name"]. '</a>
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