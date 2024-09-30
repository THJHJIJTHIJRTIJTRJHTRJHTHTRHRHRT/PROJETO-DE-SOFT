<?php
// app/models/Sale.php
class Sale {
    private $conn;
    private $table_name = "sales";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para ler todas as vendas
    public function read() {
        $query = "
            SELECT 
                s.id, 
                u.name AS user_name, 
                p.name AS product_name, 
                s.quantity, 
                s.sale_date
            FROM 
                " . $this->table_name . " s
            JOIN users u ON s.user_id = u.id
            JOIN products p ON s.product_id = p.id
            ORDER BY s.sale_date DESC
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt; // Retorna o objeto PDOStatement
    }

    // Método para criar uma nova venda
    public function create($user_id, $product_id, $quantity) {
        $query = "INSERT INTO " . $this->table_name . " (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";

        $stmt = $this->conn->prepare($query);

        // Sanitizando os dados
        $user_id = htmlspecialchars(strip_tags($user_id));
        $product_id = htmlspecialchars(strip_tags($product_id));
        $quantity = htmlspecialchars(strip_tags($quantity));

        // Bind dos parâmetros
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':quantity', $quantity);

        // Executando o comando
        if ($stmt->execute()) {
            return true; // Venda criada com sucesso
        }

        return false; // Falha ao criar a venda
    }

    // Método para ler uma venda específica pelo ID
    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna a venda como um array associativo
    }

    // Método para deletar uma venda
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute(); // Retorna verdadeiro se a venda foi deletada
    }
}


class Product {
    private $conn;
    public $id;
    public $name;
    public $description;
    public $price;
    public $category;
    public $image;
    public $quantity; // Alterando a propriedade para quantity

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO products (name, description, price, category, image, quantity) VALUES (:name, :description, :price, :category, :image, :quantity)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':quantity', $this->quantity); // Ligação da quantidade

        return $stmt->execute();
    }

    public function read() {
        $query = "SELECT * FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    public function readByCategory($category) {
        $query = "SELECT * FROM products WHERE category = :category";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category', $category);
        $stmt->execute();
        return $stmt;
    }

    public function readOne($id) {
        $query = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id) {
        $query = "UPDATE products SET name = :name, description = :description, price = :price, category = :category, image = :image, quantity = :quantity WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':quantity', $this->quantity); // Ligação da quantidade

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function addToCart($id, $quantity) {
        session_start();
    
        // Busca o produto pelo ID
        $product = $this->readOne($id);
        
        // Se o carrinho não existir, inicializa-o
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    
        // Verifica se o produto já está no carrinho
        $productFound = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $product['id']) {
                // Se o produto já estiver no carrinho, atualiza a quantidade
                $item['quantity'] += $quantity; // Alterando para quantity
                $productFound = true;
                break;
            }
        }
    
        // Se o produto não estiver no carrinho, adiciona-o
        if (!$productFound) {
            $_SESSION['cart'][] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'description' => $product['description'],
                'quantity' => $quantity // Alterando para quantity
            ];
        }
    }
}
?>
