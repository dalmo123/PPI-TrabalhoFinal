<?php
require_once "conexao.php"; // Inclua o arquivo de conexão
$conn = new Conexao();

$sql = "SELECT id, nome, tipo_conta, foto_perfil_nome, foto_perfil_tipo, foto_perfil_dados FROM usuarios WHERE id != 1"; // Não inclui o administrador
$stmt = $conn->conexao->prepare($sql);
$stmt->execute();
?>

<!DOCTYPE html>
<html>
<head>
    <title>SALVAR | Lista de Usuários</title>
    <meta charset="utf-8">
    <!-- Arquivos CSS e JavaScript do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- Estilos CSS personalizados -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/lista.css">
    <link rel="icon" type="image/x-icon" href="imagens/brand.png">
</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-custom navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><img src="imagens/Logo_transp.png" class="img-fluid" width="200" title="Logo Sistema Salvar" alt=""></a>
            <!-- Links à esquerda -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item text-center">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="sobre.php">Sobre</a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="lista_itens.php">Lista de Usuários</a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="cadastro_usuario.php">Cadastro</a>
                    </li>
                </ul>
            </div>
            <!-- Botão Burger -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon text-white"></span>
            </button>
        </div>
    </nav>
</header>
<body>
    <div class="svg-background">
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 1920 1080">
            <!-- Parte inferior ondulada -->
            <path d="M0 0 L0 200 Q 480 350, 960 200 Q 1440 50, 1920 200 L1920 0 Z" fill="url(#grad)" />
            <!-- Definição do gradiente -->
            <defs>
                <linearGradient id="grad" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" style="stop-color:#429dff;stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#0056b3;stop-opacity:1" />
                </linearGradient>
            </defs>
        </svg>
    </div>

    <!-- Container Principal -->
    <div class="container content mt-5" id="container">
        <h1 class="text-white">Lista de Usuários</h1>
        <!-- Barra de Pesquisa em tempo real -->
        <div class="input-group mb-5 mt-5">
            <input type="text" class="form-control ip-group" id="search" placeholder="Pesquise ONG ou Fornecedor..." aria-label="Username" aria-describedby="basic-addon1">
            <span class="input-group-text ip-group" id="basic-addon1">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
            </span>
        </div>

        <!-- Tabela Lista de Usuários -->
        <div class="table-responsive">
            <table class="table table-striped table-bordless mt-3" id="table">
                <caption>Lista de Usuários do Sistema</caption>
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Foto</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Categoria</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>";

                        // Verificar se o usuário tem uma foto de perfil no banco
                        if ($row['foto_perfil_nome'] && $row['foto_perfil_tipo'] && $row['foto_perfil_dados']) {
                            $foto_perfil_src = "data:" . $row['foto_perfil_tipo'] . ";base64," . base64_encode($row['foto_perfil_dados']);
                            echo "<img src='{$foto_perfil_src}' class='img-fluid rounded-circle' width='80' height='80' alt=''>";
                        } else {
                            // Caso contrário, exibir a imagem padrão
                            echo "<img src='imagens/user.png' class='img-fluid rounded-circle' width='80' height='80' alt=''>";
                        }

                        echo "</td>";
                        echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tipo_conta']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Código JavaScript -->
    <script src="js/lista.js"></script>
</body>

<!-- Footer -->
<footer class="p-2 text-center text-white">
    <p>Desenvolvido por Gabriel Batista e Dalmo Scalon - Universidade Federal de Uberlândia</p>
</footer>
</html>
