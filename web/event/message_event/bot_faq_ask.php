<?php
        use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
        use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
        use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
        
        $MultiMessageBuilder = new MultiMessageBuilder();
        $UtilityHandler= new App\event\UtilityHandler;				//create UtilityHandler object
        $jsonString=$UtilityHandler->getJsonString();				//get json string from description

        $pattern_angle = "/\{\"(.*?)\"\}/"; // remain {"..."}
		preg_match_all($pattern_angle,str_replace(array('FAQ:'), '', $getText), $matches_getText);
        $texts =$jsonString['Q'.$matches_getText[1][0]];	

        $bot->pushMessage($user_id,  new TextMessageBuilder("請問您的".$matches_getText[1][0]."問題是:")); //message push	
        //$textMessageBuilder = new TextMessageBuilder("請問您的".$matches_getText[1][0]."問題是:");  
        //$MultiMessageBuilder->add($textMessageBuilder);
        foreach($texts as $key=>$text){
           // $textMessageBuilder = new TextMessageBuilder('Q'.($key+1).'.'.$text);  
            $bot->pushMessage($user_id, new TextMessageBuilder('Q'.($key+1).'.'.$text)); //message push
            //$MultiMessageBuilder->add($textMessageBuilder);
        }
        
        $redis->updateUserStatus($user_id,$matches_getText[1][0]);
	    $MultiMessageBuilder->add(new TextMessageBuilder( emoji('100077')."請輸入欲查詢FAQ號碼。"));
        $response =  $bot->replyMessage($reply_token, $MultiMessageBuilder);