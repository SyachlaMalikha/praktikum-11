<?php
include('koneksi.php');
$label = ["India","S.Korea","Turkey","Vietnam","Japan","Iran","Indonesia","Malaysia","Thailand","Israel"];

for($id_country = 1;$id_country < 11;$id_country++)
{
	$query = mysqli_query($koneksi,"select sum(new_recovery) as new_recovery from tb_newrecovery where id_country='$id_country'");
	$row = $query->fetch_array();
	$kasus_sembuh[] = $row['new_recovery'];
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
					label: 'kasus sembuh covid di berbagai negara',
					data: <?php echo json_encode($kasus_sembuh); ?>,
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
