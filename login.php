<?php
session_start();
if (isset($_POST["usuario"]) && isset($_POST["senha"])) {
    require_once "conexao.php"; // Verifique se o arquivo de conexão está correto
    require_once "account/UsuarioEntidade.php";
    $senha = $_POST["senha"];
    $conn = new Conexao();

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->conexao->prepare($sql);

    $stmt->bindParam(1, $_POST["usuario"]);

    if ($stmt->execute()) {
        $usuarioEntidade = new UsuarioEntidade(); // Crie uma instância da classe UsuarioEntidade

        $usuario = $stmt->fetch(PDO::FETCH_OBJ);
        if ($usuario->email == "admin@example.com") {
            $senha_compara = password_hash($usuario->senha, PASSWORD_BCRYPT);
        } else {
            $senha_compara = $usuario->senha;
        }

        if ($usuario) {
            // Verifique a senha usando password_verify
            if (password_verify($senha, $senha_compara)) {
                // Senha válida, autenticação bem-sucedida

                // Preencha os dados do usuário na instância da classe UsuarioEntidade
                $usuarioEntidade->setNome($usuario->nome);
                $usuarioEntidade->setEmail($usuario->email);

                $_SESSION["login"] = "1";
                $_SESSION["usuario"] = $usuarioEntidade; // Armazene a instância da classe no array de sessão
                header("Location: account/index_account.php"); // Redireciona para a página de home, ajuste o nome conforme necessário
                exit(); // Encerra o script
            } else {
                $_SESSION["erro"] = "Senha inválida";
                echo "Senha inválida";
                //header("Location: login.php"); // Redireciona de volta para a página de login
                exit(); // Encerra o script
            }
        } else {
            $_SESSION["erro"] = "Usuário não encontrado";
            echo "Usuário não encontrado";
            //header("Location: login.php"); // Redireciona de volta para a página de login
            exit(); // Encerra o script
        }
    } else {
        $_SESSION["erro"] = "Erro ao executar a consulta";
        header("Location: login.php"); // Redireciona de volta para a página de login
        exit(); // Encerra o script
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>SALVAR | Login</title>
    <meta charset="utf-8">
    <!-- Arquivos CSS e JavaScript do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- Estilos CSS personalizados -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="image/x-icon" href="imagens/brand.png">

</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-custom navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html"><img src="imagens/Logo_transp.png" class="img-fluid" width="200" title="Logo Sistema Salvar" alt=""></a>

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

            <!-- Botão Burguer -->

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

    <div class="container mt-5 flex login-box">

        <!-- Box de login -->

        <div class="container pb-2 text-center">
            <img src="imagens/brand.png" width="80" class="img-fluid" alt="" title="Logo Sistema Salvar">
            <p class="pt-1 text-center">Faça login na sua conta do sistema SALVAR</p>
        </div>

        <!-- Formulario -->

        <form id="loginForm" action="login.php" method="POST">
            <div class="form-floating mb-2">
                <input type="email" class="form-control" id="floatingInput" placeholder="Email" name="usuario" required>
                <label for="floatingInput">Email</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Senha" name="senha" required>
                <label for="floatingPassword">Senha</label>
            </div>
            <button type="submit" class="btn btn-primary mt-3 total-btn">Entrar</button>
            <div class="separator p-2">Primeiro Acesso? Cadastre-se.</div>
            <a href="cadastro_usuario.php"><button type="button" id="cadastroButton" class="btn btn-outline-primary mt-2 total-btn">Cadastrar</button></a>
        </form>

    </div>

    <!-- Código JavaScript -->

</body>
<footer class="p-2 text-center text-white">
    <p>Desenvolvido por Gabriel Batista e Dalmo Scalon - Universidade Federal de Uberlândia</p>
</footer>
<script src="js/login.js">
</html>
