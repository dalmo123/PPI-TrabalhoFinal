<?php
include "UsuarioEntidade.php";
session_start();
require "../conexao.php";

// Verifica o logout antes de verificar a sessão
if (isset($_POST["logout"])) {
    // Destrói a sessão
    session_destroy();

    // Redireciona para a página de login
    header("Location: ../login.php");
    exit();
}

// Cria uma instância de conexão apenas se não existir
if (!isset($conn)) {
    $conn = new Conexao();
    $conn->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Coletar dados do formulário, hash da senha, preparar a consulta e executar a consulta
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        $tipo_conta_ = $_POST["tipo_conta"];
        $telefone = $_POST["telefone"];
        $site = $_POST["site"];

        // Hash da senha usando bcrypt
        $senhaCriptografada = password_hash($senha, PASSWORD_BCRYPT);

        // Preparar a consulta SQL
        $stmt = $conn->conexao->prepare("INSERT INTO usuarios (nome, email, senha, tipo_conta, telefone, site) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $senhaCriptografada);
        $stmt->bindParam(4, $tipo_conta_);
        $stmt->bindParam(5, $telefone);
        $stmt->bindParam(6, $site);

        $stmt->execute();
    } catch (PDOException $e) {
        echo "Erro ao cadastrar usuário: " . $e->getMessage();
    }
}

// Verificar sessão após tratar o formulário
if (!isset($_SESSION["login"]) || $_SESSION["login"] != "1") {
    header("Location: ../login.php");
    exit();
}else {
    // Restante do código relacionado à sessão...
    //* Consulta o ID do usuário no banco de dados
    $sql = "SELECT id, tipo_conta FROM usuarios WHERE email = ? AND nome = ?";
    $stmt = $conn->conexao->prepare($sql);
    $usuario = $_SESSION["usuario"];
// Verifica se $usuario é uma instância válida de UsuarioEntidade
if ($usuario instanceof UsuarioEntidade) {
    // Tente executar as linhas problemáticas e capture qualquer exceção
    try {
        $stmt->bindParam(1, $usuario->getEmail());
        $stmt->bindParam(2, $usuario->getNome());

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Define o ID do usuário na variável de sessão
        $usuario->setId($result['id']);

        // Obtém o tipo de conta
        $tipoConta = $result['tipo_conta'];
    } catch (PDOException $e) {
        // Imprima mensagens de erro personalizadas
        echo "Erro ao definir parâmetros: " . $e->getMessage();
    }
} else {
    // Lida com o caso em que $usuario não é uma instância válida
    echo "Erro: Objeto de usuário inválido.";
}

    //$stmt->bindParam(1, $usuario->getEmail());
    //$stmt->bindParam(2, $usuario->getNome());
    //$stmt->execute();
    //$result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Define o ID do usuário na variável de sessão
    //$usuario->setId($result['id']);

    // Obtém o tipo de conta
    //$tipoConta = $result['tipo_conta'];
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
    <!-- Estilos CSS personalizados -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/cadastro.css">
    <link rel="stylesheet" href="../css/offCanvas.css">
    <link rel="icon" type="image/x-icon" href="../imagens/brand.png">

</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-custom navbar-dark">
        <div class="container-fluid">
            <!-- Logo à direita -->
            <a class="navbar-brand" href="index_account.php"><img src="../imagens/Logo_transp.png" class="img-fluid"
                    width="200"></a>

            <!-- Links à esquerda -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item text-center">
                        <a class="nav-link" href="index_account.php">Home</a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="sobre.php">Sobre</a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="lista_itens.php">Lista de Usuários</a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="cadastro_usuario.php">Cadastro</a>
                    </li>
                </ul>
                <div class="ms-auto">
                    <a class="nav-link" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
                        aria-controls="offcanvasExample">
                        <img src="../imagens/user.png" class="rounded-circle" width="50" height="50">
                    </a>
                </div>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon text-white"></span>
            </button>
        </div>
    </nav>

    <aside>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <img src="../imagens/user.png" class="rounded-circle" width="50" height="50">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel"><?php echo $usuario->getNome();?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
    
            <div class="offcanvas-body">
                <ul>
                    <?php if ($tipoConta != 'Fornecedor' && $tipoConta != 'ONG' && $usuario->getId() == "1") {
                            // Opções de menu para admin
                            echo '<li><a href="AdminActions/valida.php">Validar Postagem</a></li>';
                            echo '<li><a href="AdminActions/gerenciar_perfis.php">Gerenciar Perfis</a></li>';
                            echo '<li><a href="AdminActions/gerenciar_postagens.php">Gerenciar Postagens</a></li>';
                            echo '<li><a href="AdminActions/editar_perfil.php">Editar Perfil</a></li>';
                            echo '<li class="separator">
                                <button type="button" class="btn btn-outline-primary w-100 mt-3" data-bs-toggle="modal"
                                    data-bs-target="#confirmExitModal">Sair
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                    </svg>
                                </button>
                            </li></a>';
                        } else {
                            // Opções de menu para outros tipos de conta
                            echo '<li><a href="UserActions/solicitar_postagem.php">Solicitar Postagem</a></li>';
                            echo '<li><a href="UserActions/gerenciar_postagens.php">Gerenciar Postagens</a></li>';
                            echo '<li><a href="UserActions/editar_perfil.php">Editar perfil</a></li>';
                            echo '<li><a href="UserActions/excluir_perfil.php">Excluir Perfil</a></li>';
                            echo '<li class="separator">
                                <button type="button" class="btn btn-outline-primary w-100 mt-3" data-bs-toggle="modal"
                                    data-bs-target="#confirmExitModal">Sair
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                    </svg>
                                </button>
                            </li>';
                        }
                        ?>

                </ul>
            </div>
    
        </div>
    </aside>
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

        <form class="form-box" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
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
                <label for="profilePicture" class="form-label" name="foto_perfil">Foto de Perfil</label>
                <input type="file" class="form-control" id="profilePicture" accept="image/*">
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
    <div class="modal fade" id="confirmExitModal" tabindex="-1" aria-labelledby="confirmExitModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmExitModalLabel">Confirmar Saída</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Tem certeza de que deseja sair do sistema?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form action="" method="post">
                            <button type="submit" name="logout" class="btn btn-primary" id="confirmExitButton">Sair</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- Código JavaScript -->
</body>
<script src="../js/cadastro.js"></script>
<footer class="p-2 text-center text-white">
    <p>Desenvolvido por Gabriel Batista e Dalmo Scalon - Universidade Federal de Uberlândia</p>
</footer>

</html>