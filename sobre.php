<!DOCTYPE html>
<html>
<head>
    <title>SALVAR | Sobre o Sistema</title>
    <meta charset="utf-8">
    <!-- Arquivos CSS e JavaScript do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- Estilos CSS personalizados -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/sobre.css">
    <link rel="icon" type="image/x-icon" href="imagens/brand.png">

</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-custom navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html"><img src="imagens/Logo_transp.png" class="img-fluid" width="200" title="Logo Sistema Salvar" alt=""></a>

            <!-- Links à esquerda -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item text-center">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="sobre.php">Sobre</a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="lista_itens.php">Lista de Usuários</a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="cadastro_usuario.php">Cadastro</a>
                    </li>
                </ul>
            </div>

            <!-- Botão Burger -->

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon text-white"></span>
            </button>
        </div>
    </nav>
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

    <div class="container content mt-5 mb-5">

        <!-- Sobre o sistema -->
        <h1 class="text-white mb-5">Sobre</h1>
        <p class="mb-3 p-style text-justify text-black">O sistema SALVAR foi desenvolvido para fins acadêmicos, por
            alunos da Universidade Federal de Uberlândia, como modo de consolidação de conhecimentos adquiridos em
            ministrações das aulas que concernem à disciplina de Programação para Internet, responsável
            pela introdução dos alunos ao desenvolvimento Web no curso de Sistemas de Informação. O sistema tem como
            objetivo unir fornecedores e ONG's com o objetivo de diminuir a fome em um país que a fome é uma
            caracteristica e um grande problema a ser sanado.
        </p>
        <p class="mb-3 p-style text-justify text-black">O sistema se dá pelo cadastro de fornecedores e ONG's onde o usuario registra no sistema, posta os alimentos
            que estão disponiveis para doação e ONG's interessadas podem entrar em contato, ou entao,
            as ONG's postam suas necessidades e o usuario também pode ver a lista de itens das ONG's e entrar em contato
            para fazer a doação. Então o sistema é um facilitador para unir pessoas e organizações que possuem o mesmo
            intuito de diminuir a fome no país.
        </p>

        <!-- Conteúdo sobre a equipe desenvolvedora e a disciplina -->

        <h3 class="mt-4">Desenvolvedores</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                      <h5 class="card-title text-white presentation">Dalmo Scalon Inacio</h5>
                      <p class="card-text text-white">Graduando em Sistemas de Informação - UFU. Aluno da 26° turma ingressante do curso.</p>
                      <a href="https://www.linkedin.com/in/dalmo-scalon-9134661a3?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app" target="_blank" class="card-link text-white" >Linkedin</a>
                    </div>
                  </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                      <h5 class="card-title text-white">Gabriel Alcântara da Costa Batista</h5>
                      <p class="card-text text-white">Graduando em Sistemas de Informação - UFU. Aluno da 19° turma ingressante do curso.</p>
                      <a href="https://www.linkedin.com/in/gblbatista?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app" target="_blank" class="card-link text-white" >Linkedin</a>
                    </div>
                  </div>
            </div>
        </div>

         <!-- Conteúdo sobre a disciplina -->

        <h3 class="mt-4">Sobre a Disciplina</h3>
        <div class="card mb-5 p-style" id="disc">
            <div class="row g-0">
              <div class="col-lg-4">
                <img src="imagens/logo_ufu.jpg" class="img-fluid rounded-2 m-1" alt="" title="Logo UFU">
              </div>

               <!-- Programação para Internet -->
              <div class="col-lg-8">
                <div class="card-body">
                  <h5 class="card-title">Programação para Internet - GSI019</h5>
                  <p class="card-text text-white mt-3 text-justify">É uma disciplina oferecida pelo curso de Sistemas de Informação da Faculdade de Computação da UFU, obrigatória com uma carga horária total de 60 horas, plenamente prática. Fornece umma visão geral do funcionamento de sistemas na Web e os protocolos envolvidos, introduzindo o aluno ao paradigma de Programação para Internet.</p>
                  <p class="card-text mt-3"><small class="text-white">Docente em exercício: <a href="https://www.facom.ufu.br/~rafaelaraujo/" target="_blank" class="text-white">Rafael Dias Araújo</a>.</small></p>
                  <div class="dropdown mt-2">
                    <a class="btn btn-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Outras Informações
                    </a>
                  
                    <!-- Links para ficha da disciplina, pagina da facom e pagina do professor -->
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="https://facom.ufu.br/system/files/conteudo/gsi019-programacao-para-internet.pdf" target="_blank">Ficha da Disciplina</a></li>
                      <li><a class="dropdown-item" href="https://facom.ufu.br/" target="_blank">Site da FACOM</a></li>
                      <li><a class="dropdown-item" href="https://www.facom.ufu.br/~rafaelaraujo/" target="_blank">Sobre o Professor</a></li>
                    </ul>
                  </div>
              </div>
                </div>
            </div>
          </div>
          
    </div>
</body>

<!-- Footer -->

<footer class="p-2 text-center text-white">
    <p>Desenvolvido por Gabriel Batista e Dalmo Scalon - Universidade Federal de Uberlândia</p>
</footer>
</html>
