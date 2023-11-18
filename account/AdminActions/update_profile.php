<?php
    require_once "../../conexao.php";
    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Verifique se o ID do usuário está presente
        if (!isset($_POST['id'])) {
            http_response_code(400);
            echo json_encode(["error" => "ID do usuário não fornecido"]);
            exit;
        }

        $userId = $_POST['id'];

        $conn = new Conexao();
        $user = "SELECT foto_perfil_nome, foto_perfil_tipo, foto_perfil_dados FROM usuarios WHERE id = ?";
        $stmt1 = $conn->conexao->prepare($user);
        $stmt1->bindParam(1, $userId);
        $stmt1->execute();
        $result =  $stmt1->fetch(PDO::FETCH_ASSOC);

        
        $nome = isset($_POST["name"]) ? $_POST["name"] : null;
        $email = isset($_POST["email"]) ? $_POST["email"] : null;
        $telefone = isset($_POST["tel"]) ? $_POST["tel"] : null;
        $site = isset($_POST["site"]) ? $_POST["site"] : null;

        // Verifique se o arquivo de foto de perfil foi enviado
        // Atualiza a foto de perfil, se fornecida
        if (isset($_FILES["foto_perfil"]) && $_FILES["foto_perfil"]["error"] == 0) {
            $foto_perfil_nome = $_FILES["foto_perfil"]["name"];
            $foto_perfil_tipo = $_FILES["foto_perfil"]["type"];
            $foto_perfil_dados = file_get_contents($_FILES["foto_perfil"]["tmp_name"]);
        } else {
            // Se não fornecida, mantenha os dados atuais no banco
            $foto_perfil_nome = $result['foto_perfil_nome'];
            $foto_perfil_tipo = $result['foto_perfil_tipo'];
            $foto_perfil_dados = $result['foto_perfil_dados'];
        }

        // Atualize os dados no banco de dados
        $sql = "UPDATE usuarios SET nome = COALESCE(?, nome), email = COALESCE(?, email), telefone = COALESCE(?, telefone), site = COALESCE(?, site), foto_perfil_nome = COALESCE(?, foto_perfil_nome), foto_perfil_tipo = COALESCE(?, foto_perfil_tipo), foto_perfil_dados = COALESCE(?, foto_perfil_dados) WHERE id = ?";
        $stmt = $conn->conexao->prepare($sql);
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $telefone);
        $stmt->bindParam(4, $site);
        $stmt->bindParam(5, $foto_perfil_nome);
        $stmt->bindParam(6, $foto_perfil_tipo);
        $stmt->bindParam(7, $foto_perfil_dados);
        $stmt->bindParam(8, $userId);

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
