let j = jQuery.noConflict();

j(document).ready(function () {
  // Carousel
  var owl = j(".owl-carousel").owlCarousel({
    loop: true,
    margin: 10,
    dots: false,
    nav: true,
    items: 1,
    autoplay: true,
    autoplayTimeout: 4000,
    autoplayHoverPause: true,
  });

  j(".next-btn").click(function () {
    owl.trigger("next.owl.carousel");
  });
  j(".prev-btn").click(function () {
    owl.trigger("prev.owl.carousel");
  });
  j(".prev-btn").addClass("disabled");
  j(owl).on("translated.owl.carousel", function (event) {
    if (j(".owl-prev").hasClass("disabled")) {
      j(".prev-btn").addClass("disabled");
    } else {
      j(".prev-btn").removeClass("disabled");
    }
    if (j(".owl-next").hasClass("disabled")) {
      j(".next-btn").addClass("disabled");
    } else {
      j(".next-btn").removeClass("disabled");
    }
  });

  // بقیه کدها همون قبلی
  if (window.innerWidth > 768) {
    const button = document.querySelector(".to-top");
    const displayButton = () => {
      window.addEventListener("scroll", () => {
        if (window.scrollY > 300) {
          button.style.display = "block";
        } else {
          button.style.display = "none";
        }
      });
    };
    const scrollToTop = () => {
      button.addEventListener("click", () => {
        window.scroll({
          top: 0,
          left: 0,
          behavior: "smooth",
        });
      });
    };
    displayButton();
    scrollToTop();
  }

  // Menu Item Active
  j(function () {
    var cUrl = window.location.href;
    j(".fi-menu li a").each(function () {
      var targetUrl = j(this).attr("href");
      if (cUrl.indexOf(targetUrl) !== -1) {
        j(this).addClass("active");
      }
    });
  });
  j("#ct-form").on("submit", function (e) {
    e.preventDefault();
    let form_data = j(this).serialize();
    let action = "register_ct_form";
    j.ajax({
      url: "/wp-admin/admin-ajax.php",
      type: "POST",
      data: form_data + "&action=" + action,
      success: function (data) {
        alert("we received your message");
      },
    });
  });
});

function mobileMenu() {
  jQuery(".mobile-menu").toggleClass("hidden");
}
