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
		    if(!in_array($tmpdomain,$wgImgchvmdDomainName)){//first not in array then get the primary domain
    		    $tmpdomainarr = explode('.',$tmpdomain);
    		    $tmax = count($tmpdomainarr);
    		    if($tmax>1){
    		        $tmpdomain = $tmpdomainarr[$tmax-2].'.'.$tmpdomainarr[$tmax-1];
    		    }
    		}
    		if(in_array($tmpdomain,$wgImgchvmdDomainName) && strpos($tmpurl,'.md.')===false){//url in array
        		$tmp1 = substr($tmpurl,0,strrpos($tmpurl,'.'));
        		$tmp2 = substr($tmpurl,strrpos($tmpurl,'.'));
        		$mdurl = 'https://'.$tmp1.'.md'.$tmp2;
        		echo $mdurl.'<br>';
        		/*curl the md link to sure it exist*/
        	    $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL,$mdurl);
                curl_setopt($ch,CURLOPT_HEADER,1);
                curl_setopt($ch,CURLOPT_NOBODY,1);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
                curl_setopt($ch,CURLOPT_TIMEOUT,10);
                curl_exec($ch);
                $httpcode = curl_getinfo($ch,CURLINFO_HTTP_CODE); 
                curl_close($ch);
                if($httpcode == 200){//if 200, replace url
                    $tmpimgtag = preg_replace('/src="(.*?)"/', 'src="'.$mdurl.'"', $tmpimgarr[$i]);
        		    $text = str_replace($tmpimgarr[$i],$tmpimgtag, $text);
                }
    		}
        }
        $parserOutput->setText($text);
        return true;
    }
}
