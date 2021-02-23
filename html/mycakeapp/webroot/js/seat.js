//予約済みのbutonにdisabled属性を追加
$(document).ready(function(){
    if(typeof Resaveted != 'undefined'){
        for(var i = 0; i < Object.keys(Resaveted).length; i++){
            $('button[value="' + Resaveted[i] + '"]').prop('disabled', true);
        }
    }
});

//座席のbutton挙動
$('button').click(function(){
    console.log(Resaveted);
    if($(this).hasClass('selected')){
        $(this).removeClass('selected');
    }else if($(this).hasClass('reserved')){
        none;
    }else{
        $('.selected').removeClass('selected');
        $(this).addClass('selected');
    }
});
