<?php
// app/controllers/ProductController.php
require_once '../config/database.php';
require_once '../models/Product.php';

class ProductController {
    private $db;
    private $product;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->product = new Product($this->db);
    }

    public function create($name, $description, $price, $category, $image, $quantity) { // Alterado para 'quantity'
        $targetDir = '../uploads/'; // Diretório onde a imagem será armazenada
        $targetFile = $targetDir . basename($image['name']);
        
        // Verifica se a imagem foi carregada com sucesso
        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            // Define os atributos do produto, incluindo o caminho da imagem
            $this->product->name = $name;
            $this->product->description = $description;
            $this->product->price = $price;
            $this->product->category = $category;
            $this->product->image = $targetFile; // Adicionando a imagem
            $this->product->quantity = $quantity; // Usando 'quantity' em vez de 'quantidade'

            return $this->product->create(); // Salva o produto no banco de dados
        } else {
            echo "Desculpe, houve um erro ao fazer o upload da imagem.";
            return false; // Retorna falso em caso de erro
        }
    }

    public function read() {
        return $this->product->read();
    }

    public function readOne($id) {
        return $this->product->readOne($id);
    }

    public function update($id, $name, $description, $price, $category, $image = null, $quantity) { // Alterado para 'quantity'
        // Verifica se a imagem foi enviada para o update
        if ($image && $image['tmp_name']) {
            $targetDir = '../uploads/'; // Diretório onde a imagem será armazenada
            $targetFile = $targetDir . basename($image['name']);
            
            // Verifica se a imagem foi carregada com sucesso
            if (move_uploaded_file($image['tmp_name'], $targetFile)) {
                $this->product->image = $targetFile; // Atualiza o caminho da imagem
            } else {
                echo "Desculpe, houve um erro ao fazer o upload da imagem.";
                return false; // Retorna falso em caso de erro
            }
        }

        // Define os atributos do produto, independentemente da imagem
        $this->product->name = $name;
        $this->product->description = $description;
        $this->product->price = $price;
        $this->product->category = $category;
        $this->product->quantity = $quantity; // Usando 'quantity' em vez de 'quantidade'

        return $this->product->update($id); // Salva o produto atualizado no banco de dados
    }

    public function delete($id) {
        return $this->product->delete($id); // Chama o método delete do modelo
    }
}
?>
