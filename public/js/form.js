/**
 * Created by STAGIAIRE on 04/11/2016.
 */
$(document).ready(function ()
{
    $('.giftsAddButton').click(function (e)
    {
        e.preventDefault();

        var $wrapper  = $(this).closest('.giftsWrapper');
        // var existingGifts =
        var giftIndex = parseInt($wrapper.find('fieldset').last().attr('data-index')) + 1 || 0;
        var fieldName = $wrapper.attr('data-name');

        $.ajax({
            dataType: "json",
            method  : 'GET',
            url     : _App.rootUrl + '/ws/content/gift',
            data    : {
                index: giftIndex,
                name : fieldName
            },
            success : function (response)
            {
                if (!response.success)
                {
                    console.log(response.error);
                    return false;
                }

                $wrapper.append(response.data);
            }
        });
    });

    $('body').on('click', '.giftDeleteButton', function (e)
    {
        e.preventDefault();

        if (confirm('Voulez-vous vraiment supprimer cette contrepartie ?'))
        {
            $(this).closest('fieldset').remove();
        }
    });
});