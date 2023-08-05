<?php
/**
 * ImgchvmdHooks
 */

class ImgchvmdHooks {
	public static function onOutputPageParserOutput( $out,  $parserOutput ){
		//$action = $out->getRequest()->getVal("action");//新版parserOptions()->getUser()弃用，直接getRequest()就行
		//注释后实测在submit编辑预览时不会加md，history查看历史时会加md，这样也合理就不加判断了
		//if (($action == 'edit') || ($action == 'submit') || ($action == 'history')) return true;
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
				
				$inputwidth = preg_match('/width="(.*?)"/',$tmpimgarr[$i],$matches) ? $matches[1]:'100%';
                $inputheight = preg_match('/height="(.*?)"/',$tmpimgarr[$i],$matches) ? $matches[1]:'auto';
				
				$tmpimgtag = preg_replace('/src="(.*?)"/', 'src="'.$mdurl.'"', $tmpimgarr[$i]);
				//中等图片不存在会重定向到404图片，其尺寸为240x180，此时替换为原链接并删除按钮元素，由js前端判断。另有404情况进入onerror
				$tmpimgtag = str_replace('>',' onerror="this.src=\''.$fullurl.'\';this.nextElementSibling.remove();" onload="javascript:if(this.naturalWidth==240 && this.naturalHeight==180){this.src=\''.$fullurl.'\';this.nextElementSibling.remove();}">',$tmpimgtag);
				
				$tmpdiv =  '<div class="mdimgdiv" style="position:relative;width:'.$inputwidth.';height:'.$inputheight.';">'.$tmpimgtag.'<button class="showoimg mw-ui-button mw-ui-progressive" data-src="'.$fullurl.'" style="position:absolute;top:0;right:0;box-shadow: 1px 1px 3px black;" type="button">'.wfMessage("imgchvmd-button-showoimg")->text().'</button></div>';
				
				$text = str_replace($tmpimgarr[$i],$tmpdiv, $text);
			}
		}
		$parserOutput->setText($text);
		return true;
	}
	
	public static function onBeforePageDisplay($out, $skin) {
        $out->addModules( 'ext.imgchvmd' );
        return true;
    }
}
