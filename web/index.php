<?php 
require_once '../vendor/autoload.php';
use Google\Cloud\Language\LanguageClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;


	if (file_exists(__DIR__.'/.env')){
		$dotenv = new Dotenv\Dotenv(__DIR__);	
		$dotenv->load();
	}
  
 	$bot = new LINE\LINEBot(
  		new LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('curlHTTPClient')),
  		['channelSecret' => getenv('channelSecret')]
	);
 
	$signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
	$body = file_get_contents("php://input");
//	$redis= new App\event\RedisHandler;				//create RedisHandler object

	//error_log("Signature: ".$signature);

    $events = $bot->parseEventRequest($body, $signature);
	
    foreach ($events as $event){
	
		$reply_token = $event->getReplyToken();

		//follow event 
        if ($event instanceof \LINE\LINEBot\Event\FollowEvent) { 

			include('event/follow_event/bot_follow_event.php');

		}
		
		//follow event 
        if ($event instanceof \LINE\LINEBot\Event\UnfollowEvent) { 
			include('event/follow_event/bot_unfollow_event.php');
		}

		
		//join group event
        if ($event instanceof \LINE\LINEBot\Event\JoinEvent) { 
			include('event/join_event/bot_join_event.php');			
         }
 
		//text event 
        if ($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage) {
			$entity_names='';
			$getText = $event->getText();
			
//call pawbo soap API		
			//$soap = new SoapClient("https://www.pawbo.com/tw/api/v2_soap?wsdl");
			//$sessionID = $soap->__soapCall("login",array('username'=>'wade.chao','apiKey'=>'Pawbo1234'));
			
			//$result = $soap->__soapCall("resources",array('sessionId'=>$sessionID));

//下面是介接 語意分析和APIAI的CODE
			// $NLP_json=[
			// 	"type"=> 'service_account',
			// 	"project_id"=> getenv('project_id'),
			// 	"private_key_id"=> getenv('private_key_id'),
			// 	"private_key"=> str_replace('|', "\n",getenv('private_key')),
			// 	"client_email"=> getenv('client_email'),
			// 	"client_id"=> getenv('client_id'),	
			// 	"auth_uri"=> getenv('auth_uri'),
			// 	"token_uri"=> getenv('token_uri'),
			// 	"auth_provider_x509_cert_url"=> getenv('auth_provider_x509_cert_url'),
			// 	"client_x509_cert_url"=> getenv('client_x509_cert_url'),
			// ];
     		// $language = new LanguageClient([
			// 	'projectId' => 'naturallanguageprocess-191606',
			// 	'type'=>'PLAIN_TEXT',
			// 	'keyFile' => $NLP_json
				
			// ]);
			
			// $annotation = $language->analyzeEntities($getText);

			// foreach ($annotation->entities() as $entity) {
			// 	//echo $entity['type'];
			// 	$entity_names=trim($entity_names).$entity['name'];
			// }

			// $result= find_synonym(urlencode($entity_names));
			

			// if(strpos( $result, '_') !== false){
			// 	include('event/message_event/bot_ask.php');
			// }else{
			// 	include('event/message_event/no_event.php');
			// }

			$result= find_synonym(urlencode($getText));
			if($result===''){
				include('event/message_event/no_event.php');
			}
			$textMessage = new TextMessageBuilder($result);
			$response =  $bot->replyMessage($reply_token, $textMessage);
        }

		//location event 		
		if ($event instanceof \LINE\LINEBot\Event\MessageEvent\LocationMessage) {
			include('event/location_event/bot_location_event.php');
		}
		
		if ($event instanceof \LINE\LINEBot\Event\PostbackEvent) {
			include('event/postback_event/bot_postback_event.php');			
		}
		
		if ($event instanceof \LINE\LINEBot\Event\MessageEvent\ImageMessage) {
			$contentId = $event->getMessageId();
			$audio = $bot->getMessageContent($contentId)->getRawBody();
		}

	 if ($event instanceof \LINE\LINEBot\Event\MessageEvent\AudioMessage) {
			
			 
		} 	
    }

	//emoji unicode
	function emoji($ID){
 		$bin = hex2bin(str_repeat('0', 8 - strlen($ID)) . $ID);
		$emoticon =  mb_convert_encoding($bin, 'UTF-8', 'UTF-32BE');
		return $emoticon;
	}
	//Dialogflow find synonym
	function find_synonym($getText){
		$ch = curl_init();
		// set url
		curl_setopt($ch, CURLOPT_URL, "https://api.dialogflow.com/v1/query?v=20170712&query='$getText'&lang=en&sessionId=" .trim(getenv('sessionID')));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer '.trim(getenv('CLIENT_ACCESS_TOKEN'))));
		//return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// $output contains the output string
		$output = curl_exec($ch);
		// close curl resource to free up system resources
		curl_close($ch);
	  return  json_decode($output)->result->fulfillment->speech;
   }
 ?>