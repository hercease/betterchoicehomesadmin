<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Forgot Password - BetterChoiceGroupHomes | Admin</title>
    <link href="/public/css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="/public/assets/img/favicon/favicon.ico" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Nunito+Sans:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <style>
        body {
            font-family: 'Nunito Sans', sans-serif;
            font-weight: 400;
            color: #333;
        }

        /* Centering the loader */
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            flex-direction: column;
            display: none; /* Initially hidden */
            z-index: 9999;
        }

        /* Rotating Circle */
        .rotating-circle {
            position: relative;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 5px solid transparent;
            border-top: 5px solid #f58634;
            border-right: 5px solid #0b184d;
            animation: spin 1.5s linear infinite;
        }

        /* Static Logo in Center */
        .loader-wrapper {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo {
            position: absolute;
            width: 45px;
            height: 45px;
            object-fit: contain;
            border-radius: 50%;
        }

        /* Spinning Animation */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Loading Text */
        .loading-text {
            margin-top: 10px;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        form .error{
            color : red;
            font-size: 13px;
        }

        /* Customize toast appearance */
        .iziToast.iziToast-color-green {
        border-left: 5px solid #2E7D32;
        }

        .iziToast.iziToast-color-red {
        border-left: 5px solid #C62828;
        }

        .iziToast.iziToast-color-yellow {
        border-left: 5px solid #FF8F00;
        }

        .iziToast.iziToast-color-blue {
        border-left: 5px solid #1565C0;
        }

        .iziToast .iziToast-icon {
        font-size: 1.5em;
        margin-right: 10px;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

<div class="loader-container">
    <div class="loader-wrapper">
        <div class="rotating-circle"></div>
        <img src="public/assets/img/favicon/favicon.ico" alt="Logo" class="logo">
    </div>
    <div class="loading-text"></div>
</div>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-4 mx-auto p-3">
  <div class="card bg-white">
  <div class="card-body">
    <div class="text-center mb-3">
      <img src="/public/assets/img/better-icon-removebg-preview.png" width="60" alt="Logo" />
    </div>
    <div class="text-center mb-4">
      <h4 class="fw-bold mb-0">Better Choice Group Homes </h4>
      <small class="text-muted">Forgot Password</small>
    </div>
    <form name="forgot">
      <div class="mb-3">
        <label for="email" class="form-label text-dark">Email address</label>
        <input type="email" class="form-control border-0 shadow" id="email" name="email" placeholder="Enter your email" required>
      </div>
      <div class="d-grid mb-2">
        <button type="submit" id="submit" class="btn btn-dark">Continue</button>
      </div>
      <div class="d-flex justify-content-between small">
        <a href="login" class="text-dark">Remember Password? Login</a>
      </div>
    </form>
    <div class="text-center text-muted small mt-3">
      &copy; <span id="year"></span> BetterChoiceGroupHomes
    </div>
  </div>
  </div>
  </div>
  </div>
  </div>

    <script>
        document.getElementById('year').textContent = new Date().getFullYear();
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="/public/cdn.jsdelivr.net/npm/bootstrap%405.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
    <script defer="" src="/public/cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
    <script>

    iziToast.settings({
    icon: 'fontawesome',             // Leave blank
    iconUrl: null,        // ⛔ Disable default SVG icon
    // Other options...
    });
      // Toast configuration with Font Awesome icons
    const showToast = {
    success: (message, title = "Success") => {
        iziToast.success({
            title: `<i class="fas fa-check-circle"></i> ${title}`,
            message: message,
            position: 'bottomRight',
            timeout: 5000,
            backgroundColor: '#4CAF50',
            titleColor: '#fff',
            messageColor: '#fff',
            iconColor: '#fff',
            progressBarColor: '#388E3C',
            close: false,
            icon: 'fas fa-check-circle', // ✅ Font Awesome class
            iconUrl: null
        });
    },
    
    error: (message, title = "Error") => {
        iziToast.error({
            title: `<i class="fas fa-times-circle"></i> ${title}`,
            message: message,
            position: 'bottomRight',
            timeout: 5000,
            backgroundColor: '#F44336',
            titleColor: '#fff',
            messageColor: '#fff',
            iconColor: '#fff',
            progressBarColor: '#D32F2F',
            close: false
        });
    },
    
    warning: (message, title = "Warning") => {
        iziToast.warning({
            title: `<i class="fas fa-exclamation-triangle"></i> ${title}`,
            message: message,
            position: 'bottomRight',
            timeout: 5000,
            backgroundColor: '#FF9800',
            titleColor: '#fff',
            messageColor: '#fff',
            iconColor: '#fff',
            progressBarColor: '#F57C00',
            close: false
        });
    },
    
    info: (message, title = "Info") => {
        iziToast.info({
            title: `<i class="fas fa-info-circle"></i> ${title}`,
            message: message,
            position: 'bottomRight',
            timeout: 5000,
            backgroundColor: '#2196F3',
            titleColor: '#fff',
            messageColor: '#fff',
            iconColor: '#fff',
            progressBarColor: '#1976D2',
            close: false
        });
    }
    };

    const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    //document.getElementById('timezone').value = Intl.DateTimeFormat().resolvedOptions().timeZone;

    

	$("form[name='forgot']").validate({
    // Specify validation rules
    rules: {
	    email: {
        required: true,
      },
    },
    // Specify validation error messages
    messages: {
	    email: {
        required: "<i class='fas fa-exclamation-circle'></i> Please enter your email",
      },
    },
    errorPlacement: function (error, element) {
        error.insertAfter(element);
    },
    highlight: function (element) {
      $(element).addClass('is-invalid');


      // 🔽 Scroll to the field
      $('html, body').animate({
          scrollTop: $(element).offset().top - 100
      }, 600);
    },
    unhighlight: function (element) {
        $(element).removeClass('is-invalid');
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form){
		
        var data = $("form[name='forgot']").serialize();
        var spinner = document.querySelector(".loader-container");
        var loadingText = document.querySelector(".loading-text");
        data += '&timezone=' + encodeURIComponent(timezone);  
	  
		$.ajax({
			type : "POST",
			url : "process_forgot_password", //URL to run
			beforeSend: function () {
                $('#submit').attr("disabled", true);
                spinner.style.display = 'flex';
                loadingText.textContent = "Please wait, processing...";
            },
            data: data,
            dataType: 'json',
			success : function(data){
				$('#submit').attr("disabled", false).html('Continue');
				spinner.style.display = 'none';
				loadingText.textContent = "";

                if (data.status) {

                    showToast.success(data.message);
                
                } else {

                    showToast.error(data.message);
                }
			},
			error: function(jqXHR, textStatus, errorThrown){
                spinner.style.display = 'none';
                loadingText.textContent = "";
               showToast.error(textStatus);
				
			    $('#submit').attr("disabled", false).html('Continue');
		},
		}); 
		
        }
    });
	</script>
</body>
</html>
