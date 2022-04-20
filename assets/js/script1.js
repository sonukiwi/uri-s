let registerDetails = {}
let loginDetails = {}
let block_ui_element = document.getElementById('block_ui');
let forgotPasswordEmail = "";
let forgotPasswordNewPassword = ""; 

function blockUI() {
    block_ui_element.style.display = "block";
}
function unblockUI() {
    block_ui_element.style.display = "none";
}

function pageLoaded() {
    // document.getElementById('white_cover').style.display = "none";
    // document.getElementById('content').style.display = "block";
    setTimeout(() => {
        document.getElementById('white_cover').style.display = "none";
        document.getElementById('content').style.display = "block";
    }, 1000);
}

function loginButtonClicked() {
    document.getElementById('home_page_login_button').style.borderBottom = "2px solid red";
    document.getElementById('home_page_register_button').style.borderBottom = "none";
    document.getElementById('register_form').style.display = "none";
    document.getElementById('login_form').style.display = "block";
}

function registerButtonClicked() {
    document.getElementById('home_page_register_button').style.borderBottom = "2px solid red";
    document.getElementById('home_page_login_button').style.borderBottom = "none";
    document.getElementById('register_form').style.display = "block";
    document.getElementById('login_form').style.display = "none";
}

let login_show_password = document.getElementById('login_show_password');
let register_show_password = document.getElementById('register_show_password');

login_show_password.addEventListener('click', (e) => {
    if (login_show_password.innerText == "SHOW")
        login_show_password.innerText = "HIDE";
    else
        login_show_password.innerText = "SHOW";
});

register_show_password.addEventListener('click', (e) => {
    if (register_show_password.innerText == "SHOW")
        register_show_password.innerText = "HIDE";
    else
        register_show_password.innerText = "SHOW";
});

$("#register_email").keyup(function (e) {
    const email = e.target.value;
    if (!validateEmail(email)) {
        $("#register_email_error").css('display', 'inline');
    }
    else {
        $("#register_email_error").css('display', 'none');
    }
});

$("#register_password").keyup(function (e) {
    const password = e.target.value;
    if (!validatePassword(password)) {
        $("#register_password_error").css('display', 'inline');
    }
    else {
        $("#register_password_error").css('display', 'none');
    }
})

$("#login_email").keyup(function (e) {
    const email = e.target.value;
    if (!validateEmail(email)) {
        $("#login_email_error").css('display', 'inline');
    }
    else {
        $("#login_email_error").css('display', 'none');
    }
});

$("#login_password").keyup(function (e) {
    const password = e.target.value;
    if (!validatePassword(password)) {
        $("#login_password_error").css('display', 'inline');
    }
    else {
        $("#login_password_error").css('display', 'none');
    }
})

function validateEmail(input) {
    var validRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (input.match(validRegex)) {
        return true;
    } else {
        return false;
    }
}

function validatePassword(input) {
    return input.length >= 8;
}

$("#register_form").on('submit', (e) => {
    e.preventDefault();
    let proceedToSubmit = true;
    if (!validateEmail($("#register_email").val())) {
        $("#register_email_error").css('display', 'inline');
        proceedToSubmit = false;
    }
    else {
        $("#register_email_error").css('display', 'none');
    }
    if (!validatePassword($("#register_password").val())) {
        $("#register_password_error").css('display', 'inline');
        proceedToSubmit = false;
    }
    else {
        $("#register_password_error").css('display', 'none');
    }
    if (proceedToSubmit) {
        registerDetails.email = $("#register_email").val();
        registerDetails.password = $("#register_password").val();
        let formData = $("#register_form").serialize();
        $.ajax({
            type: "post",
            url: window.location + "register_validation",
            data: formData,
            dataType: "json",
            beforeSend: function () {
                $("#register_login_form_submit_loader_div").css('display', 'flex');
                $("#home_page_login_register").css('opacity', 0.5);
                blockUI();
            },
            success: function (response) {

                if (!response[0]) {
                    $("#register_login_form_submit_loader_div").css('display', 'none');
                    $("#home_page_login_register").css('opacity', 1.0);
                    document.getElementById('toast').style.backgroundColor = "red";
                    show_toast(2000, response[1]);

                }
                else {
                    $("#register_login_form_submit_loader_div").css('display', 'none');
                    $("#home_page_login_register").css('opacity', 1.0);
                    $("#verify_otp").css('display', 'flex');
                    $("#login_form").css('display', 'none');
                    $("#register_form").css('display', 'none');
                    $("#home_page_login_register_buttons_div").css('display', 'none');
                    document.getElementById('toast').style.backgroundColor = "green";
                    show_toast(2000, response[1]);
                }
                setTimeout(() => {
                    unblockUI();
                }, 2000);
            }
        });
    }
})

$("#login_form").on('submit', (e) => {
    e.preventDefault();
    let proceedToSubmit = true;
    if (!validateEmail($("#login_email").val())) {
        $("#login_email_error").css('display', 'inline');
        proceedToSubmit = false;
    }
    else {
        $("#login_email_error").css('display', 'none');
    }
    if (!validatePassword($("#login_password").val())) {
        $("#login_password_error").css('display', 'inline');
        proceedToSubmit = false;
    }
    else {
        $("#login_password_error").css('display', 'none');
    }
    if (proceedToSubmit) {
        loginDetails.email = $("#login_email").val();
        loginDetails.password = $("#login_password").val();
        let formData = $("#login_form").serialize();
        $.ajax({
            type: "post",
            url: window.location + "login_validation",
            data: formData,
            dataType: "json",
            beforeSend: function () {
                $("#register_login_form_submit_loader_div").css('display', 'flex');
                $("#home_page_login_register").css('opacity', 0.5);
                blockUI();
            },
            success: function (response) {
                if (!response[0]) {
                    $("#register_login_form_submit_loader_div").css('display', 'none');
                    $("#home_page_login_register").css('opacity', 1.0);
                    document.getElementById('toast').style.backgroundColor = "red";
                    show_toast(2000, response[1]);
                }
                else {
                    $("#register_login_form_submit_loader_div").css('display', 'none');
                    $("#home_page_login_register").css('opacity', 1.0);
                    document.getElementById('toast').style.backgroundColor = "green";
                    show_toast(2000, response[1]);
                    setTimeout(() => {
                        window.location.href = `${location.href}dashboard`;
                    }, 2000);
                }
                setTimeout(() => {
                    unblockUI();
                }, 2000);
            }
        });
    }
})

