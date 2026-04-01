<?php
/* Template Name: Carpet Status */
?>

<!DOCTYPE html>
<html lang="fa">
<head>
<meta charset="UTF-8">
<title>Carpet Status</title>

<style>
body { font-family: Tahoma, sans-serif; background:#f3f3f3; margin:0; padding-top:60px; }
#header-bar { display:flex; justify-content:space-between; align-items:center; padding:10px 20px; background:#fff; position:fixed; top:0; width:100%; z-index:1000; box-shadow:0 2px 5px rgba(0,0,0,0.1); }
#header-bar img.logo-header { height:60px; }
#logout-btn { background:#268B32;margin-right: 40px; color:#fff; border:none; padding:6px 12px; border-radius:4px; cursor:pointer; display:none; }

.login-container{ max-width:400px; margin:80px auto 20px; padding:20px; background:#fff; border-radius:12px; box-shadow:0 5px 20px rgba(0,0,0,0.1); text-align:center; }
.login-container img.logo { display:block; margin:0 auto 20px; width:250px; }
.login-container input { width:70%; padding:12px; margin:10px 0; border-radius:6px; border:1px solid #ddd; box-sizing:border-box; }
.login-container button { background-color:#268B32; color:#fff; padding:12px 20px; border:none; border-radius:6px; cursor:pointer; }
.login-container button:hover { background-color:#1f6f28; }
#login-message { color:red; margin-top:10px; }

.search-box {
    display: flex;
    gap: 8px;
    margin-bottom: 15px;
}

#barcode {   flex: 1; padding: 14px;font-size: 18px;border-radius: 10px;border: 1px solid #ccc; width:100%;}

#search-btn {
    padding: 0 18px;
    font-size: 20px;
    background: #268B32;
    color: #fff;
    border: none;
    border-radius: 10px;
    cursor: pointer;
}

.status-btn.active {
    background: #1f4fff; 
}	
.status-app { max-width:500px; margin:20px auto; padding:15px; display:none; }
.grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.status-btn { padding:18px; background:#268B32; color:#fff; border-radius:10px; text-align:center; font-size:16px; cursor:pointer; }
.status-btn:active { background:#1565c0; transform:scale(0.97); }

.status-btn:disabled {
    background: #9e9e9e;
    cursor: not-allowed;
}
#message { margin-top:15px; font-size:14px; }
.loading-spinner { border:3px solid #f3f3f3; border-top:3px solid #3498db; border-radius:50%; width:16px; height:16px; animation:spin 0.9s linear infinite; display:inline-block; margin-left:8px; }
@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
</style>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="manifest" href="/manifest.json">
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

<div class="status-app" id="status-app">

    <div class="search-box">
        <input type="text" id="barcode" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" placeholder="Scan or Enter Barcode">
        <button id="search-btn" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-100">🔍</button>
    </div>

    <div id="order-info"></div>
    <div id="status-buttons" class="grid"></div>
    <div id="message"></div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

<script>
	$('#search-btn').click(function(){
    const barcode = $('#barcode').val().trim();
    if(!barcode){
        $('#message').text('Enter barcode');
        return;
    }
    searchByBarcode(barcode);
});
	$('#barcode').keypress(function(e){
    if(e.key === 'Enter'){
        $('#search-btn').click();
    }
});
	let statuses = [];
    function loadStatuses(serviceCategoryId){
        const token = getCookie("auth_token");
        $.ajax({
            url:`https://reonet-api.onrender.com/api/OrderStatus/by-service-category/${serviceCategoryId}`,
            method:'GET',
            headers:{ 'Authorization':'Bearer '+token },
            success:function(data){
                statuses=data||[];
                const container = $('#status-buttons').empty();
                statuses.forEach(status=>{
                    const btn = $('<button>')
                        .addClass('status-btn')
                        .text(status.title)
                        .prop('disabled',true)
                        .data('id',status.srl)
                        .click(() => { updateStatus(status); });
                    container.append(btn);
                });
            },
            error:function(){ $('#message').text('Cannot fetch statuses'); }
        });
    }

function getCookie(name){ return document.cookie.replace(new RegExp("(?:(?:^|.*;\\s*)"+name+"\\s*\\=\\s*([^;]*).*$)|^.*$"), "$1"); }
$(document).ready(function(){
    var token = getCookie("auth_token");
    var is_admin = localStorage.getItem('is_admin');

    if(token && is_admin){ 
        $('#login-form-container').hide();
		$('#status-app').show();
		$('#logout-btn').show();
		loadStatuses(3); // نمونه: service category = 3
		}

    $('#logout-btn').click(function(){
        document.cookie = "auth_token=; path=/; max-age=0";
        localStorage.removeItem('is_admin');
        $('#status-app').hide();
        $('#login-form-container').show();
        $('#logout-btn').hide();
    });

    $('#custom-login-form').submit(function(e){
        e.preventDefault();
        var email = $(this).find('input[name="username"]').val();
        var password = $(this).find('input[name="password"]').val();
        let btn = $('#login-btn'); btn.prop('disabled', true); btn.html('Login... <span class="loading-spinner"></span>');

        $.ajax({
            url:'https://reonet-api.onrender.com/api/Auth/login',
            method:'POST',
            data: JSON.stringify({email,password}),
            contentType:'application/json',
            success: function(res){
                if(res.token){
                    if(!res.is_admin || res.is_admin===0){ 
                        $('#login-message').text("Access Denied"); 
                        btn.prop('disabled',false); 
                        btn.html('Login'); 
                        return; 
                    }
                    document.cookie = "auth_token="+res.token+"; path=/; max-age=3600";
                    localStorage.setItem('is_admin',res.is_admin);
                    btn.prop('disabled',false); 
                    btn.html('Login'); 
                    $('#login-form-container').hide();
					$('#status-app').show();
					$('#logout-btn').show();
					loadStatuses(3); // نمونه: service category = 3
                } else { 
                    $('#login-message').text(res.message || 'Invalid Email or Password'); 
                    btn.prop('disabled',false); 
                    btn.html('Login'); 
                }
            },
            error: function(xhr){ 
                let err="Server Connection Error"; 
                if(xhr.responseJSON && xhr.responseJSON.error){ err=xhr.responseJSON.error } 
                $('#login-message').text(err); 
                btn.prop('disabled',false); 
                btn.html('Login'); 
            }
        });
    });
});

let currentOrder = null;
let currentStatusId = null;
async function searchByBarcode(barcode){
    const token = getCookie("auth_token");
    $('#message').text('Searching...');
    $('#order-info').empty();
    $('.status-btn').removeClass('active');

    try{
        const res = await fetch(
            `https://reonet-api.onrender.com/api/Orders/get-detail-by-barcode?barcode=${barcode}`,
            { headers:{ "Authorization":"Bearer "+token } }
        );

        if(!res.ok){
            $('#message').text('Barcode not found');
            return;
        }

        const data = await res.json();
        currentOrder = data;
        currentStatusId = data.srlOrderstatus; // ← فرض: وضعیت فعلی
			

        $('#order-info').html(`
            <strong>Size:</strong>&nbsp; ${data.width}-${data.length}&nbsp;&nbsp;&nbsp;<strong>Service:</strong> ${data.service || '—'} <br><br><br>
        `);

        highlightCurrentStatus();

        $('.status-btn').prop('disabled', false);
        $('#message').text('Select new status');

    }catch(err){
        console.error(err);
        $('#message').text('Server error');
    }
}
	function highlightCurrentStatus(){
    $('.status-btn').each(function(){
        const btnStatusId = $(this).data('id');
		console.log(currentStatusId);
		console.log(btnStatusId);
        if(Number(btnStatusId) === Number(currentStatusId)){
            $(this).addClass('active');
        }
    });
}
function updateStatus(status){
    if(!currentOrder){
        $('#message').text('Search barcode first');
        return;
    }

    const token = getCookie("auth_token");

    $.ajax({
        url:'https://reonet-api.onrender.com/api/Orders/update-status',
        method:'POST',
        headers:{
            'Authorization':'Bearer '+token,
            'Content-Type':'application/json'
        },
        data: JSON.stringify({
            srl: currentOrder.srl,
            statusId: status.srl
        }),
        success:function(){
            currentStatusId = status.srl;
            $('.status-btn').removeClass('active');
            highlightCurrentStatus();
            $('#message').text(`Status changed to "${status.title}"`);
        },
        error:function(){
            $('#message').text('Failed to update status');
        }
    });
}

</script>
</body>
</html>
