/**
 * Created by STAGIAIRE on 03/11/2016.
 */

$(document).ready(function ()
{

    //
    // TAG PICKER
    //
    $('[data-role="tagPicker"]').each(function ()
    {
        var items          = $(this).attr('data-items').split(',');
        var formattedItems = [];
        for (var i = 0; i < items.length; i++)
        {
            var item = items[ i ];
            formattedItems.push({value: item});
        }

        var engine = new Bloodhound({
            local         : formattedItems,
            datumTokenizer: function (d)
            {
                return Bloodhound.tokenizers.whitespace(d.value);
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });

        engine.initialize();

        $(this)
        // prevent duplicate tag
        .on('tokenfield:createtoken', function (e)
        {
            var existingTags = $(this).tokenfield('getTokens');
            var newTag       = e.attrs.value;
            for (var i = 0; i < existingTags.length; i++)
            {
                var existingTag = existingTags[ i ];
                // fix bug on init
                if (existingTag === this)
                {
                    continue;
                }

                if (newTag.toUpperCase() === existingTag.value.toUpperCase())
                {
                    e.preventDefault();
                    return false;
                }
            }
        })
        .tokenfield({
            typeahead: [
                null,
                {
                    source: engine.ttAdapter()
                }
            ]
        });
    });


    //
    // DATE PICKER
    //
    $('.datePicker').datepicker({
        format  : 'dd/mm/yyyy',
        language: 'fr'
    });

    //
    // FILE PICKER
    //
    $('input[type="file"]').fileinput({
        language         : 'fr',
        browseOnZoneClick: true,
        showUpload       : false
    });

    //
    // PHONE INPUT
    //
    $('.phoneInput').intlTelInput({
        autoFormat    : true,
        utilsScript   : "../vendor/intl-tel-input-7.1.0/lib/libphonenumber/build/utils.js",
        initialCountry: 'fr'
    });

    //
    // RESPONSIVE TABLES
    //
    $('table').basictable({
        breakpoint: 768
    });

    //
    // TOOLTIPS
    //
    $('[data-toggle="tooltip"]').tooltip();
});