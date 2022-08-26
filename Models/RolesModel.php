<?php 

	class RolesModel extends Mysql
	{
		public $intidn2;
		public $intidcategoria;
		public $strnombre;
		public $strdescripcion;

		public function __construct()
		{
			parent::__construct();
		}

		public function selectRoles()
		{
		
			$sql = "SELECT * FROM `nivel2` WHERE 1";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectRol(int $idrol)
		{
			//BUSCAR ROLE
			$this->intIdrol = $idrol;
			$sql = "SELECT * FROM rol WHERE idrol = $this->intIdrol";
			$request = $this->select($sql);
			return $request;
		}

		public function insertRol(int $intidcategoria, string $strnombre, string $strdescripcion ){

			$return = "";
			$this->$intidcategoria= $intidcategoria;
			$this->$strnombre = $strnombre;
			$this->$strdescripcion = $strdescripcion;
			$return =0;
			$sql = "SELECT * FROM nivel2 WHERE nombre = '{$this->$strnombre}' ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO nivel2(
					idcategoria,
					nombre,
					descripcion
					) VALUES(?,?,?)";
	        	$arrData = array(
					$this->$intidcategoria,
					$this->$strnombre,
					$this->$strdescripcion);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}	

		public function updateRol(int $idrol, string $rol, string $descripcion, int $status){
			$this->intIdrol = $idrol;
			$this->strRol = $rol;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			$sql = "SELECT * FROM rol WHERE nombrerol = '$this->strRol' AND idrol != $this->intIdrol";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE rol SET nombrerol = ?, descripcion = ?, status = ? WHERE idrol = $this->intIdrol ";
				$arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
		    return $request;			
		}

		public function deleteRol(int $idrol)
		{
			$this->intIdrol = $idrol;
			$sql = "SELECT * FROM persona WHERE rolid = $this->intIdrol";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				$sql = "UPDATE rol SET status = ? WHERE idrol = $this->intIdrol ";
				$arrData = array(0);
				$request = $this->update($sql,$arrData);
				if($request)
				{
					$request = 'ok';	
				}else{
					$request = 'error';
				}
			}else{
				$request = 'exist';
			}
			return $request;
		}

		
		public function selectCategorias()
		{
			$sql = "SELECT * FROM categoria";
			$request = $this->select_all($sql);
			return $request;
		}

	}
 ?>