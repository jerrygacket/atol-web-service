<?php
function toLog($message) {
    $timeStamp = date('Y-m-d H:i:s');
    file_put_contents('git_log', $timeStamp.' '.$message . PHP_EOL, FILE_APPEND);
}

if (!isset($_POST)) {
    echo "wrong request";
    exit;
}

$payload = json_decode(file_get_contents("php://input"), true);
$headers = getallheaders();

if (
     $headers['X-Github-Event'] == 'pull_request'
    && $payload['action'] == 'closed'
) {
    toLog('Begin update ***************************');
    $result = shell_exec("cd /var/www/atol-front/atol-web-service && git reset --hard HEAD");
    toLog($result);
    $result = shell_exec("cd /var/www/atol-front/atol-web-service && git pull origin master");
    toLog($result);
    toLog('User: ' . $payload['pull_request']['user']['login']);
    toLog($payload['pull_request']['title']);
    toLog($payload['pull_request']['body']);
    toLog('End update ***************************');
    exit;
}

echo 'no actions';