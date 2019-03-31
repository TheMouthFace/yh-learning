<?php
    //获得参数 signature nonce token timestamp echostr
    $nonce     = $_GET['nonce'];
    $token     = 'weixin';
    $timestamp = $_GET['timestamp'];
    $echostr   = $_GET['echostr'];
    $signature = $_GET['signature'];
    //形成数组，然后按字典序排序
    $array = array();
    $array = array($nonce, $timestamp, $token);
    sort($array);
    //拼接成字符串,sha1加密 ，然后与signature进行校验
    $str = sha1( implode( $array ) );
    if( $str == $signature && $echostr ){
        //第一次接入weixin api接口的时候
        echo  $echostr;
        exit;
    }else{

        //1.获取到微信推送过来post数据（xml格式）
        $postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
        //2.处理消息类型，并设置回复类型和内容
        /*<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[FromUser]]></FromUserName>
<CreateTime>123456789</CreateTime>
<MsgType><![CDATA[event]]></MsgType>
<Event><![CDATA[subscribe]]></Event>
</xml>*/
        $postObj = simplexml_load_string( $postArr );
        //$postObj->ToUserName = '';
        //$postObj->FromUserName = '';
        //$postObj->CreateTime = '';
        //$postObj->MsgType = '';
        //$postObj->Event = '';
        //判断该数据包是否是订阅的事件推送
        if( strtolower( $postObj->MsgType) == 'event'){
            //如果是关注 subscribe 事件
            if( strtolower($postObj->Event == 'subscribe') ){
                //回复用户消息(纯文本格式)
                $toUser   = $postObj->FromUserName;
                $fromUser = $postObj->ToUserName;
                $time     = time();
                $msgType  =  'text';
                $content  = '欢迎关注第四工作室，我是TheMouthFace，以后请多指教！！您可以回复地名以获取今天的天气信息，例如回复“长沙”';
                $template = "<xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Content><![CDATA[%s]]></Content>
                                </xml>";
                $info     = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
                echo $info;
                /*<xml>
                <ToUserName><![CDATA[toUser]]></ToUserName>
                <FromUserName><![CDATA[fromUser]]></FromUserName>
                <CreateTime>12345678</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA[你好]]></Content>
                </xml>*/

/*<xml>  <ToUserName>< ![CDATA[toUser] ]></ToUserName> 
        <FromUserName>< ![CDATA[fromUser] ]></FromUserName> 
        <CreateTime>1348831860</CreateTime> 
        <MsgType>< ![CDATA[text] ]></MsgType> 
        <Content>< ![CDATA[this is a test] ]></Content> 
        <MsgId>1234567890123456</MsgId>  </xml>
            */
}
		 }else{
            header("Content-Type:text/html;charset=utf-8");
		$url0 = "https://cdn.huyahaha.com/tianqiapi/city.json";
		$ch0 = curl_init();
       	curl_setopt($ch0, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch0, CURLOPT_URL,$url0);
        $res0 = curl_exec($ch0);
        $arr0 = json_decode($res0,true);
		$flag = 0;
        for($i=0;$i<3181;$i++)
        {
        	if($postObj->Content == $arr0[$i]['cityZh'])
                $flag = 1;
        
        }
            if($flag == 1)			{
         
                                                                               header("Content-Type:text/html;charset=utf-8");
                                                                               $url = "https://www.tianqiapi.com/api/?version=v1&city=".urlencode($postObj->Content);
                                                                                    $ch = curl_init();
                                                                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                                                    curl_setopt($ch, CURLOPT_URL,$url);
                                                                                    $res = curl_exec($ch);
                                                                                    $arr = json_decode($res,true);


                                                                                    $toUser   = $postObj->FromUserName;
                                                                                    $fromUser = $postObj->ToUserName;
                                                                                    $time     = time();
                                                                                    $msgType  =  'text';
                                                                                    $content = '【'.$postObj->Content.'】'.$arr['data']['0']['date'].$arr['data']['0']['week'].'的天气情况如下：'."\n".'【天气状况】：'.$arr['data']['0']['wea'].
                                                                                                "\n".'【空气指数】：'.$arr['data']['0']['air'].
                                                                                                "\n".'【空气质量】：'.$arr['data']['0']['air_level'].
                                                                                                "\n".'【温度区间】：'.$arr['data']['0']['tem2'].'～'.$arr['data']['0']['tem1'].
                                                                                                "\n".'【当前温度】：'.$arr['data']['0']['tem'].
                                                                                                "\n".'【风向】：'.$arr['data']['0']['win']['0'].'  【大小】：'.$arr['data']['0']['win_speed'].
                                                                                                "\n".'【空气污染扩散指数】：'.$arr['data']['0']['index']['5']['level'].
                                                                                                "\n".$arr['data']['0']['index']['5']['desc'].
                                                                                                "\n".'【紫外线等级】：'.$arr['data']['0']['index']['0']['level'].
                                                                                                "\n".'【建议】：'.$arr['data']['0']['index']['0']['desc'].
                                                                                                "\n".'【穿衣建议】：'.$arr['data']['0']['index']['3']['desc'].
                                                                                                "\n".'【外出建议】：'.$arr['data']['0']['air_tips'].
                                                                                                "\n".'【锻炼建议】：'.$arr['data']['0']['index']['1']['desc'].
                                                                                                "\n".'--------------------'."\n".
                                                                                                "\n".'【'.$arr['data']['1']['day'].'天气情况】：'.
                                                                                                "\n".'【天气状况】：'.$arr['data']['1']['wea'].
                                                                                                "\n".'【温度区间】：'.$arr['data']['1']['tem2'].'～'.$arr['data']['1']['tem1'].
                                                                                                "\n".'【风向】：'.$arr['data']['1']['win']['0'].'  【大小】：'.$arr['data']['1']['win_speed'].
                                                                                                "\n".'--------------------'."\n".
                                                                                                "\n".'【'.$arr['data']['2']['day'].'天气情况】：'.
                                                                                                "\n".'【天气状况】：'.$arr['data']['2']['wea'].
                                                                                                "\n".'【温度区间】：'.$arr['data']['2']['tem2'].'～'.$arr['data']['2']['tem1'].
                                                                                                "\n".'【风向】：'.$arr['data']['2']['win']['0'].'  【大小】：'.$arr['data']['2']['win_speed'].
                                                                                                "\n".'--------------------'."\n".
                                                                                                "\n".'您还可以输入其他地区地名来查询天气！';
                                                                                            $template = "<xml>
                                                                                                            <ToUserName><![CDATA[%s]]></ToUserName>
                                                                                                            <FromUserName><![CDATA[%s]]></FromUserName>
                                                                                                            <CreateTime>%s</CreateTime>
                                                                                                            <MsgType><![CDATA[%s]]></MsgType>
                                                                                                            <Content><![CDATA[%s]]></Content>
                                                                                                            </xml>";
                                                                                            $info     = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
                                                                                            echo $info;
          							  }else{		
                
                                                                                            $toUser   = $postObj->FromUserName;
                                                                                            $fromUser = $postObj->ToUserName;
                                                                                            $time     = time();
                                                                                            $msgType  =  'text';
                																			$content  = '对不起，暂时查询不到本地区的天气，不过您还是可以输入其他地区的地名来查询天气信息！' ;
              																				$template = "<xml>
                                                                                                            <ToUserName><![CDATA[%s]]></ToUserName>
                                                                                                            <FromUserName><![CDATA[%s]]></FromUserName>
                                                                                                            <CreateTime>%s</CreateTime>
                                                                                                            <MsgType><![CDATA[%s]]></MsgType>
                                                                                                            <Content><![CDATA[%s]]></Content>
                                                                                                            </xml>";
                                                                                            $info     = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
                                                                                            echo $info;
                
        }
  		 

    }
}