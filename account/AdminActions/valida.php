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
        require_once "../../conexao.php";
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
    <title>SALVAR | Validação de Postagens</title>
    <meta charset="utf-8">
    <!-- Arquivos CSS e JavaScript do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

     
    

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
                                    echo "<img src='../../imagens/user.png' class='img-fluid rounded-circle' width='50' height='50' alt=''>";
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

    <aside>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <?php
                    // Verificar se o usuário tem uma foto de perfil no banco
                    if ($user['foto_perfil_nome'] && $user['foto_perfil_tipo'] && $user['foto_perfil_dados']) {
                        $foto_perfil_src = "data:" . $user['foto_perfil_tipo'] . ";base64," . base64_encode($user['foto_perfil_dados']);
                        echo "<img src='{$foto_perfil_src}' class='img-fluid rounded-circle' width='50' height='50' alt=''>";
                    } else {
                            // Caso contrário, exibir a imagem padrão
                        echo "<img src='../../imagens/user.png' class='img-fluid rounded-circle' width='50' height='50' alt=''>";
                    }
                ?>
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
            <?php
            // Consulta ao banco de dados para obter perfis
            $sql_perfis = "SELECT id, nome, tipo_conta, foto_perfil_tipo, foto_perfil_dados, foto_perfil_nome FROM usuarios WHERE id!=1";
            $stmt_perfis = $conn->conexao->prepare($sql_perfis);
            $stmt_perfis->execute();
            $perfis = $stmt_perfis->fetchAll(PDO::FETCH_ASSOC);

            foreach ($perfis as $perfil) {
                $id_perfil = $perfil['id'];
                $nome_perfil = $perfil['nome'];
                $tipo_conta_perfil = $perfil['tipo_conta'];
        
                $sql_postagens = "SELECT id, alimento, quantidade, unidade_medida, data_validade, observacoes FROM postagens WHERE id_usuario=" . $id_perfil . " AND status='espera'";
               
                $stmt_postagens = $conn->conexao->prepare($sql_postagens);
                $stmt_postagens->execute();
                if($stmt_postagens->rowCount() > 0){
                    $postagens = $stmt_postagens->fetchAll(PDO::FETCH_ASSOC);

                    echo '<div class="accordion-item">';
                    echo '<h2 class="accordion-header">';
                    echo '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#perfil_' . $id_perfil . '" aria-expanded="true" aria-controls="perfil_' . $id_perfil . '">';
                     if ($perfil['foto_perfil_nome'] && $perfil['foto_perfil_tipo'] && $perfil['foto_perfil_dados']) {
                            $foto_perfil_src = "data:" . $perfil['foto_perfil_tipo'] . ";base64," . base64_encode($perfil['foto_perfil_dados']);
                            echo "<img src='{$foto_perfil_src}' class='img-fluid rounded-circle' width='80' height='80' alt=''>";
                        } else {
                            // Caso contrário, exibir a imagem padrão
                            echo "<img src='../../imagens/user.png' class='img-fluid rounded-circle' width='80' height='80' alt=''>";
                        }
                    echo '<span class="name p-3">' . $nome_perfil . ' - ' . $tipo_conta_perfil . '</span>';
                    echo '</button>';
                    echo '</h2>';
                    echo '<div id="perfil_' . $id_perfil . '" class="accordion-collapse collapse show">';
                    echo '<div id="perfil-container-' . $id_perfil . '" class="accordion-body">';
                    echo '<div class="accordion-body">';

                                echo '<h3 class="mb-4">Postagens em Espera</h3>';
                                echo '<div class="table-responsive">';
                                echo '<table class="table table-striped table-bordless mt-3" id="table1">';
                                echo '<thead class="table-dark">';
                                echo '<tr>';
                                echo '<th scope="col" class="text-center">Alimento</th>';
                                echo '<th scope="col" class="text-center">Quantidade</th>';
                                echo '<th scope="col" class="text-center">Observações</th>';
                                echo '<th scope="col" class="text-center">Data de Validade</th>';
                                echo '<th scope="col" class="text-center">Ações</th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody>';

                                foreach($postagens as $postagem){
                                    $alimento = $postagem['alimento'];
                                    $qtd = $postagem['quantidade'] . $postagem['unidade_medida'];
                                    $obs = $postagem['observacoes'];
                                    $data = $postagem['data_validade'];

                                    echo '<tr>';
                                    echo '<td class="text-center">'. $alimento .'</td>';
                                    echo '<td class="text-center">'. $qtd .'</td>';
                                    echo '<td class="text-center">'. $obs .'</td>';
                                    echo '<td class="text-center">'. $data .'</td>';
                                    echo '<td class="text-center">';
                                    echo '<button class="btn btn-danger m-1 btn-rejeitar" data-bs-target="#staticBackdrop" data-id="' . $postagem['id'] . '">Rejeitar Postagem</button>';

                                    echo '<button class="btn btn-success m-1" data-bs-toggle="modal" data-bs-target="#confirmAcceptModal" data-bs-whatever="@profile" data-id="' . $postagem['id'] . '">Publicar Postagem</button>';
                                    echo '</td>';
                                    echo '</tr>';
                                }

                                echo '</tbody>';
                                echo '</table>';
                                echo '</div>';

                                // Seu código PHP existente ...
                            
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
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
                    <p>Caso a postagem seja rejeitada, deixará de existir permanentemente. Deseja realmente rejeitar esta postagem?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <?php echo '<button class="btn btn-danger m-1 btn-rejeitar" id="confirmDelete" data-id="' . $postagem['id'] . '">Excluir</button>';?>
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
                        <?php echo '<button id="confirmAccept" data-id="' . $postagem['id'] . '" class="btn btn-primary">Confirmar</button>';?>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <script src="../../js/CRUD_Adm_Post.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Adicionar evento de clique aos botões de rejeição
        var btnRejeitar = document.querySelectorAll('.btn-rejeitar');
        btnRejeitar.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var postId = this.getAttribute('data-id');
                confirmarExclusao(postId);
            });
        });

        // Adicionar evento de clique ao botão de confirmação dentro do modal de exclusão
        document.getElementById('confirmDelete').addEventListener('click', function () {
            var postId = this.getAttribute('data-id');
            excluirPostagem(postId);
        });

        // Adicionar evento de clique ao botão de publicação
        var btnPublicar = document.querySelectorAll('.btn-publicar');
        btnPublicar.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var postId = this.getAttribute('data-id');
                confirmarPublicacao(postId);
            });
        });

        // Adicionar evento de clique ao botão de confirmação dentro do modal de publicação
        document.getElementById('confirmAccept').addEventListener('click', function () {
            var postId = this.getAttribute('data-id');
            publicarPostagem(postId);
        });
    });

    function confirmarExclusao(postId) {
        $('#staticBackdrop').modal('show');
        document.getElementById('confirmDelete').setAttribute('data-id', postId);
    }

    function excluirPostagem(postId) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'exclude_post.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                console.log(xhr.responseText);
                $('#staticBackdrop').modal('hide');
                location.reload();
            }
        };

        xhr.send('postId=' + postId);
    }

    function confirmarPublicacao(postId) {
        $('#confirmAcceptModal').modal('show');
        document.getElementById('confirmAccept').setAttribute('data-id', postId);
    }

    function publicarPostagem(postId) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'publicar_post.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                console.log(xhr.responseText);
                $('#confirmAcceptModal').modal('hide');
                location.reload();
            }
        };

        xhr.send('postId=' + postId);
    }
</script>




</body>
<footer class="p-2 text-center text-white">
    <p>Desenvolvido por Gabriel Batista e Dalmo Scalon - Universidade Federal de Uberlândia</p>
</footer>

</html>
