<?php
require_once "../UsuarioEntidade.php";
session_start();


require_once "../../conexao.php";
$conn = new Conexao();

if (isset($_POST["logout"])) {
    // Destrói a sessão
    session_destroy();

    // Redireciona para a página de login
    header("Location: ../../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirmExclusion"])) {
    // Se o formulário de confirmação foi enviado

    $usuario = $_SESSION["usuario"];

    // Excluir a tupla do banco de dados
    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conn->conexao->prepare($sql);
    $stmt->bindParam(1, $usuario->getId());
    $stmt->execute();

    // Destruir a sessão e redirecionar para a página de login
    session_destroy();
    header("Location: ../../login.php");
    exit();
}

$usuario = $_SESSION["usuario"];
?>


<!DOCTYPE html>
<html>

<head>
    <title>SALVAR | Exclusão de Perfil</title>
    <meta charset="utf-8">
    <!-- Arquivos CSS e JavaScript do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/offCanvas.css">
    <link rel="stylesheet" href="../../css/delete.css">
    <link rel="icon" type="image/x-icon" href="../../imagens/brand.png">
</head>
<header>
    <!-- Barra de Navegação -->
    <nav class="navbar navbar-expand-lg navbar-custom navbar-dark">
        <div class="container-fluid">
            <!-- Logo à direita -->
            <a class="navbar-brand" href="../index_account.php"><img src="../../imagens/Logo_transp.png"
                    class="img-fluid" width="200"></a>

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
                        <?php
                            $sql = "SELECT foto_perfil_nome, foto_perfil_tipo, foto_perfil_dados FROM usuarios WHERE id = ?"; 
                            // Não inclui o administrador 
                            $stmt = $conn->conexao->prepare($sql); 
                            $stmt->bindParam(1, $usuario->getId());
                            $stmt->execute();
                            $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        // Verificar se o usuário tem uma foto de perfil no banco
                                if ($user['foto_perfil_nome'] && $user['foto_perfil_tipo'] && $user['foto_perfil_dados']) {
                                    $foto_perfil_src = "data:" . $user['foto_perfil_tipo'] . ";base64," . base64_encode($user['foto_perfil_dados']);
                                    echo "<img src='{$foto_perfil_src}' class='img-fluid rounded-circle' width='50' height='50' alt=''>";
                                } else {
                                    // Caso contrário, exibir a imagem padrão
                                    echo "<img src='../imagens/user.png' class='img-fluid rounded-circle' width='50' height='50' alt=''>";
                                }
                        ?>
                    </a>
                </div>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon text-white"></span>
            </button>
        </div>
    </nav>

    <!-- Menu offcanvas lateral -->
    <aside>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                 <?php
                    // Verificar se o usuário tem uma foto de perfil no banco
                    if ($user['foto_perfil_nome'] && $user['foto_perfil_tipo'] && $user['foto_perfil_dados']) {
                        $foto_perfil_src = "data:" . $user['foto_perfil_tipo'] . ";base64," . base64_encode($user['foto_perfil_dados']);
                        echo "<img src='{$foto_perfil_src}' class='img-fluid rounded-circle' width='50' height='50' alt=''>";
                    } else {
                            // Caso contrário, exibir a imagem padrão
                        echo "<img src='../imagens/user.png' class='img-fluid rounded-circle' width='50' height='50' alt=''>";
                    }
                ?>
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">
                    <?php echo $usuario->getNome(); ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">
                <ul>
                    <li><a href="solicitar_postagem.php">Solicitar Postagem</a></li>
                    <li><a href="gerenciar_postagens.php">Gerenciar Postagens</a< /li>
                    <li><a href="editar_perfil.php">Editar perfil</a></li>
                    <li><a href="excluir_perfil.php">Excluir Perfil</a></li>
                    <li class="separator">
                        <button type="button" class="btn btn-outline-primary w-100 mt-3" data-bs-toggle="modal"
                            data-bs-target="#confirmExitModal">Sair
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
                                <path fill-rule="evenodd"
                                    d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                            </svg>
                        </button>
                    </li>
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

    <div class="container mt-5">
        <h1 class="text-white">Exclusão de Perfil</h1>
        <div class="text-center">
        <?php
                // Verificar se o usuário tem uma foto de perfil no banco
                if ($user['foto_perfil_nome'] && $user['foto_perfil_tipo'] && $user['foto_perfil_dados']) {
                    $foto_perfil_src = "data:" . $user['foto_perfil_tipo'] . ";base64," . base64_encode($user['foto_perfil_dados']);
                    echo "<img src='{$foto_perfil_src}' class='img-fluid rounded-circle' width='160' height='160' alt=''>";
                } else {
                        // Caso contrário, exibir a imagem padrão
                    echo "<img src='../imagens/user.png' class='img-fluid rounded-circle' width='160' height='160' alt=''>";
                }
            ?>
            <h3 class="text-center mt-4">
                <?php echo $usuario->getNome(); ?>
            </h3>
        </div>
        <p class="text-center"> Este perfil será excluído permanentemente. Deseja prosseguir com a operação de exclusão?
        </p>
        <div class="prosseguir text-center mt-4">
            <button class="btn btn-primary prosseguir" data-bs-toggle="modal"
                data-bs-target="#staticBackdrop">Prosseguir</button>
        </div>

        <!-- Button trigger modal -->
        <!-- Modal -->

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
                            <button type="submit" class="btn btn-primary" name="logout"
                                id="confirmExitButton">Sair</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Excluir</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Pedimos que, por favor, confirme ou cancele a exclusão.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form method="post" action="">
                            <button type="submit" class="btn btn-primary" name="confirmExclusion">Excluir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="../js/lista_adm.js"></script>
    <script src="../js/logout.js"></script>
    <script src="../js/delete.js"></script>
</body>
<footer class="p-2 text-center text-white">
    <p>Desenvolvido por Gabriel Batista e Dalmo Scalon - Universidade Federal de Uberlândia</p>
</footer>

</html>