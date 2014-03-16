<?php
require '../vendor/autoload.php';
use TQ\Git\Repository\Repository;
if (empty($_GET['v'])) {
    header('HTTP/1.1 400 Bad request', true, 400);
    exit;
}
$victim = $_GET['v'];
$git = Repository::open(__DIR__);
$log = $git->getLog(['author' => $victim, 'since' => 'january']);
$commitIds = array();
foreach ($log as $commit) {
    preg_match('/^commit (?P<sha1>[0-9a-f]{40})/i', $commit, $matches);
    if (isset($matches['sha1'])) {
        $commitIds[] = $matches['sha1'];
    }
}
echo json_encode(['victim' => $victim, 'commits' => $commitIds]);
