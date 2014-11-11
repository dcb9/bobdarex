/**
 * iDX
 * @authors Vee (542033800@qq.com)
 * @date    2014-07-06 23:39:06
 * @version $1.0$
 */

/*
** 喜欢视频接口： 
*/
function likeVideo(obj,id,num){
	if(login()){
		var like = 1;
		if(obj.hasClass('video_liked')){
			like = -1;
		}
		$.ajax({
			type:'POST',
			url:cxt+"/movie/operate.json",   //type：1喜欢 －1取消
			data:{
				type:like,
				movieId:id
			},
			dataType:'json'
		}).done(function(result){
			if(result.success){
				if(like == 1){
					obj.addClass("video_liked");
					obj.children('b').text(num+1);
				}else{
					obj.removeClass("video_liked");
					obj.children('b').text(num-1);
				}
			}else{
				alert(result.message);
			}
		});
	}
}

/*
** 稍后看列表接口： 
*/
function playLaterVideo(obj,id,num){
	if(login()){
		var like = 2;
		if(obj.hasClass('video_liked')){
			like = -2;
		}
		$.ajax({
			type:'POST',
			url:cxt+"/movie/operate.json",  //稍后看列表接口 type：2加入 －2取消
			data:{
				type:like,
				movieId:id
			},
			dataType:'json'
		}).done(function(result){
			if(result.success){
				if(like == 2){
					obj.addClass("video_liked");
					if(num != 'aaa'){
						obj.children('b').html(num+1);
					}else{
						obj.children('span').text('已添加');
					}
				}else{
					obj.removeClass("video_liked");
					if(num != 'aaa'){
						obj.children('b').html(num-1);
					}else{
						obj.children('span').text('稍后看');
					}
				}
				return false;
			}else{
				alert(result.message);
			}
		});
	}
}

/*
** 首页 － 关注频道接口： 
*/
function subscribeChannel(obj,id){
	if(login()){
		var type = 1;
		if(obj.hasClass('followed')){
			type = -1;
		}
		$.ajax({
			type:'POST',
			url:cxt+"/category/operate.json",  //稍后看列表接口 type：1关注 －1取消
			data:{
				type:type,
				id:id
			},
			dataType:'json'
		}).done(function(result){
			if(result.success){
				if(type == 1){
					obj.removeClass('follow_icon').addClass('followed').html('已关注');
				}else{
					obj.removeClass('followed').addClass('follow_icon').html('<b>+</b>关注');
				}
			}else{
				alert(result.message);
			}
		});
	}
}

/*
** 侧边栏 － 取消关注频道接口： 
*/
function subscribeChannelAside(obj,id){
	$.ajax({
		type:'POST',
		url:cxt+"/category/operate.json",  //稍后看列表接口 type：1关注 －1取消
		data:{
			type:'-1',
			id:id
		},
		dataType:'json'
	}).done(function(result){
		if(result.success){
			obj.parents('dd').remove();
			//查看是否有列表
		}else{
			alert(result.message);
		}
	});
}

/*
** 首页频道列表 － 切换频道接口： 
*/
function changeChannelList(subId,topId,viewType,pageNo,pageSize){
	var obj = $('.channel_bg[data-id="'+topId+'"]');
	$.ajax({
		type:'POST',
		url:cxt+"/movie/list.json",  
		data:{
			aid:topId,
			bid:subId,
			viewType:viewType,
			pageNo:pageNo,
			pageSize:pageSize
		},
		dataType:'json'
	}).done(function(result){
		if(result.success){
			obj.html(result.content);
		}else{
			alert(result.message);
		}
	});
}
