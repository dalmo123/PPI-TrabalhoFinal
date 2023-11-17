<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST["post_id"];
    $alimento = $_POST["alimento"];
    $quantidade = $_POST["quantidade"];
    $unidade_medida = $_POST["unidade_medida"];
    $data_validade = $_POST["data_validade"];
    $observacoes = $_POST["observacoes"];

    require_once "../conexao.php";
    $conn = new Conexao();

    // Atualizar o registro no banco de dados
    $sql = "UPDATE postagens SET alimento = ?, quantidade = ?, unidade_medida = ?, data_validade = ?, observacoes = ? WHERE id = ?";
    $stmt = $conn->conexao->prepare($sql);
    $stmt->bindParam(1, $alimento);
    $stmt->bindParam(2, $quantidade);
    $stmt->bindParam(3, $unidade_medida);
    $stmt->bindParam(4, $data_validade);
    $stmt->bindParam(5, $observacoes);
    $stmt->bindParam(6, $post_id);

    if ($stmt->execute()) {
        // Redirecionar para a página de sucesso ou outra página
        header("Location: gerenciar_postagens.php");
        exit();
    } else {
        // Tratar erros de execução da consulta
        echo "Erro ao editar a postagem.";
    }
}
?>
