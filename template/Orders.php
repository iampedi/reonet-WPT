<?php


?>
<!DOCTYPE html>
<html lang="fa">

<head>
  <meta charset="UTF-8">
  <title>Orders</title>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
  <style>
    .status-1 {
      background-color: #ecf0f1 !important;
    }

    /* Order Received */
    .status-2 {
      background-color: #d6eaff !important;
    }

    /* Washing */
    .status-3 {
      background-color: #ffe0b2 !important;
    }

    /* Drying */
    .status-4 {
      background-color: #d4edda !important;
    }

    /* Ready */
    .status-5 {
      background-color: #1f6f28 !important;
      color: #fff !important;
    }

    /* Delivered */
    .child-content {
      padding: 10px;
      background: #f9f9f9;
      border-radius: 6px;
      overflow-x: auto;
      box-sizing: border-box;
      max-width: 300px
    }

    @media (max-width: 768px) {
      .child-content {
        max-width: 100px !important;
        /* کمی فاصله از لبه‌ها */
        margin: auto;
      }
    }

    .splide {}

    .fullscreen-img {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: contain;
      background-color: rgba(0, 0, 0, 0.9);
      z-index: 9999;
      cursor: zoom-out;
    }

    .splide__arrow {
      background-color: #268B32 !important;
      /* سبز */
      color: #fff !important;
      /* فلش‌ها سفید */
      border-radius: 4px;
      width: 30px;
      height: 30px;
    }

    /* هاور روی دکمه‌ها */
    .splide__arrow:hover {
      background-color: #1f6f28 !important;
      /* سبز تیره‌تر */
    }

    /* نقاط پایینی */
    .splide__pagination__page {
      background-color: #268B32 !important;
      /* نقطه فعال */
      opacity: 0.5;
      /* نقطه غیر فعال کم‌رنگ */
    }

    /* نقطه فعال */
    .splide__pagination__page.is-active {
      background-color: #268B32 !important;
      opacity: 1;
      /* پر رنگ */
    }

    .order-image-slide {

      max-width: 250px;
      /* عکس کوچک‌تر */
      max-height: 250px;
      /* ارتفاع دلخواه */
      object-fit: contain;
      border-radius: 12px;
      /* گوشه‌های گرد زیبا */
      margin: auto;
      display: block;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      transition: transform .3s ease;
    }

    @media (max-width: 768px) {
      .order-image-slide {
        max-width: 50px;
        /* تقریباً عرض کل صفحه */
        max-height: 250px;
      }
    }

    /* بزرگنمایی هنگام کلیک */
    .order-image-slide:active {
      transform: scale(1.5);
    }

    .loading-spinner {
      border: 3px solid #f3f3f3;
      border-top: 3px solid #3498db;
      border-radius: 50%;
      width: 16px;
      height: 16px;
      animation: spin 0.9s linear infinite;
      display: inline-block;
      margin-left: 8px;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    .dt-button.custom-print-btn {
      background: #268B32;
      /* سبز مثل دکمه فیلتر */
      color: #fff;
      border: none;
      padding: 6px 12px;
      border-radius: 4px;
      cursor: pointer;
      margin-left: 10px;
      /* فاصله از دکمه فیلتر */
    }

    .dt-button.custom-print-btn:hover {
      background: #1f6f28;
      /* هاور سبز تیره */
    }

    body {
      font-family: Tahoma, sans-serif;
      background-color: #f5f6fa;
      margin: 0;
      padding: 0;
      padding-top: 60px;
    }

    /* هدر */
    #header-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
      background: #fff;
      /* سفید */
      color: #000;
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
      box-sizing: border-box;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    #header-bar img.logo-header {
      height: 60px;
    }

    #logout-btn {
      background: #268B32;
      /* سبز */
      color: #fff;
      border: none;
      padding: 6px 12px;
      border-radius: 4px;
      cursor: pointer;
      display: none;
    }

    #filter-orders {
      background: #268B32;
      /* سبز */
      color: #fff;
      border: none;
      padding: 6px 12px;
      border-radius: 4px;
      cursor: pointer;
    }

    /* فرم لاگین */
    .login-container {
      max-width: 400px;
      margin: 80px auto 20px;
      /* فاصله از هدر */
      padding: 20px;
      background: #ffffff;
      border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .login-container img.logo {
      display: block;
      margin: 0 auto 20px;
      width: 250px;
    }

    .login-container input[type="text"],
    .login-container input[type="password"],
    .login-container input[type="date"] {
      width: 70%;
      padding: 12px;
      margin: 10px 0;
      border-radius: 6px;
      border: 1px solid #ddd;
      box-sizing: border-box;
    }

    .login-container button,
    .login-container #filter-orders {
      background-color: #268B32;
      color: #fff;
      padding: 12px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .login-container button:hover,
    .login-container #filter-orders:hover {
      background-color: #1f6f28;
    }

    /* جدول سفارشات */
    .orders-container {
      max-width: 90%;
      margin: 20px auto;
      padding: 20px;
      background: #ffffff;
      border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      margin-top: 20px;
    }

    #orders-filter {
      margin-bottom: 20px;
      /* فاصله بین تاریخ و جدول */
    }

    table.dataTable {
      width: 100% !important;
    }

    table.dataTable th,
    table.dataTable td {
      text-align: center;
    }

    #login-message {
      color: red;
      margin-bottom: 10px;
    }

    #orders-table th,
    #orders-table td {
      text-align: left !important;
    }

    #orders-table tfoot th,
    #orders-table tfoot td {
      text-align: left !important;
    }

    .dataTables_paginate .paginate_button.previous:hover,
    .dataTables_paginate .paginate_button.next:hover {
      background: transparent !important;
      border: none !important;
      box-shadow: none !important;
    }

    /* خود دکمه‌های Previous و Next همیشه بدون استایل */
    .dataTables_paginate .paginate_button.previous,
    .dataTables_paginate .paginate_button.next {
      background: transparent !important;
      border: none !important;
      box-shadow: none !important;
    }

    /* شماره صفحات همچنان هاور داشته باشند (دلخواه تو میتونی تغییر بدی) */
    .dataTables_paginate .paginate_button:not(.previous):not(.next):hover {
      background: #268B32 !important;
      color: #fff !important;
      border-radius: 4px;
    }

    /* شماره صفحه انتخاب‌شده (current) */
    .dataTables_paginate .paginate_button.current {
      background: #268B32 !important;
      color: #fff !important;
      border-radius: 4px;
    }
  </style>
