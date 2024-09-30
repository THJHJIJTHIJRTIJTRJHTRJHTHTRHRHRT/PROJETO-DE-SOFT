<?php 
session_start(); 
require_once '../config/database.php';
require_once '../models/Product.php';

// Criando conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();

// Criando uma instância do modelo Product
$productModel = new Product($db);

// Buscando os lanches disponíveis
$bebidasStmt = $productModel->readByCategory('Bebidas');
$salgadosStmt = $productModel->readByCategory('Salgados');
$docesStmt = $productModel->readByCategory('Doces');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cantina - Lanches Deliciosos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Edu+AU+VIC+WA+NT+Hand:wght@400..700&display=swap');

    * {
        font-family: "Edu AU VIC WA NT Hand", cursive;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        outline: none;
        border: none;
        text-decoration: none;
        text-transform: capitalize;
        transition: all .2s linear;
    }
    :root {
    .home{background-image: url('https://th.bing.com/th/id/R.2bbe24ca76a316e5050e6bdfe4912364?rik=Rn%2bP15%2f6iSMOHw&pid=ImgRaw&r=0');}
    --light-color: #666;
    --box-shadow: 0 .5rem 1.5rem rgba(0, 0, 0, .1);
    --border: 2rem solid rgba(0, 0, 0, .1);
    --outline: 1rem solid rgba(0, 0, 0, .1);
    --outline-hover: 1rem solid var(--black);
}

.home {
    background: url('https://th.bing.com/th/id/R.2bbe24ca76a316e5050e6bdfe4912364?rik=Rn%2bP15%2f6iSMOHw&pid=ImgRaw&r=0') no-repeat center center/cover;
    color: white;
    text-align: center; /* Centraliza todo o conteúdo */
    padding: 8rem 2rem; /* Espaçamento superior e inferior */
}


.home h3 {
    font-size: 2rem; /* Diminui o tamanho da fonte do título */
    margin-bottom: 1rem;
    margin-top: 65px;
}

.home p {
    font-size: 1.2rem; /* Diminui o tamanho da fonte do parágrafo */
    margin-bottom: 2rem;
}

.home .btn {
    font-size: 1.5rem; /* Diminui o tamanho do botão */
    padding: .6rem 2rem; /* Ajusta o espaçamento do botão */
}

   
    .greeting {
    font-size: 1.2rem; /* Tamanho da fonte menor */
    color: var(--black); /* Cor do texto */
    white-space: nowrap; /* Impede a quebra de linha */
}

