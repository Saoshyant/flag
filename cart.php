<?php
    require("config.php");

    if(isset($_POST["send"]) && intval($_POST["quantity"]) > 0) {
        
        $query = $db->prepare("
            SELECT product_id, name, price, stock
            FROM products
            WHERE product_id = ?
              AND stock >= ?
        ");

        $query->execute([
            $_POST["product_id"],
            $_POST["quantity"]
        ]);

        $product = $query->fetch( PDO::FETCH_ASSOC );

        if(!empty($product)) {

            $_SESSION["cart"][ $product["product_id"] ] = [
                "product_id" => $product["product_id"],
                "quantity" => intval($_POST["quantity"]),
                "name" => $product["name"],
                "price" => $product["price"],
                "stock" => $product["stock"]
            ];
        }

        /* forçar que o utilizador entre na página
           novamente mas por GET em vez de POST */
        header("Location: cart.php");
    }
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <title>Carrinho</title>
        <style>
            table, tr, th, td {
                border: 1px solid #000;
                border-collapse: collapse;
            }
        </style>
        <script>
            document.addEventListener("DOMContentLoaded", () => {

                function calculateTotal() {
                    // primeiro passo, obter todos os produtos da pagina
                    const products = document.querySelectorAll('table tr[data-product-id]');

                    let total = 0;

                    // segundo passo, percorrer todos os produtos obtidos e encontrar o preço e quantidade de cada um
                    for(let product of products) {

                        const input = product.getElementsByTagName("input")[0];

                        const subtotal = product.dataset.price * input.value;

                        // terceiro passo, ir somando os subtotais a uma variavel de total já existente
                        total += subtotal;
                    }
                    
                    // passo final, escrever no HTML o total calculado
                    const totalHTML = document.querySelector('table tr:last-child td[colspan="2"]');
                    totalHTML.textContent = total.toFixed(2) + "€";
                }
                
                const buttons = document.getElementsByClassName("remove-button");
                for(let button of buttons) {
                    
                    button.addEventListener("click", () => {
                        
                        const tr = button.parentNode.parentNode;
                        const product_id = tr.dataset.productId;

                        fetch("requests.php", {
                            method: "POST",
                            headers: {
                                "Content-Type":"application/x-www-form-urlencoded"
                            },
                            body: "request=removeProduct&product_id=" + product_id
                        })
                        .then(response => response.json())
                        .then(result => {
                            tr.remove();
                            calculateTotal();
                        })
                        .catch(error => alert("Ocorreu um erro"));
                    });
                }

                const quantityInputs = document.getElementsByClassName("quantity-input");
                for(let input of quantityInputs) {
                    
                    input.addEventListener("change", () => {
                        
                        const tr = input.parentNode.parentNode;
                        const product_id = tr.dataset.productId;

                        //console.log( input.value );
                        fetch("requests.php", {
                            method: "POST",
                            headers: {
                                "Content-Type":"application/x-www-form-urlencoded"
                            },
                            body: "request=changeQuantity&product_id=" + product_id + "&quantity=" + input.value
                        })
                        .then(response => response.json())
                        .then(result => {

                            const quantity = input.value;
                            const price = tr.dataset.price;
                            const subtotal = (price * quantity).toFixed(2);

                            /* depois de calcular o subtotal, temos que o colocar no TD relevante
                               e para isso navegar para ele primeiro */
                            tr.children[3].textContent = subtotal + "€";

                            calculateTotal();
                        })
                        .catch(error => alert("Ocorreu um erro"));

                    });
                }
            });
        </script>
    </head>
    <body>
<?php
    if( !empty($_SESSION["cart"]) ) {
?>
        <table>
            <tr>
                <th>Nome</th>
                <th>Quantidade</th>
                <th>Preço</th>
                <th>Subtotal</th>
                <th>Remover</th>
            </tr>
<?php
        $total = 0;

        foreach($_SESSION["cart"] as $item) {

            $subtotal = $item["price"] * $item["quantity"];
            $total += $subtotal;

            echo '
                <tr data-product-id="' .$item["product_id"]. '" data-price="' .$item["price"]. '">
                    <td>' .$item["name"]. '</td>
                    <td>
                        <input
                            type="number"
                            class="quantity-input"
                            value="' .$item["quantity"]. '"
                            min="1"
                            max="' .$item["stock"]. '"
                        >
                    </td>
                    <td>' .$item["price"]. '€</td>
                    <td>' .$subtotal. '€</td>
                    <td>
                        <button type="button" class="remove-button">X</button>
                    </td>
                </tr>
            ';
        }
?>
            <tr>
                <td colspan="3"></td>
                <td colspan="2"><?php echo $total; ?>€</td>
            </tr>
        </table>
<?php
    }
    else {
        echo "<p>Ainda não tem nada no carrinho</p>";
    }
?>
        <nav>
            <a href="./">Voltar à Home</a>
            <a href="checkout.php">Efectuar Encomenda</a>
        </nav>
    </body>
</html>
