 
<?php
   	$MultiMessageBuilder = new LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
    
    $textMessage = emoji('1F431')."  最新產品重要訊息請至網址。\r\n https://www.pawbo.com/tw/";
  	$MultiMessageBuilder->add(new LINE\LINEBot\MessageBuilder\TextMessageBuilder($textMessage));
     
    $response =  $bot->replyMessage($reply_token, $MultiMessageBuilder);