.greeting-container {
    position: fixed; /* Fixa o quadrinho na tela */
    top: 110px; /* Distância do topo */
    right: 20px; /* Distância da direita */
    background-color: rgba(255, 255, 255, 0.9); /* Fundo branco com leve transparência */
    border: 2px solid var(--black); /* Borda do quadrinho */
    border-radius: 10px; /* Bordas arredondadas */
    padding: 10px 15px; /* Espaçamento interno */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Sombra para dar profundidade */
    z-index: 2001; /* Mantém o quadrinho acima de outros elementos */
}




    /* Estilos do cabeçalho */
    .header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 2rem 9%;
        box-shadow: var(--box-shadow);
        background: white;
    }

    .header .logo {
        font-size: 2.5rem;
        font-weight: bolder;
        color: var(--black);
        line-height: 4.5rem;
    }

    .header .navbar {
    display: flex;
    align-items: center; /* Alinha verticalmente */
    flex-wrap: nowrap; /* Impede a quebra de linha */
}

    .header .navbar a {
        font-size: 1.7rem;
        margin: 0 1rem;
        line-height: 4.5rem;
        color: var(--black);
    }

    .header .navbar a:hover {
        color: red;
    }

    #menu-btn {
        display: none;
        font-size: 2rem;
        cursor: pointer;
    }

    /* Estilos da seção inicial */
    .home {
        background: var(--orange);
        color: white;
        text-align: center;
        padding: 8rem 2rem; /* Espaçamento superior e inferior */
    }

    .home h3 {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .home p {
        font-size: 1.5rem;
        margin-bottom: 2rem;
    }

    /* Estilos dos produtos */
    .products {
        padding: 5rem 2rem; /* Espaçamento superior e inferior */
        text-align: center;
    }

    .products h1 {
        font-size: 3rem;
        margin-bottom: 3rem;
    }

    /* Estilos do container de cartões */
    .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 2rem;
        padding: 2rem;
    }

    .card {
        background: #f9f9f9;
        border-radius: .5rem;
        box-shadow: var(--box-shadow);
        padding: 1rem;
        text-align: center;
        max-width: 300px;
        flex: 1 1 250px;
    }

    .card img {
        
        width: 100%; /* A imagem ocupa toda a largura do cartão */
        border-radius: .5rem  .5rem 0 0; /* Borda arredondada no topo */
    }

    .card h3 {
        font-size: 1.8rem;
        margin: 1rem 0;
    }

    .card p {
        font-size: 1.5rem;
        margin: .5rem 0;
    }

    /* Estilos das categorias */
    .categories {
        padding: 5rem 2rem;
        text-align: center;
    }

    .categories h1 {
        font-size: 3rem;
        margin-bottom: 3rem;
    }

    .box-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 2rem;
        padding: 2rem;
    }

    .box {
        text-align: center;
        max-width: 250px;
        flex: 1 1 200px;
        background: #f9f9f9;
        border-radius: .5rem;
        box-shadow: var(--box-shadow);
        padding: 1rem;
    }

    .box img {
        width: 100%; /* A imagem ocupa toda a largura da caixa */
        border-radius: .5rem  .5rem 0 0; /* Borda arredondada no topo */
    }

    .box h3 {
        font-size: 1.8rem;
        margin: 1rem 0;
    }

    /* Estilos dos botões */
    .btn {
        margin-top: 1rem;
        display: inline-block;
        padding: .8rem 3rem;
        font-size: 1.7rem;
        border-radius: .5rem;
        border: .2rem solid var(--black);
        color: var(--black);
        cursor: pointer;
        background: none;
        transition: background 0.3s, color 0.3s;
    }

    .btn:hover {
        background: red;
        color: white;
    }

    /* Estilos do footer */
    footer {
        background: var(--black);
        color: white;
        text-align: center;
        padding: 2rem 0;
    }

    /* Media Queries */
    @media (max-width: 768px) {
        .header {
            flex-direction: column;
        }

        .header .navbar {
            flex-direction: column;
            width: 100%;
            display: none; /* Oculta o menu padrão */
        }

        .header .navbar.active {
            display: flex; /* Exibe o menu ao ativar */
        }

        #menu-btn {
            display: block; /* Exibe o ícone do menu */
        }

        .btn {
            font-size: 1.5rem;
            padding: .5rem 2rem;
        }

        .home h3 {
            font-size: 2.5rem;
        }

        .home p {
            font-size: 1.2rem;
        }

        .products h1, .categories h1 {
            font-size: 2.5rem;
        }

        .card, .box {
            max-width: 90%; /* Permite que os cartões e caixas ocupem mais espaço em telas menores */
        }

        .home {
    background: url('https://th.bing.com/th/id/R.2bbe24ca76a316e5050e6bdfe4912364?rik=Rn%2bP15%2f6iSMOHw&pid=ImgRaw&r=0') no-repeat center center/cover;
    color: white;
    text-align: center; /* Centraliza todo o conteúdo */
    padding: 8rem 2rem; /* Espaçamento superior e inferior */
   
}
}
        .home h3 {
    font-size: 2rem; /* Diminui o tamanho da fonte do título */
    margin-bottom: 1rem;
    margin-top: 185px;
}

.home p {
    font-size: 1.2rem; /* Diminui o tamanho da fonte do parágrafo */
    margin-bottom: 2rem;
}

.home .btn {
    font-size: 1.5rem; /* Diminui o tamanho do botão */
    padding: .6rem 2rem; /* Ajusta o espaçamento do botão */
}
@media (max-width: 1000px) {
        .header {
            flex-direction: column;
        }

        .header .navbar {
            flex-direction: column;
            width: 100%;
            display: none; /* Oculta o menu padrão */
        }

        .header .navbar.active {
            display: flex; /* Exibe o menu ao ativar */
        }

        #menu-btn {
            display: block; /* Exibe o ícone do menu */
        }

        .btn {
            font-size: 1.5rem;
            padding: .5rem 2rem;
        }

        .home h3 {
            font-size: 2.5rem;
        }

        .home p {
            font-size: 1.2rem;
        }

        .products h1, .categories h1 {
            font-size: 2.5rem;
        }

        .card, .box {
            max-width: 90%; /* Permite que os cartões e caixas ocupem mais espaço em telas menores */
        }

        .home {
    background: url('https://th.bing.com/th/id/R.2bbe24ca76a316e5050e6bdfe4912364?rik=Rn%2bP15%2f6iSMOHw&pid=ImgRaw&r=0') no-repeat center center/cover;
    color: white;
    text-align: center; /* Centraliza todo o conteúdo */
    padding: 8rem 2rem; /* Espaçamento superior e inferior */
   
}
}
        .home h3 {
    font-size: 2rem; /* Diminui o tamanho da fonte do título */
    margin-bottom: 1rem;
    margin-top: 185px;
}

