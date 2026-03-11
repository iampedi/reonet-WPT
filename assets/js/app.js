let j = jQuery.noConflict();

j(document).ready(function () {
  // Carousel Initialization
  if (j(".owl-carousel").length) {
    const owl = j(".owl-carousel").owlCarousel({
      loop: true,
      margin: 10,
      dots: false,
      nav: true,
      items: 1,
      autoplay: false,
      autoplayHoverPause: false,
    });

    j(".next-btn").on("click", function () {
      owl.trigger("next.owl.carousel");
      owl.trigger("stop.owl.autoplay");
    });

    j(".prev-btn").on("click", function () {
      owl.trigger("prev.owl.carousel");
      owl.trigger("stop.owl.autoplay");
    });

    owl.trigger("stop.owl.autoplay");
  }

  // To Top Script
  const button = document.querySelector(".to-top");

  if (button) {
    const updateButton = () => {
      const scrollTop = window.scrollY;
      const windowHeight = window.innerHeight;
      const docHeight = document.documentElement.scrollHeight;
      const distanceToBottom = docHeight - (scrollTop + windowHeight);

      button.style.display = scrollTop > 800 ? "block" : "none";

      const stopAt = window.innerWidth <= 768 ? 215 : 515;

      if (distanceToBottom <= stopAt) {
        button.classList.add("stop");
      } else {
        button.classList.remove("stop");
      }
    };

    window.addEventListener("scroll", updateButton);
    window.addEventListener("resize", updateButton);

    button.addEventListener("click", () => {
      window.scroll({
        top: 0,
        behavior: "smooth",
      });
    });

    updateButton();
  }

  // Menu Item Active
  const cUrl = window.location.href;
  j(".fi-menu li a").each(function () {
    const targetUrl = j(this).attr("href");
    if (targetUrl && cUrl.indexOf(targetUrl) !== -1) {
      j(this).addClass("active");
    }
  });

  // AJAX Contact Form
  j("#ct-form").on("submit", function (e) {
    e.preventDefault();

    const form = j(this);
    const formData = form.serialize();
    const action = "register_ct_form";

    j.ajax({
      url: "/wp-admin/admin-ajax.php",
      type: "POST",
      data: formData + "&action=" + action,
      success: function () {
        alert("We received your message");
        form[0].reset();
      },
      error: function () {
        alert("Something went wrong. Please try again.");
      },
    });
  });
});

function mobileMenu() {
  jQuery(".mobile-menu").toggleClass("hidden");
}
