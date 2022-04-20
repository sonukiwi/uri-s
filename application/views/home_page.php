<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/style1.css">
    <script src="https://kit.fontawesome.com/e166fea5a2.js" crossorigin="anonymous"></script>
    <title>Login | Register to proceed</title>
</head>

<body id="home_page_body" onload="pageLoaded()">
    <div id="white_cover">
        <p id="please_wait">Please Wait</p>
    </div>

    <div id="content">
        <div id="register_login_form_submit_loader_div">
            <div id="register_login_form_submit_loader">

            </div>
        </div>
        <div id="home_page_login_register">
            <div id="home_page_login_register_buttons_div">
                <button id="home_page_login_button" class="home_page_login_register_buttons" onclick="loginButtonClicked()">Login</button>
                <button id="home_page_register_button" class="home_page_login_register_buttons" onclick="registerButtonClicked()">Register</button>
            </div>
            <div id="home_page_below_login_register_buttons_div">
                <form id="login_form">
                    <div class="form-group">
                        <input style="border-radius: 0px;" name="email" type="text" class="form-control" id="login_email" aria-describedby="emailHelp" placeholder="Email">
                        <span id="login_email_error" style="display:none;margin-top:0px;margin-left:4px;font-size: 12px;color:red;">Email is not valid</span>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-2">
                            <input name="password" style="border-radius: 0px;" type="password" class="form-control" id="login_password" placeholder="Password">
                            <div class="input-group-prepend">
                                <div class="input-group-text" style="cursor: pointer;" id="login_show_password">
                                    SHOW
                                </div>
                            </div>
                        </div>
                        <span id="login_password_error" style="display:none;margin-top:0px;margin-left:4px;font-size: 12px;color:red;">Password length must be at least 8</span>
                    </div>
                    <div style="text-align: right;">
                        <button type="button" class="btn btn-danger" id="forgot_password">Forgot Password</button>
                    </div>
                    <div style="text-align: center;" class="mt-4">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
                <form id="register_form" style="display: none;">
                    <div class="form-group">
                        <input name="email" id="register_email" style="border-radius: 0px;" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email">
                        <span id="register_email_error" style="display:none;margin-top:0px;margin-left:4px;font-size: 12px;color:red;">Email is not valid</span>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-2">
                            <input name="password" id="register_password" style="border-radius: 0px;" type="password" class="form-control" id="inlineFormInputGroup" placeholder="Password">
                            <div class="input-group-prepend">
                                <div class="input-group-text" style="cursor: pointer;" id="register_show_password">
                                    SHOW
                                </div>
                            </div>
                        </div>
                        <span id="register_password_error" style="display:none;margin-top:0px;margin-left:4px;font-size: 12px;color:red;">Password length must be at least 8</span>
                    </div>

                    <div style="text-align: center;">
                        <button id="register_submit" type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>
                <form id="verify_otp" style="display: none;">
                    <p style="font-weight: normal;">Verify OTP</p>
                    <input name="otp" type="text" class="form-control" id="otp" placeholder="Enter OTP">
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
                <form id="forgot_password_form" style="display: none;">
                    <p style="font-weight: normal;">Enter registered Email</p>
                    <span id="forgot_password_email_error" style="display:none;margin-top:0px;margin-left:4px;font-size: 14px;color:red;">Email is not valid</span>
                    <input name="email" type="text" class="form-control" id="forgot_password_email" style="border-radius: 0px;" placeholder="Enter Email">
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
                <form id="forgot_password_verify_otp" style="display: none;">
                    <p style="font-weight: normal;">Verify OTP</p>
                    <input name="otp" type="text" class="form-control" id="forgot_password_otp" style="border-radius: 0px;" placeholder="Enter OTP">
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <div id="toast" style="display: none;">

    </div>

    <div id="block_ui" style="display: none;">

    </div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        let baseUrl = "<?= base_url(); ?>";
    </script>
    <script src="<?=base_url();?>assets/js/script1.js"></script>
</body>

</html>