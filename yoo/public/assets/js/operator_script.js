$(document).ready(function () {
    $('li.has-sub').find('.menu-list').click(function () {
        $(this).parent('li').toggleClass('expand');
        $(this).next('ul').toggleClass('show');
    });
});
