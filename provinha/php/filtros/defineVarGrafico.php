<?php
ob_start();
session_start();

switch($_POST['filtro']) {
	case 1: //SETAR VARIÁVEIS
	
		//$_SESSION['usuario'] = 5;
		//$_SESSION['id_pj'] = 4;
		
		$_SESSION['gtipo'] = $_POST['gtipo'];
		$_SESSION['gturma'] = $_POST['gturma'];
		$_SESSION['gserie'] = $_POST['gserie'];
		$_SESSION['gano'] = $_POST['gano'];
		$_SESSION['gfase'] = $_POST['gfase'];
		break;
	
	case 2: //Verificar e dessetar variáveis
	
		echo $_SESSION['gtipo'] . $_SESSION['gano'] . $_SESSION['gfase'] . str_repeat(0,6-strlen($_SESSION['gserie'])) . $_SESSION['gserie'] . str_repeat(0,6-strlen($_SESSION['gturma'])) . $_SESSION['gturma'];
}

?>