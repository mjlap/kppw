function changeName(obj){
	var name = $(obj).val();
	var id = $(obj).attr('rel');
	var url = "/advertisement/nameUpdate";
	$.get(url,{id:id,name:name},function(data){
		if(data['status'] == 'success'){
			gritterAdd('保存成功');
			return true;
		}else{
			location.href='/advertisement/recommendList';
		}
	});
}

function gritterAdd(tips){
	$.gritter.add({
		text:'<div><span class="text-center"><h5>'+tips+'</h5></span></div>',
		time:3000,
		position: 'bottom-center',
		class_name: 'gritter-center gritter-info'
	});
}