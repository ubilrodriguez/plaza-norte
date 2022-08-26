<?php

class Roles extends Controllers
{
	public function __construct()
	{
		parent::__construct();
		session_start();
		session_regenerate_id(true);
		if (empty($_SESSION['login'])) {
			header('Location: ' . base_url() . '/login');
			die();
		}
		getPermisos(MUSUARIOS);
	}

	public function Roles()
	{
		if (empty($_SESSION['permisosMod']['r'])) {
			header("Location:" . base_url() . '/dashboard');
		}
		$data['page_id'] = 3;
		$data['page_tag'] = "Roles Usuario";
		$data['page_name'] = "rol_usuario";
		$data['page_title'] = "SUBFAMILIA DE PRODUCTO <small> Tienda Virtual</small>";
		$data['page_functions_js'] = "functions_roles.js";
		$this->views->getView($this, "roles", $data);
	}

	public function getRoles()
	{
		if ($_SESSION['permisosMod']['r']) {
			$btnView = '';
			$btnEdit = '';
			$btnDelete = '';
			$arrData = $this->model->selectRoles();
			for ($i = 0; $i < count($arrData); $i++) {
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';

				// if($arrData[$i]['status'] == 1)
				// {
				// 	$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
				// }else{
				// 	$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
				// }

				if ($_SESSION['permisosMod']['r']) {
					$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['idn2'] . ')" title="Ver categoría"><i class="far fa-eye"></i></button>';
				}
				if ($_SESSION['permisosMod']['u']) {
					$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['idn2'] . ')" title="Editar categoría"><i class="fas fa-pencil-alt"></i></button>';
				}
				if ($_SESSION['permisosMod']['d']) {
					$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['idn2'] . ')" title="Eliminar categoría"><i class="far fa-trash-alt"></i></button>';
				}
				$arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
			}
			echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
		}
		

		// $arrData = $this->model->selectRoles();
		// dep($arrData);
		// echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		die();
	}

	public function getSelectRoles()
	{
		$htmlOptions = "";
		$arrData = $this->model->selectRoles();
		if (count($arrData) > 0) {
			for ($i = 0; $i < count($arrData); $i++) {
				if ($arrData[$i]['status'] == 1) {
					$htmlOptions .= '<option value="' . $arrData[$i]['idrol'] . '">' . $arrData[$i]['nombrerol'] . '</option>';
				}
			}
		}
		echo $htmlOptions;
		die();
	}

	public function getRol(int $idrol)
	{	
		if ($_SESSION['permisosMod']['r']) {
			$intIdrol = intval(strClean($idrol));
			if ($intIdrol > 0) {
				$arrData = $this->model->selectRol($intIdrol);
				if (empty($arrData)) {
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				} else {
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}

	public function setRol()
	{

		if ($_POST) {
			// dep($_POST);
			// die();

			if (
				empty($_POST['listIDSubFamilia']) ||
				empty($_POST['txtnombre']) ||
				empty($_POST['txtdescripcion']) 
			) {
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			} else {

				$intidn2 = intval($_POST['idRol']);
				$intidcategoria =  strClean($_POST['listIDSubFamilia']);
				$strnombre = strClean($_POST['txtnombre']);
				$strdescripcion = strClean($_POST['txtdescripcion']);

				if ($intidn2  == 0) {
					//Crear la cunsulta menos el id  por que no creamos el id
					$option = 1;
					$request_cateria = $this->model->insertRol(
						$intidcategoria,
						$strnombre,
						$strdescripcion
					);
				} else {
					//Actualizar aqui si mandamsk el id
					$option = 2;
				}
				if ($request_cateria > 0) {
					if ($option == 1) {
						$arrResponse = array('intidn2' => $request_cateria, 'msg' => 'Datos guardados correctamente.');
					}
				} else if ($request_cateria == 'exist') {
					$arrResponse = array('msg' => '¡Atención! La categoría ya existe.');
				} else {
					$arrResponse = array("msg" => 'No es posible almacenar los datos.');
				}
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
		// $intidn2= intval($_POST['intidn2']);
		// $intidcategoria =  strClean($_POST['listIDSubFamilia']);
		// 	$$strnombre = strClean($_POST['txtnombre']);
		// 	$strdescripcion = strClean($_POST['txtdescripcion']);
		// 	$intcompraNAC = intval($_POST['txtcompraNAC']);
		// 	$intcomprarExtra = intval($_POST['txtcomprarExtra']);
		// 	$intventasVinculado = intval($_POST['txtventasVinculado']);
		// 	$request_rol = "";
		// 	if($intidcategoria  == 0)
		// 	{
		// 		//Crear
		// 		$request_rol = $this->model->insertRol( $intidcategoria,  $strnombre, $strdescripcion ,$intcompraNAC ,$intcomprarExtra, $intventasVinculado);
		// 		$option = 1;       
		// 	}else{
		// 		//Actualizar
		// 		if($_SESSION['permisosMod']['u']){
		// 			$request_rol = $this->model->updateRol($intIdrol, $strRol, $strDescipcion, $intStatus);
		// 			$option = 2;
		// 		}
		// 	}


		// 	echo json_encode($request_rol, JSON_UNESCAPED_UNICODE);
		// die();
	}

	public function delRol()
	{
		if ($_POST) {
			if ($_SESSION['permisosMod']['d']) {
				$intIdrol = intval($_POST['idrol']);
				$requestDelete = $this->model->deleteRol($intIdrol);
				if ($requestDelete == 'ok') {
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Rol');
				} else if ($requestDelete == 'exist') {
					$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un Rol asociado a usuarios.');
				} else {
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Rol.');
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}

	public function getSelectCategorias()
	{
		$htmlOptions = "";
		$arrData = $this->model->selectCategorias();
		if (count($arrData) > 0) {
			for ($i = 0; $i < count($arrData); $i++) {
				if ($arrData[$i]) {
					$htmlOptions .= '<option value="' . $arrData[$i]['idcategoria'] . '">' . $arrData[$i]['nombre'] . '</option>';
				}
			}
		}
		echo $htmlOptions;
		die();
	}

	
}
