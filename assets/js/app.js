let j = jQuery.noConflict();

j(document).ready(function () {
  const getWooFragmentsEndpoint = function () {
    if (
      typeof window.wc_cart_fragments_params !== "undefined" &&
      window.wc_cart_fragments_params.wc_ajax_url
    ) {
      return window.wc_cart_fragments_params.wc_ajax_url.replace(
        "%%endpoint%%",
        "get_refreshed_fragments"
      );
    }

    return `${window.location.origin}/?wc-ajax=get_refreshed_fragments`;
  };

  const refreshHeaderCartBadgeFromServer = function () {
    j.ajax({
      url: getWooFragmentsEndpoint(),
      type: "POST",
      success: function (response) {
        const badgeHtml = response?.fragments?.[".reonet-header-cart-count"];
        if (badgeHtml) {
          j(".reonet-header-cart-count").replaceWith(badgeHtml);
        }
      },
    });
  };

  const refreshHeaderCartBadge = function () {
    if (typeof window.wc_cart_fragments_params !== "undefined") {
      j(document.body).trigger("wc_fragment_refresh");
    } else {
      refreshHeaderCartBadgeFromServer();
    }

    const badge = j(".reonet-header-cart-count");
    const qtyInputs = j(".woocommerce-cart-form .qty");

    if (!badge.length || !qtyInputs.length) {
      return;
    }

    let total = 0;
    qtyInputs.each(function () {
      const qty = parseFloat(j(this).val());
      if (!Number.isNaN(qty) && qty > 0) {
        total += qty;
      }
    });

    badge.text(Math.round(total));
  };

  j(document.body).on(
    "updated_wc_div updated_cart_totals removed_from_cart added_to_cart wc_cart_emptied",
    refreshHeaderCartBadge
  );

  const ensureToastContainer = function () {
    let container = j("#reonet-toast-container");

    if (!container.length) {
      j("body").append(
        '<div id="reonet-toast-container" class="fixed bottom-4 left-4 z-[9999] flex w-[calc(100%-2rem)] max-w-sm flex-col gap-3 sm:bottom-6 sm:left-6"></div>'
      );
      container = j("#reonet-toast-container");
    }

    return container;
  };

  const getToastAppearance = function (type) {
    if (type === "error") {
      return {
        wrapper: "border-red-300 bg-red-50 text-red-800",
        icon: "ph-warning-octagon text-red-600",
      };
    }

    if (type === "warning") {
      return {
        wrapper: "border-amber-300 bg-amber-50 text-amber-800",
        icon: "ph-warning-circle text-amber-600",
      };
    }

    if (type === "success") {
      return {
        wrapper: "border-green-300 bg-green-50 text-green-800",
        icon: "ph-check-circle text-green-600",
      };
    }

    return {
      wrapper: "border-blue-300 bg-blue-50 text-blue-800",
      icon: "ph-info text-blue-600",
    };
  };

  const showToast = function ({
    message = "",
    actionHtml = "",
    type = "info",
    duration = 4500,
  }) {
    if (!message) {
      return;
    }

    const appearance = getToastAppearance(type);
    const toastId = `reonet-toast-${Date.now()}-${Math.floor(Math.random() * 1000)}`;
    const container = ensureToastContainer();

    const toast = j(`
      <div id="${toastId}" class="reonet-toast pointer-events-auto flex w-full items-start gap-3 rounded-lg border p-4 text-sm shadow-lg transition-all duration-200 opacity-0 translate-y-2 ${appearance.wrapper}" role="alert" aria-live="polite">
        <i class="ph-duotone text-xl ${appearance.icon}"></i>
        <div class="min-w-0 flex-1 leading-tight">
          <div class="reonet-toast-message"></div>
          <div class="reonet-toast-action mt-2"></div>
        </div>
        <button type="button" class="reonet-toast-close inline-flex h-6 w-6 items-center justify-center rounded-md text-current/70 hover:bg-black/5 hover:text-current" aria-label="Close notification">
          <i class="ph ph-x text-base"></i>
        </button>
      </div>
    `);

    toast.find(".reonet-toast-message").html(message);

    if (actionHtml) {
      toast
        .find(".reonet-toast-action")
        .html(actionHtml)
        .find("a")
        .addClass("font-medium underline underline-offset-4");
    } else {
      toast.find(".reonet-toast-action").remove();
    }

    const removeToast = function () {
      toast.removeClass("opacity-100 translate-y-0").addClass("opacity-0 translate-y-2");
      window.setTimeout(function () {
        toast.remove();
      }, 220);
    };

    toast.on("click", ".reonet-toast-close", removeToast);

    container.append(toast);
    window.requestAnimationFrame(function () {
      toast.removeClass("opacity-0 translate-y-2").addClass("opacity-100 translate-y-0");
    });

    window.setTimeout(removeToast, duration);
  };

  const convertSingleProductNoticesToToasts = function () {
    if (!j("body").hasClass("single-product")) {
      return;
    }

    j(
      ".woocommerce-notices-wrapper .woocommerce-message, .woocommerce-notices-wrapper .woocommerce-error, .woocommerce-notices-wrapper .woocommerce-info"
    ).each(function () {
      const notice = j(this);
      const type = notice.hasClass("woocommerce-error")
        ? "error"
        : notice.hasClass("woocommerce-message")
          ? "success"
          : "info";

      const messageContainer = notice.find(".woocommerce-message-content > div").first();
      const messageHtml = messageContainer.length
        ? messageContainer.html()
        : notice
            .clone()
            .find("a, i")
            .remove()
            .end()
            .text()
            .trim();

      const actionLink = notice.find("a.wc-forward, a.restore-item").first();
      const actionHtml = actionLink.length ? actionLink.prop("outerHTML") : "";

      showToast({
        message: messageHtml,
        actionHtml,
        type,
      });

      notice.remove();
    });
  };

  convertSingleProductNoticesToToasts();
  j(document.body).on(
    "added_to_cart wc_fragments_loaded wc_fragments_refreshed",
    convertSingleProductNoticesToToasts
  );

  // Loader
  window.addEventListener("load", function () {
    const loader = document.getElementById("site-loader");

    if (loader) {
      loader.classList.add("is-hidden");
    }
  });

  // Carousel Initialization
  if (j(".owl-carousel").length) {
    const owl = j(".owl-carousel").owlCarousel({
      loop: true,
      margin: 10,
      dots: false,
      nav: true,
      items: 1,
      autoplay: true,
      autoplayHoverPause: false,
    });

    j(".next-btn").on("click", function () {
      owl.trigger("next.owl.carousel");
      // owl.trigger("stop.owl.autoplay");
    });

    j(".prev-btn").on("click", function () {
      owl.trigger("prev.owl.carousel");
      // owl.trigger("stop.owl.autoplay");
    });

    // owl.trigger("stop.owl.autoplay");
  }

  // To Top Script
  const button = document.querySelector(".to-top");

  if (button) {
    const updateButton = () => {
      if (window.innerWidth <= 768) {
        button.style.display = "none";
        return;
      }

      const landLine = document.getElementById("land-line");
      const scrollTop = window.scrollY;
      const windowHeight = window.innerHeight;
      const docHeight = document.documentElement.scrollHeight;
      const distanceToBottom = docHeight - (scrollTop + windowHeight);

      button.style.display = scrollTop > 800 ? "block" : "none";

      const stopAt = 750;

      if (distanceToBottom <= stopAt) {
        button.classList.add("stop");
        landLine?.classList.remove("hidden");
      } else {
        button.classList.remove("stop");
        landLine?.classList.add("hidden");
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

  j(".variations_form").each(function () {
    const form = j(this);
    const product = form.closest(".product");
    const variationNotice = product.find(".reonet-variation-notice").first();
    const variationNoticeIcon = variationNotice
      .find(".reonet-variation-notice-icon")
      .first();
    const variationNoticeText = variationNotice
      .find(".reonet-variation-notice-text")
      .first();
    const shortDescription = product
      .find(".woocommerce-product-details__short-description")
      .first();
    const productPrice = product.find(".reonet-product-price").first();
    const productPriceValue = productPrice.find(".price").first();
    const variationSelects = form.find(".reonet-variation-select");

    let defaultDescription = shortDescription.html();
    let defaultPriceHtml = productPriceValue.html() || "";

    if (productPrice.length) {
      const defaultPriceHtmlRaw = productPrice.attr("data-default-price");

      if (defaultPriceHtmlRaw) {
        try {
          defaultPriceHtml = JSON.parse(defaultPriceHtmlRaw);
        } catch (error) {
          defaultPriceHtml = productPriceValue.html() || "";
        }
      }
    }

    const setVariationNoticeType = function (type) {
      const noticeType = ["error", "warning", "info", "success"].includes(type)
        ? type
        : "error";

      variationNotice.removeClass(
        "border-red-300 bg-red-50 text-red-800 border-amber-300 bg-amber-50 text-amber-800 border-blue-300 bg-blue-50 text-blue-800 border-green-300 bg-green-50 text-green-800"
      );

      variationNoticeIcon.removeClass(
        "ph-warning-octagon ph-warning-circle ph-info ph-check-circle text-red-600 text-amber-600 text-blue-600 text-green-600"
      );

      if (noticeType === "warning") {
        variationNotice.addClass("border-amber-300 bg-amber-50 text-amber-800");
        variationNoticeIcon.addClass("ph-warning-circle text-amber-600");
        return;
      }

      if (noticeType === "info") {
        variationNotice.addClass("border-blue-300 bg-blue-50 text-blue-800");
        variationNoticeIcon.addClass("ph-info text-blue-600");
        return;
      }

      if (noticeType === "success") {
        variationNotice.addClass("border-green-300 bg-green-50 text-green-800");
        variationNoticeIcon.addClass("ph-check-circle text-green-600");
        return;
      }

      variationNotice.addClass("border-red-300 bg-red-50 text-red-800");
      variationNoticeIcon.addClass("ph-warning-octagon text-red-600");
    };

    const showVariationNotice = function (message, type = "error") {
      if (!message) {
        variationNotice.addClass("hidden");
        if (variationNoticeText.length) {
          variationNoticeText.text("");
        } else {
          variationNotice.text("");
        }
        return;
      }

      setVariationNoticeType(type);

      if (variationNoticeText.length) {
        variationNoticeText.text(message);
      } else {
        variationNotice.text(message);
      }

      variationNotice.removeClass("hidden");
    };

    const renderMainPrice = function (html) {
      if (!productPriceValue.length || typeof html !== "string") {
        return;
      }

      productPriceValue.html(html);
    };

    const renderShortDescription = function (html) {
      if (!shortDescription.length) {
        return;
      }

      shortDescription.html(html);
    };

    const getBestMatchedVariation = function (fallbackVariation) {
      const variations = form.data("product_variations");
      const selectedAttributes = {};
      let hasEmptySelection = false;

      if (!Array.isArray(variations) || !variations.length) {
        return fallbackVariation || null;
      }

      variationSelects.each(function () {
        const select = j(this);
        const attributeName = select.data("attribute_name");
        const value = select.val();

        if (!attributeName) {
          return;
        }

        selectedAttributes[attributeName] = value;

        if (!value) {
          hasEmptySelection = true;
        }
      });

      if (hasEmptySelection) {
        return fallbackVariation || null;
      }

      const candidates = variations.filter(function (variation) {
        const variationAttributes = variation?.attributes || {};

        return Object.keys(selectedAttributes).every(function (attributeName) {
          const selectedValue = selectedAttributes[attributeName];
          const variationValue = variationAttributes[attributeName];

          if (!selectedValue) {
            return false;
          }

          return !variationValue || variationValue === selectedValue;
        });
      });

      if (!candidates.length) {
        return fallbackVariation || null;
      }

      candidates.sort(function (a, b) {
        const aSpecificity = Object.values(a?.attributes || {}).filter(Boolean).length;
        const bSpecificity = Object.values(b?.attributes || {}).filter(Boolean).length;

        return bSpecificity - aSpecificity;
      });

      return candidates[0];
    };

    const clearVariationFieldState = function ($select) {
      const field = $select.closest(".horizontal-field");

      $select.removeClass("reonet-variation-select-error");
      $select.removeAttr("aria-invalid");
      field.find("label").removeClass("variation-field-label-error");
    };

    const clearAllVariationFieldStates = function () {
      variationSelects.each(function () {
        clearVariationFieldState(j(this));
      });
    };

    const focusMissingVariationField = function () {
      const missingSelect = variationSelects
        .filter(function () {
          return !j(this).val();
        })
        .first();

      if (!missingSelect.length) {
        return;
      }

      clearAllVariationFieldStates();
      missingSelect.addClass("reonet-variation-select-error");
      missingSelect.attr("aria-invalid", "true");
      missingSelect
        .closest(".horizontal-field")
        .find("label")
        .addClass("variation-field-label-error");
      missingSelect.trigger("focus");
    };

    const formElement = form.get(0);

    if (formElement && !formElement.dataset.reonetVariationNoticeBound) {
      formElement.dataset.reonetVariationNoticeBound = "true";

      formElement.addEventListener(
        "click",
        function (event) {
          const button = event.target.closest(".single_add_to_cart_button");

          if (!button || !formElement.contains(button)) {
            return;
          }

          const $button = j(button);

          if (!$button.hasClass("disabled")) {
            showVariationNotice("");
            return;
          }

          event.preventDefault();
          event.stopPropagation();
          event.stopImmediatePropagation();

          if (
            $button.hasClass("wc-variation-selection-needed") &&
            window.wc_add_to_cart_variation_params?.i18n_make_a_selection_text
          ) {
            showVariationNotice(
              window.wc_add_to_cart_variation_params.i18n_make_a_selection_text,
              "warning"
            );
            focusMissingVariationField();
            return;
          }

          if (
            $button.hasClass("wc-variation-is-unavailable") &&
            window.wc_add_to_cart_variation_params?.i18n_unavailable_text
          ) {
            showVariationNotice(
              window.wc_add_to_cart_variation_params.i18n_unavailable_text,
              "error"
            );
          }
        },
        true
      );
    }

    variationSelects.on("change", function () {
      const select = j(this);

      if (select.val()) {
        clearVariationFieldState(select);
      }
    });

    const updateVariationContent = function (variation) {
      const matchedVariation = getBestMatchedVariation(variation);
      const variationDescription = matchedVariation?.variation_description || "";
      const variationPriceHtml = matchedVariation?.price_html || "";
      const variationId = matchedVariation?.variation_id;

      showVariationNotice("");
      clearAllVariationFieldStates();

      if (variationId) {
        form
          .find('input[name="variation_id"], input.variation_id')
          .val(variationId);
      }

      if (variationPriceHtml) {
        renderMainPrice(variationPriceHtml);
      } else {
        renderMainPrice(defaultPriceHtml);
      }

      if (variationDescription) {
        renderShortDescription(variationDescription);
      } else {
        renderShortDescription(defaultDescription);
      }
    };

    form.on("found_variation", function (_, variation) {
      updateVariationContent(variation);
    });

    form.on("reset_data", function () {
      showVariationNotice("");
      clearAllVariationFieldStates();
      renderMainPrice(defaultPriceHtml);
      renderShortDescription(defaultDescription);
    });
  });
});

function mobileMenu() {
  jQuery(".mobile-menu").toggleClass("hidden");
}
