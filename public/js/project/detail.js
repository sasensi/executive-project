$(document).ready(function ()
{
    // sub nav navigation
    $('.subNav a').click(function ()
    {
        activateLink($(this));
    });

    function activateLink($link)
    {
        $('.subNav a').removeClass('active');
        $link.addClass('active');
    }

    // movies
    var $moviesCarousel = $('#moviesCarousel');
    var $overlay        = $('#overlay');
    var $playButton     = $('#playButton');
    var $pauseButton    = $('#pauseButton');

    // on play/pause button click
    $overlay.click(function ()
    {
        var $video = $moviesCarousel.find('.item.active video');
        var video  = $video.get(0);

        if ($video.hasClass('playing'))
        {
            pauseVideo($video);
        }
        else
        {
            $video.addClass('playing');
            $moviesCarousel.addClass('playing');
            $playButton.hide();
            $pauseButton.show();
            video.play();
        }
    });

    // on slide
    $moviesCarousel.on('slide.bs.carousel', function ()
    {
        var $video = $moviesCarousel.find('video.playing');
        if ($video.length > 0)
        {
            pauseVideo($video);
        }
    });

    function pauseVideo($video)
    {
        $video.removeClass('playing');
        $moviesCarousel.removeClass('playing');
        $pauseButton.hide();
        $playButton.show();
        $video.get(0).pause();
    }

    //
    // PAYMENT
    //

    var $payment = $('#payment');
    $('#payButton').click(function ()
    {
        $payment.addClass('active');
    });
    $('#closebutton').click(function ()
    {
        $payment.removeClass('active');
    });

    var gifts = [];
    // get gifts data from interface
    $('.gift').each(function ()
    {
        gifts.push({
            minAmount: $(this).data('minamount'),
            title    : $(this).data('title')
        });
    });
    // display corresponding gift on price change
    $('#price input').change(function ()
    {
        var price    = parseInt($(this).val());
        var minPrice = 1;
        if (isNaN(price) || price <= minPrice)
        {
            price = minPrice;
            $(this).val(minPrice);
        }

        var correspondingGift = null;
        for (var i = gifts.length - 1; i >= 0; i--)
        {
            var gift = gifts[i];
            if (gift.minAmount <= price)
            {
                correspondingGift = gift;
                break;
            }
        }

        var $gift = $('#gift');
        if (correspondingGift !== null)
        {
            $gift.addClass('active');
            $gift.find('span').text(correspondingGift.title);
        }
        else
        {
            $gift.removeClass('active');
            $gift.find('span').text('');
        }
    });
});