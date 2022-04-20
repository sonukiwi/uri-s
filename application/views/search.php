<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Search results for "<?= $this->input->get('q'); ?>"</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>

    <div style="margin-top:20px;text-align:center;">
        <h3>Search results for "<?= $this->input->get('q'); ?>" </h3>
    </div>
    <div style="position: fixed;left:8px;top:8px;">
        <a href="<?= base_url(); ?>"><button class="btn btn-success" style="border-radius: 0px;">Back to Home</button></a>
    </div>
    <div style="display: flex;justify-content:center;align-items:center;margin-top:4rem;">
        <table class="table table-hover" style="width: fit-content;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Actual URL</th>
                    <th scope="col">Link to page</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($data) == 0) {
                    echo "<tr style='text-align:center;'><td colspan='3'><h4>There are no results.</h4></td></tr>";
                } else {
                    for ($i = 0; $i < count($data); $i++) {
                        echo '<tr>';
                        $index = $i + 1;
                        echo '<th scope="row">' . $data[$i]['id'] . '</th>';
                        echo '<td>' . $data[$i]['actual_url'] . '</td>';
                        echo '<td><a href="' . $data[$i]['url'] . '"><button class="btn btn-primary" style="border-radius:0px;">Click</button></a></td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>