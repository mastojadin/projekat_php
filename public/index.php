<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

require_once __DIR__ . '/../vendor/autoload.php';

$o_uri = isset($_SERVER['REQUEST_URI']) ? trim($_SERVER['REQUEST_URI'], '/') : '';
$o_query_string = $_SERVER['QUERY_STRING'] ?? '';
$o_post = !empty($_POST) ? $_POST : [];

$to_return = [];
$to_return['data'] = '';
$to_return['errors'] = '';

try {
    $e = new App\Entrypoint($o_uri, $o_query_string, $o_post);
    
    // we reject if extras
    if (!$e->check_number_of_uri_segments()) {
        throw new Exception('Too many options.');
    }
    // we reject everything that is not api option
    if (!$e->check_is_in_options()) {
        throw new Exception('Unknown option.');
    }
    // we reject everything that is not api action
    if (!$e->check_is_in_actions()) {
        throw new Exception('Unknown action.');
    }
    // we check if our find of query string is the same as server find
    // perhaps ?redundant?
    if (!$e->check_is_query_string_equal($o_query_string)) {
        throw new Exception('Query string does not match.');
    }
    // we check if out find of uri is the same as server find
    // perhaps ?redundant?
    if (!$e->check_is_uri_string_equal($o_uri)) {
        throw new Exception('Uri string does not match.');
    }

    $to_return['data'] = $e->call_needed();
} catch (\Exception $e) {
    $to_return['errors'] =  $e->getMessage();
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($to_return);
