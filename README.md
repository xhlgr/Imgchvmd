# Imgchvmd
## 插件说明
* Imgchvmd是为Mediawiki开发的一个插件。它只是实现功能，慎重用于正式环境。由于作者代码只懂皮毛，php代码并不科学，欢迎优化。
* 在Chevereto的图床程序中，jpg格式可以将外链由原图.jpg改为中等图片.md.jpg，本插件利用此特性使得加载图片大小变小，提升加载体验。 
* 使用钩子[OutputPageParserOutput](https://www.mediawiki.org/wiki/Manual:Hooks/OutputPageParserOutput)将解析出来的html，在输出前对有设定链接的img标签中加入`.md`再显示。
* 文件写法参考：[HeaderFooter插件](https://github.com/enterprisemediawiki/HeaderFooter/blob/master/HeaderFooter.class.php)
* 目前尚不明确有无插件冲突或其他问题，每次页面加载都要复杂替换操作可能加重服务器负担。
## 使用方法
* 下载放在extensions/文件夹内；
* 在LocalSettings.php加入`wfLoadExtension( 'Imgchvmd' );`；
* 设置参数`$wgImgchvmdDomainName=["域名"];`（填写主域名（其子域名均进行操作）或子域名，如xxx.com或a.xxx.com，任何Chevereto程序的图床网站外链均可，需要中等图片链接只是在文件扩展名前面加“.md”的才行）；
* 完成。
## 更新日志
* 20210428：对$wgImgchvDomainName增加主域名判断，无需逐一设置子域名；php curl判断中等图片链接是否存在（可能耗费服务器资源，因为当图片小于chevereto设置的中等图片宽度或高度时，不会生成中等图片。尝试img标签使用onerror让前端处理没有作用，故此下策），增加判断后可以将判断.jpg的代码去掉即判断所有扩展名的文件是否存在md中等图片并加载。
