<?php
	
	include 'configApp.php';

	class Database{

		private $dsn = "mysql:host=localhost;dbname=db_renta_vehiculos";
		private $dbuser = 'root';
		private $dbpass = '';

		public $conn;

		public function __construct(){
			try{
				$this->conn = new PDO($this->dsn, $this->dbuser, $this->dbpass);
			}catch(PDOException $e){
				echo "Error : ".$e->getMessage();
			}
		}

		//Funcion para limpiar los inputs
		public function __Limpiar_inputs($data){
			$data = trim($data);
			$data = stripcslashes($data);
			$data = htmlspecialchars($data);
			$data = str_replace("<script>", "", $data);
			$data = str_replace("</script>", "", $data);
			$data = str_replace("<script src>", "", $data);
			$data = str_replace("<script type>", "", $data);
			$data = str_replace("SELECT * FROM", "", $data);
			$data = str_replace("DELETE FROM", "", $data);
			$data = str_replace("INSERT INTO", "", $data);
			$data = str_replace("--", "", $data);
			$data = str_replace("^", "", $data);
			$data = str_replace("[", "", $data);
			$data = str_replace("]", "", $data);
			$data = str_replace("==", "", $data);
			$data = str_replace(";", "", $data);
			return $data;
		}

		//Funcion para mostrar una alerta con SweetAlert la version de sweetalert es la v.8
		public function __SweetAlert_mensaje_simple($titulo ,$mensaje, $tipo){
			$mensaje = "
				Swal.fire(
					'".$titulo."',
					'".$mensaje."',
					'".$tipo."'
				)";
			return $mensaje;
		}

		//Funcion para generar un codigo aleatoreo
		//esta funcion recibe una letra la longitud y un numero
		public function __Generar_codigo_aleatoreo($letra, $longitud, $num){
			for( $i = 1; $i<=$longitud, $i++; ){
				$numero = rand(0,9);
				$letra.=$num;
			}
			return $letra.$numero;
		}

	  	//Funcion para el tiempo del usuario
		public function tiempoAtras($timestamp){
			date_default_timezone_set('America/Mexico_City');
			//this transform the timestamp in seconds
			$timestamp = strtotime($timestamp) ? strtotime($timestamp) : $timestamp;
			$time = time()- $timestamp;

			switch($time){
				//Seconds
				case $time <= 60:
					return 'Just Now!!';
				break;
				//minutes
				case $time >=60 && $time < 3600:
					return (round($time/60) == 1 ) ? 'un minuto atras' : round($time/60).' minutos atras';
				break;
				//hours
				case $time >= 3600 && $time < 86400:
					return (round($time/3600)==1) ? 'una hora atras' : round($time/3600).' horas atras';
				break;
				//days
				case $time >= 86400 && $time < 604800:
					return ( round($time/86400)==1 ) ? 'un dia atras' : round($time/86400).' dias atras';
				break;
				//week
				case $time >= 604800 && $time < 2600640:
					return ( round($time/604800) == 1 ) ? 'una semana atras' : round($time/604800).' semanas atras';
				break;
				//Month
				case $time >= 2600640 && $time <31207680:
					return ( round($time/2600640) == 1 ) ? 'un mes atras' : round($time/2600640).' meses atras';
				break;
				//Year
				case $time >= 31207680:
					return ( round($time/31207680) == 1 ) ? 'un año atras' : round($time/31207680).' años atras';
				break;
			}
			
		}

		
		
	}
?>