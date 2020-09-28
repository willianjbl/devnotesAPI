<?php
require '../config.php';

if (METHOD === 'PUT') {
    parse_str(file_get_contents('php://input'), $input);
    
    $id = filter_var($input['id'], FILTER_VALIDATE_INT) ?? null;
    $title = filter_var($input['title'], FILTER_SANITIZE_STRING | FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
    $body = filter_var($input['body'], FILTER_SANITIZE_STRING | FILTER_SANITIZE_SPECIAL_CHARS) ?? null;

    if (!empty($id) && !empty($title) && !empty($body)) {
        $sql = $pdo->prepare("SELECT * FROM notes WHERE id = :ID");
        $sql->bindParam(':ID', $id, PDO::PARAM_INT);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $sql = $pdo->prepare("UPDATE notes SET title = :TITLE, body = :BODY WHERE id = :ID");
            $sql->bindParam(':TITLE', $title, PDO::PARAM_STR);
            $sql->bindParam(':BODY', $body, PDO::PARAM_STR);
            $sql->bindParam(':ID', $id, PDO::PARAM_INT);
    
            if ($sql->execute()) {
                $apiReturn['result'] = [
                    'mensagem' => 'Dados alterados com sucesso!',
                    'id' => $id,
                    'title' => $title,
                    'body' => $body,
                ];
            } else {
                $apiReturn['error'] = true;
                $apiReturn['message'] = 'Error on updating register';
            }
        } else {
            $apiReturn['error'] = true;
            $apiReturn['message'] = 'No data found';
        }
    } else {
        $apiReturn['error'] = true;
        $apiReturn['message'] = 'Missing parameters';
    }
} else {
    $apiReturn['error'] = true;
    $apiReturn['message'] = 'Invalid request method';
}

require '../return.php';
