<!DOCTYPE html>
<?php
require("components/head.php");
?>
<style>
    /* Pagination Container */
    .pagination-list {
        display: flex;
        list-style: none;
        justify-content: end;
        padding: 0;
        margin: 20px 0;
    }

    /* Pagination Items */
    .pagination-item {
        margin: 0 5px;
    }

    /* Pagination Links */
    .pagination-link,
    .pagination-link-default {
        display: inline-block;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        color: #a4c735;
        text-decoration: none;
        background-color: #fff;
        transition: all 0.3s ease;
    }

    /* Hover State */
    .pagination-link:hover,
    .pagination-link-default:hover {
        background-color: #a4c735;
        color: #fff;
    }

    /* Active Page */
    .pagination-link.active,
    .pagination-link-default.active {
        background-color: #a4c735;
        color: #fff;
        border-color: #a4c735;
    }

    /* Responsive Styling */
    @media (max-width: 768px) {

        /* Reduce padding and font size for smaller screens */
        .pagination-link,
        .pagination-link-default {
            padding: 5px 8px;
            font-size: 14px;
        }
    }

    @media (max-width: 576px) {

        /* Show fewer pagination links on small screens */
        .pagination-list {
            overflow-x: auto;
            /* Allow horizontal scrolling */
            white-space: nowrap;
        }

        .pagination-item {
            display: inline-block;
        }
    }



    #products_page .de-item .d-img img {
        background-color: #fff;
        aspect-ratio: 4 / 2.7;
        width: 100%;
        object-fit: contain;
    }

    .productCard .d-img {
        padding: 10px;
    }

    .orderby,
    .discount,
    .orderby_web,
    .orderby_mob,
    .discount_mob {

        width: 100%;
        padding: 1.5%;
        color: #000;
        border-radius: 10px;
    }

    .orderby>option,
    .discount>option,
    .orderby_web>option,
    .orderby_mob>option,
    .discount_mob>option {
        color: #000 !important
    }
</style>

