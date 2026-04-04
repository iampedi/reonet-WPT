let j = jQuery.noConflict();

j(document).ready(function () {
  const getWooFragmentsEndpoint = function () {
    if (
      typeof window.wc_cart_fragments_params !== "undefined" &&
      window.wc_cart_fragments_params.wc_ajax_url
    ) {
      return window.wc_cart_fragments_params.wc_ajax_url.replace(
        "%%endpoint%%",
        "get_refreshed_fragments",
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
    refreshHeaderCartBadge,
  );

  const disableCartNoticeAutoScroll = function () {
    if (!j("body").hasClass("woocommerce-cart")) {
      return;
    }

    const disableScrollToNotices = function () {
      if (typeof j.scroll_to_notices === "function") {
        j.scroll_to_notices = function () {};
      }
    };

    disableScrollToNotices();
    window.setTimeout(disableScrollToNotices, 0);
    window.setTimeout(disableScrollToNotices, 250);
  };

  const setupCartAutoUpdateOnQuantityChange = function () {
    let updateTimer = null;
    let isUpdating = false;

    j(document.body)
      .off(
        "input.reonetCartQty change.reonetCartQty",
        ".woocommerce-cart-form input.qty",
      )
      .on(
        "input.reonetCartQty change.reonetCartQty",
        ".woocommerce-cart-form input.qty",
        function () {
          const $input = j(this);
          const $cartForm = $input.closest("form.woocommerce-cart-form");

          if (!$cartForm.length) {
            return;
          }

          if (updateTimer) {
            window.clearTimeout(updateTimer);
          }

          updateTimer = window.setTimeout(function () {
            if (isUpdating) {
              return;
            }

            const $updateButton = $cartForm.find('button[name="update_cart"]');
            if (!$updateButton.length) {
              return;
            }

            isUpdating = true;
            $updateButton.prop("disabled", false);
            $updateButton.trigger("click");
          }, 450);
        },
      );

    j(document.body)
      .off(
        "updated_wc_div.reonetCartQty updated_cart_totals.reonetCartQty wc_cart_emptied.reonetCartQty",
      )
      .on(
        "updated_wc_div.reonetCartQty updated_cart_totals.reonetCartQty wc_cart_emptied.reonetCartQty",
        function () {
          isUpdating = false;
        },
      );
  };

  disableCartNoticeAutoScroll();
  setupCartAutoUpdateOnQuantityChange();

  const ensureToastContainer = function () {
    let container = j("#reonet-toast-container");

    if (!container.length) {
      j("body").append(
        '<div id="reonet-toast-container" class="fixed bottom-4 left-4 z-[9999] flex w-[calc(100%-2rem)] max-w-sm flex-col gap-3 sm:bottom-6 sm:left-6"></div>',
      );
      container = j("#reonet-toast-container");
    }

    return container;
  };

  const getToastAppearance = function (type) {
    if (type === "error") {
      return {
        wrapper: "border-red-300 bg-red-50 text-danger",
        icon: "ph-info text-danger",
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
    duration = 8000,
  }) {
    if (!message) {
      return;
    }

    const now = Date.now();
    const signature = `${type}::${String(message).trim()}`;
    const lastToast = window.reonetLastToastMeta || { signature: "", at: 0 };
    if (lastToast.signature === signature && now - lastToast.at < 1600) {
      return;
    }
    window.reonetLastToastMeta = { signature, at: now };

    const appearance = getToastAppearance(type);
    const toastId = `reonet-toast-${Date.now()}-${Math.floor(Math.random() * 1000)}`;
    const container = ensureToastContainer();

    const toast = j(`
      <div id="${toastId}" class="reonet-toast pointer-events-auto flex w-full items-center gap-3 rounded-lg border p-4 text-sm shadow-lg transition-all duration-300 opacity-0 translate-y-2 translate-x-3 ${appearance.wrapper}" role="alert" aria-live="polite">
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
      toast
        .removeClass("opacity-100 translate-y-0")
        .addClass("opacity-0 translate-y-2");
      window.setTimeout(function () {
        toast.remove();
      }, 220);
    };

    toast.on("click", ".reonet-toast-close", removeToast);

    container.append(toast);
    window.requestAnimationFrame(function () {
      toast
        .removeClass("opacity-0 translate-y-2 translate-x-3")
        .addClass("opacity-100 translate-y-0 translate-x-0");
    });

    window.setTimeout(removeToast, duration);
  };

  const getAddToCartEndpoint = function () {
    if (
      typeof window.wc_add_to_cart_params !== "undefined" &&
      window.wc_add_to_cart_params.wc_ajax_url
    ) {
      return window.wc_add_to_cart_params.wc_ajax_url.replace(
        "%%endpoint%%",
        "add_to_cart",
      );
    }

    return `${window.location.origin}/?wc-ajax=add_to_cart`;
  };

  const setupSingleProductAjaxAddToCart = function () {
    // Scenario switched: keep native WooCommerce submit/refresh flow.
    return;

    // Force add-to-cart buttons to non-submit to avoid native form POST refresh.
    j("form.cart .single_add_to_cart_button").attr("type", "button");

    if (!window.reonetAjaxAddToCartClickBlockBound) {
      window.reonetAjaxAddToCartClickBlockBound = true;

      // Capture-phase default prevention blocks native submit before other listeners.
      document.addEventListener(
        "click",
        function (event) {
          const button = event.target.closest(
            "form.cart .single_add_to_cart_button",
          );

          if (!button || button.classList.contains("disabled")) {
            return;
          }

          event.preventDefault();
        },
        true,
      );
    }

    if (!window.reonetAjaxAddToCartSubmitBlockBound) {
      window.reonetAjaxAddToCartSubmitBlockBound = true;

      document.addEventListener(
        "submit",
        function (event) {
          const form = event.target;

          if (!(form instanceof HTMLFormElement)) {
            return;
          }

          if (!form.matches("form.cart")) {
            return;
          }

          event.preventDefault();
          event.stopPropagation();
        },
        true,
      );
    }

    if (!window.reonetNativeCartSubmitPatched) {
      window.reonetNativeCartSubmitPatched = true;
      const nativeFormSubmit = HTMLFormElement.prototype.submit;

      HTMLFormElement.prototype.submit = function () {
        try {
          if (this && this.matches && this.matches("form.cart")) {
            const submitEvent = new Event("submit", {
              bubbles: true,
              cancelable: true,
            });
            const notCancelled = this.dispatchEvent(submitEvent);

            // If any handler prevented default, never fall through to native submit.
            if (!notCancelled) {
              return;
            }
          }
        } catch (e) {
          // Fall back to native submit below.
        }

        return nativeFormSubmit.call(this);
      };
    }

    const isAjaxEligibleForm = function ($form) {
      return (
        $form.is("form.cart") &&
        $form.find(".single_add_to_cart_button").length > 0
      );
    };

    const submitViaAjax = function ($form, $button) {
      if ($form.data("reonetIsSubmitting")) {
        return;
      }

      const payload = $form.serializeArray();
      const submitName = $button.attr("name") || "add-to-cart";
      const submitValue = $button.val() || $button.attr("value") || "";
      const hasSubmitValue = payload.some((item) => item.name === submitName);

      if (!hasSubmitValue) {
        payload.push({
          name: submitName,
          value: submitValue,
        });
      }

      const endpoint = getAddToCartEndpoint();
      const cartUrl =
        (typeof window.wc_add_to_cart_params !== "undefined" &&
          window.wc_add_to_cart_params.cart_url) ||
        "/cart/";

      $form.data("reonetIsSubmitting", true);
      $button.addClass("loading").prop("disabled", true);

      j.ajax({
        type: "POST",
        url: endpoint,
        data: j.param(payload),
        success: function (response) {
          if (response?.error && response?.product_url) {
            window.location = response.product_url;
            return;
          }

          if (response?.fragments) {
            j(document.body).trigger("added_to_cart", [
              response.fragments,
              response.cart_hash,
              $button,
            ]);
          } else {
            j(document.body).trigger("wc_fragment_refresh");
          }

          const actionHtml = `<a href="${cartUrl}">${
            window.wc_add_to_cart_params?.i18n_view_cart || "View cart"
          }</a>`;

          showToast({
            message: "Product added to cart.",
            actionHtml,
            type: "success",
          });
        },
        error: function () {
          showToast({
            message: "Could not add product to cart. Please try again.",
            type: "error",
          });
        },
        complete: function () {
          $button.removeClass("loading").prop("disabled", false);
          $form.data("reonetIsSubmitting", false);
          $button.data("reonetClickLocked", false);
        },
      });
    };

    j(document.body)
      .off("click.reonetAjaxAddToCart", "form.cart .single_add_to_cart_button")
      .on(
        "click.reonetAjaxAddToCart",
        "form.cart .single_add_to_cart_button",
        function (event) {
          const $button = j(this);
          const $form = $button.closest("form.cart");

          if (!isAjaxEligibleForm($form) || $button.hasClass("disabled")) {
            return;
          }

          if ($button.data("reonetClickLocked")) {
            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();
            return false;
          }

          $button.data("reonetClickLocked", true);

          event.preventDefault();
          event.stopPropagation();
          event.stopImmediatePropagation();

          submitViaAjax($form, $button);
          return false;
        },
      );

    // Block native submit to prevent duplicate requests/page refresh on single product forms.
    j(document.body)
      .off("submit.reonetAjaxAddToCart", "form.cart")
      .on("submit.reonetAjaxAddToCart", "form.cart", function (event) {
        const $form = j(this);

        if (!isAjaxEligibleForm($form)) {
          return;
        }

        event.preventDefault();
        event.stopPropagation();
        return false;
      });
  };

  const convertSingleProductNoticesToToasts = function () {
    if (!j("body").hasClass("single-product")) {
      return;
    }

    j(
      ".woocommerce .woocommerce-message, .woocommerce-notices-wrapper .woocommerce-message",
    ).each(function () {
      const notice = j(this);

      const messageContainer = notice
        .find(".woocommerce-message-content > div")
        .first();
      const messageHtml = messageContainer.length
        ? messageContainer.html()
        : notice.clone().find("a, i").remove().end().text().trim();

      const actionLink = notice.find("a.wc-forward, a.restore-item").first();
      const actionHtml = actionLink.length ? actionLink.prop("outerHTML") : "";

      showToast({
        message: messageHtml,
        actionHtml,
        type: "success",
      });

      notice.remove();
    });
  };

  const getNoticeToastType = function (notice) {
    if (notice.hasClass("woocommerce-error")) {
      return "error";
    }

    if (notice.hasClass("woocommerce-message")) {
      return "success";
    }

    return "info";
  };

  const getNoticeToastMessageHtml = function (notice) {
    const messageContainer = notice
      .find(".woocommerce-message-content > div")
      .first();

    if (messageContainer.length) {
      return messageContainer.html();
    }

    const clone = notice.clone();
    clone.find("a, i").remove();

    return clone.html() || clone.text().trim();
  };

  const convertCartNoticesToToasts = function () {
    if (!j("body").hasClass("woocommerce-cart")) {
      return;
    }

    j(
      ".woocommerce-notices-wrapper .woocommerce-message, .woocommerce-notices-wrapper .woocommerce-error, .woocommerce-notices-wrapper .woocommerce-info, .woocommerce .woocommerce-message, .woocommerce .woocommerce-error, .woocommerce .woocommerce-info",
    ).each(function () {
      const notice = j(this);
      const messageHtml = getNoticeToastMessageHtml(notice);
      const actionLink = notice.find("a.wc-forward, a.restore-item").first();
      const actionHtml = actionLink.length ? actionLink.prop("outerHTML") : "";

      showToast({
        message: messageHtml,
        actionHtml,
        type: getNoticeToastType(notice),
        duration: 10000,
      });

      notice.remove();
    });
  };

  const convertAuthNoticesToToasts = function () {
    const getCookieValue = function (name) {
      const encoded = `${encodeURIComponent(name)}=`;
      const parts = document.cookie ? document.cookie.split("; ") : [];

      for (const part of parts) {
        if (part.indexOf(encoded) === 0) {
          return decodeURIComponent(part.substring(encoded.length));
        }
      }

      return "";
    };

    const clearCookie = function (name) {
      document.cookie = `${encodeURIComponent(name)}=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/`;
    };

    const authToastState = getCookieValue("reonet_auth_toast");
    if (authToastState === "login") {
      showToast({
        message: "Successfully logged in.",
        type: "success",
      });
      clearCookie("reonet_auth_toast");
    } else if (authToastState === "logout") {
      showToast({
        message: "You have been logged out.",
        type: "info",
      });
      clearCookie("reonet_auth_toast");
    }

    j(
      ".woocommerce-notices-wrapper .woocommerce-message, .woocommerce-notices-wrapper .woocommerce-info, .woocommerce .woocommerce-message, .woocommerce .woocommerce-info",
    ).each(function () {
      const notice = j(this);
      const text = notice.text().trim().toLowerCase();

      const isLoginNotice =
        text.includes("logged in") ||
        text.includes("kirjaud") ||
        text.includes("signed in");
      const isLogoutNotice =
        text.includes("logged out") ||
        text.includes("uloskirj") ||
        text.includes("signed out");

      if (!isLoginNotice && !isLogoutNotice) {
        return;
      }

      const messageHtml = getNoticeToastMessageHtml(notice);
      showToast({
        message: messageHtml,
        type: isLoginNotice ? "success" : "info",
      });

      notice.remove();
    });

  };

  convertSingleProductNoticesToToasts();
  convertCartNoticesToToasts();
  convertAuthNoticesToToasts();
  setupSingleProductAjaxAddToCart();

  j(document.body)
    .off(
      "updated_wc_div.reonetCartNotices updated_cart_totals.reonetCartNotices applied_coupon.reonetCartNotices removed_coupon.reonetCartNotices wc_cart_emptied.reonetCartNotices",
    )
    .on(
      "updated_wc_div.reonetCartNotices updated_cart_totals.reonetCartNotices applied_coupon.reonetCartNotices removed_coupon.reonetCartNotices wc_cart_emptied.reonetCartNotices",
      function () {
        convertCartNoticesToToasts();
      },
    );

  const setupCheckoutValidationUX = function () {
    if (!j("body").hasClass("woocommerce-checkout")) {
      return;
    }

    const toastMessage = "Please fill in all required fields.";

    const isFieldValueEmpty = function ($field) {
      if (!$field.length || !$field.is(":visible")) {
        return false;
      }

      if ($field.is(":checkbox,:radio")) {
        const name = $field.attr("name");
        if (!name) {
          return !$field.is(":checked");
        }

        const $group = $field
          .closest("form.checkout")
          .find(`[name="${name.replace(/"/g, '\\"')}"]`);
        return !$group.is(":checked");
      }

      return String($field.val() || "").trim() === "";
    };

    const updateRequiredFieldStates = function () {
      const $checkoutForm = j("form.checkout");
      if (!$checkoutForm.length) {
        return { hasEmptyRequired: false, firstInvalidField: null };
      }

      let hasEmptyRequired = false;
      let firstInvalidField = null;

      $checkoutForm
        .find(".reonet-checkout-field-error")
        .removeClass("reonet-checkout-field-error");

      $checkoutForm.find(".validate-required").each(function () {
        const $row = j(this);
        const $targetField = $row
          .find("input, select, textarea")
          .filter(":enabled")
          .not('[type="hidden"]')
          .first();

        if (isFieldValueEmpty($targetField)) {
          $row.addClass("reonet-checkout-field-error");
          hasEmptyRequired = true;
          if (!firstInvalidField && $targetField.length) {
            firstInvalidField = $targetField;
          }
        }
      });

      return { hasEmptyRequired, firstInvalidField };
    };

    const hideRequiredFieldNoticeGroups = function () {
      j(
        ".woocommerce-NoticeGroup-checkout, .woocommerce form.checkout .woocommerce-error, .woocommerce-notices-wrapper .woocommerce-error",
      ).remove();
    };

    j(document.body)
      .off("submit.reonetCheckoutValidation", "form.checkout")
      .on("submit.reonetCheckoutValidation", "form.checkout", function () {
        const validationState = updateRequiredFieldStates();
        if (validationState.hasEmptyRequired) {
          if (validationState.firstInvalidField && validationState.firstInvalidField.length) {
            validationState.firstInvalidField.trigger("focus");
          }
          showToast({
            message: toastMessage,
            type: "error",
          });
        }
      });

    j(document.body)
      .off(
        "change.reonetCheckoutValidation input.reonetCheckoutValidation",
        "form.checkout .validate-required input, form.checkout .validate-required select, form.checkout .validate-required textarea",
      )
      .on(
        "change.reonetCheckoutValidation input.reonetCheckoutValidation",
        "form.checkout .validate-required input, form.checkout .validate-required select, form.checkout .validate-required textarea",
        function () {
          const $row = j(this).closest(".validate-required");
          const $targetField = $row
            .find("input, select, textarea")
            .filter(":enabled")
            .not('[type="hidden"]')
            .first();

          if (!isFieldValueEmpty($targetField)) {
            $row.removeClass("reonet-checkout-field-error");
          }
        },
      );

    j(document.body)
      .off("checkout_error.reonetCheckoutValidation")
      .on("checkout_error.reonetCheckoutValidation", function () {
        window.setTimeout(function () {
          const validationState = updateRequiredFieldStates();
          if (!validationState.hasEmptyRequired) {
            return;
          }

          if (validationState.firstInvalidField && validationState.firstInvalidField.length) {
            validationState.firstInvalidField.trigger("focus");
          }
          hideRequiredFieldNoticeGroups();
          showToast({
            message: toastMessage,
            type: "error",
          });
        }, 20);
      });

    const updateLoginFieldStates = function () {
      const $loginForm = j("form.woocommerce-form-login");
      if (!$loginForm.length) {
        return { hasEmptyRequired: false, firstInvalidField: null };
      }

      const $username = $loginForm.find("#username, input[name='username']").first();
      const $password = $loginForm.find("#password, input[name='password']").first();
      let hasEmptyRequired = false;
      let firstInvalidField = null;

      $loginForm.find(".reonet-login-field-error").removeClass("reonet-login-field-error");

      if ($username.length && String($username.val() || "").trim() === "") {
        $username.closest(".form-row").addClass("reonet-login-field-error");
        hasEmptyRequired = true;
        if (!firstInvalidField) {
          firstInvalidField = $username;
        }
      }

      if ($password.length && String($password.val() || "").trim() === "") {
        $password.closest(".form-row").addClass("reonet-login-field-error");
        hasEmptyRequired = true;
        if (!firstInvalidField) {
          firstInvalidField = $password;
        }
      }

      return { hasEmptyRequired, firstInvalidField };
    };

    const validateLoginFormAndNotify = function () {
      const validationState = updateLoginFieldStates();
      if (!validationState.hasEmptyRequired) {
        return true;
      }

      if (validationState.firstInvalidField && validationState.firstInvalidField.length) {
        validationState.firstInvalidField.trigger("focus");
      }

      showToast({
        message: toastMessage,
        type: "error",
      });

      return false;
    };

    // Use custom validation UX instead of browser-native required popups.
    j("form.woocommerce-form-login").attr("novalidate", "novalidate");

    j(document.body)
      .off("submit.reonetCheckoutLoginValidation", "form.woocommerce-form-login")
      .on("submit.reonetCheckoutLoginValidation", "form.woocommerce-form-login", function (event) {
        if (validateLoginFormAndNotify()) {
          return;
        }

        event.preventDefault();
      });

    j(document.body)
      .off(
        "click.reonetCheckoutLoginValidation",
        "form.woocommerce-form-login button[type='submit'], form.woocommerce-form-login input[type='submit']",
      )
      .on(
        "click.reonetCheckoutLoginValidation",
        "form.woocommerce-form-login button[type='submit'], form.woocommerce-form-login input[type='submit']",
        function (event) {
          if (validateLoginFormAndNotify()) {
            return;
          }

          event.preventDefault();
        },
      );

    j(document.body)
      .off(
        "input.reonetCheckoutLoginValidation change.reonetCheckoutLoginValidation",
        "form.woocommerce-form-login input[name='username'], form.woocommerce-form-login input[name='password']",
      )
      .on(
        "input.reonetCheckoutLoginValidation change.reonetCheckoutLoginValidation",
        "form.woocommerce-form-login input[name='username'], form.woocommerce-form-login input[name='password']",
        function () {
          const $field = j(this);
          if (String($field.val() || "").trim() !== "") {
            $field.closest(".form-row").removeClass("reonet-login-field-error");
          }
        },
      );
  };

  setupCheckoutValidationUX();

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
    const hasDefaultVariation =
      String(form.data("has-default-variation")) === "yes";
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
    const initialAttributeSelections = {};

    variationNotice.addClass("hidden");
    if (variationNoticeText.length) {
      variationNoticeText.text("");
    } else {
      variationNotice.text("");
    }

    variationSelects.each(function () {
      const select = j(this);
      const attributeName = select.data("attribute_name");

      if (!attributeName) {
        return;
      }

      initialAttributeSelections[attributeName] = select.val() || "";
    });

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
        "border-red-300 bg-red-50 text-danger border-amber-300 bg-amber-50 text-amber-800 border-blue-300 bg-blue-50 text-blue-800 border-green-300 bg-green-50 text-green-800",
      );

      variationNoticeIcon.removeClass(
        "ph-warning-circle ph-info ph-check-circle text-danger text-amber-600 text-blue-600 text-green-600",
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

      variationNotice.addClass("border-red-300 bg-red-50 text-danger");
      variationNoticeIcon.addClass("ph-info text-danger");
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
        const aSpecificity = Object.values(a?.attributes || {}).filter(
          Boolean,
        ).length;
        const bSpecificity = Object.values(b?.attributes || {}).filter(
          Boolean,
        ).length;

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

    const applyDefaultVariationSelection = function () {
      if (!hasDefaultVariation) {
        return;
      }

      variationSelects.each(function () {
        const select = j(this);
        const attributeName = select.data("attribute_name");

        if (!attributeName) {
          return;
        }

        const currentValue = select.val();
        const defaultValue = initialAttributeSelections[attributeName] || "";

        if (!currentValue && defaultValue) {
          select.val(defaultValue);
        }
      });

      form.trigger("check_variations");
      form.trigger("woocommerce_variation_select_change");
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
            clearAllVariationFieldStates();
            return;
          }

          event.preventDefault();
          event.stopPropagation();
          event.stopImmediatePropagation();

          if (
            $button.hasClass("wc-variation-selection-needed") &&
            window.wc_add_to_cart_variation_params?.i18n_make_a_selection_text
          ) {
            showToast({
              message:
                window.wc_add_to_cart_variation_params
                  .i18n_make_a_selection_text,
              type: "error",
            });
            focusMissingVariationField();
            return;
          }

          if (
            $button.hasClass("wc-variation-is-unavailable") &&
            window.wc_add_to_cart_variation_params?.i18n_unavailable_text
          ) {
            showToast({
              message:
                window.wc_add_to_cart_variation_params.i18n_unavailable_text,
              type: "error",
            });
            clearAllVariationFieldStates();
            variationSelects.each(function () {
              const select = j(this);
              if (!select.val()) {
                select.addClass("reonet-variation-select-error");
                select.attr("aria-invalid", "true");
                select
                  .closest(".horizontal-field")
                  .find("label")
                  .addClass("variation-field-label-error");
              }
            });
          }

          variationNotice.addClass("hidden");
          if (variationNoticeText.length) {
            variationNoticeText.text("");
          } else {
            variationNotice.text("");
          }
        },
        true,
      );
    }

    variationSelects.on("change", function () {
      const select = j(this);

      if (select.val()) {
        clearVariationFieldState(select);
      }

      variationNotice.addClass("hidden");
      if (variationNoticeText.length) {
        variationNoticeText.text("");
      } else {
        variationNotice.text("");
      }
    });

    const updateVariationContent = function (variation) {
      const matchedVariation = getBestMatchedVariation(variation);
      const variationDescription =
        matchedVariation?.variation_description || "";
      const variationPriceHtml = matchedVariation?.price_html || "";
      const variationId = matchedVariation?.variation_id;

      clearAllVariationFieldStates();
      variationNotice.addClass("hidden");
      if (variationNoticeText.length) {
        variationNoticeText.text("");
      } else {
        variationNotice.text("");
      }

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
      if (hasDefaultVariation) {
        clearAllVariationFieldStates();
        variationNotice.addClass("hidden");
        if (variationNoticeText.length) {
          variationNoticeText.text("");
        } else {
          variationNotice.text("");
        }
        applyDefaultVariationSelection();
        return;
      }

      clearAllVariationFieldStates();
      variationNotice.addClass("hidden");
      if (variationNoticeText.length) {
        variationNoticeText.text("");
      } else {
        variationNotice.text("");
      }
      renderMainPrice(defaultPriceHtml);
      renderShortDescription(defaultDescription);
    });

    applyDefaultVariationSelection();
  });
});

function mobileMenu() {
  jQuery(".mobile-menu").toggleClass("hidden");
}
