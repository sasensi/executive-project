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
    });

    //
    // INFINITE SCROLL
    //
    var $window         = $(window);
    var $loading        = $('#loading');
    var $projectsParent = $('#projectsWrapper > .row');
    $window.on('scroll', function ()
    {
        var delta = $(document).height() - $window.height() - $window.scrollTop();
        if (delta < 30 && !$loading.data('active'))
        {
            $loading.show().data('active',true);

            $.ajax({
                dataType: "json",
                method  : 'GET',
                url     : _App.rootUrl + '/ws/content/project',
                data    : {
                    offset: $('.project').length,
                    url   : window.location.href
                },
                success : function (response)
                {
                    $loading.hide().data('active',false);

                    if (!response.success)
                    {
                        console.log(response.error);
                        return false;
                    }

                    $projectsParent.append(response.data);

                    if (response.end)
                    {
                        $window.off('scroll');
                    }
                }
            });
        }
    });
});