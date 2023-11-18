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
    <title>SALVAR | Gerenciar Perfis</title>
    <meta charset="utf-8">
    <!-- Arquivos CSS e JavaScript do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
    <!-- Estilos CSS personalizados (opcional) -->
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/gerencia.css">
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
                        echo "<img src='../imagens/user.png' class='img-fluid rounded-circle' width='50' height='50' alt=''>";
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
        <h1 class="text-white">Gerenciamento de Perfis</h1>
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
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Perfil</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nome" autocomplete="on">
                            <label for="name">Nome</label>
                        </div>
                        <div class="form-floating mb-2">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" autocomplete="on">
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="tel" name="tel" placeholder="Telefone" autocomplete="on">
                            <label for="tel">Telefone</label>
                        </div>
                        <div class="form-floating mb-2 d-none" id="siteDiv">
                            <input type="text" class="form-control" id="site" name="site" placeholder="Site" autocomplete="on">
                            <label for="site">Site</label>
                        </div>
                        <div class="mb-3">
                            <label for="profilePicture" class="form-label">Foto de Perfil</label>
                            <input type="file" class="form-control" id="foto_perfil" name="foto_perfil" accept="image/*">
                        </div>
                        <button type="button" class="btn btn-primary" id="uploadProfilePicture">Trocar Foto de Perfil</button>        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary" id="saveChanges">Salvar Alterações</button>
                </div>
                </form>
                </div>
            </div>
        </div>

        <!-- Button trigger modal -->
  
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Excluir Perfil</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Caso se confirme a exclusão, a conta deixará de existir permanentemente. Deseja realmente excluir este perfil?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="confirmDelete" class="btn btn-primary">Excluir</button>
                </div>
            </div>
            </div>
        </div>

        <div class="accordion ip-group mb-5" id="accordionPanelsStayOpenExample">
            <?php
            // Consulta ao banco de dados para obter perfis
            $sql_perfis = "SELECT id, nome, tipo_conta, email, telefone, site FROM usuarios WHERE id!=1";
            $stmt_perfis = $conn->conexao->prepare($sql_perfis);
            $stmt_perfis->execute();
            $perfis = $stmt_perfis->fetchAll(PDO::FETCH_ASSOC);

            foreach ($perfis as $perfil) {
                $id_perfil = $perfil['id'];
                $nome_perfil = $perfil['nome'];
                $tipo_conta_perfil = $perfil['tipo_conta'];
                $email_perfil = $perfil['email'];
                $telefone_perfil = $perfil['telefone'];
                $site = $perfil['site'];

                echo '<div class="accordion-item">';
                echo '<h2 class="accordion-header">';
                echo '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#perfil_' . $id_perfil . '" aria-expanded="true" aria-controls="perfil_' . $id_perfil . '">';
                // Verificar se o usuário tem uma foto de perfil no banco
                        if ($perfil['foto_perfil_nome'] && $perfil['foto_perfil_tipo'] && $perfil['foto_perfil_dados']) {
                            $foto_perfil_src = "data:" . $perfil['foto_perfil_tipo'] . ";base64," . base64_encode($perfil['foto_perfil_dados']);
                            echo "<img src='{$foto_perfil_src}' class='img-fluid rounded-circle' width='80' height='80' alt=''>";
                        } else {
                            // Caso contrário, exibir a imagem padrão
                            echo "<img src='imagens/user.png' class='img-fluid rounded-circle' width='80' height='80' alt=''>";
                        }
                echo '<span class="name p-3">' . $nome_perfil . ' - ' . $tipo_conta_perfil . '</span>';
                echo '</button>';
                echo '</h2>';
                echo '<div id="perfil_' . $id_perfil . '" class="accordion-collapse collapse show">';
                echo '<div id="perfil-container-' . $id_perfil . '" class="accordion-body">';
                // Adicione o atributo data-id aos botões
                echo '<button class="btn btn-danger m-3 delete-profile" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-id="' .  $id_perfil . '">Excluir Perfil</button>
';
    echo '<button class="btn btn-primary m-3 edit-profile" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@profile" data-id="' . $id_perfil . '" data-nome="'. $nome_perfil . '" data-email="' . $email_perfil . '" data-telefone="' . $telefone_perfil . '" data-tipo="' . $tipo_conta_perfil . '" data-site="' . $site . '">Editar Perfil</button>
';
                echo '</div>';
                echo '</div>';
                echo '</div>';
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
    </div>
    <!-- Adicione este script ao final do corpo do seu HTML -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editButtons = document.querySelectorAll('.edit-profile');
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const telInput = document.getElementById('tel');
            const siteInput = document.getElementById('site');
            const siteDiv = document.getElementById('siteDiv');
            const uploadProfilePictureButton = document.getElementById('uploadProfilePicture');
            const saveChangesButton = document.getElementById('saveChanges');

            let userId = null; // Armazenar o ID do usuário

            editButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    userId = this.getAttribute('data-id');
                    const userEmail = this.getAttribute('data-email');
                    const userNome = this.getAttribute('data-nome');
                    const userTel = this.getAttribute('data-telefone');
                    const userSite = this.getAttribute('data-site');
                    const userTipo = this.getAttribute('data-tipo');

                    nameInput.value = userNome;
                    emailInput.value = userEmail;
                    telInput.value = userTel;
                    siteInput.value = userSite;

                    if(userTipo==="ONG"){
                        siteDiv.classList.add("d-block");
                        siteDiv.classList.remove("d-none");
                    }
                });
            });

            // Adicione a lógica para enviar os dados ao servidor ao clicar no botão Salvar Alterações
            saveChangesButton.addEventListener('click', function () {
                // Obtenha os dados do formulário
                const formData = new FormData();
                formData.append('id', userId);
                formData.append('name', nameInput.value);
                formData.append('email', emailInput.value);
                formData.append('tel', telInput.value);
                formData.append('site', siteInput.value);

                // Adicione a lógica para enviar a foto de perfil, se fornecida
                const fileInput = document.getElementById('foto_perfil');
                if (fileInput.files.length > 0) {
                    formData.append('foto_perfil', fileInput.files[0]);
                }

                // Enviar a solicitação AJAX ao servidor
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            // Atualização bem-sucedida
                            alert('Alterações salvas com sucesso!');
                            // Recarregue a página ou execute outras ações necessárias
                            window.location.reload();
                        } else if(xhr.status === 500) {
                            // Exibição de mensagem de erro, se aplicável
                            alert('Erro ao salvar as alterações. Tente novamente.');
                        } else {
                            // Exibição de mensagem de erro, se aplicável
                            alert('Erro ao salvar as alterações. Tente novamente.');
                        }
                    }
                };

                xhr.open('POST', 'update_profile.php', true);
                xhr.send(formData);
            });
        });

