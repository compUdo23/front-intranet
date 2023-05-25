<?php 
	include_once("../confSeg.php");
	$_SESSION['sess_intra_usuario']  = '';
	$_SESSION['sess_intra_nombre']   = '';
	$alerta_usuario = 'Ya se encuentra disponible <BR>la planilla del AR-C 2014';
		$alerta_usuario = '';
	if (isset($_POST['usuario']) and isset($_POST['clave'])){
			$cedula = $_POST['usuario'];
			$clave  = $_POST['clave'];

			include_once("../seguridad/proceso/cSeg.php");
			$seg = new cSeg();
			$datSeg = $seg->getFuncionario($cedula, $clave);
			$filas = count($datSeg);
			if ($filas > 0  )  {
				if ($datSeg[0]['STATUS_WEB'] == 'A' or  $datSeg[0]['STATUS_WEB'] == 'C'){
					$_SESSION['sess_intra_usuario']	  = $datSeg[0]['CEDULA'];
					$_SESSION['sess_intra_nombre']    = $datSeg[0]['NOMBRE'];
					$_SESSION['sess_intra_apellido']  = $datSeg[0]['APELLIDO'];
					$_SESSION['sess_intra_nucleo']    = $datSeg[0]['NUCLEO'];
					$_SESSION['sess_intra_generico']  = $datSeg[0]['GENERICO'];
					$_SESSION['sess_intra_condicion'] = $datSeg[0]['CONDICION'];
					$_SESSION['sess_intra_email']     = $datSeg[0]['EMAIL'];
					$_SESSION['sess_status_web']      =  $datSeg[0]['STATUS_WEB'];
				    header("Location: index.php");
				    //  header("Location: DIBISE/dibise.php");
					return;
				}else{
					$alerta_usuario = 'EL USUARIO SE ENCUENTRA INACTIVO';
				}
			}else{
				$alerta_usuario = 'INFORMACI�N INVALIDA';
			}
	}
	$_SESSION['sess_intra_usuario']  = '';
	$_SESSION['sess_intra_nombre']  = '';
	session_unset();
	session_destroy();
?>
<!DOCTYPE html>
<html lang="es"> 
<head>
	<title>UNIVERSIDAD DE ORIENTE</title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico"> 
    
    <!-- FontAwesome JS-->
    <script defer src="assets/plugins/fontawesome/js/all.min.js"></script>
    
    <!-- App CSS -->  
    <link id="theme-style" rel="stylesheet" href="assets/css/portal.css">

	<link href="estilos/dba..css" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" href="http://<?php echo $servidor; ?>/intranet/favicon.ico">
    <link href="estilos/estiloSAOS.css" rel="stylesheet" type="text/css">
    <script type="text/JavaScript">
	<!--
		function MM_preloadImages() { //v3.0
		var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
			var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
			if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
		}

		function MM_swapImgRestore() { //v3.0
		var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
		}

		function MM_findObj(n, d) { //v4.01
		var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
			d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
		if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
		for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
		if(!x && d.getElementById) x=d.getElementById(n); return x;
		}

		function MM_swapImage() { //v3.0
		var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
		if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
		}
		function foco(){
			document.form1.usuario.focus();
		}
		function MM_openBrWindow(theURL,winName,features) { //v2.0
		window.open(theURL,winName,features);
		}
		//-->
    </script>
</head> 

<body class="app app-login p-0">    	
    <div class="row g-0 app-auth-wrapper">
	    <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
		    <div class="d-flex flex-column align-content-end">
			    <div class="app-auth-body mx-auto">	
				    <div class="app-auth-branding mb-4"><a class="app-logo" href="index.php"><img class="logo-icon me-2" src="assets/images/Logo_UDO.svg" alt="logo"></a></div>
					<h2 class="auth-heading text-center mb-5">Ingresa al Portal</h2>
			        <div class="auth-form-container text-start">
						<form class="auth-form login-form" name="form1" method="post" action="login.php">      
							<div class="email mb-3">
								<label class="sr-only" for="signin-email">Cédula</label>
								<input id="usuario" name="usuario" type="text" class="form-control signin-email" placeholder="Ingrese la cédula" required="required">
							</div><!--//form-group-->
							<div class="password mb-3">
								<label class="sr-only" for="signin-password">Clave</label>
								<input id="clave" name="clave" type="password" class="form-control signin-password" placeholder="Ingrese su clave" required="required">
								<div class="extra mt-3 row justify-content-between">
									<!--//col-6-->
									<div class="col-12">
										<div class="forgot-password text-end">
											<a href="reset-password.php">Recuperar clave</a>
										</div>
									</div><!--//col-6-->
								</div><!--//extra-->
							</div><!--//form-group-->
							<div class="text-center">
								<button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Iniciar</button>
							</div>
						</form>
					</div><!--//auth-form-container-->	

			    </div><!--//auth-body-->
		    
			    <footer class="app-auth-footer">
					<div class="container text-center py-3">
						<!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
					<small class="copyright">Diseñado por <a class="app-link" href="https://udo.education/" target="_blank">Universidad de Oriente - Dirección de Computación - RECTORADO. 2023</a></small>
					
					</div>
				</footer><!--//app-auth-footer-->	
		    </div><!--//flex-column-->   
	    </div><!--//auth-main-col-->
	    <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
		    <div class="auth-background-holder">
		    </div>
		    <div class="auth-background-mask"></div>
		    <div class="auth-background-overlay p-3 p-lg-5">
			    <div class="d-flex flex-column align-content-end h-100">
				    <div class="h-100"></div>
				    <div class="overlay-content p-3 p-lg-4 rounded">
					    <h5 class="mb-3 overlay-title">Sistema administrativo</h5>
					    <div>Ingrese al sistema administrativo de la Universidad de Oriente para revisar su información personal</div>
				    </div>
				</div>
		    </div><!--//auth-background-overlay-->
	    </div><!--//auth-background-col-->
    
    </div><!--//row-->


</body>
</html> 

