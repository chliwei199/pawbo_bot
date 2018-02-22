<?php
namespace App\event\message_event;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
class ImagemapHandler {

	public function createImagemap() {
        $columns = array();
        $baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').'menu_pawboV2.png?_ignore=';
        $altText="FAQ清單";
        
        $baseSizeBuilder = new BaseSizeBuilder(800,1040);
        $areaBuilder1_1 = new AreaBuilder(37,191,211,115); 	
        $areaBuilder1_2 = new AreaBuilder(289,191,211,115); 	
        $areaBuilder1_3 = new AreaBuilder(533,191,211,115); 
        $areaBuilder1_4 = new AreaBuilder(783,191,211,115); 
        $areaBuilder2_1 = new AreaBuilder(37,349,211,115); 	
        $areaBuilder2_2 = new AreaBuilder(289,349,211,115); 	
        $areaBuilder2_3 = new AreaBuilder(533,349,211,115); 
        $areaBuilder2_4 = new AreaBuilder(783,349,211,115); 	       	 
        $areaBuilder3_1 = new AreaBuilder(37,508,211,115); 	
        $areaBuilder3_2 = new AreaBuilder(289,508,211,115); 	
        $areaBuilder3_3 = new AreaBuilder(533,508,211,115); 
        $areaBuilder3_4 = new AreaBuilder(783,508,211,115); 
        $areaBuilder4_1 = new AreaBuilder(37,667,211,115); 	
        $areaBuilder4_2 = new AreaBuilder(289,667,211,115); 	
        

        $type_1_1="{\"FAQ:購買篇\"}";
        $type_1_2="{\"FAQ:購買前篇\"}";
        $type_1_3="{\"FAQ:安裝篇\"}";
        $type_1_4="{\"FAQ:串流影像篇\"}";
        $type_2_1="{\"FAQ:餵點心篇\"}";
        $type_2_2="{\"FAQ:呼叫鈴聲篇\"}";
        $type_2_3="{\"FAQ:設備密碼篇\"}";
        $type_2_4="{\"FAQ:錄影篇\"}";
        $type_3_1="{\"FAQ:拍照分享篇\"}";
        $type_3_2="{\"FAQ:光點遊戲篇\"}";
        $type_3_3="{\"FAQ:海外使用篇\"}";
        $type_3_4="{\"FAQ:裝置篇\"}";
        $type_4_1="{\"FAQ:iPuppyGo篇\"}";
        $type_4_2="{\"FAQ:其他篇\"}";

        $columns[] = new ImagemapMessageActionBuilder($type_1_1,$areaBuilder1_1);
        $columns[] = new ImagemapMessageActionBuilder($type_1_2,$areaBuilder1_2);
        $columns[] = new ImagemapMessageActionBuilder($type_1_3,$areaBuilder1_3);
        $columns[] = new ImagemapMessageActionBuilder($type_1_4,$areaBuilder1_4);
        $columns[] = new ImagemapMessageActionBuilder($type_2_1,$areaBuilder2_1);
        $columns[] = new ImagemapMessageActionBuilder($type_2_2,$areaBuilder2_2);
        $columns[] = new ImagemapMessageActionBuilder($type_2_3,$areaBuilder2_3);
        $columns[] = new ImagemapMessageActionBuilder($type_2_4,$areaBuilder2_4);
        $columns[] = new ImagemapMessageActionBuilder($type_3_1,$areaBuilder3_1);
        $columns[] = new ImagemapMessageActionBuilder($type_3_2,$areaBuilder3_2);
        $columns[] = new ImagemapMessageActionBuilder($type_3_3,$areaBuilder3_3);
        $columns[] = new ImagemapMessageActionBuilder($type_3_4,$areaBuilder3_4);
        $columns[] = new ImagemapMessageActionBuilder($type_4_1,$areaBuilder4_1);
        $columns[] = new ImagemapMessageActionBuilder($type_4_2,$areaBuilder4_2);
        $ImageMessageBuilder = new ImagemapMessageBuilder($baseUrl,$altText,$baseSizeBuilder,$columns);  
	 	return $ImageMessageBuilder;
	 }
   
}
