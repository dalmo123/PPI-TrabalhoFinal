<?php
    require_once "UsuarioEntidade.php";
    session_start();

    
    if(isset($_POST["logout"])) {
        // Destrói a sessão
        session_destroy();

        // Redireciona para a página de login
        header("Location: ../login.php");
        exit();
    }

    if(!isset($_SESSION["login"]) || $_SESSION["login"] != "1") {
        header("Location: ../login.php");
    }
    else {
        $usuario = $_SESSION["usuario"];
        // Consulta o ID do usuário no banco de dados
        require_once "../conexao.php";
        $conn = new Conexao();
        $sql = "SELECT id, tipo_conta FROM usuarios WHERE email = ? AND nome = ?"; // Supondo que você tenha uma coluna 'tipo_conta' na sua tabela de usuários
        $stmt = $conn->conexao->prepare($sql);
        $stmt->bindParam(1, $usuario->getEmail());
        $stmt->bindParam(2, $usuario->getNome());
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Define o ID do usuário na variável de sessão
        $usuario->setId($result['id']);

        // Obtém o tipo de conta
        $tipoConta = $result['tipo_conta'];
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>SALVAR | Sobre o Sistema</title>
    <meta charset="utf-8">
    <!-- Arquivos CSS e JavaScript do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- Estilos CSS personalizados -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/sobre.css">
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
    <div class="container content mt-5 mb-5">
        <h1 class="text-white mb-5">Sobre</h1>
        <p class="mb-3 p-style text-justify text-black">O sistema SALVAR foi desenvolvido para fins acadêmicos, por
            alunos da Universidade Federal de Uberlândia, como modo de consolidação de conhecimentos adquiridos em
            ministrações das aulas que concernem à disciplina de Programação para Internet, responsável
            pela introdução dos alunos ao desenvolvimento Web no curso de Sistemas de Informação. O sistema tem como
            objetivo unir fornecedores e ONG's com o objetivo de diminuir a fome em um país que a fome é uma
            caracteristica e um grande problema a ser sanado.
        </p>
        <p class="mb-3 p-style text-justify text-black">O sistema se dá pelo cadastro de fornecedores e ONG's onde o
            usuario registra no sistema, posta os alimentos
            que estão disponiveis para doação e ONG's interessadas podem entrar em contato, ou entao,
            as ONG's postam suas necessidades e o usuario também pode ver a lista de itens das ONG's e entrar em contato
            para fazer a doação. Então o sistema é um facilitador para unir pessoas e organizações que possuem o mesmo
            intuito de diminuir a fome no país.
        </p>
        <h3 class="mt-4">Desenvolvedores</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-white presentation">Dalmo Scalon Inacio</h5>
                        <p class="card-text text-white">Graduando em Sistemas de Informação - UFU. Aluno da 26° turma
                            ingressante do curso.</p>
                        <a href="https://www.linkedin.com/in/dalmo-scalon-9134661a3?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app"
                            target="_blank" class="card-link text-white">Linkedin</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-white">Gabriel Alcântara da Costa Batista</h5>
                        <p class="card-text text-white">Graduando em Sistemas de Informação - UFU. Aluno da 19° turma
                            ingressante do curso.</p>
                        <a href="https://www.linkedin.com/in/gblbatista?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app"
                            target="_blank" class="card-link text-white">Linkedin</a>
                    </div>
                </div>
            </div>
        </div>
        <h3 class="mt-4">Sobre a Disciplina</h3>
        <div class="card mb-5 p-style">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="../imagens/logo_ufu.jpg" class="img-fluid rounded-2 m-1" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Programação para Internet - GSI019</h5>
                        <p class="card-text text-white mt-3 text-justify">É uma disciplina oferecida pelo curso de
                            Sistemas de Informação da Faculdade de Computação da UFU, obrigatória com uma carga horária
                            total de 60 horas, plenamente prática. Fornece umma visão geral do funcionamento de sistemas
                            na Web e os protocolos envolvidos, introduzindo o aluno ao paradigma de Programação para
                            Internet.</p>
                        <p class="card-text mt-3"><small class="text-white">Docente em exercício: <a
                                    href="https://www.facom.ufu.br/~rafaelaraujo/" target="_blank"
                                    class="text-white">Rafael Dias Araújo</a>.</small></p>
                        <div class="dropdown mt-2">
                            <a class="btn btn-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Outras Informações
                            </a>

                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                        href="https://facom.ufu.br/system/files/conteudo/gsi019-programacao-para-internet.pdf"
                                        target="_blank">Ficha da Disciplina</a></li>
                                <li><a class="dropdown-item" href="https://facom.ufu.br/" target="_blank">Site da
                                        FACOM</a></li>
                                <li><a class="dropdown-item" href="https://www.facom.ufu.br/~rafaelaraujo/"
                                        target="_blank">Sobre o Professor</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
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
    </div>
    <script src="../js/logout.js"></script>
</body>
<footer class="p-2 text-center text-white">
    <p>Desenvolvido por Gabriel Batista e Dalmo Scalon - Universidade Federal de Uberlândia</p>
</footer>

</html>