<?php
function doBuild() {
	/* get ips */
	$ips = explode(PHP_EOL, shell_exec("bash ./build/ip.sh"));
	echo "Please, select IP address on your local network: ".PHP_EOL;
	foreach($ips as $key=>$ip) {
		echo "{$key}) {$ip}".PHP_EOL;
	}
	$ipaddr = $ips[readline("")];

	echo "Writing some changes to spy server..".PHP_EOL;
	file_put_contents("/etc/nginx/sites-enabled/emotion",str_replace("%ipaddress%",$ipaddr, file_get_contents("./build/web.conf")));
	shell_exec("sudo service nginx reload");
	echo "Unpacking build...".PHP_EOL;
	chdir("build");
	shell_exec("unzip -u build.zip");
	echo "Writing changes to eMotion source...".PHP_EOL;
	shell_exec("bash change.sh ${ipaddr}");
	echo "Building and signing APK..".PHP_EOL;
	shell_exec("bash build.sh");
	echo "APK is almost ready..".PHP_EOL;
	rename("/fumotion/build/build/dist/ru_megalabs_multifon_3.2.1_07_23_2019.s.apk","/fumotion/share/emotion-{$ipaddr}.apk");
	echo "Your APK is ready to install: http://{$ipaddr}:11111/emotion-{$ipaddr}.apk".PHP_EOL;
	echo "To get ready, enter \"spy\"".PHP_EOL;
	return;
}



?>

