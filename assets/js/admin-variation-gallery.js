(function ($) {
  "use strict";

  const buildPreviewItem = function (attachmentId, url) {
    return (
      '<div class="_variation-gallery-preview-item" data-attachment-id="' +
      attachmentId +
      '">' +
      '<img src="' +
      url +
      '" alt="" class="_variation-gallery-preview-image" />' +
      '<button type="button" class="button-link-delete _variation-gallery-remove" aria-label="Remove image" title="Remove image">&times;</button>' +
      "</div>"
    );
  };

  const uniqueIds = function (ids) {
    return Array.from(new Set(ids));
  };

  const parseIds = function (value) {
    return uniqueIds(
      (value || "")
        .split(",")
        .map(function (id) {
          return parseInt(id, 10);
        })
        .filter(function (id) {
          return Number.isInteger(id) && id > 0;
        }),
    );
  };

  const getPreviewIds = function ($preview) {
    return uniqueIds(
      $preview
        .find("._variation-gallery-preview-item")
        .map(function () {
          return parseInt($(this).attr("data-attachment-id"), 10);
        })
        .get()
        .filter(function (id) {
          return Number.isInteger(id) && id > 0;
        }),
    );
  };

  const syncInputFromPreview = function ($row) {
    const $input = $row.find("._variation-gallery-ids");
    const $preview = $row.find("._variation-gallery-preview");
    if (!$input.length || !$preview.length) {
      return;
    }

    $input.val(getPreviewIds($preview).join(","));
  };

  const initPreviewSortable = function ($scope) {
    $scope.find("._variation-gallery-preview").each(function () {
      const $preview = $(this);

      if ($preview.data("ui-sortable")) {
        return;
      }

      $preview.sortable({
        items: "> ._variation-gallery-preview-item",
        tolerance: "pointer",
        cursor: "move",
        stop: function () {
          const $row = $preview.closest("._variation-gallery-admin-field");
          syncInputFromPreview($row);
          markVariationAsChanged($row.find("._variation-gallery-ids"));
        },
      });
    });
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
      const attachmentId = parseInt(attachment.id, 10);
      const thumbUrl =
        (sizes.thumbnail && sizes.thumbnail.url) ||
        (sizes.medium && sizes.medium.url) ||
        attachment.url;

      if (Number.isInteger(attachmentId) && attachmentId > 0 && thumbUrl) {
        html += buildPreviewItem(attachmentId, thumbUrl);
      }
    });

    $preview.html(html);
    initPreviewSortable($row);
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
      "._variation-gallery-preview-item{position:relative;cursor:move}" +
      "._variation-gallery-preview-image{display:block;width:56px;height:56px;object-fit:cover;border-radius:8px;border:1px solid #dcdcde}" +
      "._variation-gallery-remove{position:absolute;top:-6px;right:-6px;background:#fff !important;border-radius:50%;height:18px;width:18px;display:flex;align-items:center;justify-content:center;border:1px solid;line-height:inherit;font-size:10px;font-weight:700}" +
      "._variation-gallery-admin-field ._variation-gallery-clear{margin-left:10px}";
    document.head.appendChild(style);
  };

  $(function () {
    initFieldStyles();
    initPreviewSortable($(document));

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
        const selection = frame.state().get("selection").toJSON();

        const ids = selection
          .map(function (item) {
            return parseInt(item.id, 10);
          })
          .filter(function (id) {
            return Number.isInteger(id) && id > 0;
          });

        $input.val(uniqueIds(ids).join(","));
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

    $(document).on("click", "._variation-gallery-remove", function (event) {
      event.preventDefault();

      const $item = $(this).closest("._variation-gallery-preview-item");
      const $row = $(this).closest("._variation-gallery-admin-field");
      const $input = $row.find("._variation-gallery-ids");

      if (!$item.length || !$row.length || !$input.length) {
        return;
      }

      $item.remove();
      syncInputFromPreview($row);
      markVariationAsChanged($input);
    });

    $(document.body).on("woocommerce_variations_loaded", function () {
      initPreviewSortable($(document));
    });
  });
})(jQuery);
