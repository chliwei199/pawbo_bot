 
<?php
 
 use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
 use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
 use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
 use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
 use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
 use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
 use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;

 $MultiMessageBuilder = new MultiMessageBuilder();
 
 $product1='https://www.pawbo.com/tw/pawbo-bundle.html/';
 $product2='https://www.pawbo.com/tw/flash-combo-bundle.html/';
 $product3='https://www.pawbo.com/tw/pawbo-munch-bundle.html/';
 $product4='https://www.pawbo.com/tw/munch-flash-combo.html/';
 $product5='https://www.pawbo.com/tw/flash-teaser-combo.html/';
 $product6='https://www.pawbo.com/tw/herz-treat-group.html/';
 $product7='https://www.pawbo.com/tw/ipuppygo.html/';
 $product8='https://www.pawbo.com/tw/teaser-combo.html/';
 $product9='https://www.pawbo.com/tw/pawbo-flash.html/';
 $product10='https://www.pawbo.com/tw/teaser-supplement.html/';
 //tutor
 
 //product1
 $baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').'pawbo_bundle.png?_ignore=';			
 $actions = array(new UriTemplateActionBuilder(emoji('1F449')." 商品連結",$product1));
 $column = new CarouselColumnTemplateBuilder('產品資訊','Pawbo⁺ 寵物互動攝影機',$baseUrl, $actions);
 $columns[] = $column;

  //product2
$baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').'flash_combo_bundle.png?_ignore=';			
$actions = array(new UriTemplateActionBuilder(emoji('1F449')." 商品連結",$product2));
$column = new CarouselColumnTemplateBuilder('產品資訊','寵物互動攝影機 貓耳閃亮組',$baseUrl, $actions);
$columns[] = $column;

  //product3
  $baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').'pawbo_munch_bundle.png?_ignore=';			
  $actions = array(new UriTemplateActionBuilder(emoji('1F449')." 商品連結",$product3));
  $column = new CarouselColumnTemplateBuilder('產品資訊','Munch 遊戲點心機',$baseUrl, $actions);
  $columns[] = $column;

    //product4
	$baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').'munch-flash-combo.png?_ignore=';			
	$actions = array(new UriTemplateActionBuilder(emoji('1F449')." 商品連結",$product4));
	$column = new CarouselColumnTemplateBuilder('產品資訊','寵物互動攝影機 + 遊戲點心機',$baseUrl, $actions);
	$columns[] = $column;

	//product5
	$baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').'flash-teaser-combo.png?_ignore=';			
	$actions = array(new UriTemplateActionBuilder(emoji('1F449')." 商品連結",$product5));
	$column = new CarouselColumnTemplateBuilder('產品資訊','貓咪派對組',$baseUrl, $actions);
	$columns[] = $column;

	//product6
	$baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').'herz_treat_group.png?_ignore=';			
	$actions = array(new UriTemplateActionBuilder(emoji('1F449')." 商品連結",$product6));
	$column = new CarouselColumnTemplateBuilder('產品資訊','Herz赫緻 低溫烘焙健康糧',$baseUrl, $actions);
	$columns[] = $column;		

	//product7
	$baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').'ipuppygo.png?_ignore=';			
	$actions = array(new UriTemplateActionBuilder(emoji('1F449')." 商品連結",$product7));
	$column = new CarouselColumnTemplateBuilder('產品資訊','iPuppyGo智慧釦',$baseUrl, $actions);
	$columns[] = $column;			

	//product8
	$baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').'teaser-combo.png?_ignore=';			
	$actions = array(new UriTemplateActionBuilder(emoji('1F449')." 商品連結",$product8));
	$column = new CarouselColumnTemplateBuilder('產品資訊','寵物轉轉樂 Party組',$baseUrl, $actions);
	$columns[] = $column;	

	//product9
	$baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').'pawbo-flash.png?_ignore=';			
	$actions = array(new UriTemplateActionBuilder(emoji('1F449')." 商品連結",$product9));
	$column = new CarouselColumnTemplateBuilder('產品資訊','貓耳智慧燈',$baseUrl, $actions);
	$columns[] = $column;	
	
	//product10
	$baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').'teaser-supplement.png?_ignore=';			
	$actions = array(new UriTemplateActionBuilder(emoji('1F449')." 商品連結",$product10));
	$column = new CarouselColumnTemplateBuilder('產品資訊','寵物轉轉樂 替換包 (3入組)',$baseUrl, $actions);
	$columns[] = $column;		


 $carousel = new CarouselTemplateBuilder($columns);
 $TemplateMessageBuilder = new TemplateMessageBuilder(emoji('1F50D')."這訊息要在手機上才能看唷", $carousel);
 $bot->replyMessage($reply_token,$TemplateMessageBuilder);	
 
 
?>
 