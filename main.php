#!/usr/bin/php
<?php
ini_set('display_errors','0');
chdir(dirname(__FILE__));
echo "Doing some fixes, plz wait..".PHP_EOL;
if (file_exists("./etc/nginx.conf")) rename("./etc/nginx.conf","/etc/nginx.conf");
$ver = json_decode(file_get_contents("./ver.ver"),true);
echo "=-=-=-=-=-=-FuMotion-=-=-=-=-=-=".PHP_EOL;
echo "build - Build your custom APK, based on your network and other configuration".PHP_EOL;
echo "spy - Enable a spider-server, for re-transmit data from your eMotion app".PHP_EOL;
echo "update - Update a distro from f14a2cd's github".PHP_EOL;
echo "=-=-=-=-=-=-FuMotion-=-=-=-=-=-=".PHP_EOL;
echo "built on {$ver[1]} by {$ver[2]} (CLI: {$ver[3]}) (v.{$ver[0]})".PHP_EOL;
while (-1) {
    $command = strtolower(readline("fum:#> "));
    if (!file_exists("./{$command}.php")) {echo "Команда не найдена: {$command}.".PHP_EOL; continue;}
    if (!function_exists("do".ucfirst($command))) $exists = "0"; else $exists = "1";
    switch($command) {
        case 'build':
            if ($exists !== "1") require 'build.php';
            doBuild();
        break;
        case 'update':
            if ($exists !== "1") require 'update.php';
            doUpdate();
        break;
        case 'spy':
            if ($exists !== "1") require 'spy.php';
            doSpy();
        break;
    }
    chdir(dirname(__FILE__));
}
