<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <!-- <a class="navbar-brand" href="#">US</a> -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse container" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active" id="nav_item">
                <a class="nav-link" href="<?php echo config_item('base_url'); ?>">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active" id="nav_item">
                <a class="nav-link" href="<?php echo config_item('base_url') . '/about'; ?>">About<span class="sr-only">(current)</span></a>
            </li>
            <div style="display:flex;width:72vw;flex-direction:row-reverse;">
                <button class="btn btn-success ml-2">Login</button>
                <button class="btn btn-danger">Register</button>
            </div>
        </ul>

    </div>
</nav>