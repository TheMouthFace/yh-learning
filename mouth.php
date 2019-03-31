<?php
header("Content-Type:text/html;charset=utf-8");
		$url = "https://www.tianqiapi.com/api/?version=v1&city=株洲";
		$ch = curl_init();
       	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$url);
        $res = curl_exec($ch);
        $arr = json_decode($res,true);

var_dump($arr);
