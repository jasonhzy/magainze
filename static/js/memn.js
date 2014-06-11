$(document).ready(function(){
	var mod_menu=$(".mod-menu");//导航<a href='http://www.zztuku.com/tags/模块.html' target='_blank'><u>模块</u></a>区
	var menu=function(){
		var menuItem=$(".menu-item li");//选择导航列表
		menuItem.each(function(){
			var _index=$(this).index();//获取当前选择菜单列表的索引
			//if(_index != 0) {
				$(this).mouseenter(function(){
					var y = $(this).position().top+1;//获取当前鼠标滑过的列表的顶部坐标
					$(".menu-cont").show();
		            $(".menu-cont").css("top", y);//需要显示的对应索引内容
					$(this).addClass("mouse-bg").siblings().removeClass("mouse-bg");
					$(".menu-cont>div").eq(_index).show().siblings().hide();
				});
			//}
		});/*导航菜单菜单*/
		$(".mod-menu").mouseleave(function(){
			$(".menu-cont").hide();
			menuItem.removeClass("mouse-bg");
		})
	}//展开二级菜单	
	menu();//执行展开二级菜单函
});