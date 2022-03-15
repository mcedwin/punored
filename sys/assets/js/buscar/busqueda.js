$(document).ready(function () {
    $("#searchForm").keyup(function (e) {
        const $input = $(this).find('input')
        if (
            ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 97 && e.keyCode <= 122))
            && $(this).find("input").val().length >= 3
        ) {
            // console.log($input.val().length);
            // if($(this).find('input').val())
            // console.log($(this).serialize())
        }
    })
})