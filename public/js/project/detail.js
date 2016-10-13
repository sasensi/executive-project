// sub nav navigation
$(document).ready(function ()
{
    $('.subNav a').click(function ()
    {
        activateLink($(this));
    });

    function activateLink($link)
    {
        $('.subNav a').removeClass('active');
        $link.addClass('active');
    }
});