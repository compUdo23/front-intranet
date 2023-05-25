<?php 
	//include_once("../../seguridad.php");
	include_once("../segsistemas.php");
	include_once("../confSeg.php");
	//
	if ($_SESSION['sess_status_web'] == 'C'){
		header("Location: /intranet/seguridad/proceso/m_clave.php");	
		return;
	}
		
	include_once("../javascript/Sajax.php"); 
	//
	include_once('../componentesGeneral/cFuncionarioGeneral.php');	 
	
	$objClase = new cFuncionarioGeneral();
	//
	$cedula = $_SESSION['sess_intra_usuario'];
	$objDatos  = $objClase->getFuncionario($_SESSION['sess_intra_usuario']);
	
	$imagen_modulo = "nomina.png";
	//tipo personal
	$generico[1] = 'DOCENTE';
	$generico[2] = 'ADMINISTRATIVO';
	$generico[3] = 'OBRERO';
	
	// condicion laboral
	
	$condicion[0] = 'NO APLICABLE';
	$condicion[1] = 'ORDINARIO O FIJO';
	$condicion[2] = 'CONTRATADO';
	$condicion[3] = 'INTERINO O SUPLENTE';
	$condicion[4] = 'JUBILADO';
	$condicion[5] = 'PENS. INCAPACIDAD';
	$condicion[6] = 'PENS. SOBREVIVIENTE';
	$condicion[7] = 'BECARIO';
	$condicion[8] = 'SABATICO O LICENCIA';
	$condicion[9] = 'SUPERNUMERARIO';
	//
	//
	$tiene_correo ='SI';
	/*	if (($objDatos[0]['EMAIL'] == NULL) or  strlen($objDatos[0]['EMAIL'])== 0) {
			$tiene_correo ='NO';	
		}*/


		//
		//
		// echo $objDatos[0]['CORREO_VALIDADO'];
		$correo_validado = 'S';
	/*	if (($objDatos[0]['CORREO_VALIDADO'] == NULL) or  ($objDatos[0]['CORREO_VALIDADO']== 'N')) {
			$correo_validado = 'N';
			$codigo_validacion_vacio = 'NO';
			if  (($objDatos[0]['CODIGO_VALIDACION'] == NULL) or  ($objDatos[0]['CODIGO_VALIDACION']== '')){
				$codigo_validacion_vacio ='';
			}
		}*/
	// CODIGO_VALIDACION
	// CODIGO_VALIDACION
	function fx_actualizaEmail( $arg_email ){
		global $objClase;
		global $cedula;
		
		$retorno_verificacion = $objClase->verificaSiCorreoExiste($cedula,  $arg_email);
		if (count($retorno_verificacion ) > 0  ){ return 'DOBLE'; }
		
		$actual = $objClase->actualizar($cedula,  $arg_email,'N');
		return $actual;
	}
	//
	//
	function fx_verifica_codigo( $arg_codigo , $arg_email){
		global $objClase;
		global $cedula;
		$actual = $objClase->getFuncionario($cedula);
		$valido = 'NO' ;
		if ( strtoupper($actual[0]['CODIGO_VALIDACION']) == strtoupper($arg_codigo) ) {
			$actual = $objClase->actualizar($cedula,  $arg_email,'S');
			
			$valido = 'SI' ;	
		}
		//
		return $valido;
	}
	//
	sajax_init ();
	sajax_export("fx_actualizaEmail","fx_verifica_codigo");
	sajax_handle_client_request();
	//
 ?>
