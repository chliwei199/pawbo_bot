<?php
        use App\event\message_event\ImagemapHandler;
        use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
        use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
        use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
        use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
        use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
        
        $MultiMessageBuilder = new MultiMessageBuilder();
        $UtilityHandler= new App\event\UtilityHandler;				//create UtilityHandler object
        $jsonString=$UtilityHandler->getJsonString();				//get json string from description
    
         $pattern_angle = '/\{\\"FAQ_ANSWER=(.*?)\\"\}/'; // remain {"..."}
         preg_match_all($pattern_angle, $getText, $matches_getText);
         $matches_getText_split=explode(":", $matches_getText[1][0]);
        if(intval($matches_getText_split[1])>=count($jsonString['A'.$matches_getText_split[0]])){  //user write error number
                $imagemap= new ImagemapHandler;				//create imagemap object
                $ImageMessageBuilder=$imagemap->createImagemap();
                $redis->updateUserStatus($user_id,'');
                $MultiMessageBuilder->add(new TextMessageBuilder('輸入號碼錯誤!!'));
                $MultiMessageBuilder->add($ImageMessageBuilder);    
              
        }else{
                $jsonString_split=explode("#", $jsonString['A'.$matches_getText_split[0]][intval($matches_getText_split[1])]);
                //$faq_answer =$jsonString['A'.$matches_getText_split[0]][intval($matches_getText_split[1])];
                if(count($jsonString_split)<2){
                   $MultiMessageBuilder->add( new TextMessageBuilder( $jsonString_split[0])); //if the description do not have keyword'#', it shows all words
                }else{
                   $MultiMessageBuilder->add( new TextMessageBuilder($jsonString_split[0])); 
                   foreach($jsonString_split as $key=>$jsonString_split_obj){
                           if($key>0){ 
                                $MultiMessageBuilder->add($UtilityHandler->tag_translate_picture($jsonString_split_obj));
                           }
                   }	
                }
                $actions = array(
                        new PostbackTemplateActionBuilder("繼續看", "map_key=Y"),
                        new PostbackTemplateActionBuilder("回常見問題","map_key=N")
                );
                $button = new ConfirmTemplateBuilder(emoji('1F4CC'), $actions);
                $msg2 = new TemplateMessageBuilder(emoji('1F50D')."這訊息要在手機上才能看唷", $button);
                $MultiMessageBuilder->add($msg2);		
        }
                $response =  $bot->replyMessage($reply_token, $MultiMessageBuilder);