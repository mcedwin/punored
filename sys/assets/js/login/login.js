$(document).ready(function() {
    $("form").submit(function() {
        $(this).mysave((data)=>document.location=data.redirect);
        return false;
    });
   /* var rs0 = $('.rs:eq(0)').attr('href');
    var rs1 = $('.rs:eq(1)').attr('href');
    $('.tipo input').change(function(){
        $('.tipo label').removeClass('btn-primary');
        $('.tipo label').addClass('btn-outline-secondary');
        if($(this).prop('checked')){
            $(this).closest('label').addClass('btn-primary');
            $(this).closest('label').removeClass('btn-outline-secondary');
            if($(this).val()=='es'){
                $('.rs:eq(0)').attr('href',rs0+'/empresa');
                $('.rs:eq(1)').attr('href',rs1+'/empresa');
            }else{
                $('.rs:eq(0)').attr('href',rs0+'/');
                $('.rs:eq(1)').attr('href',rs1+'/');
            }
        }
    })*/


    $('.recuperar').click(function() {
        $(this).mydialog();
        return false;
    });
})