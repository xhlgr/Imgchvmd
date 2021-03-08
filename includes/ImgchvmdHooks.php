<?php
/**
 * ImgchvmdHooks
 */

class ImgchvmdHooks {
	public static function onOutputPageParserOutput( $out,  $parserOutput ){
	    $action = $out->parserOptions()->getUser()->getRequest()->getVal("action");
		if (($action == 'edit') || ($action == 'submit') || ($action == 'history')) return true;
	    global $wgImgchvmdDomainName;
        $text = $parserOutput->getText();
        preg_match_all('/<img[^>]+\>/i',$text,$matcharr);
        $tmpimgarr = $matcharr[0];//imgtag
        for($i=0;$i<count($tmpimgarr);$i++){
            if(preg_match('/src="(.*?)"/',$tmpimgarr[$i],$matches)===false || strpos($tmpimgarr[$i],'.jpg')===false) continue;//only for .jpg
            $fullurl = $matches[1];
            $tmpurl = preg_replace('/^(http|https)&#58;\/\//', '', $fullurl);//without https://
            $tmpdomain = substr($tmpurl,0,strpos($tmpurl,'/'));
            if(in_array($tmpdomain,$wgImgchvmdDomainName) && strpos($tmpurl,'.md.')===false){
        		$tmp1 = substr($tmpurl,0,strrpos($tmpurl,'.'));
        		$tmp2 = substr($tmpurl,strrpos($tmpurl,'.'));
        		$tmpimgtag = preg_replace('/src="(.*?)"/', 'src="https://'.$tmp1.'.md'.$tmp2.'"', $tmpimgarr[$i]);
        		$text = str_replace($tmpimgarr[$i],$tmpimgtag, $text);
		    }
        }
        $parserOutput->setText($text);
        return true;
    }
}
