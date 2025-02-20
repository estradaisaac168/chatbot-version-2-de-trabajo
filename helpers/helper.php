<?php
function sendResponse($statusCode, $data)
{
    http_response_code($statusCode);
    echo json_encode($data);
}

function validateId($id)
{
    if (!isset($id) || trim($id) == '') {
        return false;
    } else {
        $id = intval($id);

        if ($id <= 0) {
            return false;
        }
    }

    return true;
}
