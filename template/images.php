<?php
/*
Template Name: Upload Images
*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Upload Images</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.1/simple-lightbox.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f3f3;
            margin: 0;
            padding-top: 60px;
        }

        #header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background: #fff;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        #header-bar img.logo-header {
            height: 60px;
        }

        #logout-btn {
            background: #268B32;
            margin-right: 40px;
            color: #fff;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            display: none;
        }

        .login-container {
            max-width: 400px;
            margin: 80px auto 20px;
            padding: 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-container img.logo {
            display: block;
            margin: 0 auto 20px;
            width: 250px;
        }

        .login-container input {
            width: 70%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 6px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }

        .login-container button {
            background-color: #268B32;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: #1f6f28;
        }

        #upload-container {
            max-width: 500px;
            margin: 40px auto;
            padding: 25px;
            background: #fff;
            border-radius: 12px;
            display: none;
        }

        #before-list img,
        #after-list img {
            width: 120px;
            border-radius: 8px;
            cursor: pointer;
            display: block;
            margin-bottom: 5px;
        }

        .gallery-section {
            display: flex;
            gap: 20px;
        }

        .gallery-wrapper {
            text-align: center;
        }

        #status {
            margin-top: 15px;
        }

        #barcode {
            flex: 1;
            padding: 14px;
            font-size: 18px;
            border-radius: 10px;
            border: 1px solid #ccc;
            width: 100%;
        }

        .search-box {
            display: flex;
            gap: 8px;
            margin-bottom: 15px;
        }

        #search-btn {
            padding: 0 18px;
            font-size: 20px;
            background: #268B32;
            color: #fff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
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

        .hidden-link {
            display: none;
        }

        .delete-btn {
            display: block;
            margin-top: 5px;
            color: red;
            cursor: pointer;
            font-size: 12px;
        }

        /* ===== Mobile friendly ===== */
        #upload-container {
            margin: 15px;
            padding: 15px;
        }

        h3 {
            color: #268B32;
            margin-bottom: 10px;
        }

        button {
            background: #268B32;
            color: #fff;
        }

        button:hover {
            background: #1f6f28;
        }

        #uploadBtn {
            width: 100%;
            padding: 14px;
            font-size: 18px;
            border-radius: 10px;
        }

        /* ===== Slider gallery ===== */
        .gallery-section {
            display: block;
        }

        .gallery-wrapper {
            margin-bottom: 25px;
        }

        .slider {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            padding-bottom: 10px;
        }

        .slider::-webkit-scrollbar {
            display: none;
        }

        .slider-item {
            flex: 0 0 auto;
            scroll-snap-align: center;
            text-align: center;
        }

        .slider-item img {
            width: 140px;
            height: auto;
            border-radius: 10px;
        }

        .delete-btn {
            font-size: 12px;
            margin-top: 6px;
        }

        /* موبایل */
        @media (max-width: 480px) {
            #barcode {
                font-size: 16px;
                padding: 12px;
            }

            #search-btn {
                font-size: 18px;
            }

            .slider-item img {
                width: 120px;
            }
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <div id="header-bar">
        <img src="https://finservice.ir/wp-content/uploads/2025/11/WhatsApp-Image-2025-11-22-at-19.01.08_35603e30-1.jpg" class="logo-header" alt="Logo">
        <button id="logout-btn" class="inline-flex items-center justify-center rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300">⎋ Logout</button>
    </div>

    <div class="login-container" id="login-form-container">
        <img src="https://finservice.ir/wp-content/uploads/2025/11/WhatsApp-Image-2025-11-22-at-19.01.08_35603e30.jpg" class="logo" alt="Logo">
        <form id="custom-login-form">
            <input type="text" name="username" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" placeholder="Email Or Username" required>
            <input type="password" name="password" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" placeholder="Password" required>
            <br>
            <button type="submit" id="login-btn" class="inline-flex items-center justify-center rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300">Login</button>
        </form>
        <div id="login-message"></div>
    </div>

    <div id="upload-container">
        <div class="search-box">
            <input type="text" id="barcode" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" placeholder="Scan or Enter Barcode">
            <button id="search-btn" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-100">🔍</button>
        </div><br>
        <div class="gallery-section">
            <div class="gallery-wrapper">
                <h3>Before</h3>
                <div id="before-list" class="slider"></div>
            </div>
            <div class="gallery-wrapper">
                <h3>After</h3>
                <div id="after-list" class="slider"></div>
            </div>
        </div>
        <br>
        <input type="file" id="photo" class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none" accept="image/*" multiple>
        <div style="margin:10px 0;">
            <label><input type="radio" class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500/30" name="stageType" value="before" checked> Before</label>
            <label style="margin-left:20px;"><input type="radio" class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500/30" name="stageType" value="after"> After</label>
        </div>
        <br>
        <button id="uploadBtn" class="inline-flex items-center justify-center rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300">Upload</button>
        <div id="status"></div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.5.0/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.14.1/simple-lightbox.jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

    <script>
        function getCookie(name) {
            return document.cookie.replace(new RegExp("(?:(?:^|.*;\\s*)" + name + "\\s*\\=\\s*([^;]*).*$)|^.*$"), "$1");
        }
        $('#search-btn').click(function() {
            const barcode = $('#barcode').val().trim();
            if (!barcode) {
                $('#message').text('Enter barcode');
                return;
            }
            if (barcode.length > 0)
                loadOrderDetailAndImages(barcode);;
        });
        $('#barcode').keypress(function(e) {
            if (e.key === 'Enter') {
                $('#search-btn').click();
            }
        });
        jQuery(document).ready(function() {
            var token = getCookie("auth_token");
            var is_admin = localStorage.getItem('is_admin');
            if (token && is_admin) {
                jQuery('#login-form-container').hide();
                jQuery('#upload-container').show();
                jQuery('#logout-btn').show();
            }

            jQuery('#logout-btn').on('click', function() {
                document.cookie = "auth_token=; path=/; max-age=0";
                localStorage.removeItem('is_admin');
                jQuery('#upload-container').hide();
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
                            if (!res.is_admin || res.is_admin === 0) {
                                jQuery('#login-message').text("Access Denied");
                                btn.prop('disabled', false);
                                btn.html('Login');
                                return;
                            }
                            document.cookie = "auth_token=" + res.token + "; path=/; max-age=3600";
                            localStorage.setItem('is_admin', res.is_admin);
                            jQuery('#login-form-container').hide();
                            jQuery('#upload-container').show();
                            jQuery('#logout-btn').show();
                            btn.prop('disabled', false);
                            btn.html('Login');
                        } else {
                            jQuery('#login-message').text(res.message || 'Invalid Email or Password');
                            btn.prop('disabled', false);
                            btn.html('Login');
                        }
                    },
                    error: function(xhr) {
                        let err = "Server Connection Error";
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            err = xhr.responseJSON.error
                        }
                        jQuery('#login-message').text(err);
                        btn.prop('disabled', false);
                        btn.html('Login');
                    }
                });
            });
        });

        function resizeImage(file, maxW = 800, maxH = 800, quality = 0.7) {
            return new Promise(resolve => {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = new Image();
                    img.onload = () => {
                        let w = img.width,
                            h = img.height;
                        if (w > h && w > maxW) {
                            h *= maxW / w;
                            w = maxW;
                        } else if (h > maxH) {
                            w *= maxH / h;
                            h = maxH;
                        }
                        const canvas = document.createElement("canvas");
                        canvas.width = w;
                        canvas.height = h;
                        canvas.getContext("2d").drawImage(img, 0, 0, w, h);
                        canvas.toBlob(blob => resolve(blob), "image/jpeg", quality);
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            });
        }

        function generateFileName(barcode, index) {
            return `${barcode}_${Date.now()}_${index}.jpg`;
        }

        async function loadOrderDetailAndImages(barcode) {
            const token = getCookie("auth_token");
            if (!token) {
                alert("Session expired");
                return;
            }

            jQuery("#before-list").html("Loading...");
            jQuery("#after-list").html("Loading...");
            jQuery("#status").html(`<span style="color:blue">Loading...</span>`);

            try {
                const res = await fetch(`https://reonet-api.onrender.com/api/Orders/get-detail-by-barcode?barcode=${barcode}`, {
                    headers: {
                        "Authorization": "Bearer " + token
                    }
                });
                if (!res.ok) {
                    jQuery("#status").html(`<span style="color:red">Invalid barcode or no data found</span>`);
                    return;
                }
                const data = await res.json();
                localStorage.setItem("current_srl_orderdetail", data.srl);

                const beforeImages = data.images.filter(img => img.stage === "before");
                const afterImages = data.images.filter(img => img.stage === "after");

                prepareGallery("before", beforeImages);
                prepareGallery("after", afterImages);

                jQuery("#status").html(`<span style="color:green">Ready to upload</span>`);
            } catch (err) {
                console.error(err);
                jQuery("#status").html(`<span style="color:red">Error loading data</span>`);
            }
        }

        function prepareGallery(type, images) {
            const container = document.getElementById(type + "-list");
            container.innerHTML = "";

            if (!images || images.length === 0) {
                container.innerHTML = "<em>No images</em>";
                return;
            }

            images.forEach(img => {
                const wrapper = document.createElement("div");
                wrapper.className = "slider-item";

                const link = document.createElement("a");
                link.href = img.file_Path;
                link.innerHTML = `<img src="${img.file_Path}" alt="${type}">`;

                const delBtn = document.createElement("span");
                delBtn.className = "delete-btn";
                delBtn.textContent = "Delete";

                delBtn.onclick = async function(e) {
                    e.preventDefault();
                    if (!confirm("Delete this image?")) return;

                    try {
                        const apiKey = "955384321754546";
                        const apiSecret = "ejBFIvkZzWA2WsrfJv5_JVmXcSI";
                        const timestamp = Math.floor(Date.now() / 1000);
                        const stringToSign = `public_id=${img.public_id}&timestamp=${timestamp}${apiSecret}`;
                        const sha1 = CryptoJS.SHA1(stringToSign).toString();

                        const formData = new FormData();
                        formData.append("public_id", img.public_id);
                        formData.append("signature", sha1);
                        formData.append("api_key", apiKey);
                        formData.append("timestamp", timestamp);

                        await fetch(`https://api.cloudinary.com/v1_1/dxxyfc9nm/image/destroy`, {
                            method: "POST",
                            body: formData
                        });
                        await fetch(`https://reonet-api.onrender.com/api/ReonetOrderImage/${img.srl}`, {
                            method: "DELETE",
                            headers: {
                                "Authorization": "Bearer " + getCookie("auth_token")
                            }
                        });

                        wrapper.remove();
                    } catch (err) {
                        alert("Delete failed");
                        console.error(err);
                    }
                };

                wrapper.appendChild(link);
                wrapper.appendChild(delBtn);
                container.appendChild(wrapper);
            });

            $(container).find('a').simpleLightbox({});
        }


        //jQuery("#barcode").on("blur", function(){ let barcode=jQuery(this).val().trim(); if(barcode.length>0) loadOrderDetailAndImages(barcode); });

        document.getElementById("uploadBtn").onclick = async function() {
            const barcode = document.getElementById("barcode").value;
            const files = document.getElementById("photo").files;
            const srlOrderDetail = localStorage.getItem("current_srl_orderdetail");
            const stageType = document.querySelector("input[name='stageType']:checked").value;

            if (!barcode) return alert("Enter barcode");
            if (!srlOrderDetail) return alert("OrderDetail SRL not found");
            if (files.length === 0) return alert("Select image(s)");

            const statusBox = document.getElementById("status");
            statusBox.innerHTML = "";
            for (let i = 0; i < files.length; i++) {
                statusBox.innerText = `Resizing image ${i+1}...`;
                const resized = await resizeImage(files[i]);
                const formData = new FormData();
                formData.append("file", resized, generateFileName(barcode, i + 1));
                formData.append("upload_preset", 'unsigned_barcode_upload');
                statusBox.innerText = `Uploading ${i+1}...`;

                try {
                    const cloudRes = await axios.post(`https://api.cloudinary.com/v1_1/dxxyfc9nm/upload`, formData);
                    const uploadedUrl = cloudRes.data.secure_url;
                    const publicId = cloudRes.data.public_id; // دریافت public_id

                    statusBox.innerText = `Saving ${i+1} to server...`;
                    await fetch("https://reonet-api.onrender.com/api/ReonetOrderImage/add", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Authorization": "Bearer " + getCookie("auth_token")
                        },
                        body: JSON.stringify({
                            srl_OrderDetail: parseInt(srlOrderDetail),
                            media_Type: "image",
                            file_Path: uploadedUrl,
                            public_id: publicId, // ذخیره در دیتابیس
                            stage: stageType,
                            created_At: new Date().toISOString()
                        })
                    });
                } catch (err) {
                    console.error(err);
                    statusBox.innerHTML += `<p style="color:red">Upload Failed for image ${i+1}</p>`;
                }
            }
            statusBox.innerText = "Upload completed!";
            document.getElementById("photo").value = "";
            loadOrderDetailAndImages(barcode);
        };
    </script>
</body>

</html>
