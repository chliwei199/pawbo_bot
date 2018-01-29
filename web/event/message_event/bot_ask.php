<?php
        use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
        use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
        use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
        use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
        use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
        
        $MultiMessageBuilder = new MultiMessageBuilder();
        // $UtilityHandler= new App\event\UtilityHandler;				//create UtilityHandler object
        // $jsonString=$UtilityHandler->getJsonString();				//get json string from description
        // $text =$jsonString[$result];	

        $textMessageBuilder = new TextMessageBuilder("請問您的問題是:\r\n".$text);  
        $MultiMessageBuilder->add($textMessageBuilder);
        
        $actions = array(
            new PostbackTemplateActionBuilder("正確", "map_key=Y".'#'.$text),
            new PostbackTemplateActionBuilder("錯誤", "map_key=N")
          );
        $button = new ConfirmTemplateBuilder(emoji('1F4CC')." 確認問題？", $actions);
        $msg2 = new TemplateMessageBuilder(emoji('1F50D')."這訊息要在手機上才能看唷", $button);
                            
        $MultiMessageBuilder->add($msg2);

        $response =  $bot->replyMessage($reply_token, $MultiMessageBuilder);