$("#login_form").on('submit', (e) => {

});

$("#register_show_password").on('click', (e) => {
    if ($("#register_password").attr('type') == "text") {
        $("#register_password").attr('type', 'password');
    }
    else {
        $("#register_password").attr('type', 'text');
    }
});

$("#login_show_password").on('click', (e) => {
    if ($("#login_password").attr('type') == "text") {
        $("#login_password").attr('type', 'password');
    }
    else {
        $("#login_password").attr('type', 'text');
    }
});

$("#verify_otp").on('submit', (e) => {
    e.preventDefault();
    let formData = $("#verify_otp").serialize();
    formData = `${formData}&email=${registerDetails.email}&password=${registerDetails.password}`;
    $.ajax({
        type: "post",
        url: window.location.href + "verify_otp",
        data: formData,
        dataType: "json",
        beforeSend: function () {
            blockUI();
        },
        success: function (response) {
            if (response) {
                document.getElementById('toast').style.backgroundColor = "green";
                show_toast(2000, 'You have registered successfully. Please login now');
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
            else {
                document.getElementById('toast').style.backgroundColor = "red";
                show_toast(2000, 'Entered OTP is not valid');
            }
            setTimeout(() => {
                unblockUI();
            }, 2000);
        }
    });
})

$("#forgot_password_verify_otp").on('submit', (e) => {
    e.preventDefault();
    let formData = $("#forgot_password_verify_otp").serialize();
    formData = `${formData}&email=${forgotPasswordEmail}`;
    $.ajax({
        type: "post",
        url: window.location.href + "forgot_password_verify_otp",
        data: formData,
        dataType: "json",
        beforeSend: function () {
            blockUI();
        },
        success: function (response) {
            let toast = document.getElementById('toast');
            if (response[0]) {
                toast.style.backgroundColor = "green";
                let tempHtml = '<span>Click <button style="border-radius:0px;" onclick="copy_new_password()" id="copy_new_password" class="btn btn-secondary">here</button> to copy your new password';
                show_toast_with_html(100000, tempHtml);
                forgotPasswordNewPassword = response[1];  
            }
            else {
                toast.style.backgroundColor = "red";
                show_toast(2000, response[1]);
            }
            unblockUI();
        }
    });
})

function show_toast(duration, message) {
    let toast = document.getElementById('toast');
    toast.innerHTML = `<span>${message}</span>`;
    toast.style.display = "block";
    setTimeout(() => {
        toast.style.display = "none";
    }, duration);
}

function show_toast_with_html(duration, html) {
    let toast = document.getElementById('toast');
    toast.innerHTML = html;
    toast.style.display = "block";
    setTimeout(() => {
        toast.style.display = "none";
    }, duration);
}


$("#forgot_password").on('click', (e) => {
    $("#forgot_password_form").css('display', 'block');
    $("#login_form").css('display', 'none');
    $("#register_form").css('display', 'none');
    $("#home_page_login_register_buttons_div").css('display', 'none');
})

$("#forgot_password_form").on('submit', (e) => {
    e.preventDefault();
    let forgotPasswordEmailError = document.getElementById('forgot_password_email_error');
    let proceedFurther = true;
    if (!validateEmail($("#forgot_password_email").val())) {
        forgotPasswordEmailError.style.display = "inline";
        proceedFurther = false;
    }
    else {
        forgotPasswordEmailError.style.display = "none";
        proceedFurther = true;
    }
    if (proceedFurther) {
        let formData = $("#forgot_password_form").serialize();
        let loaderDiv = document.getElementById('register_login_form_submit_loader_div');
        $.ajax({
            type: "post",
            url: baseUrl + 'forgot_password',
            data: formData,
            dataType: "json",
            beforeSend: function () {
                blockUI();
                loaderDiv.style.display = "flex";
                $("#home_page_login_register").css('opacity', 0.5);
            },
            success: function (response) {
                loaderDiv.style.display = "none";
                forgotPasswordEmail = $("#forgot_password_email").val();
                $("#home_page_login_register").css('opacity', 1);
                let toast = document.getElementById('toast');
                if (response[0]) {
                    toast.style.backgroundColor = "green";
                    $("#forgot_password_form").css('display', 'none');
                    $("#verify_otp").css('display', 'none');
                    $("#forgot_password_verify_otp").css('display', 'block');
                    $("#login_form").css('display', 'none');
                    $("#register_form").css('display', 'none');
                    $("#home_page_login_register_buttons_div").css('display', 'none');
                }
                else {
                    toast.style.backgroundColor = "red";
                }
                show_toast(2000, response[1]);
                setTimeout(() => {
                    unblockUI();
                }, 2000);
            }
        });
    }
})

function copy_new_password() {
    navigator.clipboard.writeText(forgotPasswordNewPassword);
    document.getElementById('copy_new_password').innerText = "Copied"; 
}