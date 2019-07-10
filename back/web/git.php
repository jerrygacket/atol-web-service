<?php
if (!isset($_POST)) {
    echo "wrong request";
    exit;
}

$payload = json_decode(file_get_contents("php://input"), true);

$secret = $payload['hook']['config']['secret'] ?? '';

if ($secret != 'eeSaoSuongaeyuor8cee') {
    echo "wrong request";
    exit;
}

file_put_contents('git_request', print_r($payload['hook']['events'],true));
//file_put_contents('git_request', $payload->hook->events);
//
//exec("git pull https://user:password@bitbucket.org/user/repo.git master");
echo 'OK';