</head>

<body>
  <!-- هدر -->
  <div id="header-bar">
    <img src="http://finservice.ir/wp-content/uploads/2025/11/WhatsApp-Image-2025-11-22-at-19.01.08_35603e30-1.jpg" class="logo-header" alt="Logo">
    <button id="logout-btn">⎋ Logout</button>
  </div>

  <div class="login-container" id="login-form-container">
    <img src="http://finservice.ir/wp-content/uploads/2025/11/WhatsApp-Image-2025-11-22-at-19.01.08_35603e30.jpg" class="logo" alt="Logo">
    <form id="custom-login-form">
      <input type="text" name="username" placeholder="Email Or Username" required>
      <input type="password" name="password" placeholder="Password" required>

      <br>
      <button type="submit" id="login-btn">Login</button>
    </form>
    <div id="login-message"></div>
  </div>

  <div class="orders-container" id="orders-container" style="display:none;">
    <div id="orders-filter">
      <label>Start Date: <input type="date" id="start-date"></label>
      <label>End Date: <input type="date" id="end-date"></label>
      <button id="filter-orders">Filter</button>
    </div>
    <div id="orders-table-wrapper"></div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
  <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

  <script>
    function formatDateCustom(date) {
      const y = date.getFullYear();
      const m = ("0" + (date.getMonth() + 1)).slice(-2);
      const d = ("0" + date.getDate()).slice(-2);
      return `${y}/${m}/${d}`;
    }

    function formatDateForInput(date) {
      const y = date.getFullYear();
      const m = ("0" + (date.getMonth() + 1)).slice(-2);
      const d = ("0" + date.getDate()).slice(-2);
      return `${y}-${m}-${d}`;
    }

    function setDefaultDates() {
      const now = new Date();
      const firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
      const lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0);

      document.getElementById("start-date").value = formatDateForInput(firstDay);
      document.getElementById("end-date").value = formatDateForInput(lastDay);

      return {
        start: formatDateCustom(firstDay),
        end: formatDateCustom(lastDay)
      };
    }

    function DefaultDates() {
      const startInput = document.getElementById("start-date").value;
      const endInput = document.getElementById("end-date").value;
      const startDate = startInput ? formatDateCustom(new Date(startInput)) : '';
      const endDate = endInput ? formatDateCustom(new Date(endInput)) : '';
      return {
        start: startDate,
        end: endDate
      };
    }

    jQuery(document).ready(function() {
      var token = document.cookie.replace(/(?:(?:^|.*;\s*)auth_token\s*=\s*([^;]*).*$)|^.*$/, "$1");
      var customerId = localStorage.getItem('customer_id');

      if (token && customerId) {
        window.history.replaceState({}, document.title, "/orders/");
        jQuery('#login-form-container').hide();
        jQuery('#orders-container').show();
        jQuery('#logout-btn').show();

        var defaultDates = setDefaultDates();
        loadOrders(token, customerId, defaultDates.start, defaultDates.end);
      } else {
        jQuery('#login-form-container').show();
        jQuery('#orders-container').hide();
        jQuery('#logout-btn').hide();
      }

      jQuery('#logout-btn').on('click', function() {
        document.cookie = "auth_token=; path=/; max-age=0";
        localStorage.removeItem('customer_id');

        jQuery('#orders-container').hide();
        jQuery('#login-form-container').show();
        jQuery('#logout-btn').hide();
      });

      jQuery('#custom-login-form').on('submit', function(e) {

        e.preventDefault();


        var email = jQuery(this).find('input[name="username"]').val();
        var password = jQuery(this).find('input[name="password"]').val();
        let btn = jQuery('#login-btn');
        btn.prop('disabled', true);
        btn.html('Login... <span class="loading-spinner"></span>');
        jQuery.ajax({
          url: 'https://reonet-api.onrender.com/api/Auth/login',
          method: 'POST',
          data: JSON.stringify({
            email,
            password
          }),
          contentType: 'application/json',
          success: function(res) {
            if (res.token) {
              document.cookie = "auth_token=" + res.token + "; path=/; max-age=3600";
              localStorage.setItem('customer_id', res.srl_customer);

              jQuery('#login-form-container').hide();
              jQuery('#orders-container').show();
              jQuery('#logout-btn').show();
              btn.prop('disabled', false);
              btn.html('Login');
              var defaultDates = setDefaultDates();
              loadOrders(res.token, res.srl_customer, defaultDates.start, defaultDates.end);
            } else {
              jQuery('#login-message').text(res.message || 'Invalid Email or Password!');
            }
          },
          error: function(xhr) {
            let err = "Server Connection Error!";
            btn.prop('disabled', false);
            btn.html('Login');
            if (xhr.responseJSON && xhr.responseJSON.error) {
              err = xhr.responseJSON.error;
            }

            jQuery('#login-message').text(err);
          }
        });
      });

      jQuery('#filter-orders').on('click', function() {
        var token = document.cookie.replace(/(?:(?:^|.*;\s*)auth_token\s*=\s*([^;]*).*$)|^.*$/, "$1");
        var defaultDates = DefaultDates();
        loadOrders(token, localStorage.getItem('customer_id'), defaultDates.start, defaultDates.end);
      });

    });

    function loadOrders(token, customerId, startDate = '', endDate = '') {
      jQuery.ajax({
        url: `https://reonet-api.onrender.com/api/Orders/orderdetail?CustomerId=${customerId}&StartDate=${startDate}&EndDate=${endDate}&status=1`,
        method: 'GET',
        headers: {
          'Authorization': 'Bearer ' + token
        },
        success: function(data) {
          if (!data || data.length === 0) {
            jQuery('#orders-table-wrapper').html('<p>No Order!.</p>');
            return;
          }
          let totalArea = 0;
          let totalPrice = 0;
          data.forEach(item => {
            totalArea += parseFloat(item.area) || 0;
            totalPrice += parseFloat(item.totalprice) || 0;
          });
          var html = '<table id="orders-table" class="display"><thead><tr>' +
            '<th></th>' +
            '<th>Code</th>' +
            '<th>Date</th>' +
            '<th>Service</th>' +
            '<th>Width</th>' +
            '<th>Length</th>' +
            '<th>Area</th>' +
            '<th>Total Price</th>' +
            '<th>Status</th>' +
            '<th style="display:none">StatusId</th>' +
            '</tr></thead><tbody>';

          data.forEach(function(item) {
            html += '<tr>' +
              '<td class="details-control" style="cursor:pointer;">➤</td>' +
              '<td>' + item.barcode + '</td>' +
              '<td>' + item.orderDate + '</td>' +
              '<td>' + item.name + '</td>' +
              '<td>' + item.width + '</td>' +
              '<td>' + item.length + '</td>' +
              '<td>' + item.area + '</td>' +
              '<td>' + item.totalprice + '</td>' +
              '<td>' + item.title + '</td>' +
              '<td style="display:none">' + item.srlOrderstatus + '</td></tr>';
          });

          html += '</tbody><tfoot><tr>' +
            '<th colspan="5" style="text-align:right">Total:</th>' +
            '<th>' + totalArea.toFixed(2) + '</th>' +
            '<th>' + totalPrice.toFixed(2) + '</th>' +
            '<th></th>' +
            '</tr></tfoot></table>';
          jQuery('#orders-table-wrapper').html(html);
          var table = $('#orders-table').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            order: [
              [2, 'desc']
            ],
            dom: '<"dt-top"fB>rtlip',
            rowCallback: function(row, data) {
              // 🔹 ستون وضعیت (SrlOrderstatus)
              // فرض: ستون وضعیت عددی هست
              const statusId = parseInt(data[9]); // اگر SrlOrderstatus ستون 8 هست

              if (statusId === 1) $(row).addClass('status-1');
              if (statusId === 2) $(row).addClass('status-2');
              if (statusId === 3) $(row).addClass('status-3');
              if (statusId === 4) $(row).addClass('status-4');
              if (statusId === 5) $(row).addClass('status-5');
            },
            // 🔹 آیکون‌های قبلی / بعدی
            language: {
              paginate: {
                previous: '<img src="http://finservice.ir/wp-content/uploads/2025/11/Pre.png" style="width:28px;height:28px;background:#268B32;border-radius:4px;">',
                next: '<img src="http://finservice.ir/wp-content/uploads/2025/11/Next.png" style="width:28px;height:28px;background:#268B32;border-radius:4px;">'
              }
            },

            buttons: [{
              extend: 'print',
              text: 'Print',
              className: 'custom-print-btn',
              customize: function(win) {
                $(win.document.body).css('font-family', 'Tahoma, sans-serif');
                $(win.document.body).find('table')
                  .css('width', '100%')
                  .css('border-collapse', 'collapse');
                $(win.document.body).find('table, th, td')
                  .css('border', '1px solid #000')
                  .css('padding', '8px')
                  .css('text-align', 'left');
              }
            }],

            initComplete: function() {
              // 🔹 استایل دکمه Print
              $('.dt-button.custom-print-btn').css({
                'background': '#268B32',
                'color': '#fff',
                'border': 'none',
                'padding': '6px 12px',
                'border-radius': '4px',
                'cursor': 'pointer',
                'margin-left': '10px'
              }).hover(
                function() {
                  $(this).css('background', '#1f6f28');
                },
                function() {
                  $(this).css('background', '#268B32');
                }
              );
            },

            columnDefs: [{
                targets: "_all",
                className: 'dt-left'
              },
              {
                targets: [3, 4, 5, 6],
                type: "num"
              }
            ]
          });
          $('#orders-table tbody').on('click', 'td.details-control', function() {

            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
              row.child.hide();
              tr.removeClass('shown');
              $(this).text('➤'); // فلش بسته
            } else {

              // پیدا کردن داده اصلی آیتم از API
              var rowData = row.data();
              var barcode = rowData[1];
              var item = data.find(d => d.barcode == barcode);

              row.child(formatDetails(item)).show();
              tr.addClass('shown');
              $(this).text('▼'); // فلش باز
            }
          });

        },
        error: function() {
          jQuery('#orders-table-wrapper').html('<p>Error in Getting Order Data.</p>');
        }
      });
    }

    function formatDetails(item) {

      let images = item.images || [];

      let beforeImgs = images.filter(x => x.stage === "before");
      let afterImgs = images.filter(x => x.stage === "after");

      if (images.length === 0)
        return `<div style="padding:10px;">No images found.</div>`;

      // ساختن HTML اسلایدرها
      const buildSlides = (list, id) => {
        if (list.length === 0)
          return "<p>No images.</p>";

        let slides = "";
        list.forEach(img => {
          slides += `
                <li class="splide__slide">

                    <img src="${img.file_Path}" class="order-image-slide" 
                         style="width:100%; border-radius:10px; cursor:pointer;"> style="cursor:pointer;

                </li>
            `;
        });

        return `
            <div id="${id}" class="splide" style="margin-top:10px;">
                <div class="splide__track">
                    <ul class="splide__list">
                        ${slides}
                    </ul>
                </div>
            </div>
        `;
      };

      // خروجی HTML
      let html = `
        <div class="child-content"  >
            <strong>Description:</strong> ${item.description || "—"}
            <br><br>

            <h4>Before</h4>
            ${buildSlides(beforeImgs, "before-" + item.barcode)}

            <h4 style="margin-top:20px;">After</h4>
            ${buildSlides(afterImgs, "after-" + item.barcode)}
        </div>
    `;

      // اجرای اسلایدر پس از رندر
      setTimeout(() => {
        const beforeEl = document.querySelector('#before-' + item.barcode);
        const afterEl = document.querySelector('#after-' + item.barcode);

        if (beforeEl) new Splide(beforeEl, {
          type: 'loop',
          perPage: 1,
          height: 250
        }).mount();
        if (afterEl) new Splide(afterEl, {
          type: 'loop',
          perPage: 1,
          height: 250
        }).mount();
      }, 50);

      return html;
    }
    document.addEventListener('click', function(e) {
      if (e.target.classList.contains('order-image-slide')) {
        const fsImg = document.createElement('img');
        fsImg.src = e.target.src;
        fsImg.className = 'fullscreen-img';
        document.body.appendChild(fsImg);

        fsImg.addEventListener('click', () => fsImg.remove());
      }
    });
  </script>
</body>

</html>