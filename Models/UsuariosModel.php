<?php

class UsuariosModel extends Mysql
{
	// private $idUsuario;
	private $listIDSubFamilia2;
	private $txtnombreG;
	private $txtdescripcionGrupo;
	private $txtcuotacompra;


	public function __construct()
	{
		parent::__construct();
	}

	public function insertUsuario(
		int $listIDSubFamilia2,
		string $txtnombreG,
		string $txtdescripcionGrupo
	) {

		$this->listIDSubFamilia2 = $listIDSubFamilia2;
		$this->txtnombreG = $txtnombreG;
		$this->txtdescripcionGrupo = $txtdescripcionGrupo;
	

		$return = 0;
		$sql = "SELECT * FROM nivel3 WHERE nomgru = '{$this->txtnombreG}' ";
		$request = $this->select_all($sql);

		if (empty($request)) {
			$query_insert  = "INSERT INTO nivel3(
				idn2, 
				nomgru,
				desgru) 
								  VALUES(?,?,?)";
			$arrData = array(
				$this->listIDSubFamilia2,
				$this->txtnombreG,
				$this->txtdescripcionGrupo	);
			$request_insert = $this->insert($query_insert, $arrData);
			$return = $request_insert;
		} else {
			$return = "exist";
		}
		return $return;
	}

	public function selectUsuarios()
	{
		// $whereAdmin = "";
		// if($_SESSION['idUser'] != 1 ){
		// 	$whereAdmin = " and p.idpersona != 1 ";
		// }
		$sql = "SELECT * FROM `nivel3` WHERE 1";
		$request = $this->select_all($sql);
		return $request;
	}
	public function selectnivel2()
	{
		// $whereAdmin = "";
		// if($_SESSION['idUser'] != 1 ){
		// 	$whereAdmin = " and p.idpersona != 1 ";
		// }
		$sql = "SELECT * FROM `nivel2` WHERE 1";
		$request = $this->select_all($sql);
		return $request;
	}
	public function selectUsuario(int $idpersona)
	{
		$this->intIdUsuario = $idpersona;
		$sql = "SELECT p.idpersona,p.identificacion,p.nombres,p.apellidos,p.telefono,p.email_user,p.nit,p.nombrefiscal,p.direccionfiscal,r.idrol,r.nombrerol,p.status, DATE_FORMAT(p.datecreated, '%d-%m-%Y') as fechaRegistro 
					FROM persona p
					INNER JOIN rol r
					ON p.rolid = r.idrol
					WHERE p.idpersona = $this->intIdUsuario";
		$request = $this->select($sql);
		return $request;
	}

	public function updateUsuario(int $idUsuario, string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid, int $status)
	{

		$this->intIdUsuario = $idUsuario;
		$this->strIdentificacion = $identificacion;
		$this->strNombre = $nombre;
		$this->strApellido = $apellido;
		$this->intTelefono = $telefono;
		$this->strEmail = $email;
		$this->strPassword = $password;
		$this->intTipoId = $tipoid;
		$this->intStatus = $status;

		$sql = "SELECT * FROM persona WHERE (email_user = '{$this->strEmail}' AND idpersona != $this->intIdUsuario)
										  OR (identificacion = '{$this->strIdentificacion}' AND idpersona != $this->intIdUsuario) ";
		$request = $this->select_all($sql);

		if (empty($request)) {
			if ($this->strPassword  != "") {
				$sql = "UPDATE persona SET identificacion=?, nombres=?, apellidos=?, telefono=?, email_user=?, password=?, rolid=?, status=? 
							WHERE idpersona = $this->intIdUsuario ";
				$arrData = array(
					$this->strIdentificacion,
					$this->strNombre,
					$this->strApellido,
					$this->intTelefono,
					$this->strEmail,
					$this->strPassword,
					$this->intTipoId,
					$this->intStatus
				);
			} else {
				$sql = "UPDATE persona SET identificacion=?, nombres=?, apellidos=?, telefono=?, email_user=?, rolid=?, status=? 
							WHERE idpersona = $this->intIdUsuario ";
				$arrData = array(
					$this->strIdentificacion,
					$this->strNombre,
					$this->strApellido,
					$this->intTelefono,
					$this->strEmail,
					$this->intTipoId,
					$this->intStatus
				);
			}
			$request = $this->update($sql, $arrData);
		} else {
			$request = "exist";
		}
		return $request;
	}
	public function deleteUsuario(int $intIdpersona)
	{
		$this->intIdUsuario = $intIdpersona;
		$sql = "UPDATE persona SET status = ? WHERE idpersona = $this->intIdUsuario ";
		$arrData = array(0);
		$request = $this->update($sql, $arrData);
		return $request;
	}

	public function updatePerfil(int $idUsuario, string $identificacion, string $nombre, string $apellido, int $telefono, string $password)
	{
		$this->intIdUsuario = $idUsuario;
		$this->strIdentificacion = $identificacion;
		$this->strNombre = $nombre;
		$this->strApellido = $apellido;
		$this->intTelefono = $telefono;
		$this->strPassword = $password;

		if ($this->strPassword != "") {
			$sql = "UPDATE persona SET identificacion=?, nombres=?, apellidos=?, telefono=?, password=? 
						WHERE idpersona = $this->intIdUsuario ";
			$arrData = array(
				$this->strIdentificacion,
				$this->strNombre,
				$this->strApellido,
				$this->intTelefono,
				$this->strPassword
			);
		} else {
			$sql = "UPDATE persona SET identificacion=?, nombres=?, apellidos=?, telefono=? 
						WHERE idpersona = $this->intIdUsuario ";
			$arrData = array(
				$this->strIdentificacion,
				$this->strNombre,
				$this->strApellido,
				$this->intTelefono
			);
		}
		$request = $this->update($sql, $arrData);
		return $request;
	}

	public function updateDataFiscal(int $idUsuario, string $strNit, string $strNomFiscal, string $strDirFiscal)
	{
		$this->intIdUsuario = $idUsuario;
		$this->strNit = $strNit;
		$this->strNomFiscal = $strNomFiscal;
		$this->strDirFiscal = $strDirFiscal;
		$sql = "UPDATE persona SET nit=?, nombrefiscal=?, direccionfiscal=? 
						WHERE idpersona = $this->intIdUsuario ";
		$arrData = array(
			$this->strNit,
			$this->strNomFiscal,
			$this->strDirFiscal
		);
		$request = $this->update($sql, $arrData);
		return $request;
	}
}
