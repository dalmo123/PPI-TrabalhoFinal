<?php
// get_user_data.php

require_once "../conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $userId = $_POST['id'];

    // Recupera os dados do formulário
    $nome = !empty($_POST["name"]) ? $_POST["name"] : null;
    $email = !empty($_POST["email"]) ? $_POST["email"] : null;
    $telefone = !empty($_POST["tel"]) ? $_POST["tel"] : null;

    // Atualiza a foto de perfil, se fornecida
    if (isset($_FILES["profilePicture"]) && $_FILES["profilePicture"]["error"] == 0) {
        $foto_perfil_nome = $_FILES["profilePicture"]["name"];
        $foto_perfil_tipo = $_FILES["profilePicture"]["type"];
        $foto_perfil_dados = file_get_contents($_FILES["profilePicture"]["tmp_name"]);
    } else {
        // Se não fornecida, mantenha os dados atuais no banco
        $foto_perfil_nome = null;
        $foto_perfil_tipo = null;
        $foto_perfil_dados = null;
    }

    // Atualiza os dados no banco apenas se não estiverem em branco
    $sql = "UPDATE usuarios SET nome = COALESCE(?, nome), email = COALESCE(?, email), telefone = COALESCE(?, telefone), foto_perfil_nome = COALESCE(?, foto_perfil_nome), foto_perfil_tipo = COALESCE(?, foto_perfil_tipo), foto_perfil_dados = COALESCE(?, foto_perfil_dados) WHERE id = ?";
    $stmt = $conn->conexao->prepare($sql);
    $stmt->bindParam(1, $nome);
    $stmt->bindParam(2, $email);
    $stmt->bindParam(3, $telefone);
    $stmt->bindParam(4, $foto_perfil_nome);
    $stmt->bindParam(5, $foto_perfil_tipo);
    $stmt->bindParam(6, $foto_perfil_dados);
    $stmt->bindParam(7, $userId);
    $stmt->execute();

    // Envie uma resposta JSON indicando o sucesso ou falha da operação
    $response = ['success' => true];
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Se não for uma solicitação POST válida, envie uma resposta indicando erro
    $response = ['success' => false, 'message' => 'Invalid request'];
    header('Content-Type: application/json');
    echo json_encode($response);
}

?>