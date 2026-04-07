(function ($) {
  "use strict";

  const buildPreviewItem = function (url) {
    return (
      '<img src="' +
      url +
      '" alt="" class="_variation-gallery-preview-image" style="width:56px;height:56px;object-fit:cover;border-radius:8px;border:1px solid #dcdcde;" />'
    );
  };

  const renderPreview = function ($row, attachments) {
    const $preview = $row.find("._variation-gallery-preview");

    if (!$preview.length) {
      return;
    }

    if (!attachments.length) {
      $preview.empty();
      return;
    }

    let html = "";
    attachments.forEach(function (attachment) {
      const sizes = attachment.sizes || {};
      const thumbUrl =
        (sizes.thumbnail && sizes.thumbnail.url) ||
        (sizes.medium && sizes.medium.url) ||
        attachment.url;

      if (thumbUrl) {
        html += buildPreviewItem(thumbUrl);
      }
    });

    $preview.html(html);
  };

  const parseIds = function (value) {
    return (value || "")
      .split(",")
      .map(function (id) {
        return parseInt(id, 10);
      })
      .filter(function (id) {
        return Number.isInteger(id) && id > 0;
      });
  };

  const markVariationAsChanged = function ($input) {
    const $variation = $input.closest(".woocommerce_variation");
    const $variableOptions = $("#variable_product_options");

    if ($variation.length) {
      $variation.addClass("variation-needs-update");
    }

    $variableOptions
      .find("button.cancel-variation-changes, button.save-variation-changes")
      .prop("disabled", false);

    $input.trigger("change");
    $variableOptions.trigger("woocommerce_variations_input_changed");
  };

  const initFieldStyles = function () {
    if (document.getElementById("_variation-gallery-admin-style")) {
      return;
    }

    const style = document.createElement("style");
    style.id = "_variation-gallery-admin-style";
    style.textContent =
      "._variation-gallery-preview{display:flex;flex-wrap:wrap;gap:8px;margin-top:8px}" +
      "._variation-gallery-admin-field ._variation-gallery-clear{margin-left:10px}";
    document.head.appendChild(style);
  };

  $(function () {
    initFieldStyles();

    $(document).on("click", "._variation-gallery-upload", function (event) {
      event.preventDefault();

      const $button = $(this);
      const $row = $button.closest("._variation-gallery-admin-field");
      const $input = $row.find("._variation-gallery-ids");

      if (!$row.length || !$input.length) {
        return;
      }

      const frame = wp.media({
        title: "Select variation gallery images",
        button: { text: "Use selected images" },
        multiple: true,
        library: { type: "image" },
      });

      frame.on("open", function () {
        const selection = frame.state().get("selection");
        const ids = parseIds($input.val());

        ids.forEach(function (id) {
          const attachment = wp.media.attachment(id);
          if (attachment) {
            attachment.fetch();
            selection.add(attachment);
          }
        });
      });

      frame.on("select", function () {
        const selection = frame
          .state()
          .get("selection")
          .toJSON();

        const ids = selection
          .map(function (item) {
            return parseInt(item.id, 10);
          })
          .filter(function (id) {
            return Number.isInteger(id) && id > 0;
          });

        $input.val(ids.join(","));
        renderPreview($row, selection);
        markVariationAsChanged($input);
      });

      frame.open();
    });

    $(document).on("click", "._variation-gallery-clear", function (event) {
      event.preventDefault();

      const $row = $(this).closest("._variation-gallery-admin-field");
      if (!$row.length) {
        return;
      }

      const $input = $row.find("._variation-gallery-ids");
      $input.val("");
      $row.find("._variation-gallery-preview").empty();
      markVariationAsChanged($input);
    });
  });
})(jQuery);
