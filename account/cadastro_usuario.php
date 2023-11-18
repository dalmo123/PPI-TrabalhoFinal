<?php
include "UsuarioEntidade.php";
session_start();
require "../conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados de conexão com o banco de dados (já definidos no arquivo conexao.php)
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
<script>
        $(document).ready(function(){
                // Aplica a máscara de telefone ao campo de entrada
                $('#tel').inputmask({
                    mask: ['(99) 9999-9999', '(99) 99999-9999'],
                    keepStatic: true
                });
    });
    </script>
<footer class="p-2 text-center text-white">
    <p>Desenvolvido por Gabriel Batista e Dalmo Scalon - Universidade Federal de Uberlândia</p>
</footer>

</html>