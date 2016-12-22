$(document).ready(function ()
{
    //
    // SCROLL NAVIGATION
    //

    // fine tunning for scroll navigation
    var offsetTop = 105;

    // subnav click event
    $('.subNav a').click(function (event)
    {
        var $target = $(this);
        $('html, body').stop().animate({
            scrollTop: $($target.attr('href')).offset().top - offsetTop
        }, 1500);
        event.preventDefault();
    });

    // update subnav display on scroll
    $('#mainPicture, #description, #movies, #gifts')
    .on('scrollSpy:enter', function ()
    {
        $(this).addClass('scrollVisible');
        updateActiveLink();
    })
    .on('scrollSpy:exit', function ()
    {
        $(this).removeClass('scrollVisible');
        updateActiveLink();
    })
    .scrollSpy({
        offsetTop: offsetTop
    })
    ;

    function updateActiveLink()
    {
        $('.subNav a').removeClass('active');
        var activeId = $('.scrollVisible').first().attr('id');
        $('.subNav a[href="#' + activeId + '"]').addClass('active');
    }

    //
    // movies
    //
    var $moviesCarousel = $('#moviesCarousel');
    var $overlay        = $('#overlay');
    var $playButton     = $('#playButton');
    var $pauseButton    = $('#pauseButton');

    // on play/pause button click
    $overlay.click(function ()
    {
        var $video = $moviesCarousel.find('.item.active video');
        // single video case
        if ($video.length === 0)
        {
            $video = $moviesCarousel.find('video');
        }
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
    $('#price input').on('keyup', function ()
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