/**
 * Created by STAGIAIRE on 09/09/2016.
 */

$(document).ready(function ()
{
    $('#aditionalFilterBtn').click(function ()
    {
        if ($(this).hasClass('active'))
        {
            $(this).removeClass('active');
            $('#aditionalFilterWrapper').removeClass('active');
        }
        else
        {
            $(this).addClass('active');
            $('#aditionalFilterWrapper').addClass('active');
        }
    })
});