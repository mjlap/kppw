/**
 * Created by Administrator on 2016/10/10.
 */
function isOpenKee(obj){
    var value = $(obj).val();
    var url = '/manage/isOpenKee';
    $.get(url,{value:value},function(data){
        if(data.code == 1){
            gritterAdd(' 设置成功');
        }else{
            gritterAdd(' 设置失败');
        }
    },'json');
}

function gritterAdd(tips){
    $.gritter.add({
        text:'<div><span class="text-center"><h5>'+tips+'</h5></span></div>',
        time:3000,
        position: 'bottom-center',
        class_name: 'gritter-center gritter-info'
    });
}