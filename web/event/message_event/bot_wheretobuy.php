 
<?php
   	$MultiMessageBuilder = new LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
    
    $textMessage = emoji('10002D')." 產品購買請參考下列網址。\r\n https://www.pawbo.com/tw/where-to-buy/";
  	$MultiMessageBuilder->add(new LINE\LINEBot\MessageBuilder\TextMessageBuilder($textMessage));
  
    $response =  $bot->replyMessage($reply_token, $MultiMessageBuilder);



