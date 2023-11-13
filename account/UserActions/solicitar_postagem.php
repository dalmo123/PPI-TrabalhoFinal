<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["usuario"])) {

    // Dados de conexão com o banco de dados (substitua pelas suas credenciais)
    $servername = "sql109.infinityfree.com";
    $username = "if0_34787818";
    $password = "jyiUTaabL7fF45";
    $dbname = "if0_34787818_trabalho_final";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Restante do código para processar a solicitação e inserir dados no banco de dados
        // ...
            $id_usuario = 2; // Defina um valor padrão (2, por exemplo) para teste

        // Coletar dados do formulário
        $alimento = $_POST["alimento"];
        $quantidade = $_POST["quantidade"];
        $unidade_medida = $_POST["unidade_medida"];
        $data_validade = $_POST["data_validade"];
        $observacoes = $_POST["observacoes"];
        $status = "espera"; // Defina o status como "espera"
        
         $stmt = $conn->conexao->prepare("INSERT INTO postagens (id_usuario, alimento, quantidade, unidade_medida, data_validade, observacoes, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $id_usuario);
        $stmt->bindParam(2, $alimento);
        $stmt->bindParam(3, $quantidade);
        $stmt->bindParam(4, $unidade_medida);
        $stmt->bindParam(5, $data_validade);
        $stmt->bindParam(6, $observacoes);
        $stmt->bindParam(7, $status);

        // Executar a consulta
        if ($stmt->execute()) {
            echo "Solicitação de postagem registrada com sucesso. Aguarde a aprovação.";
        } else {
            // Mensagem de erro em caso de falha na execução
            $errorInfo = $stmt->errorInfo();
            echo "Erro ao registrar a solicitação de postagem: " . $errorInfo[2];
        }
    } catch (PDOException $e) {
        echo "Erro ao registrar a solicitação de postagem: " . $e->getMessage();
    }
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
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/solicitarPostagem.css">
    <link rel="stylesheet" href="../../css/offCanvas.css">
    <link rel="icon" type="image/x-icon" href="../../imagens/brand.png">

</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-custom navbar-dark">
        <!-- Barra de Navegação -->
        <div class="container-fluid">
            <a class="navbar-brand" href="index_usuario.html">
                <img src="../imagens/Logo_transp.png" class="img-fluid" width="200" title="Logo Sistema Salvar" alt=""></a>

            <!-- Links à esquerda -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item text-center">
                        <a class="nav-link" href="index_usuario.html">Home</a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="sobre_usuario.html">Sobre</a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="lista_itens_usuario.html">Lista de Usuários</a>
                    </li>
                </ul>
                <div class="ms-auto">
                    <a class="nav-link" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
                        aria-controls="offcanvasExample">
                        <img src="../../imagens/user.png" class="rounded-circle" width="50" height="50">
                    </a>
                </div>
            </div>

             <!-- Botão Burger -->

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon text-white"></span>
            </button>
        </div>
    </nav>

    <!-- Menu offcanvas lateral -->
    <aside>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <img src="../../imagens/user.png" class="rounded-circle" width="50" height="50">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">Nome do Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">
                <ul>
                    <li><a href="solicitar_postagem.php">Solicitar Postagem</a></li>
                    <li><a href="gerenciar_postagens.php">Gerenciar Postagens</a</li>
                    <li><a href="editar_perfil.php">Editar perfil</a></li>
                    <li><a href="excluir_perfil.php">Excluir Perfil</a></li>
                    <li class="separator">
                        <button type="button" class="btn btn-outline-primary w-100 mt-3" data-bs-toggle="modal"
                            data-bs-target="#confirmExitModal">Sair
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
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

    <div class="container mt-5 flex solicitarPostagem-box">
        <div class="container pb-2 text-center">
            <img src="../imagens/brand.png" width="80" class="img-fluid" alt="">
            <p class="pt-1 text-center">Solicite sua postagem no sistema SALVAR</p>
        </div>
        <form id="loginForm" action="solicitar_postagem.php" method="POST">
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="floatingInput1" placeholder="Alimento" name="alimento" required>
                <label for="floatingInput1">Alimento (Arroz, feijao, etc..)</label>
            </div>
            <div class="row">
                <div class="form-floating mb-2 col-lg-6">
                    <input type="number" class="form-control bg-transparent" id="floatingInput2" name="quantidade" placeholder="Quantidade" required>
                    <label for="floatingInput2" class="adjust">Quantidade</label>
                </div>
                <div class="form-floating mb-2 col-lg-6">
                    <label for="select" class="m-1 p-3" id="lb-select">Unidade de Medida</label>
                    <select class="form-select" id="select" aria-label="Unidade de Medida" name="unidade_medida" required>
                        <option selected value="" aria-placeholder="Unidade de Medida"></option>
                        <option value="Kg">Kg</option>
                        <option value="g">g</option>
                        <option value="L">L</option>
                        <option value="ml">ml</option>
                    </select>
                </div>
            </div>      
            <div class="form-floating mb-2">
                <input type="date" class="form-control" id="floatingInput3" placeholder="Data de Validade" name="data_validade" required>
                <label for="floatingInput3">Data de Validade</label>
            </div>
            <div class="form-floating mb-2 input-group">
                <span class="input-group-text">Observações</span>
                <textarea class="form-control" aria-label="Observações" rows="3" maxlength="100" id="text-area" name="observacoes"></textarea>
                <legend class="p-1"><i>Máximo de 100 caracteres</i></legend>
              </div>
            <button type="submit" class="btn btn-primary mt-3 total-btn">Solicitar Postagem</button>
        </form>

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
                        <button type="button" class="btn btn-primary" id="confirmExitButton">Sair</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="../js/logout.js"></script>
    <script src="../js/solicitar.js"></script>
</body>


<footer class="p-2 text-center text-white">
    <p>Desenvolvido por Gabriel Batista e Dalmo Scalon - Universidade Federal de Uberlândia</p>
</footer>

</html>