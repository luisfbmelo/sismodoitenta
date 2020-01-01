<?php
include "../connection.php";
class critic{
    private $testemunhoId;
    private $nome;
    private $contato;
    private $data_nasc;
    private $freguesia_id;
    private $testemunho;
    private $foto;
    private $status;
    private $exist=false;
    private $error = false;
    private $allErrors = array();


    /*
	 * This function determines the number of arguments and decides witch function to execute. 
	 * 
	 * 1 argument: constructs the critic according to the userId given
	 * @use getInfoId()
	 * @param testemunhoId
	 *
     * 11 arguments: register new critic
	 * @use registerCritic()
	 * @param $nome,$sobrenome,$contato,$data_nasc,$freguesia_id,$testemunho,$foto,$userId,$type,$foto_desc,$status
     *
     *  arguments: updates critic
	 * @use updateCritic()
	 * @param
	 * 
	 * @return void
	 */
    public function __construct(){
		$args=func_get_args();

		switch (func_num_args()){
			case 1:
				//gets the info from the critic with id=args[0]
				$this->getInfoId($args[0]);
				break;
            case 11:
				//registers new critic
				$this->registerCritic($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7],$args[8],$args[9],$args[10]);
				break;
			/*case :
				//updates critic
				$this->updateCritic($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6]);
				break;*/
		}
	}
    
    /*
	 * Executes the given query and checks if there is any values on the array
	 * After validation, and if it's true, gives the values to the proper properties
	 * 
	 * @param id
	 */
	private function getInfoId($id){
        global $mysqli;
        $stmt = $mysqli->prepare("SELECT * FROM testemunhos WHERE id_testemunhos = ?");

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows>0){
            while ($dados = $result->fetch_assoc()) {
                $this->exist=true;
                $this->testemunhoId = $dados["id_testemunhos"];
                $this->nome = $dados["nome"];
                $this->contato = $dados["contato"];
                $this->data_nasc = $dados["data_nasc"];
                $this->freguesia_id = $dados["freguesia_id"];
                $this->testemunho = $dados["testemunho"];
                $this->foto = $dados["foto"];
                $this->status = $dados["status"];
            }
		}
	}
    
    /*
	 * Executes the instructions to register new critic
	 * 
	 * @param $nome,$sobrenome,$contato,$data_nasc,$freguesia_id,$testemunho,$foto,$userId,$type,$foto_desc
	 * @return void
	 */

	private function registerCritic($nome,$sobrenome,$contato,$data_nasc,$freguesia_id,$testemunho,$foto,$userId,$type,$foto_desc,$status){
        global $mysqli;

        /*CHECK IMAGE*/
        $this->error=false;
        /*if ($foto!=""){
            checkPhotos($foto);
        }*/

        /*CHECK DATA*/
        $freguesia_id=(int)$freguesia_id;
        $allErrors = $this->checkAllData($nome,$sobrenome,$contato,$data_nasc,$freguesia_id,$testemunho);

        //IF IMAGE INCORRECT
        if (!$this->error && count($allErrors)==0){

            //substituir breaks por br
            $breaks = explode("\n", $testemunho);
            $testFinal="";
            $i=0;
            $len = count($breaks);
            foreach($breaks as $data){
                if ($i<$len-1){
                    $testFinal .= $data.'<br/>';
                }else{
                    $testFinal .= $data;
                }
                $i++;
            }

            //REMOVE ALL TAGS
            $a='@<[\/\!]*?[^<>]*?>@si';            // Strip out HTML tags

            $search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
                '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
                '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
            );
            $testFinal = preg_replace($search, '', $testFinal);
            /*$testFinal = strip_tags($testFinal,'<br/>');*/

            $search2 = $search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
                '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
                '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
                '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
            );

            $nome = preg_replace($search, '', $nome);
            $sobrenome = preg_replace($search, '', $sobrenome);
            $contato = preg_replace($search, '', $contato);

            //TAKE CARE OF POSSIBLE SPECIAL CHARS
            $testFinal = htmlentities($testFinal,ENT_NOQUOTES,"UTF-8");
            $nome = htmlentities($nome,ENT_NOQUOTES,"UTF-8");
            $sobrenome = htmlentities($sobrenome,ENT_NOQUOTES,"UTF-8");
            $foto = htmlentities($foto,ENT_NOQUOTES,"UTF-8");
            $foto_desc = htmlentities($foto_desc,ENT_NOQUOTES,"UTF-8");
            $contato = htmlentities($contato,ENT_NOQUOTES,"UTF-8");

            //INSERT DATA
            if($query = $mysqli->prepare('INSERT INTO testemunhos (nome, sobrenome, contato, data_nasc, freguesia_id, testemunho, foto, user_id, tipo, foto_desc, date, status, av) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,NOW(),?, 1)')) { // assuming $mysqli is the connection
                $rc = $query->bind_param('ssssissiisi',
                    $nome,
                    $sobrenome,
                    $contato,
                    $data_nasc,
                    $freguesia_id,
                    $testFinal,
                    $foto,
                    $userId,
                    $type,
                    $foto_desc,
                    $status
                );
                if ( false===$rc ) {
                  // again execute() is useless if you can't bind the parameters. Bail out somehow.
                  //die('bind_param() failed: ' . htmlspecialchars($query->error));
                }

                $rc = $query->execute();
                // execute() can fail for various reasons. And may it be as stupid as someone tripping over the network cable
                // 2006 "server gone away" is always an option
                if ( false===$rc ) {
                  //die('execute() failed: ' . htmlspecialchars($query->error));
                }

                $query->close();
            } else {
                $error = $mysqli->errno . ' ' . $mysqli->error;
                //die($error); // 1054 Unknown column 'foo' in 'field list'
            }   

            //GET ID
            $sql="SELECT * FROM testemunhos ORDER BY id_testemunhos DESC LIMIT 1";
            $query = $mysqli->query($sql);

            if ($query->num_rows>0){
                while ($dados = $query->fetch_assoc()) {
                    $this->exist=true;
                    $this->testemunhoId = $dados["id_testemunhos"];
                    $this->nome = $dados["nome"];
                    $this->contato = $dados["contato"];
                    $this->data_nasc = $dados["data_nasc"];
                    $this->freguesia_id = $dados["freguesia_id"];
                    $this->testemunho = $dados["testemunho"];
                    $this->foto = $dados["foto"];
                    $this->status = $dados["status"];
                }
            }

            if ($this->exist){
                $this->newSubMail();
            }

            //CREATE NEW ARTICLE IMAGE FOLDER
            /*if (!is_dir("./img/testimg/$this->testemunhoId")){
                mkdir("./img/testimg/$this->testemunhoId",0777);
            }

            //CREATE NEW ARTICLE IMAGE THUMBNAIL FOLDER
            if (!is_dir("./img/testthumbnails/$this->testemunhoId")){
                mkdir("./img/testthumbnails/$this->testemunhoId",0777);
            }


            //UPLOAD PIC
            if ($foto!=""){
                $this->uploadPic($foto);
            }*/

        }else{
            return $allErrors;
        }
	}
    
    /*
	 * Executes the instructions to update critic info
	 * 
	 * @param $testemunhoId,$nome,$contato,$data_nasc,$freguesia_id,$testemunho,$foto
	 * @return void
	 */
	private function updateCritic($testemunhoId,$nome,$contato,$data_nasc,$freguesia_id,$testemunho,$email,$foto=""){
        global $mysqli;

        /*CHECK IMAGE*/
        /*$this->error=false;
        if ($foto!=""){
            checkPhotos($foto);
        }*/

        //IF IMAGE INCORRECT
        if (!$this->error){
            //substituir breaks por br
            $breaks = explode("\n", $testemunho);
            $testFinal="";
            foreach($breaks as $data){
                $testFinal .= $data.'<br />';
            }

            //REMOVE ALL TAGS
            $a='@<[\/\!]*?[^<>]*?>@si';            // Strip out HTML tags
            $search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
                '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
                '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
            );
            $testFinal = preg_replace($search, '', $testFinal);
            $testFinal = strip_tags($testFinal,'<br/>');

            //INSERT DATA
            $stmt = $mysqli->prepare("UPDATE testemunhos SET nome = ?,
               contato = ?,
               data_nasc = ?,
               freguesia_id = ?,
               testemunho = ?,
               email = ?,
               user_id = 1
               WHERE id_testemunhos = ?");
            $stmt->bind_param('sssissi',
                $nome,
                $contato,
                $data_nasc,
                $freguesia_id,
                $testFinal,
                $email,
                $testemunhoId);
            $stmt->execute();
            $stmt->close();

            //UPLOAD PIC
            /*if ($foto!=""){
                $this->uploadPic($foto);
                $this->getInfoId($testemunhoId);
            }*/
        }
	}

    /*
     * Checks all photos if there is any
     *
     * @param $photos
     * @return void
     */
    public function checkPhotos($foto){
        //SEE IF IMAGES ARE ACCEPTABLE

        $extensions = array("jpeg","jpg","png","gif");

        // Loop through the friend array
        foreach($foto['tmp_name'] as $key=>$tmp_name){
            //GO THROUGH IMAGES
            $file_name = $foto['name'][$key];
            $file_size =$foto['size'][$key];
            $file_tmp =$foto['tmp_name'][$key];
            $file_type=$foto['type'][$key];

            //CHECK EXTENSION
            $file_ext=explode('.',$foto['name'][$key]);
            $file_ext=end($file_ext);
            $file_ext=strtolower($file_ext);

            if(in_array($file_ext,$extensions ) === false){
                $errors[]="Extension not allowed";
                $this->error=true;
            }

            //CHECK IMAGE SIZE
            if($foto['size'][$key] > 8097152){
                $errors[]='File size must be less than 8 MB';
                $this->error=true;
            }
        }
    }

    /*
     * Checks all the data from form
     *
     * @param $nome,$sobrenome,$contato,$data_nasc,$freguesia_id,$testemunho,$foto,$userId,$type,$foto_desc
     * @return $errors
     */
    public function checkAllData($nome,$sobrenome,$contato,$data_nasc,$freguesia_id,$testemunho){
        $errors = array();
        if (!isset($nome) || !is_string($nome) || $nome=="" || strlen($nome)==0){
            array_push($errors,"name");
        }

        if (!isset($sobrenome) || !is_string($sobrenome) || $sobrenome=="" || strlen($sobrenome)==0){
            array_push($errors,"surname");
        }

        if (!isset($contato) || !is_string($contato) || $contato=="" || strlen($contato)==0){
            array_push($errors,"contact");
        }

        if (!isset($data_nasc) || !is_string($data_nasc) || $data_nasc=="" || strlen($data_nasc)==0){
            array_push($errors,"date");
        }

        if (!isset($freguesia_id) || !is_int($freguesia_id) || $freguesia_id=="" || strlen($freguesia_id)==0){
            array_push($errors,"freguesias");
        }

        if (!isset($testemunho) || !is_string($testemunho) || $testemunho=="" || strlen($testemunho)==0 || strlen($testemunho)>4500){
            array_push($errors,"testemunhoTXT");
        }

        $this->allErrors = $errors;
        return $errors;
    }

    /*
	 * Executes the instructions to upload picture
	 *
	 * @param $testemunhoId
	 * @return void
	 */
    public function uploadPic($file){
        global $mysqli;

        $path="./img/testimg/$this->testemunhoId/";
        $thumbPath="./img/testthumbnails/$this->testemunhoId/";

        if (isset($file)){

            // Loop through the friend array
            foreach($file['tmp_name'] as $key=>$tmp_name){
                //GO THROUGH IMAGES
                $file_name = $file['name'][$key];
                $file_size =$file['size'][$key];
                $file_tmp =$file['tmp_name'][$key];
                $file_type=$file['type'][$key];

                //IMPORT FILE

                    move_uploaded_file($file_tmp,$path.$file_name);
                    $stmt = $mysqli->prepare("UPDATE testemunhos SET foto = ?
                       WHERE id_testemunhos = ?");
                    $stmt->bind_param('si',
                        $file_name,
                        $this->testemunhoId);
                    $stmt->execute();
                    $stmt->close();

                    //create thumb
                    if ($file_type=="image/jpg" || $file_type=="image/jpeg") {
                        $imgt = "imagejpeg";
                        $imgcreatefrom = "imagecreatefromjpeg";
                    }else if ($file_type == "image/png") {
                        $imgt = "imagepng";
                        $imgcreatefrom = "imagecreatefrompng";
                    }else{
                        $imgt = "imagegif";
                        $imgcreatefrom = "imagecreatefromgif";
                    }
                    $nova_foto = $imgcreatefrom($path.$file_name);


                    $largura = imagesx($nova_foto);
                    $altura = imagesy($nova_foto);

                    //rela��o entre largura e altura da foto carregada
                    $proporcao = $largura/$altura;

                    //determinar dimens�es do thumbnail, evitando as distor��es no resize
                    $largura_thumb = 300;
                    $altura_thumb = floor($largura_thumb/$proporcao); // aredondamento inteiro por defeito

                    //criar nova imagem fotogr�fica para o thumbnail
                    $thumb_foto = imagecreatetruecolor($largura_thumb,$altura_thumb);
                    imagecopyresized ($thumb_foto, $nova_foto, 0, 0, 0, 0, $largura_thumb, $altura_thumb, $largura, $altura);

                    //gravar o ficheiro jpg com o thumbnail
                    if ($imgt=="imagepng"){
                        $white = imagecolorallocate($thumb_foto, 255, 255, 255);
                        imagefill($thumb_foto, 0, 0, $white);

                        $imgt($thumb_foto, $thumbPath.$file_name, 0);
                    }else if ($imgt=="imagejpg"){
                        $imgt($thumb_foto, $thumbPath.$file_name, 100);
                    }else{
                        $imgt($thumb_foto, $thumbPath.$file_name);
                    }

            }
        }
    }
    
	/*
	 * Returns the criticId
	 * 
	 * @return String
	 */
	public function getId(){
		if ($this->testemunhoId!="" && isset($this->testemunhoId)){
			return $this->testemunhoId;
		}
	}
	
	/*
	 * Returns the critic name
	 * 
	 * @return String
	 */
	public function getName(){
		if ($this->nome!="" && isset($this->nome)){
			return $this->nome;
		}
	}
	
	/*
	 * Returns the user age
	 * 
	 * @return String
	 */
	public function getBirth(){
        if ($this->data_nasc!="" && isset($this->data_nasc)){
            return $this->data_nasc;
        }
	}

    /*
	 * Returns the user contact
	 *
	 * @return String
	 */
    public function getContact(){
        if ($this->contato!="" && isset($this->contato)){
            return $this->contato;
        }
    }
	
	/*
	 * Returns the "freguesia"
	 * 
	 * @return int
	 */
	public function getFreguesia(){
		if ($this->freguesia_id!="" && isset($this->freguesia_id)){
			return $this->freguesia_id;
		}
	}

    /*
	 * Returns errors
	 *
	 * @return void
	 */
    public function returnErrors(){

        if ($this->allErrors!="" && isset($this->allErrors)){
            return $this->allErrors;
        }
    }
    
    //PRINT FUNCTIONS
    /*
	 * PRINTS the userId
	 * 
	 * @return void
	 */
	public function printId(){
		if ($this->testemunhoId!="" && isset($this->testemunhoId)){
			echo $this->testemunhoId;
		}
	}
	
	/*
	 * PRINTS the critic name
	 * 
	 * @return void
	 */
	public function printName(){
		if ($this->nome!="" && isset($this->nome)){
			echo stripslashes(utf8_decode($this->nome));
		}
	}

    /*
     * Prints the user age
     *
     * @return void
     */
    public function printAge(){
        $time = time(); // Store time for consistency

        if (isset($this->data_nasc) && !empty($this->data_nasc)) {
            list($birthYear, $birthMonth, $birthDay) = explode("-", $this->data_nasc);
            $day = 60 * 60 * 24;
            $year = $day * 365;
            $thisYear = date("Y", $time);
            $numYears = $thisYear - $birthYear;
            $leapYears = $numYears / 4 * $day; // Calculate for accuracy
            $ageTime = mktime(0, 0, 0, $birthMonth, $birthDay, $birthYear);
            $age = $time - $ageTime - $leapYears;
            echo floor($age / $year)." anos";
        }
    }

    /*
     * Prints the user birthday
     *
     * @param  $format OPTIONAL | ("DMY")->prints dd-mm-yyyy format
     * @return void
     */
    public function printBirth($format=""){
        if ($this->data_nasc!="" && isset($this->data_nasc)){
            if ($format=="DMY"){
                $timestamp = strtotime($this->data_nasc);
                $birthDate = date("d-m-Y",$timestamp);
                echo $birthDate;
            }else{
                echo $this->data_nasc;
            }
        }
    }

    /*
     * Prints the user image
     *
     * @param Optional int $size - 200px by default
     * @param Optional String $imgId - "" by default
     * @return void
     */
    public function printImage($size=200, $imgId=""){
        /*$imgFullPath = "user_images/".$this->username."/".$this->image;


        if(!file_exists($imgFullPath)){
            $imgFullPath = "user_images/user_default.png";
        }
        if($imgId != ""){
            $imgId = 'id="'.$imgId.'"';
        }

        $imageHtml='<img src="'.ABS_PATH.$imgFullPath.'" alt="Imagem de '.$this->name.'" width="'.$size.'px" '.$imgId.'/>';
        echo $imageHtml;*/
    }

    /*
	 * Prints the user contact
	 *
	 * @return void
	 */
    public function printContact(){
        if ($this->contato!="" && isset($this->contato)){
            echo $this->contato;
        }
    }

    /*
     * Send email on submition
     *
     * @return void
     */
    function newSubMail(){
        //date_default_timezone_set('Europe/Lisbon');

        $status = $this->status ? 'visível':'invisível';

        $date = date("d:m:Y H:i:s");
        $to="luisfbmelo91@gmail.com, rtqramos@gmail.com";
        //$to="luisfbmelo91@gmail.com";
        $subject="Novo testemunho";


        $fullMessage="Foi adicionado um novo testemunho de id <b>".$this->testemunhoId."</b> e nome <b>".html_entity_decode($this->nome, ENT_NOQUOTES, 'UTF-8')."</b> no dia <b>".$date."</b>, no estado <b>".$status."</b>, com o  contacto ".$this->contato." e o seguinte texto:<br/><br/><i>".html_entity_decode($this->testemunho, ENT_NOQUOTES, 'UTF-8')."</i><br/><a href=\"www.sismodoitenta.com/testemunhoSet.php?sda=".$this->testemunhoId."&ac=1\">Aceitar</a> <a href=\"www.sismodoitenta.com/testemunhoSet.php?sda=".$this->testemunhoId."\">Recusar</a>";
        $to=strip_tags($to);
        /*$email=strip_tags($email);*/
        $message = stripslashes($message);
        $message=strip_tags($message);
        $fullMessage.=$message;

        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=ISO-8859-1' . "\r\n";

        /*$headers .= 'To: Luis <luisfbmelo91@gmail.com>'. "\r\n";*/
        $headers .= 'From: Sismo d\'Oitenta <sismodoitenta@gmail.com>' . "\r\n";

        mail($to,$subject,$fullMessage,$headers);
    }
}
?>