<?php
require '../config.php';

if (METHOD === 'GET') {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if (!empty($id)) {
        $sql = $pdo->prepare("SELECT * FROM notes WHERE id = :ID");
        $sql->bindParam(':ID', $id, PDO::PARAM_INT);
        $sql->execute();
    
        if ($sql->rowCount() > 0) {
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $apiReturn['result'] = [
                'id' => $data['id'],
                'title' => $data['title'],
                'body' => $data['body'],
            ];
        } else {
            $apiReturn['result'] = 'Sem resultados para essa consulta';
        }
    } else {
        $apiReturn['error'] = true;
        $apiReturn['message'] = 'No integer parameters sent';
    }
} else {
    $apiReturn['error'] = true;
    $apiReturn['message'] = 'Invalid request method';
}

require '../return.php';
