$( function () {
    $(document).ready(function(){
    	$(".showoimg").on('click',function(){
    	    //alert($(this).attr("data-src"));
    	    let tmpw = $(window).width();
    	    let tmph = $(window).height();
    	    if(tmpw/3*2 > tmph) tmpw=tmph/2*3;//imgage 3:2;
    	    let tmptxt1='<div id="showoimgshade" style="z-index:999998;background-color:rgba(0,0,0,0.8);width:100%;height:100%;top:0;left:0;position:fixed;"></div>';
    	    let tmptxt2='<div id="showoimgdiv" style="z-index:999999;background-color:rgb(233,233,233);width:'+tmpw+'px;height:'+tmpw/3*2+'px;top:50%;left:50%;position:fixed;transform:translate(-50%,-50%);-webkit-transform:translate(-50%,-50%);-moz-transform:translate(-50%,-50%);">';
    	    let tmptxt3='<img style="width:98%;position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);-webkit-transform:translate(-50%,-50%);-moz-transform:translate(-50%,-50%);" src="'+$(this).attr("data-src")+'"/>';
    	    let tmptxt4='<button type="button" class="mw-ui-button mw-ui-progressive" id="showoimgclose" style="position:fixed;top:0;right:0;box-shadow: 1px 1px 3px black;">x</button></div>';
    	    $("body").append(tmptxt1+tmptxt2+tmptxt3+tmptxt4);
    	    $("#showoimgclose").on("click",function(){
                $("#showoimgshade").remove();
                $("#showoimgdiv").remove();
            });
            $("#showoimgshade").on("click",function(){
                $("#showoimgshade").remove();
                $("#showoimgdiv").remove();
            });
            //$("img").on("contextmenu",function(){return false;});
    	});
    });
});