/**
 * iDX
 * @authors Vee (542033800@qq.com)
 * @date    2014-07-09 11:34:28
 * @version 0.1
 */

var spinner = (function($){

	return function(args){

		var option = {
			data: '',   //图片信息 src、url、alt
			node: '',   //父级节点
			delay: 3000,
			speed: 500,
			width: 380,
			height: 218,
			initPage: 3,
			direct: 'left'
		}

		if(args){
			for(var elem in option){
				if(args[elem]){
					option[elem] = args[elem];
				}
			}
		}

		//常量定义区
		var node = option.node;
		var upperDom = $(".banner_upper", node);
		var lowerDom = $(".banner_lower", node);
		var width = option.width;
		var height = option.height; 
		var data = option.data.banner;//eval("("+option.data+")").banner;
		var total = data.length; 

		//banner至少要有六个
		if(total < 5 || !node){
			return false;
		}

		//常量计算区
		var preWidth = 304;//width*0.8;
		var preHeight = 174;//height*0.8;
		var prepreWidth = 0;//preWidth*0.8;
		var prepreHeight = 0;//preHeight*0.8;

		var leftP = [152, 0, 52, 182, 182];//[0, 48, 108, 198, 270];

		var prepreLeft = leftP[0];
		var preLeft = leftP[1];
		var nextLeft = leftP[3];
		var nextnextLeft = leftP[4];
		var preNLeft = -prepreWidth;
		var nextNLeft = nextnextLeft + prepreWidth/2;
		var pageNowLeft = leftP[2];

		//变量定义区
		var pageNow = option.initPage;
		var direct = option.direct;
		var timer;  

		var _this = {
			drawContent: function(){
				var layerItem = '';
				$.each(data, function(idx){
					layerItem += '<li class="layer" ref="'+parseInt(idx+1)+'"><a href="'+data[idx].url+'" target="_blank">'+ '<img alt="'+data[idx].alt+'" src="'+data[idx].img+'" />' +'</a></li>'
				});
				
				upperDom.html(layerItem);
				
				$("li", upperDom).css({opacity: 0});
				$("li", upperDom).css({width:'0px',height:'0px', opacity: 0, left: width/2+'px', bottom:'20px', zIndex:0});

				var pre = pageNow > 1 ? pageNow - 1: total;
				var prepre = pre - 1 >= 1 ? pre - 1: total;
				var preP = prepre - 1 >= 1 ? prepre-1 : total;

				var next = pageNow == total ? 1 : pageNow + 1;
				var nextnext = next + 1 > total ? 1 : next + 1;
				var nextN = nextnext + 1 > total ? 1 : nextnext + 1;

				//alert(pre);alert(prepre);alert(preP);alert(next);alert(nextnext);alert(nextN);
				$("li:nth-child("+prepre+")", upperDom).css({width: prepreWidth+"px", height: prepreHeight+"px", left: prepreLeft+"px", bottom:'20px', zIndex: 1, opacity: 1});
				$("li:nth-child("+pre+")", upperDom).css({width: preWidth+"px", height:  preHeight+"px", left:  preLeft+"px", bottom:'20px', zIndex: 2, opacity: 1});
				$("li:nth-child("+pageNow+")", upperDom).css({width: width+"px", height: height+"px", left:  pageNowLeft+"px", bottom:'0', zIndex: 3, opacity: 1});
				$("li:nth-child("+next+")", upperDom).css({width: preWidth+"px", height:  preHeight+"px", left:  nextLeft+"px", bottom:'20px', zIndex: 2, opacity: 1});
				$("li:nth-child("+nextnext+")", upperDom).css({width: prepreWidth+"px", height:  prepreHeight+"px", left: nextnextLeft+"px", bottom:'20px', zIndex: 1, opacity: 1});
			},
			initContent: function(){
				_this.drawContent();
				_this.bindEvt();
				_this.start();
			},
			start: function(){
				if(timer){_this.stop();};
				timer = setInterval(function(){
					if(direct == "left"){
						_this.turn('left');
					}else{
						_this.turn("right");	
					}
				}, option.delay);
			},
			stop: function(){
				clearInterval(timer);
			},
			bindEvt: function(){

				node.mouseover(function(){
					_this.stop();
				});
				node.mouseout(function(){
					_this.start();
				});

				$("li", upperDom).click(function(){
					var ref = parseInt($(this).attr("ref"));

					if(pageNow == ref){return true};

					if(pageNow < ref){
						var rightAbs = ref - pageNow;
						var leftAbs = pageNow + total - ref;
					}else{
						var rightAbs = total - pageNow + ref;
						var leftAbs = pageNow - ref;
					}
					if(leftAbs < rightAbs){
						 dir = "right";	
					}else{
						 dir = "left";	
					}

					_this.turnpage(ref, dir);
					return false;
				});
			},
			turn: function(dir){
				if(dir == "right"){
					var page = pageNow -1;
					if(page <= 0) page = total;
				}else{
					var page = pageNow + 1;
					if(page > total){page = 1};
				}
				_this.turnpage(page, dir);

			},
			turnpage: function(page, dir){
				if(pageNow == page){return false};
				$("li", upperDom).stop(false,false);

				var run = function(page, dir, t){
					var pre = page > 1 ? page - 1: total;
					var prepre = pre - 1 >= 1 ? pre - 1: total;
					var preP = prepre - 1 >= 1 ? prepre-1 : total;

					var next = page == total ? 1 : page + 1;
					var nextnext = next + 1 > total ? 1 : next + 1;
					var nextN = nextnext + 1 > total ? 1 : nextnext + 1;

					if(pre != pageNow && next != pageNow){
						var nowpre = pageNow > 1 ? pageNow -1: total;
						var nowprepre = nowpre - 1 >= 1 ? nowpre - 1: total;
						var nownext = pageNow == total ? 1 : pageNow + 1;
						var nownextnext = nownext + 1 > total ? 1 : nownext + 1;

						$("li", upperDom).animate({
							width:'55px',
							height:'82px', 
							left: 188+'px',
							bottom:'0px',
						}, 300);
						//return false;
					}

					if(dir == 'left'){		
						$("li:nth-child("+preP+")", upperDom).css({zIndex:0});
						$("li:nth-child("+preP+")", upperDom).animate({
							width: prepreWidth + 'px', 
							height: '64px', 
							opacity: 0, 
							left: preNLeft+'px', 
							bottom:'20px',
							zIndex:0
						},t, "", function(){locked=false;});
							
						$("li:nth-child("+prepre+")", upperDom).css({zIndex: 1});	
						$("li:nth-child("+prepre+")", upperDom).animate({
							opacity: 1, 
							left: prepreLeft +'px', 
							bottom:'20px',
							height: prepreHeight + 'px', 
							width: prepreWidth + 'px', 
							zIndex: 1
						}, t);

						$("li:nth-child("+pre+")", upperDom).css({zIndex: 2});
						$("li:nth-child("+pre+")", upperDom).animate({
							opacity: 1, 
							left: preLeft +'px', 
							bottom:'20px',
							height: preHeight + 'px', 
							width: preWidth + 'px', 
							zIndex: 2
						}, t);
						
						
						$("li:nth-child("+page+")", upperDom).css({zIndex: 3});
						$("li:nth-child("+page+")", upperDom).animate({
							opacity: 1, 
							left: pageNowLeft+'px', 
							bottom:'0px',
							height: height+'px', 
							width: width+'px', 
							zIndex: 3
						}, t);
				

						$("li:nth-child("+next+")", upperDom).css({zIndex: 2});
						$("li:nth-child("+next+")", upperDom).animate({
							opacity: 1, 
							left: nextLeft+'px', 
							bottom:'20px',
							height: preHeight + 'px', 
							width: preWidth + 'px', 
							zIndex: 2
						}, t);


						$("li:nth-child("+nextnext+")", upperDom).css({
							opacity: 1, 
							left: nextNLeft+'px', 
							bottom:'20px',
							height: '64px', 
							width: prepreWidth + 'px',
							zIndex: 1
						});
						$("li:nth-child("+nextnext+")", upperDom).animate({
							opacity: 1, 
							left: nextnextLeft+'px',
							bottom:'20px', 
							height: prepreHeight + 'px', 
							width: prepreWidth + 'px', 
							zIndex: 1
						}, t);		
					}else{
						$("li:nth-child("+nextN+")", upperDom).css({zIndex:0});
						$("li:nth-child("+nextN+")", upperDom).animate({
							width: prepreWidth + 'px',
							height:'64px', 
							opacity: 0, 
							left: nextNLeft+'px', 
							bottom:'20px',
							zIndex:0
						}, t, "",function(){_this.locked=false;});


						$("li:nth-child("+nextnext+")", upperDom).css({zIndex:1});
						$("li:nth-child("+nextnext+")", upperDom).animate({
							opacity: 1, 
							left: nextnextLeft+'px', 
							bottom:'20px',
							height: prepreHeight + 'px', 
							width: prepreWidth + 'px',
							zIndex: 1
						}, t);

						$("li:nth-child("+next+")", upperDom).css({zIndex:2});
						$("li:nth-child("+next+")", upperDom).animate({
							opacity: 1, 
							left: nextLeft+'px', 
							bottom:'20px',
							height: preHeight + 'px', 
							width: preWidth + 'px',
							zIndex: 2
						}, t);
						
						
						$("li:nth-child("+page+")", upperDom).css({zIndex: 3});
						$("li:nth-child("+page+")", upperDom).animate({
							opacity: 1, 
							left: pageNowLeft+'px', 
							bottom:'0px',
							height: height+'px', 
							width: width+'px', 
							zIndex: 3
						}, t);
						
						
						$("li:nth-child("+pre+")", upperDom).css({zIndex: 2});
						$("li:nth-child("+pre+")", upperDom).animate({
							opacity: 1, 
							left: preLeft+'px', 
							bottom:'20px',
							height: preHeight + 'px', 
							width: preWidth + 'px', 
							zIndex: 2
						}, t);

						$("li:nth-child("+prepre+")", upperDom).css({
							opacity: 0, 
							left: preNLeft+'px', 
							bottom:'20px',
							height: '64px', 
							width: prepreWidth + 'px',
							zIndex: 1
						});
						$("li:nth-child("+prepre+")", upperDom).animate({
							opacity: 1, 
							left: prepreLeft+'px', 
							bottom:'20px',
							height: prepreHeight + 'px', 
							width: prepreWidth + 'px',
							zIndex: 1
						}, t);
						
					}
					
					$("li",lowerDom).fadeOut(t);
					$("li:nth-child("+page+")",lowerDom).fadeIn(t);
					pageNow = page;
					//_this.initBottomNav();
				};
				
				run(page, dir, option.speed);	
			}//end turnpage
		}//end _this

		_this.initContent();
	}

})(jQuery)