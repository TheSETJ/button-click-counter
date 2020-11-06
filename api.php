<?php

if (isset($_GET['fn'])) {
    if ($_GET['fn'] === 'getClicksCount') {
        $result = getClicksCount();

        if ($result['failed']) {
            http_response_code(500);
            echo json_encode(implode('<br>', $result['errors']));
            return;
        }

        echo json_encode($result['data']['clicks_count']);
        return;
    }

    if ($_GET['fn'] === 'updateClicksCount') {
        $result = updateClicksCount();

        if ($result['failed']) {
            http_response_code(500);
            echo json_encode(implode('<br>', $result['errors']));
            return;
        }

        echo json_encode($result['data']['clicks_count']);
        return;
    }
}

function getClicksCount()
{
    $result = [
        'failed' => false,
        'errors' => [],
        'data' => []
    ];

    try {
        $db = new SQLite3('db.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

        ensureStatsTableExistence($db);

        $result['data']['clicks_count'] = fetchClicksCountFromDb($db);
    } catch (Exception $e) {
        $result['failed'] = true;
        $result['errors'][] = $e->getMessage();
    }

    return $result;
}

function updateClicksCount()
{
    $result = [
        'failed' => false,
        'errors' => [],
        'data' => []
    ];

    try {
        $db = new SQLite3('db.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

        ensureStatsTableExistence($db);

        // get current count
        $count = fetchClicksCountFromDb($db);

        $query = $count === null ?
            'INSERT INTO "stats" ("key", "value") VALUES (:key, :count)' :
            'UPDATE "stats" SET "value" = :count WHERE "key" = :key';

        $statement = $db->prepare($query);

        $statement->bindValue(':key', 'clicks_count');
        $statement->bindValue(':count', $count + 1);
        $statement->execute();

        $result['data']['clicks_count'] = $count + 1;
    } catch (Exception $e) {
        $result['failed'] = true;
        $result['errors'][] = $e->getMessage();
    }

    return $result;
}

function ensureStatsTableExistence($db)
{
    $db->query('CREATE TABLE IF NOT EXISTS "stats" (
        "key" TEXT NOT NULL UNIQUE,
        "value"
    )');
}

function fetchClicksCountFromDb($db)
{
    $statement = $db->prepare('SELECT "value" FROM "stats" WHERE "key" = :key');

    $statement->bindValue(':key', 'clicks_count');

    return $statement->execute()->fetchArray()[0];
}
