$(function () {


    //header styling and fixing animation
    var cbpAnimatedHeader = (function () {
        var header = $('.rx-header'),
            didScroll = false,
            changeHeaderOn = 100;


        function scrollPage() {
            if ($(window).scrollTop() >= changeHeaderOn) {
                header.addClass('rx-header-fixed');
            }
            else {
                header.removeClass('rx-header-fixed');
            }
            didScroll = false;
        }

        $(window).scroll(function () {
            if (!didScroll) {
                didScroll = true;
                setTimeout(scrollPage, 150);
            }
        });
    })();



    //button apply click scroll page to sign up section
    //$('.rx-btn-apply').on('click', function () {
    //    $("html, body").animate({ scrollTop: $('#signupForm').offset().top }, 1000);
    //});

    $('.rx-btn-apply , .rx-header-nav li > a').on('click', function () {
        var header = $('.rx-header-fixed'),
            headerHeight = header.height() > 0 ? header.outerHeight() : 130;
        $("html, body").animate({ scrollTop: $($(this).attr('data-goto-section')).offset().top - headerHeight }, 1000);
    });

    //carousel initialization
    $("#rxPartnerLogo").owlCarousel({
        items: 3,
        itemsDesktop: [1000, 3],
        itemsDesktopSmall: [900, 3],
        itemsTablet: [600, 3],
        itemsMobile: [500, 1],
        //Autoplay
        autoPlay: true,
        stopOnHover: false,

        // Navigation
        navigation: true,
        navigationText: false,
        rewindNav: true,
        scrollPerPage: false,

        //Pagination
        pagination: false,

        // Responsive
        responsive: true,
        responsiveRefreshRate: 200,
        responsiveBaseWidth: '.rx-section-bottom'
    });

    $("#rxPartnerCLogo").owlCarousel({

        // Most important owl features
        items: 5,
        //Autoplay
        autoPlay: true,
        stopOnHover: false,

        // Navigation
        navigation: true,
        navigationText: false,
        rewindNav: true,
        scrollPerPage: false,

        //Pagination
        pagination: false,
        responsiveBaseWidth: '.rx-section-bottom'
    });

    $("#rxSectionHero").owlCarousel({

        navigation: false, // Show next and prev buttons
        slideSpeed: 300,
        paginationSpeed: 400,
        singleItem: true
    });

    $("#rxMentorsList").owlCarousel({
        //Pagination
        pagination: false,
        autoPlay: false,
        navigation: true,
        items: 6,
        itemsDesktop: [1199, 5],
        itemsDesktopSmall: [979, 4],
        navigationText: false
    });


    //show mentor name and title on hover
    //and change arrow position
    $(function () {
        //var arrowPosition = 56.5; // starting arrow position

       //$('#rxMentorBio .rx-mentor-bio-arrow').css('left', arrowPosition + 'px');

        $('.rx-mentor-item').each(function (index) {

            var $mentorBio = $(this).find('.bio-content').html();
            var $bioTarget = $('#rxMentorBio').find('.bio-content');

            $(this).hover(function () {

                //var arrowPosition = $(this).offset().left - $('#rxMentorsList').offset().left + ($(this).width() / 2) - 12.5;
                //$('#rxMentorBio .rx-mentor-bio-arrow').css('left', arrowPosition + 'px');

                $(this).children('.rx-mentor-item-active').show();

                $bioTarget.html($mentorBio);

            }, function () {

                $(this).children('.rx-mentor-item-active').hide();
                $bioTarget.find('.bio-content').html('');

            });

        });
    });



/*// Get the modal
var modal = document.getElementById('rxMentorBio');

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById('myImg');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
    modal.style.display = "block";
    modalImg.src = this.src;
    modalImg.alt = this.alt;
    captionText.innerHTML = this.alt;
}


// Get the <span> element that closes the modal
var span = document.getElementsByClassName("closeButton")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}*/



    //last call modal
    $(window).load(function(){
        $('#lastCallModal').modal('show');
    });


    //contact us modal submiting
    $('#contactUsSubmit').on('click', function () {
        if ($("#contactUsForm").valid()) {

            //submit form here

            $('#modalContactUS').modal('hide');
        }
    });

    //signup submit click
    $('#signupFormSubmit').on('click', function () {
        if ($("#signupForm").valid()) {
            //console.log($('#signupForm').serialize());

            //submit form here
            var signupformdata = $('#signupForm').serializeArray();

            $('#modalUserFullName').text(signupformdata[0].value);
            $('#modalSignup').modal('show');
        };
    });

    //signup modal submit click
    $('#signUpForSecondSubmit').on('click', function () {
        if ($("#modalSignupForm").valid()) {
            console.log($('#signupForm').serialize());
            console.log($('#modalSignupForm').serialize());

            //first form here
            var signupformdata = $('#signupForm').serializeArray();
            //submit form here
            var signupFormData = $('#modalSignupForm').serializeArray();

            // Using the core $.ajax() method
            $.ajax({
                // The URL for the request
                url: "email.php",
                // The data to send (will be converted to a query string)
                data: {
                    signupformdata: signupformdata,
                    signupFormData: signupFormData
                },
                // Whether this is a POST or GET request
                type: "POST",

                // Code to run if the request succeeds;
                // the response is passed to the function
                success: function( data ) {
                    res = data;
                    console.log(data)
                }
            });
            $('#modalSignupForm').hide();
            $('#modalSignupThanku').show();
        }
    });

    $('#modalSignup').on('hide.bs.modal', function () {
        $('#modalSignupForm').show();
        $('#modalSignupThanku').hide();
        document.getElementById("signupForm").reset();
        document.getElementById("modalSignupForm").reset();

    });
    $('#modalSignupThanku input[type=button]').on('click', function () {
        $('#modalSignup').modal('hide');
    })

    //sign up  modal inputs visibility
    $('#snp-q31').click(function () {
        $('#snp-q3-option-yes').fadeIn(100);
        $('#snp-q3-option-no').fadeOut(100);
    });


    $('#snp-q32').click(function () {
        $('#snp-q3-option-no').fadeIn(100);
        $('#snp-q3-option-yes').fadeOut(100);
    });


    $('#snp-q3-option-no-1').click(function () {
        $('#snp-q3-option-no-2-no').fadeOut(100);
    });

    $('#snp-q3-option-no-2').click(function () {
        $('#snp-q3-option-no-2-no').fadeIn(100);
    });


    $('#snp-q42').click(function () {
        $('#snp-q4-yes').fadeOut(100);
    });

    $('#snp-q41').click(function () {
        $('#snp-q4-yes').fadeIn(100);
    });

    $('#snp-q52').click(function () {
        $('#snp-q5-yes-options').fadeOut(100);
    });

    $('#snp-q51').click(function () {
        $('#snp-q5-yes-options').fadeIn(100);
    });
});