</script>

<script>
    // Aguarde o documento ser totalmente carregado
    document.addEventListener('DOMContentLoaded', function () {
        // Obtenha uma referência ao modal
        const deleteModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));

        // Adicione um ouvinte de evento para o evento hidden.bs.modal
        deleteModal._element.addEventListener('hidden.bs.modal', function () {
            // Remova a classe modal-open do corpo da página
            document.body.classList.remove('modal-open');
            document.body.style="overflow: auto";

            // Remova o elemento de máscara modal-backdrop
            const modalBackdrop = document.querySelector('.modal-backdrop');
            if (modalBackdrop) {
                modalBackdrop.remove();
            }
        });
    });
</script>


<script>
    
    document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-profile');
    const confirmDeleteButton = document.getElementById('confirmDelete');

    let userIdToDelete = null;

    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            // Armazena o ID do perfil a ser excluído
            userIdToDelete = this.getAttribute('data-id');
        });
    });

    confirmDeleteButton.addEventListener('click', function () {
        // Certifique-se de que há um ID de usuário para excluir
        if (userIdToDelete !== null) {
            // Enviar solicitação AJAX para exclude.php
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        // Exclusão bem-sucedida
                        alert('Perfil excluído com sucesso!');
                        // Remover o accordion da página
                         window.location.href = "gerenciar_perfis.php";
                    } else {
                        // Exibição de mensagem de erro, se aplicável
                        alert('Erro ao excluir o perfil. Tente novamente.');
                    }
                }
            };

            xhr.open('POST', 'exclude.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('id=' + userIdToDelete);

            // Limpar o ID do usuário a ser excluído
            userIdToDelete = null;
        }
    });
});

</script>

    <script>
        $(document).ready(function(){
            // Aplica a máscara de telefone ao campo de entrada
            $('#tel').inputmask({
                mask: ['(99) 9999-9999', '(99) 99999-9999'],
                keepStatic: true
            });
        });
    </script>

  <script src="../../js/CRUD_Adm.js"></script>
</body>
<footer class="p-2 text-center text-white">
    <p>Desenvolvido por Gabriel Batista e Dalmo Scalon - Universidade Federal de Uberlândia</p>
</footer>

</html>