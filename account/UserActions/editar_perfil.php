<!DOCTYPE html>
<html>

<head>
    <title>SALVAR | Editar Perfil</title>
    <!-- Arquivos CSS e JavaScript do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- Estilos CSS personalizados -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/offCanvas.css">
    <link rel="icon" type="image/x-icon" href="../imagens/brand.png">

</head>
<header>
    <!-- Barra de Navegação -->
    <nav class="navbar navbar-expand-lg navbar-custom navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index_usuario.html"><img src="../imagens/Logo_transp.png" class="img-fluid" width="200" title="Logo Sistema Salvar" alt=""></a>

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
                        <img src="../imagens/user.png" class="rounded-circle" width="50" height="50">
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
                <img src="../imagens/user.png" class="rounded-circle" width="50" height="50">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">Nome do Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">
                <ul>
                    <li><a href="solicitar_postagem.html">Solicitar Postagem</a></li>
                    <li><a href="gerenciar_postagens.html">Gerenciar Postagens</a</li>
                    <li><a href="editar_perfil.html">Editar perfil</a></li>
                    <li><a href="excluir_perfil.html">Excluir Perfil</a></li>
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

    <div class="container mt-5 flex login-box">
        <div class="container pb-2 text-center">
            <img src="../imagens/brand.png" width="80" class="img-fluid" alt="">
            <p class="pt-1 text-center">Edite o seu perfil no sistema SALVAR</p>
        </div>
        <form id="profileEditForm">
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="name" placeholder="Nome" value="Nome do Usuário" autocomplete="on">
                <label for="name">Nome</label>
            </div>
            <div class="form-floating mb-2">
                <input type="email" class="form-control" id="email" placeholder="Email" value="usuario@example.com" autocomplete="on">
                <label for="email">Email</label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="tel" placeholder="Telefone" value="Telefone do Usuário" autocomplete="on">
                <label for="tel">Telefone</label>
            </div>
            <div class="mb-3">
                <label for="profilePicture" class="form-label">Foto de Perfil</label>
                <input type="file" class="form-control" id="profilePicture" accept="image/*">
            </div>
            <button type="button" class="btn btn-primary" id="uploadProfilePicture">Trocar Foto de Perfil</button>        
        
            <button type="submit" class="btn btn-primary mt-3 total-btn">Salvar Alterações</button>
        </form>
    </div>
    <!-- Código JavaScript -->
    <script src="../js/profileEdit.js"></script>
</body>
<footer class="p-2 text-center text-white">
    <p>Desenvolvido por Gabriel Batista e Dalmo Scalon - Universidade Federal de Uberlândia</p>
</footer>

</html>