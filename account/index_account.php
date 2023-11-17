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
    <title>SALVAR | Sistema de Apoio à Luta contra Vulnerabilidade Alimentar e Recursos</title>
    <meta charset="utf-8">
    <!-- Arquivos CSS e JavaScript do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- Estilos CSS personalizados -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/index.css">
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

    <div class="container mt-4 w-100">
        <div class="row">
            <!-- Carrossel (lado esquerdo) -->
            <div class="col-lg-6 h-100">
                <div id="carousel" class="carousel slide carousel-fade mt-5">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <a href="https://brasil.un.org/pt-br/sdgs/2" target="_blank">
                                <img src="../imagens/Fome_zero.jpeg" class="d-block w-100 rounded" alt="...">
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a href="https://brasil.un.org/pt-br/sdgs" target="_blank">
                                <img src="../imagens/agenda.jpeg" class="d-block w-100 rounded" alt="...">
                            </a>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <!-- Texto: Visão Geral (lado direito) -->
            <div class="col-lg-6 p-style mt-5">
                <h4>Sistema de Apoio a Luta contra Vulnerabilidade Alimentar e Recursos
                </h4>
                <p class="mt-4">
                    O SALVAR é uma plataforma dedicada a promover a união entre Organizações Não Governamentais (ONGs)
                    que necessitam de recursos alimentares e fornecedores de alimentos dispostos a doar. Esses
                    fornecedores podem ser empresas, instituições ou qualquer pessoa que deseje contribuir com recursos
                    alimentares para aqueles que mais precisam.
                </p>
            </div>
        </div>
    </div>

    <!-- Segunda sessão: Nossa Motivação e SVG -->
    <div class=" mt-5" id="motiv">
        <div class="container-fluid">
            <div class="row">
                <!-- Texto: Nossa Motivação (lado esquerdo) -->
                <div class="col-lg-7">
                    <h2 class="text-white mt-4">Nossa Motivação</h2>
                    <p class="text-white mt-5">
                        O tema central do SALVAR está alinhado com o Objetivo de Desenvolvimento Sustentável (ODS)
                        número dois, que é "Fome Zero e Agricultura Sustentável". A plataforma foi desenvolvida com o
                        objetivo de contribuir para a erradicação da fome, garantindo o acesso de todas as pessoas,
                        especialmente as mais pobres e vulneráveis, incluindo crianças, a alimentos seguros, nutritivos
                        e suficientes durante todo o ano.
                    </p>
                    <p class="text-white mb-4">
                        Com a implementação do SALVAR, facilitamos o contato entre as ONGs que lutam contra a
                        vulnerabilidade alimentar e os doadores de alimentos. Essa colaboração é fundamental para
                        alcançar o ODS de Fome Zero, trabalhando juntos para garantir que ninguém passe fome em nossa
                        comunidade e no mundo.
                    </p>
                </div>
                <!-- SVG (lado direito) -->
                <div class="col-lg-5 mb-4 mt-4">
                    <img src="../imagens/plate.png" class="img-fluid" alt="">

                </div>
            </div>
        </div>
    </div>

    <!-- Terceira sessão: Cards -->
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body mb-5">
                        <h5 class="card-title">Cadastro</h5>
                        <p class="card-text">Cadastre-se no sistema SALVAR.</p>
                        <a href="cadastro_usuario.php" class="btn btn-primary">Cadastrar</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body mb-5">
                        <h5 class="card-title">Listagem</h5>
                        <p class="card-text">Veja quem já colabora no sistema SALVAR.</p>
                        <a href="lista_itens.php" class="btn btn-primary">Ver Lista</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body mb-5">
                        <h5 class="card-title">Objetivos da ONU</h5>
                        <p class="card-text">Conheça os 17 Objetivos do Século da ONU.</p>
                        <a href="https://brasil.un.org/pt-br/sdgs" target="_blank" class="btn btn-primary">Saiba
                            Mais</a>
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
</body>
<footer class="p-2 text-center text-white">
    <p>Desenvolvido por Gabriel Batista e Dalmo Scalon - Universidade Federal de Uberlândia</p>
</footer>

</html>