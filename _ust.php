<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$baseUrl = "/Sites/sirkef.com/";
  require_once 'lib/DBOperations.php';
  require_once 'lib/SettingOperations.php';
  require_once 'lib/CommonOperations.php'; 
  
  $dbOp = new DBOperations();
  $settingOp = new SettingOperations();
  $commonOp = new CommonOperations();
  
  if(!$settingOp->getSiteSettingsFromKey("uygulama_aktif_mi")){
  	header("Location: maintenence.php");
  }
  
  date_default_timezone_set($settingOp->getSiteSettingsFromKey("default_timezone"));
  
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bilişimciler İçin Türkçe Sözlük</title>
<meta name="description" content="">

<link rel="stylesheet" href="./css/main.css">
<link rel="canonical" href="https://turkce.me/">

</head>

<body>
	<div class="progress-header">
		<div class="progress-container">
			<div class="progress-bar" id="myBar"></div>
		</div>
	</div>
	<header class="site-header">
		<div class="wrapper">
			<nav class="navbar navbar-default navbar-fixed-top" id="mysiteNav">

				<div class="container animated slow fadeIn">
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-12 col-lg-4">
							<div class="navbar-header">
								<div class="collapsed">
									<div style="padding-top: 16px;">
										<img src="./images/logo.png"
											alt="Bilişimciler için Türkçe sözlük" />
									</div>

									<button type="button"
										class="no-space navbar-toggle collapsed pull-right"
										data-toggle="collapse" data-target="#navbar"
										aria-expanded="false" aria-controls="navbar">
										<i class="ion-navicon collapsed pull-right"> </i>
									</button>
								</div>
							</div>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-12 col-lg-8">
							<div id="navbar" class="collapse navbar-collapse">
								<ul class="nav navbar-nav pull-right">
									<li><a class="page-scroll" href="#home"> Anasayfa</a></li>
									<li><a class="page-scroll" href="#hakkinda"> Hakkında</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</nav>
		</div>
	</header>