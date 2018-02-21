<?php
        use App\event\message_event\ImagemapHandler;
        use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
        use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
        use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
        use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
        
        $imagemap= new ImagemapHandler;				//create imagemap object
        $ImageMessageBuilder=$imagemap->createImagemap();
        $redis->updateUserStatus($user_id,'');                              //clear user status
		$response =  $bot->replyMessage($reply_token, $ImageMessageBuilder);