<!DOCTYPE html>
<html lang="es"> 
<head>
    <title>UDO</title>
    
    <?php include('./Layout/cabeceras.php'); ?>

	<style type="text/css">
	<!--
	body {
		margin-left: 0px;
		margin-top: 0px;
		margin-right: 0px;
		margin-bottom: 0px;
	}
	.ROJO {
		color: #F00;
	}
	-->
	</style>
	<script type="text/javascript">
	function MM_findObj(n, d) { //v4.01
	var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
		d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
	if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
	for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
	if(!x && d.getElementById) x=d.getElementById(n); return x;
	}

	function YY_checkform() { //v4.66
	//copyright (c)1998,2002 Yaromat.com
	var args = YY_checkform.arguments; var myDot=true; var myV=''; var myErr='';var addErr=false;var myReq;
	for (var i=1; i<args.length;i=i+4){
		if (args[i+1].charAt(0)=='#'){myReq=true; args[i+1]=args[i+1].substring(1);}else{myReq=false}
		var myObj = MM_findObj(args[i].replace(/\[\d+\]/ig,""));
		myV=myObj.value;
		if (myObj.type=='text'||myObj.type=='password'||myObj.type=='hidden'){
		if (myReq&&myObj.value.length==0){addErr=true}
		if ((myV.length>0)&&(args[i+2]==1)){ //fromto
			var myMa=args[i+1].split('_');if(isNaN(myV)||myV<myMa[0]/1||myV > myMa[1]/1){addErr=true}
		} else if ((myV.length>0)&&(args[i+2]==2)){
			var rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-z]{2,4}$");if(!rx.test(myV))addErr=true;
		} else if ((myV.length>0)&&(args[i+2]==3)){ // date
			var myMa=args[i+1].split("#"); var myAt=myV.match(myMa[0]);
			if(myAt){
			var myD=(myAt[myMa[1]])?myAt[myMa[1]]:1; var myM=myAt[myMa[2]]-1; var myY=myAt[myMa[3]];
			var myDate=new Date(myY,myM,myD);
			if(myDate.getFullYear()!=myY||myDate.getDate()!=myD||myDate.getMonth()!=myM){addErr=true};
			}else{addErr=true}
		} else if ((myV.length>0)&&(args[i+2]==4)){ // time
			var myMa=args[i+1].split("#"); var myAt=myV.match(myMa[0]);if(!myAt){addErr=true}
		} else if (myV.length>0&&args[i+2]==5){ // check this 2
				var myObj1 = MM_findObj(args[i+1].replace(/\[\d+\]/ig,""));
				if(myObj1.length)myObj1=myObj1[args[i+1].replace(/(.*\[)|(\].*)/ig,"")];
				if(!myObj1.checked){addErr=true}
		} else if (myV.length>0&&args[i+2]==6){ // the same
				var myObj1 = MM_findObj(args[i+1]);
				if(myV!=myObj1.value){addErr=true}
		}
		} else
		if (!myObj.type&&myObj.length>0&&myObj[0].type=='radio'){
			var myTest = args[i].match(/(.*)\[(\d+)\].*/i);
			var myObj1=(myObj.length>1)?myObj[myTest[2]]:myObj;
		if (args[i+2]==1&&myObj1&&myObj1.checked&&MM_findObj(args[i+1]).value.length/1==0){addErr=true}
		if (args[i+2]==2){
			var myDot=false;
			for(var j=0;j<myObj.length;j++){myDot=myDot||myObj[j].checked}
			if(!myDot){myErr+='* ' +args[i+3]+'\n'}
		}
		} else if (myObj.type=='checkbox'){
		if(args[i+2]==1&&myObj.checked==false){addErr=true}
		if(args[i+2]==2&&myObj.checked&&MM_findObj(args[i+1]).value.length/1==0){addErr=true}
		} else if (myObj.type=='select-one'||myObj.type=='select-multiple'){
		if(args[i+2]==1&&myObj.selectedIndex/1==0){addErr=true}
		}else if (myObj.type=='textarea'){
		if(myV.length<args[i+1]){addErr=true}
		}
		if (addErr){myErr+='* '+args[i+3]+'\n'; addErr=false}
	}
	if (myErr!=''){alert('La informaci�n es requerida o continene error:\t\t\t\t\t\n\n'+myErr)}
	document.MM_returnValue = (myErr=='');
	}
	</script>

	<script type="text/javascript" language="JavaScript1.2" src="stm31.js"></script>
	<script id="Sothink Widgets:floatingmenu.pgt" type="text/javascript" language="JavaScript1.2"> 
			
		if ( "<?php echo  $correo_validado  ?>" =="S" )	 {
			
			stm_bm(["bmgmfhr",400,"","blank.gif",1,"stgcl()+10","stgct()+130",0,0,250,0,1000,0,0,0,""],this);
			stm_bp("p0",[1,4,0,0,2,2,0,7,100,"progid:DXImageTransform.Microsoft.Pixelate(MaxSquare=15,enabled=0,Duration=0.58)",-2,"",-2,52,2,3,"#999999","#ffffff","",3,1,1,"#999999"]);
			// TITULO DEL MENU
			stm_ai("p0i0",[0,"UNIVERSIDAD DE ORIENTE    ","","",-1,-1,0,"","_self","","","","",0,0,0,"","",0,0,0,0,1,"#ffffff",0,"#ffffff",0,"","",3,3,0,0,"#3399cc","#3399cc","#000000","#000000","bold 9pt Verdana","bold 9pt Verdana",0,0]);
			stm_aix("p0i0","p0i0",[0,"  PERSONAL","","",-1,-1,0,"","_self","","","","",0,0,0,"arrow_gray.gif","arrow_r.gif",7,7,0,0,1,"#ffffff",0,"#dfdfdf",0,"","",3,3,1,1,"#ffffff","#666666","#333333","#333333","9pt Verdana","9pt Verdana"]);
			stm_bpx("p1","p0",[1,2,-2,0,3,1,0,0,91,"progid:DXImageTransform.Microsoft.Pixelate(MaxSquare=15,enabled=0,Duration=0.37)",-2,"progid:DXImageTransform.Microsoft.Slide(slideStyle=swap,bands=15,enabled=0,Duration=0.37)",-2,73]);
			stm_aix("p0i0","p0i0",[0,"Informaci�n Personal.","","",-1,-1,0,"/intranet/personal/vperson/v_person.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_self","","","","",0,0,0,"","",0,0]);
			stm_aix("p0i0","p0i0",[0,"Informaci�n Acad�mica.","","",-1,-1,0,"/intranet/personal/vperson/v_inf_academica.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_self","","","","",0,0,0,"","",0,0]);
			stm_aix("p0i0","p0i0",[0,"Informaci�n Laboral.","","",-1,-1,0,"/intranet/personal/vperson/v_inf_laboral.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_self","","","","",0,0,0,"","",0,0]);
			stm_aix("p0i0","p0i0",[0,"Carga Familiar.","","",-1,-1,0,"/intranet/personal/vperson/v_carga_familiar.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_self","","","","",0,0,0,"","",0,0]);
			stm_aix("p0i0","p0i0",[0,"FP-020.","","",-1,-1,0,"/intranet/personal/vperson/v_inf_fp_020.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_self","","","","",0,0,0,"","",0,0]);
			//stm_aix("p0i0","p0i0",[0,"CONSTANCIA DE TRABAJO.","","",-1,-1,0,"/intranet/personal/mantenimientos/Constancia_sueldo_integral.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_new","","","","",0,0,0,"","",0,0]);
			stm_ep();
			stm_aix("p0i0","p0i0",[0,"  N�MINA","","",-1,-1,0,"","_self","","","","",0,0,0,"arrow_gray.gif","arrow_r.gif",7,7,0,0,1,"#ffffff",0,"#dfdfdf",0,"","",3,3,1,1,"#ffffff","#666666","#333333","#333333","9pt Verdana","9pt Verdana"]);
			stm_bpx("p1","p0",[1,2,-2,0,3,1,0,0,91,"progid:DXImageTransform.Microsoft.Pixelate(MaxSquare=15,enabled=0,Duration=0.37)",-2,"progid:DXImageTransform.Microsoft.Slide(slideStyle=swap,bands=15,enabled=0,Duration=0.37)",-2,73]);
			stm_aix("p0i0","p0i0",[0,"Edo. de Cta. N�minas COMPLETA.","","",-1,-1,0,"/intranet/personal/vperson/v_edocuenta_homo.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_self","","","","",0,0,0,"","",0,0]);
			stm_aix("p0i0","p0i0",[0,"Edo. de Cta. N�minas Regulares.","","",-1,-1,0,"/intranet/personal/vperson/v_edocuenta.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_self","","","","",0,0,0,"","",0,0]);
			stm_aix("p0i0","p0i0",[0,"Edo. de Cta. Otras N�minas.","","",-1,-1,0,"/intranet/personal/vperson/v_edocuenta_otras.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_self","","","","",0,0,0,"","",0,0]);
			//stm_aix("p0i0","p0i0",[0,"Edo. de Cta. N�minas Extras.","","",-1,-1,0,"/SegOS/administrador/admprincipal.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_self","","","","",0,0,0,"","",0,0]);
			//stm_aix("p0i0","p0i0",[0,"Modificaciones de la N�mina.","","",-1,-1,0,"/SegOS/administrador/admprincipal.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_self","","","","",0,0,0,"","",0,0]);
			stm_ep();
			stm_aix("p0i0","p0i0",[0,"  PASIVOS LABORALES","","",-1,-1,0,"","_self","","","","",0,0,0,"arrow_gray.gif","arrow_r.gif",7,7,0,0,1,"#ffffff",0,"#dfdfdf",0,"","",3,3,1,1,"#ffffff","#666666","#333333","#333333","9pt Verdana","9pt Verdana"]);
			stm_bpx("p1","p0",[1,2,-2,0,3,1,0,0,91,"progid:DXImageTransform.Microsoft.Pixelate(MaxSquare=15,enabled=0,Duration=0.37)",-2,"progid:DXImageTransform.Microsoft.Slide(slideStyle=swap,bands=15,enabled=0,Duration=0.37)",-2,73]);
			stm_aix("p0i0","p0i0",[0,"PLANILLA SOLICITUD ANTICIPO DE PRESTACIONES INTERNO DOCENTES","","",-1,-1,0,"/intranet/pasivos/Planilla-Interna-Docentes.doc","_blank","","","","",0,0,0,"","",0,0]);
			stm_aix("p0i0","p0i0",[0,"PLANILLA SOLICITUD ANTICIPO DE PRESTACIONES INTERNO ADMINISTRATIVOS","","",-1,-1,0,"/intranet/pasivos/Planilla-Interna-Administrativos.doc","_blank","","","","",0,0,0,"","",0,0]);
			stm_aix("p0i0","p0i0",[0,"PLANILLA SOLICITUD ANTICIPO DE PRESTACIONES INTERNO OBREROS","","",-1,-1,0,"/intranet/pasivos/Planilla-Interna-Obreros.doc","_blank","","","","",0,0,0,"","",0,0]);
			stm_aix("p0i0","p0i0",[0,"PLANILLA SOLICITUD ANTICIPO DE PRESTACIONES OPSU","","",-1,-1,0,"/intranet/pasivos/Planilla-Solicitud-Anticipo-Opsu.pdf","_blank","","","","",0,0,0,"","",0,0]);
			stm_aix("p0i0","p0i0",[0,"ESTADO DE CUENTA - FIDEICOMISO / 8.5% 2019","","",-1,-1,0,"/intranet/pasivos/papeleta_obreros.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_blank","","","","",0,0,0,"","",0,0]);
			//stm_aix("p0i0","p0i0",[0,"ESTADO DE CUENTA PARA CALCULO DE FIDEICOMISO 2018 PERSONAL OBRERO","","",-1,-1,0,"/intranet/pasivos/base_calculo_fide_obreros.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_blank","","","","",0,0,0,"","",0,0]);
			stm_aix("p0i0","p0i0",[0,"ESTADO DE CUENTA - PRESTACIONES ESTIMADAS","","",-1,-1,0,"/intranet/pasivos/calc_presta.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_blank","","","","",0,0,0,"","",0,0]);
			stm_ep();
			stm_aix("p0i0","p0i0",[0,"  RUTA DE DOCUMENTOS ","","",-1,-1,0,"","_self","","","","",0,0,0,"arrow_gray.gif","arrow_r.gif",7,7,0,0,1,"#ffffff",0,"#dfdfdf",0,"","",3,3,1,1,"#ffffff","#666666","#333333","#333333","9pt Verdana","9pt Verdana"]);
			stm_bpx("p1","p0",[1,2,-2,0,3,1,0,0,91,"progid:DXImageTransform.Microsoft.Pixelate(MaxSquare=15,enabled=0,Duration=0.37)",-2,"progid:DXImageTransform.Microsoft.Slide(slideStyle=swap,bands=15,enabled=0,Duration=0.37)",-2,73]);
			stm_aix("p0i0","p0i0",[0,"Ordenes de Pago/Vi�ticos/Otros...","","",-1,-1,0,"/intranet/ruta/vdoc/v_ruta_doc.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_self","","","","",0,0,0,"","",0,0]);
			stm_ep();
			stm_aix("p0i0","p0i0",[0,"  IMPUESTOS (AR-C)","","",-1,-1,0,"","_self","","","","",0,0,0,"arrow_gray.gif","arrow_r.gif",7,7,0,0,1,"#ffffff",0,"#dfdfdf",0,"","",3,3,1,1,"#ffffff","#666666","#333333","#333333","9pt Verdana","9pt Verdana"]);
			stm_bpx("p1","p0",[1,2,-2,0,3,1,0,0,91,"progid:DXImageTransform.Microsoft.Pixelate(MaxSquare=15,enabled=0,Duration=0.37)",-2,"progid:DXImageTransform.Microsoft.Slide(slideStyle=swap,bands=15,enabled=0,Duration=0.37)",-2,73]);
			stm_aix("p0i0","p0i0",[0,"2021","","",-1,-1,0,"/intranet/personal/impuesto/impuesto.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_self","","","","",0,0,0,"","",0,0]);


	//////////////////////////////////////////////////////////////////////////////////////////// TALLASS

	/*	stm_ep();
			stm_aix("p0i0","p0i0",[0,"  TALLAS DE UNIFORMES","","",-1,-1,0,"","_self","","","","",0,0,0,"arrow_gray.gif","arrow_r.gif",7,7,0,0,1,"#ffffff",0,"#dfdfdf",0,"","",3,3,1,1,"#ffffff","#666666","#333333","#333333","9pt Verdana","9pt Verdana"]);
			stm_bpx("p1","p0",[1,2,-2,0,3,1,0,0,91,"progid:DXImageTransform.Microsoft.Pixelate(MaxSquare=15,enabled=0,Duration=0.37)",-2,"progid:DXImageTransform.Microsoft.Slide(slideStyle=swap,bands=15,enabled=0,Duration=0.37)",-2,73]);


			stm_aix("p0i0","p0i0",[0,"AGREGAR O MODIFICAR","","",-1,-1,0,"/intranet/personal/actualizacion/crearboletin_sin_nomina_intranet_tallas.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_self","","","","",0,0,0,"","",0,0]);
			

			*/
	//////////////////////////////HASTA AQUI  TALLAS DE ROPA Y CALZADO//////////////////////////////////////		
			stm_ep();
			stm_aix("p0i0","p0i0",[0,"  ACTUALIZACION DATOS PERSONALES","","",-1,-1,0,"","_self","","","","",0,0,0,"arrow_gray.gif","arrow_r.gif",7,7,0,0,1,"#ffffff",0,"#dfdfdf",0,"","",3,3,1,1,"#ffffff","#666666","#333333","#333333","9pt Verdana","9pt Verdana"]);
			stm_bpx("p1","p0",[1,2,-2,0,3,1,0,0,91,"progid:DXImageTransform.Microsoft.Pixelate(MaxSquare=15,enabled=0,Duration=0.37)",-2,"progid:DXImageTransform.Microsoft.Slide(slideStyle=swap,bands=15,enabled=0,Duration=0.37)",-2,73]);

			stm_aix("p0i0","p0i0",[0,"DATOS PERSONALES","","",-1,-1,0,"/intranet/personal/actualizacion/m_datos_cesta_ticket.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_self","","","","",0,0,0,"","",0,0]);


			stm_ep();
			stm_aix("p0i0","p0i0",[0," CERTIFICACI�N DE CUENTA N�MINA","","",-1,-1,0,"","_self","","","","",0,0,0,"arrow_gray.gif","arrow_r.gif",7,7,0,0,1,"#ffffff",0,"#dfdfdf",0,"","",3,3,1,1,"#ffffff","#666666","#333333","#333333","9pt Verdana","9pt Verdana"]);
			stm_bpx("p1","p0",[1,2,-2,0,3,1,0,0,91,"progid:DXImageTransform.Microsoft.Pixelate(MaxSquare=15,enabled=0,Duration=0.37)",-2,"progid:DXImageTransform.Microsoft.Slide(slideStyle=swap,bands=15,enabled=0,Duration=0.37)",-2,73]);

			stm_aix("p0i0","p0i0",[0,"CERTIFICACI�N DE CUENTA N�MINA","","",-1,-1,0,"/intranet/personal/mantenimientos/certificacion_cuenta_nomina.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_blank","","","","",0,0,0,"","",0,0]);

			//stm_aix("p0i0","p0i0",[0,"CARGA FAMILIAR","","",-1,-1,0,"/intranet/personal/actualizacion/v_carga_familiar_intranet.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_self","","","","",0,0,0,"","",0,0]);
			//stm_aix("p0i0","p0i0",[0,"DATOS ACADEMICOS","","",-1,-1,0,"/intranet/personal/actualizacion/v_datos_academicos_intranet.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_self","","","","",0,0,0,"","",0,0]);
			
			stm_ep();
			stm_aix("p0i0","p0i0",[0,"  CONSTANCIA DE TRABAJO O PENSION","","",-1,-1,0,"","_self","","","","",0,0,0,"arrow_gray.gif","arrow_r.gif",7,7,0,0,1,"#ffffff",0,"#dfdfdf",0,"","",3,3,1,1,"#ffffff","#666666","#333333","#333333","9pt Verdana","9pt Verdana"]);
			stm_bpx("p1","p0",[1,2,-2,0,3,1,0,0,91,"progid:DXImageTransform.Microsoft.Pixelate(MaxSquare=15,enabled=0,Duration=0.37)",-2,"progid:DXImageTransform.Microsoft.Slide(slideStyle=swap,bands=15,enabled=0,Duration=0.37)",-2,73]);
			stm_aix("p0i0","p0i0",[0,"SUELDO INTEGRAL PERSONAL ACTIVO","","",-1,-1,0,"/intranet/personal/mantenimientos/Constancia_sueldo_integral.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_new","","","","",0,0,0,"","",0,0]);
			stm_aix("p0i0","p0i0",[0,"SUELDO INTEGRAL + BONOS PERSONAL ACTIVO","","",-1,-1,0,"/intranet/personal/mantenimientos/Constancia_sueldo_integral_bono_alimentacion_vacacional.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_new","","","","",0,0,0,"","",0,0]);
			stm_aix("p0i0","p0i0",[0,"SUELDO BASE PERSONAL ACTIVO","","",-1,-1,0,"/intranet/personal/mantenimientos/Constancia_sueldo_base.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_new","","","","",0,0,0,"","",0,0]);
			stm_aix("p0i0","p0i0",[0,"SIN SUELDO PERSONAL ACTIVO","","",-1,-1,0,"/intranet/personal/mantenimientos/Constancia_sin_sueldo.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_new","","","","",0,0,0,"","",0,0]);
			stm_aix("p0i0","p0i0",[0,"SIN SUELDO PERSONAL JUBILADO","","",-1,-1,0,"/intranet/personal/mantenimientos/Constancia_jubilados_sin_sueldo.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_new","","","","",0,0,0,"","",0,0]);
			stm_aix("p0i0","p0i0",[0,"SUELDO INTEGRAL PERSONAL JUBILADO","","",-1,-1,0,"/intranet/personal/mantenimientos/Constancia_jubilados.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_new","","","","",0,0,0,"","",0,0]);
			stm_aix("p0i0","p0i0",[0,"SUELDO INTEGRAL + BONOS PERSONAL JUBILADO","","",-1,-1,0,"/intranet/personal/mantenimientos/Constancia_jubilados_bonos.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_new","","","","",0,0,0,"","",0,0]);
			stm_aix("p0i0","p0i0",[0,"SUELDO INTEGRAL + BONOS PERSONAL PENSION POR INCAPACIDAD","","",-1,-1,0,"/intranet/personal/mantenimientos/Constancia_pension_incapacidad_bonos.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_new","","","","",0,0,0,"","",0,0]);
			stm_aix("p0i0","p0i0",[0,"SUELDO INTEGRAL + BONOS PERSONAL PENSION POR SOBREVIVIENTE","","",-1,-1,0,"/intranet/personal/mantenimientos/Constancia_pension_sobrev_bonos.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_new","","","","",0,0,0,"","",0,0]);
			stm_aix("p0i0","p0i0",[0,"CON CARGA FAMILIAR","","",-1,-1,0,"/intranet/personal/mantenimientos/Constancia_con_carga_familiar.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_new","","","","",0,0,0,"","",0,0]);
			
			
			stm_ep();
			stm_aix("p0i0","p0i0",[0,"  CARNET CARGA FAMILIAR","","",-1,-1,0,"","_self","","","","",0,0,0,"arrow_gray.gif","arrow_r.gif",7,7,0,0,1,"#ffffff",0,"#dfdfdf",0,"","",3,3,1,1,"#ffffff","#666666","#333333","#333333","9pt Verdana","9pt Verdana"]);
			stm_bpx("p1","p0",[1,2,-2,0,3,1,0,0,91,"progid:DXImageTransform.Microsoft.Pixelate(MaxSquare=15,enabled=0,Duration=0.37)",-2,"progid:DXImageTransform.Microsoft.Slide(slideStyle=swap,bands=15,enabled=0,Duration=0.37)",-2,73]);
			stm_aix("p0i0","p0i0",[0,"CARNET","","",-1,-1,0,"Carnet Carga Familiar/r_carnetfam_intranet22.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_new","","","","",0,0,0,"","",0,0]);
			
			
			stm_ep();
			stm_aix("p0i0","p0i0",[0,"  CARNET FUNCIONARIO","","",-1,-1,0,"","_self","","","","",0,0,0,"arrow_gray.gif","arrow_r.gif",7,7,0,0,1,"#ffffff",0,"#dfdfdf",0,"","",3,3,1,1,"#ffffff","#666666","#333333","#333333","9pt Verdana","9pt Verdana"]);
			stm_bpx("p1","p0",[1,2,-2,0,3,1,0,0,91,"progid:DXImageTransform.Microsoft.Pixelate(MaxSquare=15,enabled=0,Duration=0.37)",-2,"progid:DXImageTransform.Microsoft.Slide(slideStyle=swap,bands=15,enabled=0,Duration=0.37)",-2,73]);
			stm_aix("p0i0","p0i0",[0,"CARNET","","",-1,-1,0,"Carnet Funcionarios/carnet_funcionarios.php?formidinf=usht1f9pefbhd271n2r35p8sv7&id=1GGUwSJLLGy/2&datossl=MXx8fDF8fHwxfHx8MXx8fDB8fHww","_new","","","","",0,0,0,"","",0,0]);
			
			stm_ep();
			
			stm_ai( "p1i3",[6,1,"#999999","",0,0,0]);
			stm_aix("p0i2","p0i0",[0,"   Informaci�n de Interes","","",-1,-1,0,"","_self","","","","",0,0,0,"","",0,0,0,0,1,"#ffffff",0,"#ffffff",0,"","",3,3,0,0,"#3399cc","#3399cc","#000000","#000000","bold 9pt Verdana","bold 9pt Verdana",0,0]);
			stm_aix("p0i3","p0i0",[0,"        Cambiar Contrase�a","","",-1,-1,0,"/intranet/seguridad/proceso/m_clave.php","_self","","","","",0,0,0,"","",0,0]);
			stm_ep();
			stm_aix("p0i4","p1i3",[]);
			stm_ep();	
			stm_aix("p0i5","p0i0",[0,"  Cerrar Aplicaci�n","","",-1,-1,0,"../adminsalir.php","_self","","","","",0,0,0,"","",0,0]);
			stm_ai( "p1i3",[6,1,"#999999","",0,0,0]);
			stm_ep();
			stm_em();
		}

	<?php  sajax_show_javascript();	?>

	function show_retorno (c) {
	if (c=='DOBLE'){
	//	  document.getElementById('id_msg_validacion').innerHTML  = 'ERROR ESTE CORREO YA SE ENCUENTRA REGISTRADO'
		alert("ERROR, ESTE CORREO YA SE ENCUENTRA REGISTRADO ")
		window.location.reload();
		return;
	}
	alert("Informaci�n Actualizada")
	window.location.reload();
	
	}

	function fx_guardarObservacion(){
		//
		YY_checkform('form1','f_email','#S','2','Error, no es un correo valido');
		
		
		if  (document.MM_returnValue == false){
			return;
		}
		document.getElementById('id_muestra_boton').innerHTML = ''
		document.getElementById('id_muestra_boton2').innerHTML = ''
		document.getElementById('id_muestra_boton3').innerHTML = '' 
		document.getElementById('id_msg_validacion').innerHTML = "ESPERE UN MOMENTO MIENTRAS SE ACTUALIZA LA INFORMACION Y SE LE ENVIA A SU CORREO ELECTRONICO UN CODIGO DE VERIFICACION"
		var email  = document.getElementById('f_email').value;
		x_fx_actualizaEmail(email  ,  show_retorno )
	}

	function show_retorno2 (c) {
	window.location.reload();
	}


	//
	//
	//
	function fx_validarCodigo(){
		var codigo_valida  = document.getElementById('f_codigo').value;
		var email  = document.getElementById('f_email').value;
		x_fx_verifica_codigo(codigo_valida  ,email,  show_retorno2 )
	}
	//
	//
	</script>
