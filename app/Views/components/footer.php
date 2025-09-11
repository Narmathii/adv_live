<!-- footer begin -->
<footer class="text-light">
    <div class="container  mw-100 m-0">
        <div class="row g-custom-x">
            <div class="col-lg-2 footersm">
                <a href="<?php echo base_url() ?>"><img
                        src="<?php echo base_url() ?>public/assets/images/logo-whiteBorder.png" class="jarallax-img"
                        alt="" width="150"></a>
            </div>
            <div class="col-lg-3">
                <div class="widget p-sm-0">
                    <h5>About</h5>
                    <p>We provide the best camping, riding and motorcycle accessories in Coimbatore. Retail store &
                        Wholesale.</p>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="widget p-sm-0">
                    <h5>Contact Info</h5>
                    <address class="s1">
                        <span><i class="id-color fa fa-map-marker fa-lg"></i>Sri Saaraa Towers,6-9, Dr, Balasundaram
                            Rd,<span class="footer_address"> Coimbatore - 641018, Tamil Nadu , India</span></span>
                        <span><i class="id-color fa fa-phone fa-lg"></i>+91-7358992528</span>
                        <span><i class="id-color fa fa-envelope-o fa-lg"></i>
                            <a href="mailto:abhishek@adventureshoppe.com">abhishek@adventureshoppe.com</a></span>
                    </address>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="widget m-0 p-sm-0">
                    <h5>Social Network</h5>
                    <div class="socialmedia_links">
                        <a href="https://www.instagram.com/ridersranchcoimbatore/?igsh=MWxnZmJldmZmdDdq#"><i
                                class="fa fa-instagram fa-lg"></i></a>
                        <a href="https://www.facebook.com/share/1AdUYKNcPB/"><i class="fa fa-facebook-f"></i></a>
                        <!-- <i class="fa fa-whatsapp"></i> -->
                        <!-- <i class="fa fa-youtube"></i>
                        <i class="fa-brands fa-youtube"> -->

                        <a href="https://www.youtube.com/@adventureshoppe3772?si=t6L5pC2zHRb4z1-i"><i
                                class="youtube_link"><img
                                    src="<?php echo base_url() ?>public/assets/images/icons/youtube.svg" alt=""></i></a>

                        <!-- <si><span aria-hidden="true" class="icon-facebook"></span></si> -->
                    </div>
                    <!-- <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook" style="size:30px"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                    </div> -->
                </div>
            </div>

        </div>
    </div>
    <div class="subfooter">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="de-flex">
                        <div class="de-flex-col">
                            <a href="hello:;">
                                Copyright 2024
                            </a>
                        </div>
                        <ul class="menu-simple">
                            <li><a href="<?php echo base_url() ?>contact-us">Contact Us</a></li>
                            <li><a href="<?php echo base_url() ?>terms-conditions">Terms &amp; Conditions</a></li>
                            <li><a href="<?php echo base_url() ?>privacy-policy">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer close -->

<!-- Javascript Files================================================== -->


<script src="https://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/owl.carousel.min.js"></script>
<script src="<?php echo base_url() ?>public/assets/js/plugins.js"></script>
<script src="<?php echo base_url() ?>public/assets/js/designesia.js"></script>
<script src="<?php echo base_url() ?>public/assets/js/custom.js"></script>


<!--TOAST CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>

<!-- Bootsrap 5 js  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script src="<?php echo base_url() ?>public/assets/custom/detail.js"></script>
<script src="<?php echo base_url() ?>public/assets/custom/globalwishlist.js"></script>

<!-- <script src="<?php echo base_url() ?>public/assets/custom/buynow.js"></script> -->

<!-- SWEETALERTS JS -->
<script src="<?php echo base_url() ?>assets/admin/build/assets/libs/sweetalert2/sweetalert2.min.js"></script>


<link rel="modulepreload" href="<?php echo base_url() ?>assets/admin/build/assets/sweet-alerts-ccdc3280.js" />
<script type="module" src="<?php echo base_url() ?>assets/admin/build/assets/sweet-alerts-ccdc3280.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>


<script>
    $(window).on('load', function () {
        $('#status').fadeIn();
        $('#preloaderr').delay(350).fadeOut('slow');
        $('body').delay(350).css({ 'overflow': 'visible' });
    })
</script>