<body id="products_page" class="dark-scheme">
    <?php
    require("components/header.php");
    ?>
    <!-- content begin -->

    <div class="no-bottom no-top zebra">
        <section id="section-newArrivalView" class="products_wrapper px-5">
            <div class="container access_list_grid">
                <h2 class="text-center mb-4">Hot Sale Products</h2>
                <div class="row">
                    <!-- mobile view filter -->
                    <span class="filter_sm d-lg-none">
                        <button type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                            aria-controls="offcanvasRight"><i class="fa fa-filter"
                                aria-hidden="true"></i>Filter</button>
                    </span>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
                        aria-labelledby="offcanvasRightLabel">
                        <div class="offcanvas-header">
                            <h5 id="offcanvasRightLabel" class="mb-0">Filter</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div class="item_filter_group">
                                <h4>Price (₹)</h4>
                                <fieldset class="filter-price">
                                    <div class="price-field price-field mobile-view">
                                        <input type="range" min="0" class="input-min common_selector" max="50000"
                                            value="0" id="mob_min_val" readonly>
                                        <input type="range" min="0" class="input-max common_selector" max="50000"
                                            value="50000" id="mob_max_val" readonly>
                                    </div>
                                    <div class="price-wrap">
                                        <div class="price-wrap-1">

                                            <input id="mob_one">
                                            <label for="one"></label>
                                        </div>
                                        <div class="price-wrap_line">-</div>

                                        <div class="price-wrap-2">

                                            <input id="mob_two">
                                            <label for="two"></label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="item_filter_group">
                                <h4>Sort By</h4>
                                <select class="common_selector orderby_mob" aria-label="Default select example">
                                    <option value="0">Select Option</option>
                                    <option value="ASC">Order by A-Z</option>
                                    <option value="DESC">Order by Z-A</option>
                                    <option value="LOW">Low to High</option>
                                    <option value="HIGH">High to Low</option>
                                </select>
                            </div>


                            <div class="item_filter_group">
                                <h4>Discount</h4>
                                <select class="common_selector discount_mob" aria-label="Default select example">
                                    <option value="0">Select Discount</option>
                                    <option value="10">10% or more</option>
                                    <option value="20">20% or more</option>
                                    <option value="30">30% or more</option>
                                    <option value="40">40% or more</option>
                                </select>
                            </div>


                            <div class="item_filter_group">
                                <h4>Availabilty</h4>
                                <div class="de_form">
                                    <div class="de_checkbox">
                                        <input class="common_selector available" id="available-mob" name="available-mob"
                                            type="checkbox" value="1">
                                        <label for="available-mob">Available</label>
                                    </div>

                                    <div class="de_checkbox">
                                        <input class="common_selector available" id="outofstock-mob"
                                            name="outofstock-mob" type="checkbox" value="0">
                                        <label for="outofstock-mob">Out Of Stock</label>
                                    </div>


                                </div>
                            </div>
                            <div class="item_filter_group">
                                <h4>Brands</h4>
                                <div class="de_form">
                                    <?php for ($i = 0; $i < count($search_brand); $i++) { ?>
                                        <div class="de_checkbox">

                                            <input class="common_selector table_name" id="table_name<?php echo $i ?>"
                                                name="table_name" type="checkbox"
                                                value="<?php echo $search_brand[$i]['tbl_name'] ?>">

                                            <input class="common_selector brand" id="mob_search_brand_<?php echo $i ?>"
                                                name="brand[]" type="checkbox"
                                                value="<?php echo $search_brand[$i]['search_brand'] ?>">
                                            <label
                                                for="mob_search_brand_<?php echo $i ?>"><?php echo $search_brand[$i]['brand_name'] ?></label>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>
                    </div>


                    <!-- web view filter -->
                    <div class="col-lg-3 filter_lg">
                        <div class="item_filter_group">
                            <h3>Price (₹)</h3>
                            <fieldset class="filter-price">
                                <div class="price-field web-view">
                                    <input type="range" min="0" class="input-min common_selector" max="50000" value="0"
                                        id="web_min_val">
                                    <input type="range" min="0" class="input-max common_selector" max="50000"
                                        value="50000" id="web_max_val">
                                </div>
                                <div class="price-wrap">
                                    <div class="price-wrap-1">
                                        <input id="web_one">
                                        <label for="one"></label>
                                    </div>
                                    <div class="price-wrap_line">-</div>
                                    <div class="price-wrap-2">
                                        <input id="web_two">
                                        <label for="two"></label>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="item_filter_group">
                            <h3>Sort By</h3>
                            <select class="common_selector orderby_web" aria-label="Default select example">
                                <option value="0">Select Option</option>
                                <option value="ASC">Order by A-Z</option>
                                <option value="DESC">Order by Z-A</option>
                                <option value="LOW">Low to High</option>
                                <option value="HIGH">High to Low</option>
                            </select>
                        </div>


                        <div class="item_filter_group">
                            <h3>Discount</h3>
                            <select class="common_selector discount" aria-label="Default select example">
                                <option value="0">Select Discount</option>
                                <option value="10">10% or more</option>
                                <option value="20">20% or more</option>
                                <option value="30">30% or more</option>
                                <option value="40">40% or more</option>
                            </select>
                        </div>


                        <div class="item_filter_group">
                            <h3>Availabilty</h3>
                            <div class="de_form">
                                <div class="de_checkbox">
                                    <input class="common_selector available" id="web_available" name="web_available"
                                        type="checkbox" value="1">
                                    <label for="web_available">Available</label>
                                </div>

                                <div class="de_checkbox">
                                    <input class="common_selector available" id="web_outofstock" name="web_outofstock"
                                        type="checkbox" value="0">
                                    <label for="web_outofstock">Out Of Stock</label>
                                </div>


                            </div>
                        </div>
                        <div class="item_filter_group">
                            <h3>Brands</h3>
                            <div class="de_form">
                                <?php for ($i = 0; $i < count($search_brand); $i++) { ?>
                                    <div class="de_checkbox">
                                        <input class="common_selector brand" id="web_search_brand_<?php echo $i ?>"
                                            name="brand[]" type="checkbox"
                                            value="<?php echo $search_brand[$i]['search_brand'] ?>">
                                        <label
                                            for="web_search_brand_<?php echo $i ?>"><?php echo $search_brand[$i]['brand_name'] ?></label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="row seach_results">
                          <!-- Dynamic Data = -->

                        </div>

                        <input type="hidden" id="total_page" value="<?= $total_page ?>">
                        <div class="col-lg-12">
                            <div class="pagination-container" id="pagination-container">

                            </div>
                        </div>

                        <input type="hidden" id="sub_id" data-subid="<?= $sub_id ?>">

                      
                    </div>
                </div>
            </div>
        </section>


        <!-- content close -->
        <?php
        require("components/footer.php");
        ?>

    
         <script>
            $(document).ready(function () {
                if (performance.navigation.type === performance.navigation.TYPE_RELOAD) {
                    history.replaceState(null, '', window.location.pathname);
                }

                 const page = setFiltersFromURL();
               filter_data(page);

                $('.common_selector').click(function () {
                    filter_data(1);
                });

                $('.common_selector').change(function () {
                    filter_data(1);
                });


                function scrollToTop() {
                    const target = $(".seach_results");
                    if (target.length > 0) {
                        $('html, body').stop().animate({
                            scrollTop: target.offset().top - 250
                        }, 500, 'swing');
                    }
                }


                function get_filter(class_name) {
                    const values = new Set();
                    $('.' + class_name + ':checked').each(function () {
                        values.add($(this).val());
                    });
                    return Array.from(values);
                }

                // --- Update URL with filters and page ---
                function updateURLWithFilters(page = 1) {
                    const newParams = new URLSearchParams();

                    const available = get_filter('available');
                    const brand = get_filter('brand');
                    const discount = $('.discount').val();
                    const orderby_web = $('.orderby_web').val();
                    const orderby_mob = $('.orderby_mob').val();
                    const discount_mob = $('.discount_mob').val();

                   

                    available.forEach(val => {
                        if (!newParams.getAll('available[]').includes(val)) {
                            newParams.append('available[]', val);
                        }
                    });
                    brand.forEach(val => {
                        if (!newParams.getAll('brand[]').includes(val)) {
                            newParams.append('brand[]', val);
                        }
                    });
                    if (discount) newParams.set('discount', discount);
                    if (orderby_web) newParams.set('orderby_web', orderby_web);

                    if (discount_mob) newParams.set('discount_mob', discount_mob);
                    if (orderby_mob) newParams.set('orderby_mob', orderby_mob);
                    newParams.set('page', page);


                    const currentParams = new URLSearchParams(window.location.search);
                    let shouldUpdate = false;


                    const keys = ['available[]', 'brand[]', 'discount', 'orderby_web', 'discount_mob', 'orderby_mob', 'page'];

                    for (let key of keys) {
                        const currentVals = [...new Set(currentParams.getAll(key))].sort();
                        const newVals = [...new Set(newParams.getAll(key))].sort();

                        if (currentVals.length !== newVals.length ||
                            currentVals.some((val, i) => val !== newVals[i])) {
                            shouldUpdate = true;
                            break;
                        }
                    }


                    if (shouldUpdate) {
                        const newURL = `${window.location.pathname}?${newParams.toString()}`;
                        history.pushState(null, '', newURL);
                        filter_data(page);
                    }
                }


                // --- Set filters and page number from URL ---
                function setFiltersFromURL() {
                    const params = new URLSearchParams(window.location.search);
                    const page = parseInt(params.get('page')) || 1;

                    // Available filter checkboxes
                    const available = params.getAll('available[]');
                    $('.common_selector[name="available[]"]').each(function () {
                        $(this).prop('checked', available.includes($(this).val()));
                    });

                    // Brand filter checkboxes
                    const brand = params.getAll('brand[]');
                    $('.common_selector[name="brand[]"]').each(function () {
                        $(this).prop('checked', brand.includes($(this).val()));
                    });

                    // Dropdown values
                    $('.discount').val(params.get('discount') || '');
                    $('.orderby_web').val(params.get('orderby_web') || '');

                    $('.discount_mob').val(params.get('discount_mob') || '');
                    $('.orderby_mob').val(params.get('orderby_mob') || '');


                    return page;
                }

                // --- Filter and Load Products ---
                function filter_data(page = 1) {
                    updateURLWithFilters(page);

                    const width = $(window).width();
                    let minimum_price, maximum_price;

                    if (width <= 768) {
                        minimum_price = $('#mob_min_val').val();
                        maximum_price = $('#mob_max_val').val();
                    } else {
                        minimum_price = $('#web_min_val').val();
                        maximum_price = $('#web_max_val').val();
                    }

                    const available = get_filter('available');
                    const brand = get_filter('brand');
                    const orderby_web = $('.orderby_web').val();
                    const orderby_mob = $('.orderby_mob').val();
                    const discount = $('.discount').val();
                    const discount_mob = $('.discount_mob').val();
                    const tablename = 'tbl_helmet_products';
                    const submenu_id = $('.submenuid').val();
                    const action = 'fetch_data';

                    $.ajax({
                        url: `${base_Url}hotsale-filter/${page}`,
                        type: "POST",
                        dataType: "json",
                        data: {
                            minimum_price,
                            maximum_price,
                            available,
                            brand,
                            orderby_web,
                            tablename,
                            submenu_id,
                            discount,
                            orderby_mob,
                            discount_mob,
                            action
                        },
                        success: function (data) {
                            const count = data.products.length;
                            const totalPages = data.pagination.length;

                          
                            let searchResults = "";

                            if (count <= 0) {
                                searchResults = `
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12 text-center newarrival_header">
                                        <h3 class="no-product">Currently, there are no products available!!!.</h3>
                                    </div>
                                </div>
                            </div>`;
                                $('.seach_results').html(searchResults);
                                $('#pagination-container').addClass('d-none');
                            } else {
                                const formatter = new Intl.NumberFormat('en-US', {
                                    style: 'currency',
                                    currency: 'INR',
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                });

                                data.products.forEach(product => {
                                    const redirectUrl = product.redirect_url.toLowerCase().replace(/[/ ]/g, '-');
                                    const prodId = btoa(product.prod_id);
                                    const formattedPrice = formatter.format(product.offer_price);
                                    const stockStatus = product.quantity <= 0 ? 'Out of stock' : 'Available';
                                    const MRPPrice = product.product_price;
                                    const formatMRP = formatter.format(MRPPrice);
                                    const offerPrice = product.offer_price;
                                    const formatOffer = formatter.format(offerPrice);
                                    let stock = product.quantity;

                                    let offerClass = (product.offer_details == 1 || product.offer_details == 2 || product.offer_details == "" || product.offer_details == 0 || product.offer_details == "-") ? "d-none" : "";
                                    let piceClassname = (MRPPrice === offerPrice) ? 'd-none' : '';

                                    let tblName = product.tbl_name;
                                    let url = '';
                                    if (tblName) {
                                        if (tblName === "tbl_products") {
                                            url = base_Url + "detail/" + product.redirect_url.toLowerCase().replace(/[/ ]/g, '-') + "/" + btoa(product.prod_id);
                                        } else if (tblName === "tbl_accessories_list") {
                                            url = base_Url + "accessories-detail/" + product.redirect_url.toLowerCase().replace(/[/ ]/g, '-') + "/" + btoa(product.prod_id);
                                        } else if (tblName === "tbl_rproduct_list") {
                                            url = base_Url + "riding-details/" + product.redirect_url.toLowerCase().replace(/[/ ]/g, '-') + "/" + btoa(product.prod_id);
                                        } else if (tblName === "tbl_helmet_products") {
                                            url = base_Url + "helmet-details/" + product.redirect_url.toLowerCase().replace(/[/ ]/g, '-') + "/" + btoa(product.prod_id);
                                        } else if (tblName === "tbl_luggagee_products") {
                                            url = base_Url + "tour-detail/" + product.redirect_url.toLowerCase().replace(/[/ ]/g, '-') + "/" + btoa(product.prod_id);
                                        } else if (tblName === "tbl_camping_products") {
                                            url = base_Url + "camp-details/" + product.redirect_url.toLowerCase().replace(/[/ ]/g, '-') + "/" + btoa(product.prod_id);
                                        }
                                    }
                                    //redirect url end
                                    let buyNow = "";
                                    if (stock <= 0) {
                                        buyNow += `
                                                <div>
                                                    <a class="btn-main buynow_btn"
                                                        href="https://wa.me/7358992528?text=${encodeURIComponent("Welcome to Adventure Shoppe!\nProduct Name: " + product.product_name + "\nProduct Price: " + product.offer_price)}">
                                                        Contact us to order
                                                    </a>
                                                </div>
                                            `;
                                    }
                                    else {
                                        buyNow += `
                                                <div>
                                                    <a class="btn-main buynow_btn"
                                                        href="${url}">
                                                        Buy Now
                                                    </a>
                                                </div>
                                            `;
                                    }



                                    searchResults += `
                                <div class="col-12 col-lg-3 productCard my-4">
                                    <form>
                                        <div class="de-item">
                                            <span class="discount-tag ${offerClass}">${product.offer_details}%<span class="off_span">off</span></span>
                                            <a><span aria-hidden="true" class="icon_heart_alt wishlist-icon"
                                                data-id="${product.prod_id}" tbl-name="${product.tbl_name}"></span></a>
                                            <div class="d-img">
                                                <a href="${url}">
                                                    <img src="${base_Url}${product.product_img}" alt="${product.product_name}"/>
                                                </a>
                                            </div>
                                            <div class="d-info">
                                                <div class="d-text">
                                                    <h4>${product.product_name}</h4>
                                                    <span class="d-price">${formatOffer}
                                                        <small class="${piceClassname}" style="text-decoration:line-through">${formatMRP}</small>
                                                    </span>                                                    
                                                    <p class="d-flex wish-status my-2">
                                                        <span class="d-flex align-items-center">
                                                            <span class="product_status ${product.quantity <= 0 ? 'outof_stock' : ''}">
                                                                <label>${stockStatus}</label>
                                                            </span>
                                                        </span>
                                                    </p>
                                                    ${buyNow}
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>`;
                                });

                                $('.seach_results').html(searchResults);

                                if (count >= 12 || (totalPages === 1 && count > 12) || (totalPages >1  && count <= 12 )) {
                                    $("#pagination-container-default").addClass("d-none");
                                    $('#pagination-container').html("");
                                    renderPagination(data, page);
                                }
                                else if (count <= 12 && page != 1) {
                                    renderPagination(data, page);
                                }
                                else {
                                    $("#pagination-container-default").addClass("d-none");
                                    $('#pagination-container').addClass("d-none");
                                }

                                $(".wishlist-icon").on('click', function () {
                                    let prod_id = $(this).data("id");
                                    let tbl_name = $(this).attr('tbl-name');

                                    $.ajax({
                                        type: "POST",
                                        url: `${base_Url}add-wishlist`,
                                        data: { prod_id, tbl_name },
                                        success: function (data) {
                                            let res = $.parseJSON(data);
                                            if (res.code === 200) {
                                                $.toast({
                                                    icon: "success",
                                                    heading: "Success",
                                                    text: res.msg,
                                                    position: "top-right",
                                                    bgColor: "#28292d",
                                                    loader: true,
                                                    hideAfter: 2000,
                                                    stack: false,
                                                    showHideTransition: "fade",
                                                });
                                                setTimeout(function () {
                                                    location.reload();
                                                }, 1000);
                                            } else {
                                                $.toast({
                                                    icon: "error",
                                                    heading: "Warning",
                                                    text: res.msg,
                                                    position: "top-right",
                                                    bgColor: "#res",
                                                    loader: true,
                                                    hideAfter: 2000,
                                                    stack: false,
                                                    showHideTransition: "fade",
                                                });
                                            }
                                        },
                                    });
                                });
                            }
                        }
                    });
                }

                // --- Render Pagination UI ---
                function renderPagination(data, currentPage) {

                    let paginationUI = '<ul class="pagination-list">';
                    data.pagination.forEach(function (pageLink) {
                        paginationUI += `
                    <li class="pagination-item">
                        <a href="#" class="pagination-link ${pageLink.page === currentPage ? 'active' : ''}" data-page="${pageLink.page}">
                            ${pageLink.label}
                        </a>
                    </li>`;
                    });
                    paginationUI += '</ul>';

                    $("#pagination-container").removeClass('d-none');
                    $('#pagination-container').html(paginationUI);
                    $('#pagination-container-default').html("");

                    $(".pagination-link").on('click', function (e) {
                        e.preventDefault();
                        const page = $(this).data("page");
                        filter_data(page);
                    });
                }

                // Handle browser back / forward navigation
                // window.onpopstate = function () {

                //     const page = setFiltersFromURL();
                //     console.log("back");
                //     console.log(page);
                //     filter_data(page);
                // };

            });


        </script>
</body>

</html>