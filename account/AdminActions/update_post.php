<?php
require_once "../conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['postId'])) {
    $postId = $_POST['postId'];

    // Obtenha os outros dados do formulário
    $alimento = !empty($_POST['alimento']) ? $_POST['alimento'] : null;
    $qtd = !empty($_POST['quantidade']) ? $_POST['quantidade'] : null;
    $unidade = !empty($_POST['unidade']) ? $_POST['unidade'] : null;
    $data = !empty($_POST['data']) ? $_POST['data'] : null;
    $obs = !empty($_POST['obs']) ? $_POST['obs'] : null;

    $conn = new Conexao();

    try {
        // Preparar e executar a instrução SQL UPDATE usando COALESCE
        $sql = "UPDATE postagens SET
                alimento = COALESCE(?, alimento),
                quantidade = COALESCE(?, quantidade),
                unidade_medida = COALESCE(?, unidade_medida),
                data_validade = COALESCE(?, data_validade),
                observacoes = COALESCE(?, observacoes)
                WHERE id = ?";

        $stmt = $conn->conexao->prepare($sql);
        $stmt->bindParam(1, $alimento, PDO::PARAM_STR);
        $stmt->bindParam(2, $qtd, PDO::PARAM_STR);
        $stmt->bindParam(3, $unidade, PDO::PARAM_STR);
        $stmt->bindParam(4, $data, PDO::PARAM_STR);
        $stmt->bindParam(5, $obs, PDO::PARAM_STR);
        $stmt->bindParam(6, $postId, PDO::PARAM_INT);

        if($stmt->execute()){
            header('Location: gerenciar_postagens.php');
            exit();
        }
    } catch (PDOException $e) {
        // Tratar exceções, se necessário
        echo "Erro: " . $e->getMessage();
    }
}
?>
