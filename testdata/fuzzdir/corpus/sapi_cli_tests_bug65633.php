<?php
include "php_cli_server.inc";
php_cli_server_start(<<<'PHP'
var_dump($_COOKIE, $_SERVER['HTTP_FOO']);
PHP
);

list($host, $port) = explode(':', PHP_CLI_SERVER_ADDRESS);
$port = intval($port)?:80;

$fp = fsockopen($host, $port, $errno, $errstr, 0.5);
if (!$fp) {
  die("connect failed");
}

if(fwrite($fp, <<<HEADER
GET / HTTP/1.1
cookie: foo=bar
foo: bar


HEADER
)) {
    while (!feof($fp)) {
        echo fgets($fp);
    }
}

fclose($fp);
?>
