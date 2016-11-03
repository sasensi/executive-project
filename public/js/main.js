/**
 * Created by STAGIAIRE on 03/11/2016.
 */

$(document).ready(function ()
{

    $('[data-role="tagPicker"]').each(function ()
    {
        var items          = $(this).attr('data-items').split(',');
        var formattedItems = [];
        for (var i = 0; i < items.length; i++)
        {
            var item = items[i];
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
            var newTag = e.attrs.value;
            for (var i=0; i<existingTags.length; i++)
            {
                if (newTag.toUpperCase() === existingTags[i].value.toUpperCase())
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
});