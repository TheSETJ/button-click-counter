<?php

if (isset($_POST['fn'])) {
    if ($_POST['fn'] === 'updateClicksCount') {
        $validationResult = validateUpdateClicksCountRequest($_POST);

        if ($validationResult['failed']) {
            http_response_code(400);
            echo json_encode(implode('<br>', $validationResult['errors']));
            return;
        }

        echo json_encode(updateClicksCount((int) $_POST['count']));
        return;
    }
}

function validateUpdateClicksCountRequest($request)
{
    $validationResult = [
        'failed' => false,
        'errors' => []
    ];

    // required
    if (! isset($request['count'])) {
        $validationResult['failed'] = true;
        $validationResult['errors'][] = 'Parameter `count` is required.';

        return $validationResult;
    }

    // must be numeric
    if (! is_numeric($request['count'])) {
        $validationResult['failed'] = true;
        $validationResult['errors'][] = 'Parameter `count` must be of type `int`.';

        return $validationResult;
    }

    return $validationResult;
}

function updateClicksCount($count)
{
    return $count + 1;
}
