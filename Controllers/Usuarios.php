<?php 

	class Usuarios extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
			getPermisos(MUSUARIOS);
		}

		public function Usuarios()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Usuarios";
			$data['page_title'] = "GRUPO DE PRODUCTO <small>Tienda Virtual</small>";
			$data['page_name'] = "usuarios";
			$data['page_functions_js'] = "functions_usuarios.js";
			$this->views->getView($this,"usuarios",$data);
		}

		public function setUsuario(){
	
			if ($_POST) {
				// dep($_POST);
				// die();
	
				if (
					empty($_POST['listIDSubFamilia2']) ||
					empty($_POST['txtnombreG']) ||
					empty($_POST['txtdescripcionGrupo']) 
				) {
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				} else {

					// [idUsuario] => 
					// [listIDSubFamilia2] => 1
					// [txtnombreG] => s
					// [txtdescripcionGrupo] => d
					// [txtcuotacompra] => 3
					$idn3  = intval($_POST['idUsuario']);
					// $idUsuario= intval($_POST['idUsuario']);
					$listIDSubFamilia2 =  strClean($_POST['listIDSubFamilia2']);
					$txtnombreG = strClean($_POST['txtnombreG']);
					$txtdescripcionGrupo = strClean($_POST['txtdescripcionGrupo']);
				
			
					if ($idn3  == 0) {
						//Cra cunsulta menos el id  por que no creamos el id
						$option = 1;
						$request_cateria = $this->model->insertUsuario(
							$listIDSubFamilia2,
							$txtnombreG,
							$txtdescripcionGrupo
						);
					} else {
						//Actualizar aqui si mandamsk el id
						$option = 2;
					}
					if ($request_cateria > 0) {
						if ($option == 1) {
							$arrResponse = array('idn3' => $request_cateria, 'msg' => 'Datos guardados correctamente.');
						}
					} else if ($request_cateria == 'exist') {
						$arrResponse = array('msg' => '¡Atención! La categoría ya existe.');
					} else {
						$arrResponse = array("msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}

		public function getUsuarios()
		{
			if($_SESSION['permisosMod']['r']){
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->selectUsuarios();
				for ($i=0; $i < count($arrData); $i++) {
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

					// if($arrData[$i]['status'] == 1)
					// {
					// 	$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					// }else{
					// 	$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					// }

					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['idn3'].')" title="Ver categoría"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['idn3'].')" title="Editar categoría"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){	
						$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idn3'].')" title="Eliminar categoría"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
		
			// $arrData = $this->model->selectUsuarios();
			// dep($arrData);
			// echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function getUsuario($idpersona){
			if($_SESSION['permisosMod']['r']){
				$idusuario = intval($idpersona);
				if($idusuario > 0)
				{
					$arrData = $this->model->selectUsuario($idusuario);
					if(empty($arrData))
					{
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function delUsuario()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdpersona = intval($_POST['idUsuario']);
					$requestDelete = $this->model->deleteUsuario($intIdpersona);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function perfil(){
			$data['page_tag'] = "Perfil";
			$data['page_title'] = "Perfil de usuario";
			$data['page_name'] = "perfil";
			$data['page_functions_js'] = "functions_usuarios.js";
			$this->views->getView($this,"perfil",$data);
		}

		public function putPerfil(){
			if($_POST){
				if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					$idUsuario = $_SESSION['idUser'];
					$strIdentificacion = strClean($_POST['txtIdentificacion']);
					$strNombre = strClean($_POST['txtNombre']);
					$strApellido = strClean($_POST['txtApellido']);
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$strPassword = "";
					if(!empty($_POST['txtPassword'])){
						$strPassword = hash("SHA256",$_POST['txtPassword']);
					}
					$request_user = $this->model->updatePerfil($idUsuario,
																$strIdentificacion, 
																$strNombre,
																$strApellido, 
																$intTelefono, 
																$strPassword);
					if($request_user)
					{
						sessionUser($_SESSION['idUser']);
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible actualizar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function putDFical(){
			if($_POST){
				if(empty($_POST['txtNit']) || empty($_POST['txtNombreFiscal']) || empty($_POST['txtDirFiscal']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					$idUsuario = $_SESSION['idUser'];
					$strNit = strClean($_POST['txtNit']);
					$strNomFiscal = strClean($_POST['txtNombreFiscal']);
					$strDirFiscal = strClean($_POST['txtDirFiscal']);
					$request_datafiscal = $this->model->updateDataFiscal($idUsuario,
																		$strNit,
																		$strNomFiscal, 
																		$strDirFiscal);
					if($request_datafiscal)
					{
						sessionUser($_SESSION['idUser']);
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible actualizar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getSelectUsari(){
			$htmlOptions = "";
			$arrData = $this->model->selectnivel2();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					if($arrData[$i] ){
					$htmlOptions .= '<option value="'.$arrData[$i]['idn2'].'">'.$arrData[$i]['nombre'].'</option>';
					}
				}
			}
			echo $htmlOptions;
			die();	

			
			// $arrData = $this->model->selectUsuarios();
			// dep($arrData);
						
			// echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		}

	}
 ?>