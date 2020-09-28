<?php
require '../config.php';

if (METHOD === 'POST') {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_STRING);

    if (!empty($title) && !empty($body)) {
        $sql = $pdo->prepare("INSERT INTO notes (title, body) VALUES (:TITLE, :BODY)");
        $sql->bindParam(':TITLE', $title, PDO::PARAM_STR);
        $sql->bindParam(':BODY', $body, PDO::PARAM_STR);
        
        if ($sql->execute()) {
            $apiReturn['result'] = [
                'mensagem' => 'Cadastro realizado com sucesso!',
                'id' => $pdo->lastInsertId(),
                'title' => $title,
                'body' => $body,
            ];
        } else {
            $apiReturn['error'] = true;
            $apiReturn['message'] = 'Error on insert a new register';
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