.home p {
    font-size: 1.2rem; /* Diminui o tamanho da fonte do parágrafo */
    margin-bottom: 2rem;
}

.home .btn {
    font-size: 1.5rem; /* Diminui o tamanho do botão */
    padding: .6rem 2rem; /* Ajusta o espaçamento do botão */
}
</style>

</head>
<body>
    <header class="header">
        <div class="logo"><i class="fas fa-utensils"></i> Cantina Site</div>
        <div id="menu-btn" onclick="toggleMenu()"><i class="fas fa-bars"></i></div>
        <nav class="navbar">
            <a href="#home">Página Inicial</a>
            <a href="#products">Lanches</a>
            <a href="#categories">Categorias</a>
            <a href="admin.php">Adicionar Lanches</a>
            <?php if (isset($_SESSION['user'])): ?>
                <div class="greeting-container">
    <span class="greeting">Olá, <?php echo htmlspecialchars($_SESSION['user']['name']); ?>!</span>
</div>


                <a href="logout.php">Sair</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <section class="home" id="home">
        <div class="content">
            <h3>Lanches mais <span>vendidos</span></h3>
            <p>Aqui você encontra <span>Sucos</span>, <span>Sobremesas</span>, <span>Comidas</span> e muito mais.</p>
            <a href="#products" class="btn">Compre agora</a>
        </div>
    </section>

    <section class="products" id="products">
        <h1 class="heading">Nossos <span>Lanches</span></h1>
        
        <!-- Bebidas -->
        <h2>Bebidas</h2>
        <div class="card-container">
            <?php while ($product = $bebidasStmt->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="card">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <p>R$ <?php echo number_format($product['price'], 2, ',', '.'); ?></p>
                    <div>
                        <?php if (isset($_SESSION['user'])): ?>
                            <form method="POST" action="cart.php">
                                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                <input type="hidden" name="name" value="<?php echo $product['name']; ?>">
                                <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                                <button type="submit" class="btn">Comprar</button>
                            </form>
                        <?php else: ?>
                            <span>Faça login para comprar</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Salgados -->
        <h2>Salgados</h2>
        <div class="card-container">
            <?php while ($product = $salgadosStmt->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="card">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <p>R$ <?php echo number_format($product['price'], 2, ',', '.'); ?></p>
                    <div>
                        <?php if (isset($_SESSION['user'])): ?>
                            <form method="POST" action="cart.php">
                                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                <input type="hidden" name="name" value="<?php echo $product['name']; ?>">
                                <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                                <button type="submit" class="btn">Comprar</button>
                            </form>
                        <?php else: ?>
                            <span>Faça login para comprar</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Doces -->
        <h2>Doces</h2>
        <div class="card-container">
    <?php while ($product = $docesStmt->fetch(PDO::FETCH_ASSOC)): ?>
        <div class="card">
            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <p>R$ <?php echo number_format($product['price'], 2, ',', '.'); ?></p>
            <div>
                <?php if (isset($_SESSION['user'])): ?>
                    <form method="POST" action="cart.php">
                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="name" value="<?php echo $product['name']; ?>">
                        <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                        <input type="hidden" name="image" value="<?php echo htmlspecialchars($product['image']); ?>">
                        <button type="submit" class="btn">Comprar</button>
                    </form>
                <?php else: ?>
                    <span>Faça login para comprar</span>
                <?php endif; ?>
            </div>
        </div>
    <?php endwhile; ?>
</div>

    </section>


    <footer>
        <p>&copy; <?php echo date('Y'); ?> Cantina Site. Todos os direitos reservados.</p>
    </footer>

    <script>
        function toggleMenu() {
            const navbar = document.querySelector('.navbar');
            navbar.classList.toggle('active'); // Adiciona/remover a classe 'active' para o menu
        }
    </script>
</body>
</html>


