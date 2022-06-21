<?php
    //Server url
    $url = "https://api.sightmap.com/v1/assets/1273/multifamily/units?per-page=1000";
    $apiKey = '7d64ca3869544c469c3e7a586921ba37'; // should match with Server key
    $headers = array(
        'API-Key: '.$apiKey
    );
    // Send request to Server
    $ch = curl_init($url);
    // To save response in a variable from server, set headers;
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    // Get response
    $response = curl_exec($ch);
    // Decode
    $result = json_decode($response, true);
    if ($result === NULL) die('Something went wrong!');
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
</head>
<body>
<?php
    echo '<h2>Records where the area is 1 SqFt</h2>';
    echo '<table id="one" class="table table-striped">';
    echo '<thead><th>Unit Number</th><th>Area (SqFt)</th><th>Updated At</th></thead>';
    foreach ($result['data'] as $res) {
        $unit = $res['unit_number'];
        $area = $res['area'];
        $updated_at = $res['updated_at'];

        if($area == 1) {
            echo '<tr>';
            echo '<td>' . $unit . '</td>';
            echo '<td>' . $area . '</td>';
            echo '<td>' . date("F jS, Y", strtotime($updated_at)) . '</td>';
            echo '</tr>';
        }
    }
    echo '</table>';

    echo '<br><hr><br>';

    echo '<h2>Records where the area is greater than 1 SqFt</h2>';
    echo '<table id="two" class="table table-striped">';
    echo '<thead><th>Unit Number</th><th>Area (SqFt)</th><th>Updated At</th></thead>';
    foreach ($result['data'] as $res) {
        $unit = $res['unit_number'];
        $area = $res['area'];
        $updated_at = $res['updated_at'];

        if($area != 1) {
            echo '<tr>';
            echo '<td>' . $unit . '</td>';
            echo '<td>' . $area . '</td>';
            echo '<td>' . date("F jS, Y", strtotime($updated_at)) . '</td>';
            echo '</tr>';
        }
    }
    echo '</table>';
?>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#one').DataTable();
        $('#two').DataTable();
    });
</script>
</body>
</html>



