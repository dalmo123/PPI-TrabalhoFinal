<!DOCTYPE html>
<html>
<head>
    <title>SALVAR | Sistema de Apoio à Luta contra Vulnerabilidade Alimentar e Recursos</title>
    <meta charset="utf-8">
    <!-- Arquivos CSS e JavaScript do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- Estilos CSS personalizados  -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
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

            <!-- Botão Burger  -->
            
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
     
    <div class="container mt-4">
        <div class="row">
            <!-- Carrossel (lado esquerdo) -->
            <div class="col-lg-6 h-100">
                <div id="carousel" class="carousel slide carousel-fade mt-5">
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <a href="https://brasil.un.org/pt-br/sdgs/2" target="_blank">
                            <img src="imagens/Fome_zero.jpeg" class="d-block w-100 rounded" title="Fome Zero e Agricultura Sustentável" alt="Banner com o objetivo do seculo número 2 da ONU, com fundo roxo e letras brancas, também um link que leva à página da ONU Brasil que descreve o objetivo.">
                        </a>
                      </div>
                      <div class="carousel-item">
                        <a href="https://brasil.un.org/pt-br/sdgs" target="_blank">
                            <img src="imagens/agenda.jpeg" class="d-block w-100 rounded" title="Os 17 objetivos do século, painel" alt="Um painel com figuras dos 17 objetivos do seculo da ONU e também um link que leva à página oficial dos objetivos no site da ONU Brasil.">
                        </a>
                      </div>
                    </div>

                    <!-- Carrossel (botões) -->
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
                    O SALVAR é uma plataforma dedicada a promover a união entre Organizações Não Governamentais (ONGs) que necessitam de recursos alimentares e fornecedores de alimentos dispostos a doar. Esses fornecedores podem ser empresas, instituições ou qualquer pessoa que deseje contribuir com recursos alimentares para aqueles que mais precisam.
                </p>
            </div>
        </div>
    </div>

    <!-- Segunda sessão: Nossa Motivação e SVG -->
    <div class=" mt-5" id="motiv">
        <div class="container">
            <div class="row">
                <!-- Texto: Nossa Motivação (lado esquerdo) -->
                <div class="col-lg-7">
                    <h2 class="text-white mt-4">Nossa Motivação</h2>
                    <p class="text-white mt-5">
                        O tema central do SALVAR está alinhado com o Objetivo de Desenvolvimento Sustentável (ODS) número dois, que é "Fome Zero e Agricultura Sustentável". A plataforma foi desenvolvida com o objetivo de contribuir para a erradicação da fome, garantindo o acesso de todas as pessoas, especialmente as mais pobres e vulneráveis, incluindo crianças, a alimentos seguros, nutritivos e suficientes durante todo o ano.
                    </p>
                    <p class="text-white mb-4">
                        Com a implementação do SALVAR, facilitamos o contato entre as ONGs que lutam contra a vulnerabilidade alimentar e os doadores de alimentos. Essa colaboração é fundamental para alcançar o ODS de Fome Zero, trabalhando juntos para garantir que ninguém passe fome em nossa comunidade e no mundo.
                    </p>
                </div>
                <!-- SVG (lado direito) -->
                <div class="col-lg-5 mb-4 mt-4">
                    <img src="imagens/plate.png" class="img-fluid" alt="">
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Terceira sessão: Cards -->
    <div class="container mt-5 mb-5">
        <div class="row">

            <!-- Cadastro -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body mb-5">
                        <h5 class="card-title">Cadastro</h5>
                        <p class="card-text">Cadastre-se no sistema SALVAR.</p>
                        <a href="cadastro_usuario.html" class="btn btn-primary">Cadastrar</a>
                    </div>
                </div>
            </div>

            <!-- Listagem -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body mb-5">
                        <h5 class="card-title">Listagem</h5>
                        <p class="card-text">Veja quem já colabora no sistema SALVAR.</p>
                        <a href="lista_itens.html" class="btn btn-primary">Ver Lista</a>
                    </div>
                </div>
            </div>

            <!-- Objetivos da ONU -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body mb-5">
                        <h5 class="card-title">Objetivos da ONU</h5>
                        <p class="card-text">Conheça os 17 Objetivos do Século da ONU.</p>
                        <a href="https://brasil.un.org/pt-br/sdgs" target="_blank" class="btn btn-primary">Saiba Mais</a>
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
