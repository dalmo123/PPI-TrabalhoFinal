<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados de conexão com o banco de dados (já definidos no arquivo conexao.php)
    require_once "conexao.php"; // Certifique-se de que o arquivo "conexao.php" contém as credenciais

    try {
        $conn = new Conexao(); // Cria a instância de conexão usando as credenciais do arquivo "conexao.php"
        // Defina o modo de erro para exceção
        $conn->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Restante do código permanece o mesmo
        // Coletar dados do formulário, hash da senha, preparar a consulta e executar a consulta
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        $tipo_conta = $_POST["tipo_conta"];
        $telefone = $_POST["telefone"];
        $site = $_POST["site"];

        // Hash da senha usando bcrypt
        $senhaCriptografada = password_hash($senha, PASSWORD_BCRYPT);

        // Verificar se foi feito o upload da foto
        if ($_FILES['foto_perfil']['error'] == UPLOAD_ERR_OK) {
            $foto_perfil_nome = $_FILES['foto_perfil']['name'];
            $foto_perfil_tipo = $_FILES['foto_perfil']['type'];
            $foto_perfil_dados = file_get_contents($_FILES['foto_perfil']['tmp_name']);
        } else {
            // Se não houver upload, usar a foto padrão
            $foto_perfil_nome = "user.png";
            $foto_perfil_tipo = "image/png";
            $foto_perfil_dados = file_get_contents("imagens/user.png"); // Substitua pelo caminho correto
        }

        // Inserir dados do usuário e a foto de perfil no banco de dados
        $stmt = $conn->conexao->prepare("INSERT INTO usuarios (nome, email, senha, tipo_conta, telefone, site, foto_perfil_nome, foto_perfil_tipo, foto_perfil_dados) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $senhaCriptografada);
        $stmt->bindParam(4, $tipo_conta);
        $stmt->bindParam(5, $telefone);
        $stmt->bindParam(6, $site);
        $stmt->bindParam(7, $foto_perfil_nome);
        $stmt->bindParam(8, $foto_perfil_tipo);
        $stmt->bindParam(9, $foto_perfil_dados, PDO::PARAM_LOB);
        
        // Executar a consulta
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Erro ao cadastrar usuário: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SALVAR | Cadastro de Usuário</title>
    <meta charset="utf-8">
    <!-- Arquivos CSS e JavaScript do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
    <!-- Estilos CSS personalizados -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/cadastro.css">
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

            <!-- Botão Burger  -->

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

    <div class="container content mt-5">
        <h1 class="text-white">Cadastro de Usuário</h1>

        <!-- Box de cadastro e formulario -->

        <form class="form-box" action="" method="POST" enctype="multipart/form-data">
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="name" name="nome" placeholder="Nome" required>
                <label for="name">Nome</label>
            </div>
            <div class="form-floating mb-2">
                <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" required>
                <label for="email">E-mail</label>
            </div>
            <div class="form-floating mb-2">
                <input type="password" class="form-control" id="password" name="senha" placeholder="Senha" required>
                <label for="password">Senha</label>
            </div>
            <div class="form-floating mb-2">
                <label for="select"  id="lb-select">Quem é você? Selecione o tipo de conta...</label>
                <select class="form-select" id="select" aria-label="Tipo de Conta" name="tipo_conta" required>
                    <option selected value="" aria-placeholder="Selecione o tipo de conta..."></option>
                    <option value="Fornecedor">Fornecedor</option>
                    <option value="ONG">ONG (Organização Não-Governamental)</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="profilePicture" class="form-label">Foto de Perfil</label>
                <input type="file" class="form-control" id="profilePicture" name="foto_perfil" accept="image/*">
            </div>
            <button type="button" class="btn btn-primary mb-2" id="uploadProfilePicture">Trocar Foto de Perfil</button>
            <div class="row  mb-2">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="tel" class="form-control" id="tel" name="telefone" placeholder="Telefone" required>
                        <label for="tel" id="lb-tel">Telefone</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="site" name="site" placeholder="Site">
                        <label for="site" id="lb-site">Site da Instituição (opcional)</label>
                    </div>
                </div>
            </div>
            <!-- Outros campos de cadastro -->
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
    <!-- Código JavaScript -->
    <script src="js/cadastro.js"></script>
    <script>
        $(document).ready(function(){
                // Aplica a máscara de telefone ao campo de entrada
                $('#tel').inputmask({
                    mask: ['(99) 9999-9999', '(99) 99999-9999'],
                    keepStatic: true
                });
    });
    </script>
</body>

<!-- Footer -->

<footer class="p-2 text-center text-white">
    <p>Desenvolvido por Gabriel Batista e Dalmo Scalon - Universidade Federal de Uberlândia</p>
</footer>
</html>
