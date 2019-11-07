function change_mymenu(a) {
    window.location = site_url + a;
}

function windowWidth() {
    if ($(window).width() > 991) {
        $(".hdr-container").addClass("full-container");
        $(".hdr-container").removeClass("container");
    }
    if ($(window).width() < 991) {
        $(".hdr-container").removeClass("full-container");
        $(".hdr-container").addClass("container");
    }
}

$(function() {
    windowWidth();
    $(window).bind("resize", function() {
        if ($(window).width() > 991) {
            $(".hdr-container").addClass("full-container");
            $(".hdr-container").removeClass("container");
        }
        if ($(window).width() < 991) {
            $(".hdr-container").removeClass("full-container");
            $(".hdr-container").addClass("container");
        }
    });
    $(".click-search").click(function() {
        $(".input-search").addClass("open-search");
    });
	$('#home-banner.owl-carousel').owlCarousel({
		slideSpeed : 300,
		paginationSpeed : 400,
		singleItem:true,
		autoPlay: true,
		pagination : false,
		paginationNumbers: false
	});
    $("html").click(function(a) {
        if (!$(a.target).is(".input-search") && !$(a.target).parents().is(".click-search") && !$(a.target).is(".search-inline")) $(".input-search").removeClass("open-search");
    });
    $(window).scroll(function() {
        var a = $(window).scrollTop();
        if (a >= 10) {
            $(".h100").css("height", "70px");
            $(".img-logo img").css("height", "40px");
        } else {
            $(".h100").css("height", "100px");
            $(".img-logo img").css("height", "45px");
        }
    });
    $("html").click(function(a) {
        if (!$(a.target).is(".toggle-menu") && !$(a.target).parents().is(".toggle-menu") && !$(a.target).is("#offcanvas-menu") && !$(a.target).parents().is("#offcanvas-menu")) {
            $("body").removeClass("offcanvas-menu-open");
            $(".bg-dark").hide();
            $(".bg-dark").animate({
                opacity: 0
            });
        }
    });
    $(document).keyup(function(a) {
        if (27 == a.keyCode) {
            $("body").removeClass("offcanvas-menu-open");
            $(".bg-dark").hide();
            $(".bg-dark").animate({
                opacity: 0
            });
        }
    });
    $(".close-menu").click(function(a) {
        a.preventDefault();
        $("body").removeClass("offcanvas-menu-open");
        $(".bg-dark").hide();
        $(".bg-dark").animate({
            opacity: 0
        });
    });
    $(".toggle-menu").click(function(a) {
        a.preventDefault();
        $("body").toggleClass("offcanvas-menu-open");
        $(".bg-dark").show();
        $(".bg-dark").animate({
            opacity: .85
        });
    });
    $(".search-toggle").click(function() {
        $("#tsearch").stop(true, true).fadeIn().find('input[type="text"]').focus();
    });
    $("html").click(function(a) {
        if (!$(a.target).is("#tsearch") && !$(a.target).is(".search-toggle") && !$(a.target).is(".text-hdr") && !$(a.target).is(".search-toggle img") && !$(a.target).is("#tsearch input")) $("#tsearch").stop(true, true).fadeOut();
    });
    $(".dropdown-listmenu").click(function() {
        $(this).next().slideToggle("fast");
        $(this).toggleClass("active");
    });
    $(".index-slider.owl-carousel").owlCarousel({
        slideSpeed: 300,
        paginationSpeed: 300,
        singleItem: true,
        autoPlay: true,
        pagination: false,
        paginationNumbers: false
    });
    $("ul.tabs li").click(function() {
        var a = $(this).attr("data-tab");
        $("ul.tabs li").removeClass("current");
        $(".tab-content").removeClass("current");
        $(this).addClass("current");
        $("#" + a).addClass("current");
    });
    $("ul.tabs-color li").click(function() {
        var a = $(this).attr("data-tab");
        $("ul.tabs-color li").removeClass("current");
        $(".content-img").removeClass("current");
        $(this).addClass("current");
        $("." + a).addClass("current");
    });
    $("#accordion").accordion({
        collapsible: true,
        active: false
    });
    var a;
    $(".cart-link").hover(function() {
		if($('.hide1300').siblings().html() != 0){
			$(".hover-cart").show();
		}
    }, function() {
        a = setTimeout(function() {
            $(".hover-cart").fadeOut(500);
        }, 2e3);
    });
    $(".btn-link").click(function(a) {

    });
    $(".jspane").each(function() {
        $(this).jScrollPane({
            autoReinitialise: true,
            contentWidth: "0px"
        });
    });
    $(".fancybox").fancybox();
    $(document).on("keydown", function(a) {
        if (27 === a.keyCode) $.fancybox.close();
    });
    $(".close-fancy").click(function(a) {
        $.fancybox.close();
    });
    $('input[name="same_address"]').click(function() {
        if ($(this).is(":checked")) $(".same_address").stop(true, true).slideUp(); else $(".same_address").stop(true, true).slideDown();
    });
    $("#table-order").DataTable();
    $("ul.tab-payment li").click(function() {
        var a = $(this).attr("data-tab");
        $("ul.tab-payment li").removeClass("current");
        $(".content-payment").removeClass("current");
        $(this).addClass("current");
        $("#" + a).addClass("current");
    });
    $(".txtboxToFilter").keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});
    $(".imagezoom img").ImageZoom();
    $("ul.tab-detail li").click(function() {
        var a = $(this).attr("data-tab");
        $("ul.tab-detail li").removeClass("current");
        $(".detail-content").removeClass("current");
        $(this).addClass("current");
        $("#" + a).addClass("current");
    });
    $(".button-subscribed").click(function(a) {
        $.fancybox.close();
        $(".box-subscribed").hide();
        $(".box-unsubscribed").show();
    });
    $(".button-unsubscribed").click(function(a) {
        $.fancybox.close();
        $(".box-subscribed").show();
        $(".box-unsubscribed").hide();
    });
    $(".center-full, .tbl-banner").height($(window).height());
});

function custom_select(a) {
    el = $(a);
    if (0 != el.find("option:selected")) text = el.find("option:selected").text(); else text = el.siblings(".replacement").attr("data-text");
    el.siblings(".replacement").html(text);
}
