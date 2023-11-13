<?php
    require_once "../UsuarioEntidade.php";
    session_start();

    
    if(isset($_POST["logout"])) {
        // Destrói a sessão
        session_destroy();

        // Redireciona para a página de login
        header("Location: ../../login.php");
        exit();
    }

    if(!isset($_SESSION["login"]) || $_SESSION["login"] != "1") {
        header("Location: ../../login.php");
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
    <title>SALVAR | Gerenciador de Postagens</title>
    <meta charset="utf-8">
    <!-- Arquivos CSS e JavaScript do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
     
    

    <!-- Estilos CSS personalizados -->
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/offCanvas.css">
    <link rel="stylesheet" href="../../css/gerencia.css">
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
                    <li class="nav-item text-center">
                        <a class="nav-link" href="../cadastro_usuario.php">Cadastro</a>
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
    <div class="container mt-5" id="container">
        <h1 class="text-white">Validação de Postagens</h1>
        <div class="input-group mb-5 mt-5">
            <input type="text" class="form-control ip-group" id="search" placeholder="Pesquise ONG ou Fornecedor..."
                aria-label="Username" aria-describedby="basic-addon1">
            <span class="input-group-text ip-group" id="basic-addon1">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search"
                    viewBox="0 0 16 16">
                    <path
                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                </svg>
            </span>
        </div>

        <div class="accordion ip-group mb-5" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                        aria-controls="panelsStayOpen-collapseOne">
                        <img src="../../imagens/user.png" class="img-fluid rounded-circle" width="80" alt="">
                        <span class="name p-3">Maria Silva - Fornecedor</span>
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <h3 class="mb-4">Postagens em Espera</h3>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordless mt-3" id="table1">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Alimento</th>
                                        <th scope="col">Quantidade</th>
                                        <th scope="col">Observações</th>
                                        <th scope="col">Data de Validade</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Farinha de Trigo</td>
                                        <td>10 kg</td>
                                        <td>-</td>
                                        <td>02/01/24</td>
                                        <td> 
                                            <button class="btn btn-danger mb-1" data-bs-target="#staticBackdrop">Rejeitar Postagem</button>
                                            <button class="btn btn-success mb-1" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@profile">Publicar Postagem</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Leite</td>
                                        <td>4L</td>
                                        <td>Desnatado ou integral</td>
                                        <td>03/03/24</td>
                                        <td> 
                                            <button class="btn btn-danger mb-1" data-bs-target="#staticBackdrop">Rejeitar Postagem</button>
                                            <button class="btn btn-success mb-1" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@profile">Publicar Postagem</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false"
                        aria-controls="panelsStayOpen-collapseTwo">
                        <img src="../../imagens/user.png" class="img-fluid rounded-circle" width="80" alt="">
                        <span class="name p-3">Casa da Ajuda - ONG</span>
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <h3 class="mb-4">Postagens em Espera</h3>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordless mt-3" id="table1">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Alimento</th>
                                        <th scope="col">Quantidade</th>
                                        <th scope="col">Observações</th>
                                        <th scope="col">Data de Validade</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Farinha de Trigo</td>
                                        <td>10 kg</td>
                                        <td>-</td>
                                        <td>02/01/24</td>
                                        <td> 
                                            <button class="btn btn-danger mb-1" data-bs-target="#staticBackdrop">Rejeitar Postagem</button>
                                            <button class="btn btn-success mb-1" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@profile">Publicar Postagem</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Leite</td>
                                        <td>4L</td>
                                        <td>Desnatado ou integral</td>
                                        <td>03/03/24</td>
                                        <td> 
                                            <button class="btn btn-danger mb-1" data-bs-target="#staticBackdrop">Rejeitar Postagem</button>
                                            <button class="btn btn-success mb-1" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@profile">Publicar Postagem</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false"
                        aria-controls="panelsStayOpen-collapseThree">
                        <img src="../../imagens/user.png" class="img-fluid rounded-circle" width="80" alt="">
                        <span class="name p-3">Gilberto Costa - Fornecedor</span>
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <h3 class="mb-4">Postagens em Espera</h3>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordless mt-3" id="table1">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Alimento</th>
                                        <th scope="col">Quantidade</th>
                                        <th scope="col">Observações</th>
                                        <th scope="col">Data de Validade</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Farinha de Trigo</td>
                                        <td>10 kg</td>
                                        <td>-</td>
                                        <td>02/01/24</td>
                                        <td> 
                                            <button class="btn btn-danger mb-1" data-bs-target="#staticBackdrop">Rejeitar Postagem</button>
                                            <button class="btn btn-success mb-1" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@profile">Publicar Postagem</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Leite</td>
                                        <td>4L</td>
                                        <td>Desnatado ou integral</td>
                                        <td>03/03/24</td>
                                        <td> 
                                            <button class="btn btn-danger mb-1" data-bs-target="#staticBackdrop">Rejeitar Postagem</button>
                                            <button class="btn btn-success mb-1" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@profile">Publicar Postagem</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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

        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="label_exclui">Rejeitar Postagem</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Caso se confirme a rejeição, a postagem deixará de existir permanentemente. Deseja realmente rejeitar esta postagem?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="confirmDelete" class="btn btn-primary">Excluir</button>
                </div>
            </div>
            </div>
        </div>

        <div class="modal fade" id="confirmAcceptModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="label_confirma">Publicar Postagem</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Confirma a publicação da postagem?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" id="confirmAccept" class="btn btn-primary">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/CRUD_Adm_Post.js"></script>
</body>
<footer class="p-2 text-center text-white">
    <p>Desenvolvido por Gabriel Batista e Dalmo Scalon - Universidade Federal de Uberlândia</p>
</footer>

</html>
