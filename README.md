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
* 设置参数`$wgImgchvmdDomainName=["子域名"];`（需要填写完整子域名，如a.xxx.com，需要填写完整子域名，任何Chevereto程序的图床网站外链均可）；
* 完成。
