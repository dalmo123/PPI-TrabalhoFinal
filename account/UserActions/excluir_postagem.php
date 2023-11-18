<?php
require_once "../../conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["post_id"])) {
    $post_id = $_POST["post_id"];

    // Lógica para excluir a postagem com o ID fornecido
    $conn = new Conexao();
    $sql = "DELETE FROM postagens WHERE id = ?";
    $stmt = $conn->conexao->prepare($sql);
    $stmt->bindParam(1, $post_id);

    if ($stmt->execute()) {
        header("Location: gerenciar_postagens.php");
    } else {
        // Erro ao excluir
        echo "Erro ao excluir postagem. Tente novamente mais tarde.";
    }
} else {
    // ID da postagem não fornecido ou método de requisição inválido
    echo "ID da postagem não fornecido ou método de requisição inválido.";
}
?>