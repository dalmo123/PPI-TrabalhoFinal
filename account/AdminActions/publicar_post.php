<?php
// publicar_post.php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['postId'])) {
    $postId = $_POST['postId'];

    // Realize a atualização do status da postagem para "aprovada" no banco de dados aqui
    // Exemplo usando PDO:
    require_once "../../conexao.php";
    $conn = new Conexao();
    $sql = "UPDATE postagens SET status = 'aprovada' WHERE id = ?";
    $stmt = $conn->conexao->prepare($sql);
    $stmt->bindParam(1, $postId);
    $stmt->execute();

    // Responda com uma mensagem (opcional)
    echo "Postagem aprovada com sucesso!";
} else {
    // Responda com um erro (opcional)
    header('HTTP/1.1 400 Bad Request');
    echo "Erro na solicitação";
}
?>
