<?php
// Arquivo exclude.php
require_once "../conexao.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém o ID do perfil a ser excluído
    $userId = isset($_POST['id']) ? $_POST['id'] : null;

    // Certifica-se de que o ID não está vazio e não é 1 (evita excluir o admin)
    if ($userId !== null && $userId != 1) {
        try {
            $conn = new Conexao();
            $sql = "DELETE FROM usuarios WHERE id = ?";
            $stmt = $conn->conexao->prepare($sql);
            $stmt->bindParam(1, $userId);
            $stmt->execute();
            // Resposta bem-sucedida
            http_response_code(200);
            echo 'Exclusão bem-sucedida!';
        } catch (Exception $e) {
            // Erro ao excluir
            http_response_code(500);
            echo 'Erro ao excluir o perfil. Tente novamente.';
        }
    } else {
        // ID vazio ou tentativa de excluir admin
        http_response_code(400);
        echo 'Operação inválida.';
    }
} else {
    // Método de requisição inválido
    http_response_code(405);
    echo 'Método de requisição inválido.';
}
?>
