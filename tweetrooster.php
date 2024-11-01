<?php
/*
Plugin Name: Tweet Rooster
Plugin URI: http://www.tweetrooster.com/
Description: Enables users to tweet directly from your blog with a simple button
Author: Go Global Gadget, LLC
Version: 1.0
Author URI: http://www.goglobalgadget.com/
*/
 
function tweetrooster_widget() {
    ?>
<li class="widget"><h4 class="widgettitle">Twitter</h4>
    <script>
    document.write("<style>");
document.write(".TR_Arrow {z-index:1000;}\n");
document.write(".TR_topArrow {	background-image: url('http://tweetrooster.com/images/top.gif');height:16px;width:31px;}\n");
document.write(".TR_rightArrow {	background-image: url('http://tweetrooster.com/images/right.gif');height:31px;width:16px;}\n");
document.write(".TR_bottomArrow {	background-image: url('http://tweetrooster.com/images/bottom.gif');height:16px;width:31px;}\n");
document.write(".TR_leftArrow {	background-image: url('http://tweetrooster.com/images/left.gif');height:31px;width:16px;}\n");
document.write(".TR_Box { background-color:white; border: 1px solid #a0a0a0;z-index:100 }\n");
document.write("</style>");

document.write("<img id='TR_button_1360597502' style=\"width:110px;height:16px;\" src='http://tweetrooster.com/images/button1.gif'></div>");
document.write("<div id='TR_arrow_1360597502' style='display:none;'></div>");
document.write("<div class='TR_Box' id='TR_box_1360597502' style='display:none; width:350px; height:200px;'><iframe id='R_iframe_1360597502' style='width:100%; height:100%; border:none;' frameborder='0' scrolling='no' allowtransparency='true'></iframe></div>");


var tweetrooster1360597502 = {
	button: false,
	div: false,
	iframe: false,
	arrow: false,
	isIE: false,
	init: function() {
		this.button = document.getElementById('TR_button_1360597502');
		this.div = document.getElementById('TR_box_1360597502');
		this.iframe = document.getElementById('R_iframe_1360597502');
		this.arrow = document.getElementById('TR_arrow_1360597502');
		this.button.onclick = function() {
			tweetrooster1360597502.onclick(this);
		};
		this.div.style.position = "absolute";
		this.div.style.zIndex = 100;
		this.arrow.style.position = "absolute";
		this.arrow.style.zIndex = 1000;
		this.isIE = (/MSIE (\d+\.\d+);/.test(navigator.userAgent));
		this.addOnResize(function() {
			tweetrooster1360597502.positionBox();
		});
		
		//Reset it for when the users uses the back button
		this.button.value = "Tweet about it!";
		this.div.style.display = "none";
		this.arrow.style.display = "none";
		
	},
	onclick: function(btn) {
		if(this.div.style.display == "none") { // to visible
			this.button.value = "Close";
		} else { // to hide
			this.button.value = "Tweet about it!";
		}
		this.positionBox();
		if(this.div.style.display == "none") { // to visible
			this.div.style.display = "block";
			this.arrow.style.display = "block";
		} else { // to hide
			this.div.style.display = "none";
			this.arrow.style.display = "none";
		}
	},
	positionBox: function() {
		var order = [1,3,2,0]; //right, bottom, left, top
		var obj = this.button;
		var l = 0, t = 0, r = 0, b = 0;
		
		do {
			l += obj.offsetLeft;
			t += obj.offsetTop;
		} while(obj = obj.offsetParent);
		
		r = l + this.button.offsetWidth;
		b = t + this.button.offsetHeight;
		
		pagesize = this.pageSize();
		var x = -1, y = -1, i = 0, good = false, override = false, arrowCss, arrow_x, arrow_y;
		do {
			arrowCss = 'TR_Arrow ';
			good = true;
			var type = order[i];
			if(type == 0) { // top
				x = (l + r)/2 - 350 / 2;
				y = t - 200 - 15;
				if(y < 0)
					good = false;
				if(x + 350 > pagesize[0] - 20)
					x = pagesize[0] - 350 - 20;
				else if(x < 2)
					x = 2;
				arrowCss += "TR_topArrow";
				arrow_x = (l + r)/2 - 30 / 2;
				arrow_y = t - 16;
			} else if(type == 1) { // right
				x = r + 15;
				y = (t + b) / 2 - 30 + 5;
				if(x + 350 > pagesize[0] - 20)
					good = false;
				if(y + 200 > pagesize[1] - 20)
					y = pagesize[1] - 200 - 20;
				if(y < 2)
					y = 2
				arrowCss += "TR_rightArrow";
				arrow_x = r;
				arrow_y = (t + b) / 2 - 16;
			} else if(type == 2) { // bottom
				x = (l + r)/2 - 350 / 2;
				y = b + 15;
				if(y > pagesize[1] - 20)
					good = false;
				if(x + 350 > pagesize[0] - 20)
					x = pagesize[0] - 350 - 20;
				else if(x < 2)
					x = 2;
				arrowCss += "TR_bottomArrow";
				arrow_x = (l + r)/2 - 30 / 2;
				arrow_y = b;
			} else if(type == 3) { // left
				x = l - 350 - 15 - 1;
				y = (t + b) / 2 - 30 + 5;
				if(x < 2)
					good = false;
				if(y + 200 > pagesize[1] - 20)
					y = pagesize[1] - 200 - 20;
				if(y < 2)
					y = 2
				arrowCss += "TR_leftArrow";
				arrow_x = l - 30 / 2;
				arrow_y = (t + b) / 2  - 16;
			}
		} while(++i < order.length && !good && !override);
		
		this.arrow.className = arrowCss;
		this.arrow.style.left = arrow_x + "px";
		this.arrow.style.top = arrow_y + "px";
		
		this.div.style.left = x + "px";
		this.div.style.top = y + "px";
		//alert("(" + l + " " + t + ")");
		//alert("(" + r + " " + b + ")");
		//alert("(" + x + " " + y + ")");
		if(this.iframe.src == '')
			this.iframe.src = "http://tweetrooster.com/?page=InnerHTML&url=" + 
			escape(document.location.href) + "&h=200&w=350";
	},
	addOnResize: function(newFunction) {
		if(this.isIE) {
			window.attachEvent("onresize", newFunction);
		} else {
			window.addEventListener("resize", newFunction,   false);
		}
	},
	pageSize: function(){
		if (window.innerHeight && window.scrollMaxY) {// Firefox
			yWithScroll = parseInt(window.innerHeight + window.scrollMaxY) - 10;
			xWithScroll = parseInt(window.innerWidth + window.scrollMaxX) - 10;
		} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
			yWithScroll = document.body.scrollHeight;
			xWithScroll = document.body.scrollWidth;
		} else { // works in Explorer 6 Strict, Mozilla (not FF) and Safari
			yWithScroll = document.body.offsetHeight;
			xWithScroll = document.body.offsetWidth;
		}
		arrayPageSizeWithScroll = new Array(xWithScroll, yWithScroll);
		return arrayPageSizeWithScroll;
	},
	addLoadEvent:  function (func) {
		var oldonload = window.onload;
		if (typeof window.onload != 'function') {
			window.onload = func;
		} else {
			window.onload = function() {
				oldonload();
				func();
			}
		}
	}
}

	tweetrooster1360597502.init();
	</script>
				</li>
    <?
}
 
function init_tweetrooster(){
	register_sidebar_widget("Tweet Rooster", "tweetrooster_widget");
}
 
add_action("plugins_loaded", "init_tweetrooster");
 
?>