</head> 

<body class="app">   	
    <header class="app-header fixed-top">	   	            
        <div class="app-header-inner">  
	        <div class="container-fluid py-2">
		        <div class="app-header-content"> 
		            <div class="row justify-content-between align-items-center">
			        
				    <div class="col-auto">
					    <a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
						    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" role="img"><title>Menú</title><path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path></svg>
					    </a>
				    </div><!--//col-->
		            <div class="search-mobile-trigger d-sm-none col">
			            <i class="search-mobile-trigger-icon fas fa-search"></i>
			        </div><!--//col-->
		            		            
		            <div class="app-utilities col-auto">			            
			            <div class="app-utility-item app-user-dropdown dropdown">
				            <a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><img src="/intranet/carnet2018/<?php echo  $_SESSION['sess_intra_usuario'];?>.jpg" alt="user profile"></a>
				            <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
								<!--<li><a class="dropdown-item" href="account.php">Account</a></li>
								<li><a class="dropdown-item" href="settings.php">Settings</a></li>
								<li><hr class="dropdown-divider"></li>-->
								<li><a class="dropdown-item" href="login.php">Salir</a></li>
							</ul>
			            </div><!--//app-user-dropdown--> 
		            </div><!--//app-utilities-->
		        </div><!--//row-->
	            </div><!--//app-header-content-->
	        </div><!--//container-fluid-->
        </div><!--//app-header-inner-->
        <div id="app-sidepanel" class="app-sidepanel sidepanel-hidden"> 
	        <div id="sidepanel-drop" class="sidepanel-drop"></div>
	        <div class="sidepanel-inner d-flex flex-column">
		        <a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>
		        <div class="app-branding">
		            <a class="app-logo" href="index.php"><img class="logo-icon me-2" src="assets/images/Logo_UDO.svg" alt="logo"><span class="logo-text">UDO</span></a>
	
		        </div><!--//app-branding-->  
			    <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
				    <ul class="app-menu list-unstyled accordion" id="menu-accordion">
					    <li class="nav-item">
					        <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
					        <a class="nav-link active" href="index.php">
						        <span class="nav-icon">
						        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-house-door" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
		  <path fill-rule="evenodd" d="M7.646 1.146a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 .146.354v7a.5.5 0 0 1-.5.5H9.5a.5.5 0 0 1-.5-.5v-4H7v4a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .146-.354l6-6zM2.5 7.707V14H6v-4a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v4h3.5V7.707L8 2.207l-5.5 5.5z"/>
		  <path fill-rule="evenodd" d="M13 2.5V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
		</svg>
						         </span>
		                         <span class="nav-link-text">Inicio</span>
					        </a><!--//nav-link-->
					    </li><!--//nav-item-->
						<li class="nav-item has-submenu">
					        <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
					        <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#submenu-1" aria-expanded="false" aria-controls="submenu-1">
						        <span class="nav-icon">
						        <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
						        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-files" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd" d="M4 2h7a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H4z"/>
									<path d="M6 0h7a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H6a1 1 0 0 0-1 1H4a2 2 0 0 1 2-2z"/>
									</svg>
						         </span>
		                         <span class="nav-link-text">Pages</span>
		                         <span class="submenu-arrow">
		                             <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
									</svg>
	                             </span><!--//submenu-arrow-->
					        </a><!--//nav-link-->
					        <div id="submenu-1" class="collapse submenu submenu-1" data-bs-parent="#menu-accordion">
						        <ul class="submenu-list list-unstyled">
							        <li class="submenu-item"><a class="submenu-link" href="notifications.html">Notifications</a></li>
							        <li class="submenu-item"><a class="submenu-link" href="account.html">Account</a></li>
							        <li class="submenu-item"><a class="submenu-link" href="settings.html">Settings</a></li>
						        </ul>
					        </div>
					    </li><!--//nav-item-->
					    
				    </ul><!--//app-menu-->
			    </nav><!--//app-nav-->
	        </div><!--//sidepanel-inner-->
	    </div><!--//app-sidepanel-->
    </header><!--//app-header-->
    
    <div class="app-wrapper min-vh-100 position-relative pb-5">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
			    
			    <h1 class="app-page-title">Mis Datos</h1>
                <div class="row gy-4">
	                <div class="col-12 col-lg-6">
		                <div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start">
						    <div class="app-card-header p-3 border-bottom-0">
						        <div class="row align-items-center gx-3">
							        <div class="col-auto">
								        <div class="app-icon-holder">
										    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  												<path fill-rule="evenodd" d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
											</svg>
									    </div><!--//icon-holder-->
						                
							        </div><!--//col-->
							        <div class="col-auto">
								        <h4 class="app-card-title">Perfil</h4>
							        </div><!--//col-->
						        </div><!--//row-->
						    </div><!--//app-card-header-->
						    <div class="app-card-body px-4 w-100">
							    <div class="item border-bottom py-3">
								    <div class="row justify-content-between align-items-center">
									    <div class="col-auto">
										    <div class="item-label mb-2"><strong>Foto</strong></div>
										    <div class="item-data"><img class="profile-image" src="/intranet/carnet2018/<?php echo  $_SESSION['sess_intra_usuario'];?>.jpg" alt=""></div>
									    </div><!--//col-->
									    <div class="col text-end">
										    
									    </div><!--//col-->
								    </div><!--//row-->
							    </div><!--//item-->
							    <div class="item border-bottom py-3">
								    <div class="row justify-content-between align-items-center">
									    <div class="col-auto">
										    <div class="item-label"><strong>Nombre</strong></div>
									        <div class="item-data"><?php echo $_SESSION['sess_intra_nombre'];?>  <?php echo $_SESSION['sess_intra_apellido'];?></div>
									    </div><!--//col-->
									    <div class="col text-end">
										    
									    </div><!--//col-->
								    </div><!--//row-->
							    </div><!--//item-->
								<div class="item border-bottom py-3">
								    <div class="row justify-content-between align-items-center">
									    <div class="col-auto">
										    <div class="item-label"><strong>Cédula</strong></div>
									        <div class="item-data"><?php echo $_SESSION['sess_intra_usuario'];?></div>
									    </div><!--//col-->
									    <div class="col text-end">
										    
									    </div><!--//col-->
								    </div><!--//row-->
							    </div><!--//item-->
							    <div class="item border-bottom py-3">
								    <div class="row justify-content-between align-items-center">
									    <div class="col-auto">
										    <div class="item-label"><strong>Núcleo</strong></div>
									        <div class="item-data"><?php echo $_SESSION['sess_intra_nucleo'];?></div>
									    </div><!--//col-->
									    <div class="col text-end">
										    
									    </div><!--//col-->
								    </div><!--//row-->
							    </div><!--//item-->
							    <div class="item border-bottom py-3">
								    <div class="row justify-content-between align-items-center">
									    <div class="col-auto">
										    <div class="item-label"><strong>Tipo Personal</strong></div>
									        <div class="item-data">
												<?php echo $generico[$_SESSION['sess_intra_generico']];?>
									        </div>
									    </div><!--//col-->
									    <div class="col text-end">
										    
									    </div><!--//col-->
								    </div><!--//row-->
							    </div><!--//item-->
						    </div><!--//app-card-body-->
						    <div class="app-card-footer p-4 mt-auto">
							   
						    </div><!--//app-card-footer-->
						   
						</div><!--//app-card-->
	                </div><!--//col-->
	                <div class="col-12 col-lg-6">
		                <div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start">
						    <div class="app-card-header p-3 border-bottom-0">

						    </div><!--//app-card-header-->
						    <div class="app-card-body px-4 w-100">
							    
								<div class="item border-bottom py-3">
								    <div class="row justify-content-between align-items-center">
									    <div class="col-auto">
										    <div class="item-label"><strong>Correo</strong></div>
									        <div class="item-data">
											<?php 
														if ($objDatos[0]['EMAIL'] == NULL) {
												$mensaje= "USTED NO POSEE REGISTRADO EN NUESTRO SISTEMA DE PERSONAL CORREO ELECTRONICO INSTITUCIONAL PARA SOLICITARLO";
												echo $mensaje;
																			}
																else {
														echo $objDatos[0]['EMAIL'];
																}
														?>
											</div>
									    </div><!--//col-->
									    <div class="col text-end">
										    
									    </div><!--//col-->
								    </div><!--//row-->
							    </div><!--//item-->
							    <div class="item border-bottom py-3">
								    <div class="row justify-content-between align-items-center">
									    <div class="col-auto">
										    <div class="item-label"><strong>Condición Laboral</strong></div>
									        <div class="item-data">
												<?php echo $condicion[$_SESSION['sess_intra_condicion']];?>
									        </div>
									    </div><!--//col-->
									    <div class="col text-end">
										    
									    </div><!--//col-->
								    </div><!--//row-->
							    </div><!--//item-->
						    </div><!--//app-card-body-->
						    <div class="app-card-footer p-4 mt-auto">
							   
						    </div><!--//app-card-footer-->
						   
						</div><!--//app-card-->
	                </div><!--//col-->
	                
                </div><!--//row-->
			    
		    </div><!--//container-fluid-->
	    </div><!--//app-content-->
	    
	    <footer class="app-auth-footer">
			<div class="container text-center py-3">
				 <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
			<small class="copyright">Diseñado por <a class="app-link" href="https://udo.education/" target="_blank">Universidad de Oriente - Dirección de Computación - RECTORADO. 2023</a></small>
			   
			</div>
		</footer><!--//app-auth-footer-->
	    
    </div><!--//app-wrapper-->    					

 
    <!-- Javascript -->          
    <script src="assets/plugins/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>  
    
    <!-- Page Specific JS -->
    <script src="assets/js/app.js"></script> 

</body>
</html> 

