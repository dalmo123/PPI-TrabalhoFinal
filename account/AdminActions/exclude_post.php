<?php
require_once "../../conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['postId'])) {
        $postId = $_POST['postId'];
        
        $conn = new Conexao();

        try {
            // Preparar e executar a instrução SQL DELETE
            $sql = "DELETE FROM postagens WHERE id = ?";
            $stmt = $conn->conexao->prepare($sql);
            $stmt->bindParam(1, $postId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                // A exclusão foi bem-sucedida
                echo "Postagem excluída com sucesso!";
            } else {
                // Houve um erro na exclusão
                echo "Erro ao excluir a postagem.";
            }
        } catch (PDOException $e) {
            // Tratar exceções, se necessário
            echo "Erro: " . $e->getMessage();
        }
    }
?>

