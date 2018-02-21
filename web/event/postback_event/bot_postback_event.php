<?php
		use LINE\LINEBot\MessageBuilder\TextMessageBuilder as TextMessageBuilder;
			/*
			post event
			*/
			$UtilityHandler= new App\event\UtilityHandler;				//create UtilityHandler object
			$jsonString=$UtilityHandler->getJsonString();				//get json string from description
			$getText = $event->getPostbackData();
			
			if ($getText) {
				parse_str($getText, $data);
				if (isset($data["map_key"])) {
					
					$page = $data["map_key"];

					switch ($page) {
						case 'Y':
							$bot->pushMessage($user_id, new TextMessageBuilder($jsonString['bot_postback_event_continue_search'])); //message push
							$getText="{\"FAQ:".$redis->checkStatus($user_id)."\"}";
							include('event/message_event/bot_faq_ask.php');
						break;
						case 'N':
							$bot->pushMessage($user_id, new TextMessageBuilder($jsonString['bot_postback_event_pawbo_service'])); //message push
							include('event/message_event/bot_menu_faq.php');
						break;				
					}
				}					
			}
?>			