function Check(options){
    //this.oItemsBox = options.oItemsBox;
    this.aItems = options.aItems;
    this.oCheckAll = options.oCheckAll;
    this.oCheckReverse = options.oCheckReverse;
}
Check.prototype = {
    init : function(){
        var that = this;
        //全选操作
        this.oCheckAll.onclick = function(){
            that.checkAll();
        };
        //反选操作
        this.oCheckReverse.onclick = function(){
            that.checkReverse(that, true);
        };
    },
    //全选/全不选
    checkAll : function(){
        for(var i = 0, len = this.aItems.length; i < len; i++){
            this.aItems[i].checked = this.oCheckAll.checked;
        }
    },
    //根据选项更新全选
    checkReverse : function(that, isReverse){
        for(var i = 0, n = 0, arr = [], len = that.aItems.length; i < len; i++){
            if(isReverse){
                that.aItems[i].checked = !that.aItems[i].checked;
            }
            if(that.aItems[i].checked){n++;arr.push(that.aItems[i].value)}
        }
        that.oCheckAll.checked = len == n;
        return arr;
    }
};

//实例化
var myCheck = new Check({
    aItems : document.getElementsByName('object'),
    oCheckAll : document.getElementById('checkall'),
    oCheckReverse : document.getElementById('checkall')
});
myCheck.init();

$(document).ready(function(){ 
	$('#batchdel').bind('click',function(event){
		event.preventDefault();
		event.stopPropagation();
		var ids = '';
		$(".ids:checked").each(function(){
			ids += $(this).val()+',';
		});
		if(!ids){
			easyDialog.open({
				container : {
					content : '请先选择要删除的数据'
				},
				autoClose : 1000
			});
			return false;
		}
		ids = ids.substring(0, ids.length - 1);
		if (!confirm("确认要删除么？")) {
			return false;
		}
		$.ajax({
			type: "POST",
			url: $('input[name="del_url"]').val(),
			data : 'ids='+ids,
			dataType: 'json',
			success: function(data) {
				easyDialog.open({
					container : {
						content : data.msg
					},
					autoClose : 1000
				});
				if(data.success){
					setTimeout("window.location.href = '"+data.url+"'",1000);
				}
			}
		});
	});
});