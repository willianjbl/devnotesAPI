<?php
require '../config.php';

if (METHOD === 'DELETE') {
    parse_str(file_get_contents('php://input'), $input);
    
    $id = filter_var($input['id'], FILTER_VALIDATE_INT) ?? null;

    if (!empty($id)) {
        $sql = $pdo->prepare("SELECT * FROM notes WHERE id = :ID");
        $sql->bindParam(':ID', $id, PDO::PARAM_INT);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $temp = $sql->fetch(PDO::FETCH_ASSOC);
            $sql = $pdo->prepare("DELETE FROM notes WHERE id = :ID");
            $sql->bindParam(':ID', $id, PDO::PARAM_INT);
    
            if ($sql->execute()) {
                $apiReturn['result'] = [
                    'mensagem' => 'Dados removidos com sucesso!',
                    'id' => $temp['id'],
                    'title' => $temp['title'],
                    'body' => $temp['body'],
                ];
            } else {
                $apiReturn['error'] = true;
                $apiReturn['message'] = 'Error on removing register';
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
