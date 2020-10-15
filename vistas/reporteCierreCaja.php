<?php
session_start();
if (isset($_SESSION['usuario'])) {
	$cierre = isset($_GET['cierre']) ?  $_GET['cierre'] : 'Sin cierre';
?>
	<!DOCTYPE html>
	<html>

	<head>
		<title>Caja</title>
		<?php require_once "menu.php"; ?>
	</head>

	<body>
		<div class="container">
		</div>
		<div class="container">
			<h3>Caja</h3>
			<br>
			<div class="panel  panel-info">
				<div class="panel-heading">
					<div class="row">
						<div class="col-sm-6">
							<h3 class="panel-title">Reporte cierre</h3>
						</div>
						<div class="col-sm-6">
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div id="reporteCierreCaja"></div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function() {
				<?php
				if ($cierre) {
				?>
					$('#reporteCierreCaja').load('caja/reporteCaja.php?cierre=<?php echo $cierre ?>');
				<?php
				} else {
				?>
					$('#reporteCierreCaja').load('caja/reporteCaja.php');

				<?php
				}
				?>
			});
		</script>

	</body>

	</html>


<?php
} else {
	header("location:../index.php");
}
?>