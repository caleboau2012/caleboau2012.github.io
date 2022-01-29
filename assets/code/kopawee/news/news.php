<?php
$sources = array("http://www.punchng.com/feed/", "http://www.vanguardngr.com/feed/", "http://www.topix.net/rss/world/nigeria", "http://sunnewsonline.com/new/?feed=rss2", "http://thenationonlineng.net/new/feed/");

//for($j=0; $j<=4; $j++) {
//  parser($sources[$j]);
//}

parser("http://www.vanguardngr.com/feed/");

function parser($xml){
    $xmlDoc = new DOMDocument();
    $xmlDoc->load($xml);

    //get elements from "<channel>"
    $channel=$xmlDoc->getElementsByTagName('channel')->item(0);
    $channel_title = $channel->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;

    //output elements from "<channel>"
    //echo("<p>Channel Title:" . $channel_title . "</p>");

    //get and output "<item>" elements
    $x=$xmlDoc->getElementsByTagName('item');
    for ($i=0; $i<=9; $i++) {
        $item_title=$x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
        $item_link=$x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
        $item_desc=$x->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
        $item_content=$x->item($i)->getElementsByTagName('encoded');
        if($item_content->length != 0){
            $item_content=$x->item($i)->getElementsByTagName('encoded')->item(0)->childNodes->item(0)->nodeValue;
        }else{
            $item_content = " ";
        }
        $item_date=$x->item($i)->getElementsByTagName('pubDate')->item(0)->childNodes->item(0)->nodeValue;

        $news[$i]['title'] = strip_tags($item_title);
        $news[$i]['link'] = strip_tags($item_link);
        $news[$i]['desc'] = strip_tags($item_desc);
        $news[$i]['content'] = strip_tags($item_content);
        $news[$i]['date'] = strip_tags($item_date);
    }

    $json = array("response"=>"1", "data"=>$news);
    echo json_encode($json);

}

?>
