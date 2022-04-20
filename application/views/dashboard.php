<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <script src="https://kit.fontawesome.com/10621aa4f1.js" crossorigin="anonymous"></script>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/dashboard.css">
  <title>Dashboard</title>
  <style>
    #generate_short_url {
      position: absolute;
      width: 100vw;
      height: 100vh;
      left: 0;
      top: 0;
      background-color: white;
      z-index: 3;
      display: none;
    }

    #generate_short_url_form {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }

    #toast {
      background-color: rgb(214, 19, 19);
      color: white;
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      padding: 8px 12px;
      bottom: 24px;
      transition: all 2s;
      z-index: 1500;
    }

    #block_ui {
      position: absolute;
      left: 0;
      top: 0;
      width: 100vw;
      height: 100vh;
      background-color: transparent;
      display: none;
      z-index: 9;
    }

    #no_records {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
  </style>
</head>

<body style="height: 100vh;width: 100vw;">
  <div id="logout_button_and_add_buttons_div">
    <button data-toggle="modal" data-target="#exampleModal" class="btn btn-success">Change Password</button>
    <button onclick="open_generate_short_url()" class="btn btn-success" style="border-radius: 0px;"><i class="fa-solid fa-plus"></i></button>
    <a href="<?= base_url() . 'logout'; ?>"><button class="btn btn-danger" style="border-radius: 0px;"><i class="fa-solid fa-power-off"></i></button></a>
  </div>

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="change_password">
          <label id="change_password_error" for="" style="font-size: 12px;color:red;display:none;">Both passwords length must be at least 8</label>
        <input type="text" name="current_password" class="form-control" id="current_password" aria-describedby="emailHelp" placeholder="Current Password"><br>
        <input type="text" name="new_password" class="form-control" id="new_password" aria-describedby="emailHelp" placeholder="New Password">
        <button type="submit" class="btn btn-primary mt-2">Change Password</button>
        </form>
      </div>
        
    </div>
  </div>
</div>

  <div id="block_ui">

  </div>

  <div id="url_info">
    <button onclick="close_url_info()" id="close_url_info" class="btn btn-danger"><i class="fa-solid fa-xmark"></i></button>
    <div id="url_info_actual_div">
      <span><b>Actual URL</b></span> => <a id="actual_url_outside" href=""><span id="actual_url"></span></a> <br>
      <span><b>Clicks</b></span> => <span id="clicks"></span> <br>
      <span><b>Created At</b></span> => <span id="created_at"></span> <br>
      <span><b>Action</b></span> => <button id="status"></button> <br>
      <span><b>Description</b></span> => <span id="description"></span>
    </div>
  </div>


  <div id="toast" style="display: none;">

  </div>

  <div id="generate_short_url">
    <button onclick="close_generate_short_url()" class="btn btn-danger" style="float: right;margin-top:8px;margin-right:8px;"><i class="fa-solid fa-xmark"></i></button>
    <div id="generate_short_url_form">
      <form style="position: absolute;left:50%;top:50%;transform:translate(-50%,-50%)" id="add_record_form">
        <div class="form-group">
          <input name="url" type="text" class="form-control" id="url" aria-describedby="emailHelp" placeholder="Enter URL">
          <span id="url_error" style="display:none;color: red;font-size:12px;margin-top:0px;margin-left:4px;">Entered URL is not valid</span>
        </div>
        <div class="form-group">
          <input name="description" type="text" class="form-control generate_short_url_description" id="description" placeholder="Enter Description">
        </div>
        <div style="text-align: center;">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>


  <h2 id="welcome_message">Welcome, <?= explode('@', $this->session->userdata('email'))[0]; ?></h2>
  <div id="content">
    <form id="search_by_description" method="get" action="<?=base_url().'search';?>">
      <div style="position: absolute;left:50%;top:6rem;transform:translate(-50%,-50%);display:flex;justify-content:center;align-items:center;">
        <input name="q" required type="text" class="form-control" id="search" aria-describedby="emailHelp" placeholder="Search by URL description">
        <button class="btn btn-primary">Search</button>
      </div>
    </form>
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Short URL</th>
          <th scope="col">Action</th>
          <th scope="col">Status</th>
          <th scope="col">More Info</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($data as $item) {
          $status = $item['status'] ? "Active" : "Inactive";
          $statusFontColor = $item['status'] ? "green" : "red";
          $functionOnInfoClick = "open_url_info('" . $item['actual_url'] . "', " . $item['clicks'] . ", '" . $item['created_at'] . "', " . $item['status'] . ", '" . $item['description'] . "', " . $item['id'] . ")";
          echo '<tr>';
          echo '<th scope="row">' . $item['id'] . '</th>';
          echo '<td>' . $item['short_url'] . '</td>';
          echo '<td><a href="' . $item['short_url'] . '" target="_blank"><button class="btn btn-secondary">Visit</button></a></td>';
          echo '<td style="color:' . $statusFontColor . '">' . $status . '</td>';
          echo '<td><button class="btn btn-success" style="border-radius:0px;" onclick="' . $functionOnInfoClick . '">Click</button></td>';
          echo '</tr>';
        }
        ?>
      </tbody>
    </table>
    <div style="text-align: center;">
      <p>Showing <?= $count == 0 ? 0 : 5 * ($page - 1) + 1; ?> to <?= $count == 0 ? 0 : 5 * ($page - 1) + 1 + count($data) - 1; ?> of <?= $count ?> records.</p>
    </div>
    <div id="prev_next_buttons">
      <a href="<?= base_url() . 'dashboard'; ?>/1"><button class="btn btn-primary ml-1"><?= $count == 0 ? 0 : 1; ?></button></a>
      <?php
      if ($page == 1) {
        echo '<button id="go_back" class="btn btn-primary ml-1" disabled><i class="fa-solid fa-angles-left"></i></button>';
      } else {
        echo '<button id="go_back" class="btn btn-primary ml-1"><i class="fa-solid fa-angles-left"></i></button>';
      }
      ?>
      <?php
      if ($page * 5 < $count) {
        echo '<button id="go_forward" class="btn btn-primary ml-1"><i class="fa-solid fa-angles-right"></i></button>';
      } else {
        echo '<button id="go_forward" class="btn btn-primary ml-1" disabled><i class="fa-solid fa-angles-right"></i></button>';
      }
      ?>


      <a href="<?= base_url() . 'dashboard/'; ?><?= $count == 0 ? 1 : $lastPageNumber; ?>"><button class="btn btn-primary ml-1"><?= $lastPageNumber; ?></button></a>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="<?= base_url(); ?>assets/js/dashboard.js"></script>
  <script>
    let currentPageNumber = <?= $page; ?>;
    let baseUrl = "<?= base_url(); ?>";
    let currentEmail = "<?= $this->session->userdata('email'); ?>";
    document.getElementById('go_forward').addEventListener('click', (e) => {
      window.location.href = `${baseUrl}dashboard/${currentPageNumber+1}`;
    })
    document.getElementById('go_back').addEventListener('click', (e) => {
      window.location.href = `${baseUrl}dashboard/${currentPageNumber-1}`;
    })

    function close_generate_short_url() {
      document.getElementById('generate_short_url').style.display = "none";
    }

    function open_generate_short_url() {
      document.getElementById('generate_short_url').style.display = "block";
    }
  </script>
</body>

</html>