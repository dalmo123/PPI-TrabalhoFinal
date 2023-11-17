<?php
require_once "../UsuarioEntidade.php";
session_start();

if (isset($_POST["logout"])) {
    // Destrói a sessão
    session_destroy();

    // Redireciona para a página de login
    header("Location: ../../login.php");
    exit();
}

if (!isset($_SESSION["login"]) || $_SESSION["login"] != "1") {
    header("Location: ../../login.php");
} else {
    $usuario = $_SESSION["usuario"];
    // Consulta o ID e tipo_conta do usuário no banco de dados
    require_once "../conexao.php";
    $conn = new Conexao();
    $sql = "SELECT id, tipo_conta, nome, email, telefone FROM usuarios WHERE id = ?";
    $stmt = $conn->conexao->prepare($sql);
    $stmt->bindParam(1, $usuario->getId());
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Recupera os dados do usuário
    $idUsuario = $result['id'];
    $tipoConta = $result['tipo_conta'];
    $nomeUsuario = $result['nome'];
    $emailUsuario = $result['email'];
    $telefoneUsuario = $result['telefone'];
}

// Processamento do formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados do formulário
    $nome = !empty($_POST["name"]) ? $_POST["name"] : null;
    $email = !empty($_POST["email"]) ? $_POST["email"] : null;
    $telefone = !empty($_POST["tel"]) ? $_POST["tel"] : null;

    // Atualiza a foto de perfil, se fornecida
    if (isset($_FILES["profilePicture"]) && $_FILES["profilePicture"]["error"] == 0) {
        $foto_perfil_nome = $_FILES["profilePicture"]["name"];
        $foto_perfil_tipo = $_FILES["profilePicture"]["type"];
        $foto_perfil_dados = file_get_contents($_FILES["profilePicture"]["tmp_name"]);
    } else {
        // Se não fornecida, mantenha os dados atuais no banco
        $foto_perfil_nome = null;
        $foto_perfil_tipo = null;
        $foto_perfil_dados = null;
    }

    // Atualiza os dados no banco apenas se não estiverem em branco
    $sql = "UPDATE usuarios SET nome = COALESCE(?, nome), email = COALESCE(?, email), telefone = COALESCE(?, telefone), foto_perfil_nome = COALESCE(?, foto_perfil_nome), foto_perfil_tipo = COALESCE(?, foto_perfil_tipo), foto_perfil_dados = COALESCE(?, foto_perfil_dados) WHERE id = ?";
    $stmt = $conn->conexao->prepare($sql);
    $stmt->bindParam(1, $nome);
    $stmt->bindParam(2, $email);
    $stmt->bindParam(3, $telefone);
    $stmt->bindParam(4, $foto_perfil_nome);
    $stmt->bindParam(5, $foto_perfil_tipo);
    $stmt->bindParam(6, $foto_perfil_dados);
    $stmt->bindParam(7, $usuario->getId());
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>SALVAR | Editar Usuário</title>
    
    <meta charset="utf-8">
    <!-- Arquivos CSS e JavaScript do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- Estilos CSS personalizados -->

    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/login.css">
    <link rel="stylesheet" href="../../css/offCanvas.css">
    <link rel="icon" type="image/x-icon" href="../../imagens/brand.png">

</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-custom navbar-dark">
        <div class="container-fluid">
            <!-- Logo à direita -->
            <a class="navbar-brand" href="../index_account.php"><img src="../../imagens/Logo_transp.png" class="img-fluid"
                    width="200"></a>

            <!-- Links à esquerda -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item text-center">
                        <a class="nav-link" href="../index_account.php">Home</a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="../sobre.php">Sobre</a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="../lista_itens.php">Lista de Usuários</a>
                    </li>
                </ul>
                <div class="ms-auto">
                    <a class="nav-link" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
                        aria-controls="offcanvasExample">
                        <img src="../../imagens/user.png" class="rounded-circle" width="50" height="50">
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
                <img src="../../imagens/user.png" class="rounded-circle" width="50" height="50">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel"><?php echo $usuario->getNome();?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
    
            <div class="offcanvas-body">
                <ul>
                    <?php if ($tipoConta != 'Fornecedor' && $tipoConta != 'ONG' && $usuario->getId() == "1") {
                            // Opções de menu para admin
                            echo '<li><a href="valida.php">Validar Postagem</a></li>';
                            echo '<li><a href="gerenciar_perfis.php">Gerenciar Perfis</a></li>';
                            echo '<li><a href="gerenciar_postagens.php">Gerenciar Postagens</a></li>';
                            echo '<li><a href="editar_perfil.php">Editar Perfil</a></li>';
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
                            echo '<li><a href="../UserActions/solicitar_postagem.php">Solicitar Postagem</a></li>';
                            echo '<li><a href="../UserActions/gerenciar_postagens.php">Gerenciar Postagens</a></li>';
                            echo '<li><a href="../UserActions/editar_perfil.php">Editar perfil</a></li>';
                            echo '<li><a href="../UserActions/excluir_perfil.php">Excluir Perfil</a></li>';
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
    <div class="container content mt-5 login-box bg-white">
        <div class="container pb-2 text-center">
            <img src="../../imagens/brand.png" width="80" class="img-fluid" alt="">
            <p class="pt-1 text-center">Bem-vindo Usuario! Edite o seu perfil no sistema SALVAR</p>
        </div>
        <form id="profileEditForm" action="" method="post" enctype="multipart/form-data">
              <div class="form-floating mb-2">
                <input type="text" class="form-control" id="name" placeholder="Nome" name="name" value="<?php echo isset($nomeUsuario) ? $nomeUsuario : ''; ?>" autocomplete="on">
                <label for="name">Nome</label>
              </div>
            <div class="form-floating mb-2">
                <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo isset($emailUsuario) ? $emailUsuario : ''; ?>" autocomplete="on">
                <label for="email">Email</label>
            </div>
    <div class="form-floating mb-2">
        <input type="text" class="form-control" id="tel" placeholder="Telefone" name="tel" value="<?php echo isset($telefoneUsuario) ? $telefoneUsuario : ''; ?>" autocomplete="on">
        <label for="tel">Telefone</label>
    </div>
            <div class="mb-3">
                <label for="profilePicture" class="form-label">Foto de Perfil</label>
                <input type="file" class="form-control" id="profilePicture" accept="image/*">
            </div>
            <button type="button" class="btn btn-primary" id="uploadProfilePicture" name="profilePicture">Trocar Foto de Perfil</button>        
        
            <button type="submit" class="btn btn-primary mt-3 total-btn">Salvar Alterações</button>
        </form>
        

    </div>

    <!-- Modal de confirmação de saída -->
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
    <script src="../../js/cadastro.js"></script>
</body>
<footer class="p-2 text-center text-white">
    <p>Desenvolvido por Gabriel Batista e Dalmo Scalon - Universidade Federal de Uberlândia</p>
</footer>

</html>