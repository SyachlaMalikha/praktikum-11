<?php
include('koneksi.php');
$covid= mysqli_query($koneksi,"select * from tb_newrecovery");
while($row = mysqli_fetch_array($covid)){
	$nama_negara[] = $row['country'];
	
	$query = mysqli_query($koneksi,"select sum(new_recovery) as new_recovery from tb_newrecovery where id_country='".$row['id_country']."'");
	$row = $query->fetch_array();
	$kasus_sembuh[] = $row['new_recovery'];
}
?>
<!doctype html>
<html>

<head>
	<title>Pie Chart</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>
<h1>Digram kesembuhan covid</h1>
<style>
    h1 {color:rgba(200, 100, 100, 1);}
</style>
<body>
	<div id="canvas-holder" style="width:50%">
		<canvas id="chart-area"></canvas>
	</div>
	<script>
		var config = {
			type: 'doughnut',
			data: {
				datasets: [{
					data:<?php echo json_encode($kasus_sembuh); ?>,
					backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
                    'rgba(290, 193, 193, 0.2)',
                    'rgba(200, 100, 100, 0.2)',
                    'rgba(140, 130, 130, 0.2)',
                    'rgba(150, 120, 120, 0.2)',
                    'rgba(20, 170, 170, 0.2)',
					'rgba(340, 150, 150, 0.2)'
					
					],
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)',
                    'rgba(290, 193, 193, 1)',
                    'rgba(200, 100, 100, 1)',
                    'rgba(140, 130, 130, 1)',
                    'rgba(150, 120, 120, 1)',
                    'rgba(20, 170, 170, 1)',
					'rgba(340, 150, 150, 1)'
					],
					label: 'Presentase total sembuh'
				}],
				labels: <?php echo json_encode($nama_negara); ?>},
			options: {
				responsive: true
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);
		};

		document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return randomScalingFactor();
				});
			});

			window.myPie.update();
		});

		var colorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function() {
			var newDataset = {
				backgroundColor: [],
				data: [],
				label: 'New dataset ' + config.data.datasets.length,
			};

			for (var index = 0; index < config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());

				var colorName = colorNames[index % colorNames.length];
				var newColor = window.chartColors[colorName];
				newDataset.backgroundColor.push(newColor);
			}

			config.data.datasets.push(newDataset);
			window.myPie.update();
		});

		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myPie.update();
		});
	</script>
</body>

</html>