<?php
require '../config.php';

if (METHOD === 'GET') {
    $sql = $pdo->query("SELECT * FROM notes");

    if ($sql->rowCount() > 0) {
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $item) {
            $apiReturn['result'][] = [
                'id' => $item['id'],
                'title' => $item['title'],
                'body' => $item['body'],
            ];
        }
    } else {
        $apiReturn['result'] = 'Sem resultados para essa consulta';
    }
} else {
    $apiReturn['error'] = true;
    $apiReturn['message'] = 'Invalid request method';
}

require '../return.php';
