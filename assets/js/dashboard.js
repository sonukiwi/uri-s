let loader = document.getElementById('loader');
let currentUrlInfoId = 1;
function isValidHttpUrl(string) {
    let url;

    try {
        url = new URL(string);
    } catch (_) {
        return false;
    }

    return url.protocol === "http:" || url.protocol === "https:";
}
$("#add_record_form").on('submit', (e) => {
    e.preventDefault();
    let url = $("#url").val();
    if (!isValidHttpUrl(url)) {
        document.getElementById('url_error').style.display = "inline";
    }
    else {
        document.getElementById('url_error').style.display = "none";
        let description = $("#description").val();
        console.log($("#add_record_form").serialize());
        $.ajax({
            type: "post",
            url: `${baseUrl}generate_short_url`,
            data: $("#add_record_form").serialize(),
            dataType: "json",
            beforeSend: function () {
                block_ui();
            },
            success: function (response) {
                let toast = document.getElementById('toast');
                if (response[0] === true) {
                    toast.style.backgroundColor = "green";
                    show_toast(2000, "URL shorted successfully. ");
                    document.getElementById('url').value = "";
                    document.getElementsByClassName('generate_short_url_description')[0].value = ""; 
                }
                else {
                    toast.style.backgroundColor = "red";
                    show_toast(2000, response[1]);
                }
                setTimeout(() => {
                    unblock_ui();
                }, 2000);
            }
        });
    }
})

function show_toast(duration, message) {
    let toast = document.getElementById('toast');
    toast.innerHTML = `<span>${message}</span>`;
    toast.style.display = "block";
    setTimeout(() => {
        toast.style.display = "none";
    }, duration);
}

function block_ui() {
    document.getElementById('block_ui').style.display = "block";
}

function unblock_ui() {
    document.getElementById('block_ui').style.display = "none";
}

function open_url_info(actualUrl, clicks, createdAt, status, description, id) {
    currentUrlInfoId = id;
    document.getElementById('url_info').style.display = "flex";
    document.getElementById('actual_url').innerText = actualUrl;
    const actualUrlOutsideElement = document.getElementById('actual_url_outside');
    actualUrlOutsideElement.setAttribute('href', actualUrl);
    actualUrlOutsideElement.setAttribute('target', "_blank");
    actualUrlOutsideElement.style.color = "black";
    document.getElementById('clicks').innerText = clicks;
    document.getElementById('created_at').innerText = createdAt;
    document.getElementById('status').innerText = status ? "Deactivate" : "Activate";
    document.getElementById('status').setAttribute('class', status ? 'btn btn-danger' : 'btn btn-success');
    document.getElementById('description').innerText = description ? description : "No Description Found";
}

function close_url_info() {
    document.getElementById('url_info').style.display = "none";
}

$("#status").on('click', (e) => {
    $.ajax({
        type: "post",
        url: `${baseUrl}change_status`,
        data: 'id=' + currentUrlInfoId,
        dataType: "json",
        beforeSend: function () {
            block_ui();
        },
        success: function (response) {
            if (response[0]) {
                document.getElementById('toast').style.backgroundColor = "green";
            }
            else {
                document.getElementById('toast').style.backgroundColor = "red";
            }
            show_toast(2000, response[1]);
            setTimeout(() => {
                unblock_ui();
                window.location.reload();
            }, 2000);
        }
    });
})

$("#change_password").on('submit', (e) => {
    e.preventDefault();
    let formData = $("#change_password").serialize();
    let currentPassword = document.getElementById('current_password').value;
    let newPassword = document.getElementById('new_password').value;
    let changePasswordError = document.getElementById('change_password_error');
    let moveAhead = true;
    if (!currentPassword || !newPassword || currentPassword.length < 8 || newPassword.length < 8) {
        changePasswordError.style.display = "inline";
        moveAhead = false;
    }
    else {
        changePasswordError.style.display = "none";
        moveAhead = true;
    }
    if (moveAhead) {
        $.ajax({
            type: "post",
            url: baseUrl + 'change_password',
            data: `${formData}`,
            dataType: "json",
            beforeSend: function() 
            {
                block_ui(); 
            }, 
            success: function (response) {
                let toastElement = document.getElementById('toast'); 
                if(response[0]) 
                {
                    toastElement.style.backgroundColor = "green"; 
                    setTimeout(() => {
                        unblock_ui(); 
                        window.location.href = baseUrl + 'logout'; 
                    }, 2000); 
                } 
                else 
                {
                    toastElement.style.backgroundColor = "red"; 
                }
                show_toast(2000, response[1]); 
            }
        });
    }
})
