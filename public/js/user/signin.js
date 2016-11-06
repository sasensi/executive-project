/**
 * Created by sam on 06/11/2016.
 */

$(document).ready(function ()
{
    var $favouriteCategoryInput = $('select[name="favouritecategory_id"]');
    var $favouriteCategoryRow   = $favouriteCategoryInput.closest('.row');
    // only show favourite category field if user type is financer
    $('select[name="usertype_id"]').change(function ()
    {
        if ($(this).val() === '1')
        {
            $favouriteCategoryRow.show();
            $favouriteCategoryInput.removeAttr('disabled');
        }
        else
        {
            $favouriteCategoryRow.hide();
            $favouriteCategoryInput.attr('disabled', true);
        }
    });
});