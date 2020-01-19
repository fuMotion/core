<?php

function doUpdate() {
    $ver = json_decode(file_get_contents("./ver.ver"),true);
    $server_ver = json_decode(file_get_contents("https://raw.githubusercontent.com/fuMotion/core/master/ver.ver"),true);
    if ($ver[0]==$server_ver[0]) {
        echo "Up-to-date".PHP_EOL;
        return;
    }
    else {
        echo "Updating to {$server_ver[0]}..".PHP_EOL;
        shell_exec('wget https://github.com/fuMotion/core/archive/master.zip -O /tmp/update.zip');
        chdir(dirname(__FILE__));
        shell_exec('unzip -u /tmp/update.zip');
        die("Please, re-launch app.".PHP_EOL);
    }
}
