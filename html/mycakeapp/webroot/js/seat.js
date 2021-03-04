//予約済みのbutonにdisabled属性を追加
$(document).ready(function(){
    //予約済みのbutonにdisabled属性を追加
    if(typeof Reserved != 'undefined'){
        for(var i = 0; i < Object.keys(Reserved).length; i++){
            $('#' + Reserved[i]).prop('disabled', true);
            $('label[for=' + Reserved[i] + ']').addClass('reserved');
        }
    }
});

// 座席のbutton挙動
$('input[type="checkbox"]').click(function(){
    if($(this).hasClass('selected')){
        $('.selected').removeClass('selected');
        $('button[type=submit]').prop('disabled', true);
    }else{
        $('.selected').removeClass('selected');
        $(this).addClass('selected');
        $selectedId = $(this).attr('id');
        $('label[for=' + $selectedId + ']').addClass('selected');
        $('button[type=submit]').prop('disabled', false);
    }
});
