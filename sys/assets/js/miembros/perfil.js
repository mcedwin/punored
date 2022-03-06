$(document).ready(function(){
    $('.formu').load_img();
    $('.formu').submit(function() {
        $(this).mysave(() => document.location = base_url);
        return false;
    });
})