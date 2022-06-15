<?php
include('koneksi.php');
$label = ["India","S.Korea","Turkey","Vietnam","Japan","Iran","Indonesia","Malaysia","Thailand","Israel"];

for($id_country = 1;$id_country < 11;$id_country++)
{
	$query = mysqli_query($koneksi,"select sum(new_cases) as new_cases from tb_newcase where id_country='$id_country'");
	$row = $query->fetch_array();
	$kasus_covid[] = $row['new_cases'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Membuat Grafik Menggunakan Chart JS</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
	<div style="width: 800px;height: 800px">
		<canvas id="myChart"></canvas>
	</div>


	<script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: <?php echo json_encode($label); ?>,
				datasets: [{
					label: 'kasus  covid di berbagai negara',
					data: <?php echo json_encode($kasus_covid); ?>,
					borderWidth: 1
				}]
			},
			options: {
                scales: {
            yAxes: [{
                stacked: true
            }]
        }
    }
		});
	</script>
</body>
</html>
