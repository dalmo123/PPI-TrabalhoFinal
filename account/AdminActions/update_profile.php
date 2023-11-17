<?php
    require_once "../conexao.php";
    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Verifique se o ID do usuário está presente
        if (!isset($_POST['id'])) {
            http_response_code(400);
            echo json_encode(["error" => "ID do usuário não fornecido"]);
            exit;
        }

        $userId = $_POST['id'];
        $nome = isset($_POST["name"]) ? $_POST["name"] : null;
        $email = isset($_POST["email"]) ? $_POST["email"] : null;
        $telefone = isset($_POST["tel"]) ? $_POST["tel"] : null;

        // Verifique se o arquivo de foto de perfil foi enviado
        if (isset($_FILES["profilePicture"]) && $_FILES["profilePicture"]["error"] === 0) {
            $fotoPerfilNome = $_FILES["profilePicture"]["name"];
            $fotoPerfilTipo = $_FILES["profilePicture"]["type"];
            $fotoPerfilDados = file_get_contents($_FILES["profilePicture"]["tmp_name"]);
        } else {
            // Se não fornecido, mantenha os dados atuais no banco
            $fotoPerfilNome = null;
            $fotoPerfilTipo = null;
            $fotoPerfilDados = null;
        }

        // Atualize os dados no banco de dados
        $conn = new Conexao();
        $sql = "UPDATE usuarios SET nome = ?, email = ?, telefone = ?, foto_perfil_nome = ?, foto_perfil_tipo = ?, foto_perfil_dados = ? WHERE id = ?";
        $stmt = $conn->conexao->prepare($sql);
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $telefone);
        $stmt->bindParam(4, $fotoPerfilNome);
        $stmt->bindParam(5, $fotoPerfilTipo);
        $stmt->bindParam(6, $fotoPerfilDados);
        $stmt->bindParam(7, $userId);

        if ($stmt->execute()) {
            // Atualização bem-sucedida
            http_response_code(200);
            echo json_encode(["success" => "Perfil atualizado com sucesso"]);
        } else {
            // Erro ao executar a atualização
            http_response_code(500);
            echo json_encode(["error" => "Erro ao atualizar o perfil"]);
        }
    } else {
        // Método de solicitação incorreto
        http_response_code(405);
        echo json_encode(["error" => "Método de solicitação incorreto"]);
    }
?>
