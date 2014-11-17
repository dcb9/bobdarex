/**
 * iDX
 * @authors Vee (542033800@qq.com)
 * @date    2014-07-06 23:39:06
 * @version $1.0$
 */

//侧边栏－滚动加载更多
var pageNo = 2;
var pageTotal = 2;

$(function(){
	/*
	** aside 右侧边栏功能区：
	** 1. 登录、注册、忘记密码、重置密码
	** 2. 点击修改昵称
	** 3. 点击我的头像出现侧边栏
	** 4. 点击侧边栏各个模块按钮出现列表（稍后看列表、历史记录列表、我的喜欢列表、关注频道列表）
 	** 5. 微博、微信
 	** 6. 退出登录
	*/
	var myspace = {
			reg : /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i,
			obj : $('.myspace'),
			aside : $('#aside'),
			droplist : $('.droplist'),
			droplistInner : $('#droplist'),
			showSidebar : function(){
				var wHeight = $(window).height();
				if(this.obj.hasClass('login')){
					this.aside.height(wHeight-44);
					this.droplistInner.height(wHeight-89);
					if(this.obj.children('em').hasClass('close')){
						this.aside.stop(true,true).animate({
							right: '-73px'
						},300);
						this.aside.find('.myicons li.current').removeClass('current');
						this.droplist.stop(true,true).animate({
							right: '-400px'
						},600);
						this.obj.children('em').removeClass('close');
					}else{
						this.aside.stop(true,true).animate({
							right: 0
						},300);
						this.obj.children('em').addClass('close');
					}
				}else{
					$('#loginBox').show(200);
				}
			}
	}
	
	//click me to show the right sidebar icons
	myspace.obj.children('a').click(function(e){
		myspace.showSidebar();
	});

	$('#loginBox').on('click','dt li',function(){
		if($(this).hasClass('current')){
			return false;
		}else{
			var index = $('#loginBox dt li').index($(this));
			$('#loginBox dd form').eq(index).show().siblings('form').hide();
			$('#loginBox dd form').eq(index).find('input[type="text"]').focus();
			$(this).addClass('current').siblings('li').removeClass('current');
		}
	});
	
	//关闭弹窗
	$('.popbox').on('click','dt a',function(){
		$(this).parents('.popbox').hide(200);
	});
	
	//弹窗input在focus的时候 整行变选中状态
	$('.popbox').on('focus','dd input',function(){
		$(this).parent('label').addClass('focus');
	});
	$('.popbox').on('blur','dd input',function(){
		$(this).parent('label').removeClass('focus');
	});
	
	//登录
	$("#loginBoxLogin").click(function(){
		var activeCode = $('#activeCode').val();
		var email = $.trim($("#lEmail").val());
		var password = $("#lPassword").val();
		var success = true;
		//if(!myspace.reg.test(email)){
		//	success = false;
		//}
		if(password.length < 6 || password.length > 16){
			success = false;
		}
		if(success == false){
			$('#loginForm .error').html('您的账号或密码错误请重新输入222').show();
			return false;
		}
		$.ajax({
			url : cxt+'/site/login',
			type : 'POST',
			data : {
				'LoginForm[username]' : email,
                'LoginForm[password]' : password
			}
		}).done(function(result) {
			if (result.success) {
				if(activeCode){
					window.location.href =  cxt;
				}else{
					window.location.href =  top.location.href;
				}
			}else{
				$('#loginForm .error').html('登录失败').show();
				return false;
			}
		});
	});
		
	//注册
	$("#loginBoxRegist").click(function(e){
		e.stopPropagation();
		var activeCode = $('#activeCode').val();
		var email = $.trim($("#rEmail").val());
		var password = $("#rPassword").val();
		var rPassword = $("#rcPassword").val();
		var success = true;
		if(!myspace.reg.test(email)){
			success = false;
		}
		if(password.length < 6 || password.length > 16){
			success = false;
		}
		if(success == false){
			$('#registerForm .error').html('您的账号或密码错误请重新输入').show();
			return false;
		}
		if(password != rPassword){
			$('#registerForm .error').html('两次密码输入不一致').show();
			return false;
		}
		$.ajax({
			url : cxt+'/user/regist.json',
			type : 'POST',
			data : {
				email : email,
				password : password,
				rPassword : rPassword
			}
		}).done(function(result) {
			if (result.success) {
				alert('注册成功');
				if(activeCode){
					window.location.href =  cxt;
				}else{
					window.location.href =  top.location.href;
				}
				return false;
			}else{
				if(result.code == 0){
					$('#registerForm .error').html('该帐号已被注册').show();
				}else{
					$('#registerForm .error').html('注册失败').show();
				}
				return false;
			}
		});
	});
	
	//忘记密码
	$('#loginBox .forgetpsw').click(function(){
		var email = $('#lEmail').val();
		$('#forgetPswBox input[type="text"]').val(email);
		$('#loginBox').hide(200);
		$('#forgetPswBox').show(400);
	});
	
	//找回密码弹窗
	$('#forgetPswBox input[type="submit"]').click(function(){
		var email = $.trim($('#forgetPswBox input[type="text"]').val());
		if(!myspace.reg.test(email)){
			$('#forgetPswBox .error').html('请输入格式正确的邮箱').show();
			return false;
		}
		$.ajax({
			url : cxt+'/user/sendemail.json',
			type : 'POST',
			data : {
				email : email
			},
			datatype:'json'
		}).done(function(result) {
			if (result.success) {
				alert('发送成功！');
				window.location.href = top.location.href;
			}else{
				$('#forgetPswBox .error').html(result.message).show();
				return false;
			}
		});
	});
	
	//重置密码弹窗
	$('#resetPswBox input[type="submit"]').click(function(){
		var psw1 = $.trim($('#resetPswBox .psw1 input[type="password"]').val());
		var psw2 = $.trim($('#resetPswBox .psw2 input[type="password"]').val());
		var activeCode = $('#activeCode').val();
		if(psw1.length < 6 || psw1.length > 16 || psw2.length < 6 || psw2.length > 16){
			$('#resetPswBox .error').html('请输入6-16位的密码').show();
			return false;
		}
		if(psw1 != psw2){
			$('#resetPswBox .error').html('两次密码输入不一致').show();
			return false;
		}
		$.ajax({
			url : cxt+'/user/setnewpwd.json',
			type : 'POST',
			data : {
				activeCode:activeCode,
				newPwd : psw1
			},
			datatype:'json'
		}).done(function(result) {
			if (result.success) {
				$('#resetPswBox').hide(200);
				$('#loginBox').show(400);
			}else{
				$('#forgetPswBox .error').html(result.message).show();
				return false;
			}
		});
	});
	
	//修改昵称
	myspace.obj.children('.name').click(function(){
		$(this).hide().siblings('input').show().focus();
	});
	myspace.obj.children('input').keyup(function(e){
		e.stopPropagation();
		var name = $.trim($(this).val());
		if(name == ''){
			$(this).val('');
			return false;
		}
		if(e.which == 13 && name != ''){
			nameSave(name);
		}
	});
	//修改昵称接口
	function nameSave(name){
		$.ajax({
			url : cxt+'/user/setnickname.json',
			type : 'POST',
			data : {
				newName : name
			}
		}).done(function(result) {
			if (result.success) {
				myspace.obj.children('input').hide().siblings('.name').html(result.content).show();
			}else{
				alert(result.message);
			}
		});
	}
	
	//prevent the body scrolling effect when aside on scroll
//	$('#aside').hover(function(){
//		$('body').css("overflow","hidden");
//	},function(){
//		$('body').css("overflow","auto");
//	});
	
	
	//显示侧边栏的内容列表
	function showAsideLists(obj){
		if(obj.hasClass('current')){
			myspace.droplist.stop(true,true).animate({
				right: '-400px'
			},400);
			obj.removeClass('current');
			return false;
		}else{
			myspace.droplist.stop(true,true).animate({
				right: '70px'
			},400).children('#droplist').children('ul').html('');
			obj.addClass('current').siblings('li').removeClass('current');
		}
//		if(category){
//			myspace.droplistInner.removeAttr('class');
//			myspace.droplistInner.addClass(category);
//		}
	}
	
	$('#aside .myicons li').on('click',function(){
		//var category = $(this).attr('data-category');
		showAsideLists($(this));
		//稍后看列表
		if($(this).hasClass('myplaylist')){
			loadAsideList("/userData/playList.json", 1, 10);
			$('#aside .droplist h3').html('稍后看列表');
			pageNo = 2;
			$('#droplist').removeScrollPagination();
			$('#droplist').attr('scrollPagination', 'enabled');
			$('#droplist').scrollPagination({
				'contentPage': cxt+'/userData/playList.json', // the url you are fetching the results
				'contentData': {pageNo: pageNo}, // these are the variables you can pass to the request, for example: children().size() to know which page you are
				'scrollTarget': $('#droplist'), // who gonna scroll? in this example, the full window
				'heightOffset': 10 // it gonna request when scroll is 10 pixels before the page ends
			});
		}
		//历史记录列表
		else if($(this).hasClass('myhistory')){
			loadAsideList("/userData/historyList.json", 1, 10);
			$('#aside .droplist h3').html('历史记录');
		}
		//我的喜欢列表
		else if($(this).hasClass('mylike')){
			loadAsideList("/userData/favoriteList.json", 1, 10);
			$('#aside .droplist h3').html('我的喜欢');
			pageNo = 2;
			$('#droplist').removeScrollPagination();
			$('#droplist').attr('scrollPagination', 'enabled');
			$('#droplist').scrollPagination({
				'contentPage': cxt+'/userData/favoriteList.json', // the url you are fetching the results
				'contentData': {pageNo: pageNo}, // these are the variables you can pass to the request, for example: children().size() to know which page you are
				'scrollTarget': $('#droplist'), // who gonna scroll? in this example, the full window
				'heightOffset': 10  // it gonna request when scroll is 10 pixels before the page ends
			});
		}
		//我的微博
		else if($(this).hasClass('myweibo')){
			var weiboFrame = $('#weiboFrame').html();
			myspace.droplist.children('h3').html('');
			myspace.droplistInner.children('ul').html(weiboFrame);
		}
		//我的微信
		else if($(this).hasClass('myweixin')){
			var weixinFrame = $('#weixinQR').html();
			myspace.droplist.children('h3').html('');
			myspace.droplistInner.children('ul').html(weixinFrame);
		}
		else{
			return true;
		}
	});
	
	//aside 我的喜欢列表 滚动加载	
//	$('#droplist').scrollPagination({
//		'contentPage': cxt+'/userData/favoriteList.json', // the url you are fetching the results
//		'contentData': {pageNo: pageNo, pageSize:10}, // these are the variables you can pass to the request, for example: children().size() to know which page you are
//		'scrollTarget': $('#droplist'), // who gonna scroll? in this example, the full window
//		'heightOffset': 10, // it gonna request when scroll is 10 pixels before the page ends
//		'beforeLoad': function(){ // before load function, you can display a preloader div
//			$('#loading').fadeIn();
//		},
//		'afterLoad': function(elementsLoaded){ // after loading content, you can use this function to animate your new elements
//			$('#loading').fadeOut();
//			var i = 0;
//			// $(elementsLoaded).fadeInWithDelay();
//			 if (pageNo > pageTotal){ // if more than 100 results already loaded, then stop pagination (only for testing)
//			 	$('#nomoreresults').fadeIn();
//				$('#droplist').stopScrollPagination();
//			 }
//			 pageNo++; 
//		}
//	});
	
	// code for fade in element by element
//	$.fn.fadeInWithDelay = function(){
//		var delay = 0;
//		return this.each(function(){
//			$(this).delay(delay).animate({opacity:1}, 200);
//			delay += 100;
//		});
//	};
	
	//请求加载侧边栏数据方法
	function loadAsideList(url,pageNo,pageSize){
		$.ajax({
			type:'POST',
			url:cxt+url,  
			data:{
				pageNo:pageNo,
				pageSize:pageSize
			},
			dataType:'json'
		}).done(function(result){
			if(result.success){
				pageTotal = result.code;
				$('#droplist ul').html(result.content);
			}else{
				//alert(result.message);
				$('#droplist ul').html('<div style="text-align:center;padding:20px 0;">暂无记录</div>');
			}
		});
	}
	
	
	//aside 关注频道列表
	$('.myfollow').click(function(){
		showAsideLists($(this));
		$.ajax({
			type:'POST',
			url:cxt+"/userData/followChannels.json",  
			data:{},
			dataType:'json'
		}).done(function(result){
			if(result.success){
				var channels = result.content.channels;
				var subChannels = result.content.subChannels;
				var channelHtml = '';
				var subchannelHtml = '';
				if(channels != ''){
					channelHtml = '<dl class="channel"><dt>主频道</dt>';
					for(var i=0; i<=channels.length; i++){
						channelHtml += '<dd data-id="'+channels.id+'"><a href="#"><i>'+(i+1)+'.</i><span>'+channels.name+'</span><b>'+channels.addNumToday+'</b></a><a href="javascript:;" class="cancel">取消关注</a></dd>';
					}
					channelHtml += '</dl>';
				}
				if(subChannels != ''){
					subchannelHtml = '<dl class="subchannel"><dt>分频道</dt>';
					for(var i=0; i<=channels.length; i++){
						subchannelHtml += '<dd data-id="'+channels.id+'"><a href="#"><i>'+(i+1)+'.</i><span>'+channels.name+'</span><b>'+channels.addNumToday+'</b></a><a href="javascript:;" class="cancel">取消关注</a></dd>';
					}
					subchannelHtml += '</dl>';
				}
				$('.droplist').html('<h3>关注频道</h3><div id="droplist">' + channelHtml + subchannelHtml + '</div>');
			}else{
				alert(result.message);
			}
		});
	});
	
	//侧边栏关注频道－取消关注  
	$('.droplist').on('click','dd .cancel',function(){
		var id = $(this).parents('dd').attr('data-id');
		var obj = $(this);
		subscribeChannelAside(obj,id);
	});
	
	

});

/**
 * 判断是否登录状态
 */
function login(){
	var user = $('#sessionUser').val();
	if(user){
		return true;
	}else{
		$('#loginBox').show(200);
		return false;
	}
}

//(function($){
//	//全站滚动加载
//    var counter = 0;
//    function loadData(n,obj){
//	    if(counter < n){
//	        if  (isBottom(obj)){
//	            getData(obj);
//	        }
//	    }
//	}
//            
//    function isBottom(obj){
//    	return (((obj.children().height() - obj.height()) - obj.children().scrollTop()) <= 50) ? true : false;
//    }
//	function getData(obj){
//	    $(window).unbind('scroll');
//	    $('#loading').show();
//	    $.ajax({
//	    	url:'data.php',
//	    	type:'POST',
//	    	data:{},
//	    	dataType:'json'
//	    }).done(function(result){
//	        counter++;
//	        $('#loading').hide();
//	        obj.append(response);
//	        obj.scroll(loadData);
//	    });
//	}
//})(jQuery)