<!-- price slider -->
<script>
    function setupSliders(minSliderId, maxSliderId, minValueId, maxValueId, priceFieldId) {

        var lowerSlider = document.querySelector(minSliderId);
        var upperSlider = document.querySelector(maxSliderId);
        var priceField = document.querySelector(priceFieldId);
        // Set initial values
        document.querySelector(minValueId).value = lowerSlider.value;
        document.querySelector(maxValueId).value = upperSlider.value;

        // Function to update the track background color based on slider values
        function updateBackground() {
            var lowerVal = parseInt(lowerSlider.value);
            var upperVal = parseInt(upperSlider.value);
            var maxVal = parseInt(lowerSlider.max);

            // Calculate percentage positions for both sliders
            var lowerPercent = (lowerVal / maxVal) * 100;
            var upperPercent = (upperVal / maxVal) * 100;

            // Set the background color of the slider track
            priceField.style.background = `linear-gradient(to right, #ccc ${lowerPercent}%,#829b2f ${lowerPercent}%, #829b2f ${upperPercent}%,#ccc ${upperPercent}%)`;
            priceField.style.height = `4px`;
        }

        // Function to update the values and background
        function updateValues() {
            var lowerVal = parseInt(lowerSlider.value);
            var upperVal = parseInt(upperSlider.value);

            // Ensure the upper slider is not below the lower slider
            if (upperVal < lowerVal + 4) {
                lowerSlider.value = upperVal - 4;
                if (lowerVal == lowerSlider.min) {
                    upperSlider.value = 4;
                }
            }

            // Update the displayed values
            document.querySelector(maxValueId).value = upperSlider.value;
            updateBackground();
        }

        // Lower slider input event
        lowerSlider.oninput = function () {
            var lowerVal = parseInt(lowerSlider.value);
            var upperVal = parseInt(upperSlider.value);
            if (lowerVal > upperVal - 4) {
                upperSlider.value = lowerVal + 4;
                if (upperVal == upperSlider.max) {
                    lowerSlider.value = parseInt(upperSlider.max) - 4;
                }
            }
            document.querySelector(minValueId).value = lowerSlider.value;
            updateValues();
        };

        // Upper slider input event
        upperSlider.oninput = function () {
            updateValues();
        };

        // Initial background update
        updateBackground();
    }

    // Initialize sliders
    var width = $(window).width();
    if (width <= 768) {
        setupSliders('#mob_min_val', '#mob_max_val', '#mob_one', '#mob_two', '.price-field.mobile-view input[type="range"]');
    } else {
        setupSliders('#web_min_val', '#web_max_val', '#web_one', '#web_two', '.price-field.web-view input[type="range"]');
    }


</script>

<script>

    $(document).ready(function () {
        $(document).on('click', function (event) {
            if (
                !$(event.target).closest('#search_bar').length &&
                !$(event.target).closest('#suggestionsBox').length
            ) {
                $('#suggestionsBox').empty().addClass('d-none');
            }
        })

    })

    function fetchSuggestions() {
        var searchText = $('#search_bar').val().trim();

        if (searchText.length > 0) {
            $.ajax({
                url: base_Url + 'get-search-suggestions',
                type: 'GET',
                data: { query: searchText },
                success: function (response) {
                    displaySuggestions(response);
                },
                error: function () {
                    $('#suggestionsBox').html('Error fetching suggestions');
                }
            });
        } else {
            $('#suggestionsBox').empty();
        }
    }

    function displaySuggestions(suggestions) {
        var suggestionsBox = $('#suggestionsBox');
        suggestionsBox.empty();

        if (suggestions.length > 0) {
            suggestions.forEach(function (suggestion) {
                const redirectUrl = suggestion.redirect_url
                    .toLowerCase()
                    .replace(/\s+/g, '-');

                const encodedId = btoa(suggestion.prod_id);

                let url = "#";
                switch (suggestion.tbl_name) {
                    case "tbl_products":
                        url = `${base_Url}detail/${redirectUrl}/${encodedId}`;
                        break;
                    case "tbl_accessories_list":
                        url = `${base_Url}accessories-detail/${redirectUrl}/${encodedId}`;
                        break;
                    case "tbl_rproduct_list":
                        url = `${base_Url}riding-details/${redirectUrl}/${encodedId}`;
                        break;
                    case "tbl_helmet_products":
                        url = `${base_Url}helmet-details/${redirectUrl}/${encodedId}`;
                        break;
                    case "tbl_luggagee_products":
                        url = `${base_Url}tour-detail/${redirectUrl}/${encodedId}`;
                        break;
                    case "tbl_camping_products":
                        url = `${base_Url}camp-details/${redirectUrl}/${encodedId}`;
                        break;
                }

                let searchResHtml = $(`
                    <a href="${url}" class="suggestion-link">
                        <div class="suggestion">
                            <img class="suggestion-img" src="${base_Url + suggestion.product_img}" alt="${suggestion.product_name}" />
                            <p>${suggestion.product_name}</p>
                        </div>
                    </a>
                `);

                // Attach click event properly
                searchResHtml.on('click', function () {
                    $('#search_bar').val(suggestion.product_name);
                    $('#suggestionsBox').empty();
                });

                suggestionsBox.removeClass("d-none");
                suggestionsBox.append(searchResHtml);
            });
        } else {
            suggestionsBox.removeClass('d-none');
            suggestionsBox.html('<div class="no-suggestions">No suggestions found</div>');
        }
    }
</script>



<!-- To scroll search suggestions -->
<script>
    const suggestionsBox = document.getElementById("suggestionsBox");

    suggestionsBox.addEventListener("wheel", function (e) {
        const scrollTop = this.scrollTop;
        const scrollHeight = this.scrollHeight;
        const height = this.clientHeight;
        const delta = e.deltaY;

        // Prevent page scroll when suggestions box can still scroll
        if (
            (delta > 0 && scrollTop + height < scrollHeight) ||
            (delta < 0 && scrollTop > 0)
        ) {
            e.preventDefault();
            this.scrollTop += delta;
        }
    });


</script>