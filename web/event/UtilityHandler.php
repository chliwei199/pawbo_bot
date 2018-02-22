<?php
namespace App\event;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
class UtilityHandler {

	public static function toBoolean($value) {
	 	if ($value === null || $value == '')
	 		return false;
	 	return ($value == 0) ? false : true;
	 }
	 public function getJsonString() {
		$stream = fopen('description.json', 'r');
		$listener = new \JsonStreamingParser\Listener\InMemoryListener();
		try {
 			 $parser = new \JsonStreamingParser\Parser($stream, $listener);
  			 $parser->parse();
  			fclose($stream);
			} catch (Exception $e) {
 		 	fclose($stream);
  			throw $e;
		}
		return $listener->getJson();
	}
	public function tag_translate_picture($ori_string){
		$pattern_square = "/\{{(.*)\s\w+='(.*)'\}}/"; // deal with{{...}}
		// Tag content_og_tag																
		preg_match_all($pattern_square, $ori_string, $matches);
		$baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').$matches[2][0].'.png?_ignore=';	
	   return new ImageMessageBuilder($baseUrl,$baseUrl);
	}

	public function emoji($ID){
		$bin = hex2bin(str_repeat('0', 8 - strlen($ID)) . $ID);
	   $emoticon =  mb_convert_encoding($bin, 'UTF-8', 'UTF-32BE');
	   return $emoticon;
	}
	public function tag_translate($ori_string){
		$pattern_angle = "/\{{(.*?)\}}/"; // remain{{}}
		$pattern_square = "/\{{(.*)\s\w+='(.*)'\}}/"; // deal with{{...}}
													  // Tag content_og_tag																
		// Tag content
		preg_match_all($pattern_angle, $ori_string, $matches_angle);
		foreach ($matches_angle[0] as $angle) {
			preg_match_all($pattern_square, $angle, $matches);
			if (isset($matches[0][0])) {
				$be_replaced[] = $matches[0][0]; // save string be replace
				$replacement[] = $this->{$matches[1][0]}($matches[2][0]); // save replace string
			}
		}
		if (isset($be_replaced) && isset($replacement))
		$Text = str_replace($be_replaced, $replacement, trim($ori_string));
	   return $Text;
	}
	public function displayMoreItems($category,$quotient){
		$list =json_decode( file_get_contents('https://spreadsheets.google.com/feeds/list/1ZLpkq1oidCON-9cuBA1x-J-vS_G2R4VA2JZo4bMq2_I/1/public/values?alt=json'));
   
		foreach($list->feed->entry as $entry){
			$codemap[$entry->{'gsx$category'}->{'$t'}] = $entry->{'gsx$id'}->{'$t'}; //get categoty->id
		}
	
		$Text=$codemap[$category];

			$MultiMessageBuilder = new MultiMessageBuilder();
			$results =json_decode( file_get_contents('https://spreadsheets.google.com/feeds/list/1ZLpkq1oidCON-9cuBA1x-J-vS_G2R4VA2JZo4bMq2_I/'.$Text.'/public/values?alt=json'));
		
			foreach($results->feed->entry as $key =>$entry){
				if( $key >= ($quotient-1)*constant("_data_maxsize") && $key < $quotient*constant("_data_maxsize") ){  //between n-1 <= X < n

					$share =emoji('100005')."BLAH BLAH BLAH 居酒屋的"					
					."⌜".$hotsale.$entry->{'gsx$name'}->{'$t'}."⌟，真的是超讚的，而且老闆人又很NICE，趕快過來試試看吧。\r\n\r\n"								
					.emoji('2728')."地點資訊：https://www.google.com.tw/maps/place/BLAH+BLAH+BLAH+居酒屋+106\r\n";
		
		
					//$actions =array( new MessageTemplateActionBuilder(emoji('1F44D').' 給菜一個讚'," "));
					$actions =array( new UriTemplateActionBuilder(emoji('1F46B').' 推菜給好友',"line://msg/text/?".urlencode($share)));
					$baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').$entry->{'gsx$pictureurl'}->{'$t'}.'?_ignore=';
					$hotsale=$entry->{'gsx$hotsale'}->{'$t'}==='B'?emoji('1F496').' ':'';
					$column = new CarouselColumnTemplateBuilder($hotsale.$entry->{'gsx$name'}->{'$t'},emoji('1F4B5')." ".$entry->{'gsx$price'}->{'$t'},$baseUrl,$actions);
					$columns[] = $column;
				}
			}
			$carousel = new CarouselTemplateBuilder($columns);
			$msg = new TemplateMessageBuilder(emoji('1F50D')."這訊息要在手機上才能看唷", $carousel);
			$MultiMessageBuilder->add($msg);

			$actions = array(
					new PostbackTemplateActionBuilder("回列表", "map_key=Y"),
					new PostbackTemplateActionBuilder(" ", " ")
			);
		
			$button = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder(emoji('1F4CC')." 訊息", $actions);
			$msg2 = new TemplateMessageBuilder(emoji('1F50D')."這訊息要在手機上才能看唷", $button);					
			$MultiMessageBuilder->add($msg2);
	   return $MultiMessageBuilder;
	}

}
