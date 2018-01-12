<?php include "connection.php";
/*
 * Function prints the quote and the author
 * 
 * @return random position of array ["name"]["quote"]
 */
function quotesPrint(){
	$allQuotes = array("name"=>array("Pe. Helder Sousa","Dr. Francisco Maduro-Dias","Doutor João Carlos Nunes","Enf. Lúcia Oliveira","Enf. Lúcia Oliveira","Eng. Carlos Nunes","Pe. Helder Sousa"),
					   "quote"=>array("Há um pré-sismo e um pós-sismo porque tudo muda nesse minuto.","Não era suposto haver nada do outro mundo.","Nada foi igual após o sismo de 1 de Janeiro de 1980.","Dava a sensação que era o fim do mundo.","A nossa luta (...) era aliviar o sofrimento e dar apoio moral a todos.","Nada foi igual após o sismo de 1 de Janeiro de 1980.","Uma situação destas mexe com toda a vida."));
					   
	$randomVal = rand(0,sizeOf($allQuotes["quote"])-1);
	
	$returnArray[0] = $allQuotes["name"][$randomVal];
	$returnArray[1] = $allQuotes["quote"][$randomVal];
	
	return $returnArray;
}

/*
 * Function prints the lightbox contents
 * 
 * @return full body constructed
 */
function printPicBoxes($id){
    global $mysqli;

    $sql = "SELECT
                *
            FROM
                fotos
            WHERE
              id_fotos = ".$id;
    $query = $mysqli->query($sql);
    
    if ($query->num_rows>0){
        $count=0;
        $result= array();
        while ($dados = $query->fetch_assoc()) {

            //GET PROPORTIONS RIGHT
            list($width, $height, $type, $attr) = getimagesize("../../img/mapPics/".$dados['id_fotos']."/".$dados['foto_1']);
            $ratio = 1.5;

            if ($width>$height){
                $finalHeight = round(620/$ratio);
                $finalWidth = 620;
            }
            if ($height>$width){
                $finalHeight = round(413*$ratio);
                $finalWidth = 413;
            }
            /*END PROPORTIONS*/

            if ($dados['type']==1){
                $dataSend= '
                <div id="data_'.$dados['id_fotos'].'" class="compareContainer" style="display: inline-block;margin:10px 0;">
                    <div class="dataTitle" style="width:'.$finalWidth.'px;">
    				    '.$dados['titulo'].'
                    </div>
                    <div class="dataSource" style="width:'.$finalWidth.'px;">
                        Fonte: '.$dados['fonte'].'.
                    </div>
                    <div class="dataSource" style="margin-top:5px;margin-bottom:5px;width:'.$finalWidth.'px;">
                        Fotografia atual captada pela equipa do Sismo d\'Oitenta.
                    </div>
    				<div class="imagesToCompare">
    				    <div><img alt="before" src="img/mapPics/'.$dados['id_fotos'].'/'.$dados['foto_1'].'" width="'.$finalWidth.'" height="'.$finalHeight.'" /></div>
                         <div><img alt="after" src="img/mapPics/'.$dados['id_fotos'].'/'.$dados['foto_2'].'" width="'.$finalWidth.'" height="'.$finalHeight.'" /></div>
     			    </div>';
                    if ($dados['descricao']!="" && $dados['descricao']!=NULL){
                        $dataSend.='<div class="dataDesc">
                                        '.$dados['descricao'].'
                                    </div>';
                    }
                    
                    $dataSend.='
                    <div class="fb-like" data-href="http://sismodoitenta.com/momentos#'.$dados['id_fotos'].'" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
                    <div class="faceCom">
                        <div class="fb-comments" data-href="http://sismodoitenta.com/momentos#'.$dados['id_fotos'].'" data-numposts="5"></div>
                    </div>
                </div>
                ';
            }else{
                $dataSend= '<div id="data_'.$dados['id_fotos'].'" style="display: inline-block;margin:10px 0;">
                    <div class="dataTitle" style="width:'.$finalWidth.'px;">
                    '.$dados['titulo'].'
                    </div>
                    <div class="dataSource" style="width:'.$finalWidth.'px;margin-bottom:5px;">
                        '.$dados['fonte'].'.
                    </div>
    				<div>
    				    <img alt="before" src="img/mapPics/'.$dados['id_fotos'].'/'.$dados['foto_1'].'" style="max-width:620px;max-height:620px;"/>
    				</div>';
                    if ($dados['descricao']!="" && $dados['descricao']!=NULL){
                        $dataSend.='<div class="dataDesc">
                                        '.$dados['descricao'].'
                                    </div>';
                    }
                    
                    $dataSend.='
                    <div class="fb-like" data-href="http://sismodoitenta.com/momentos#'.$dados['id_fotos'].'" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
                    <div class="faceCom">
                        <div class="fb-comments" data-href="http://sismodoitenta.com/momentos#'.$dados['id_fotos'].'" data-numposts="5"></div>
                    </div>
                </div>';
            }
            return $dataSend;
        }
    }
}

/*
 * Function returns all "freguesias"
 *
 */
function returnFreguesia(){
    global $mysqli;
    $sql = "SELECT
                *
            FROM
                freguesias
            ORDER BY
                descricao ASC";

    $query = $mysqli->query($sql);

    if ($query->num_rows>0){
        $bodyPrint = '<select id="freguesias" name="freguesias">
                        <option value="0">Escolha uma freguesia da listagem</option>';
        while ($dados = $query->fetch_assoc()) {
            if ($dados["id_freguesia"]!=28){
                $bodyPrint.='<option value="'.$dados["id_freguesia"].'">'.utf8_encode($dados["descricao"]).'</option>';
            }
        }
        $bodyPrint .= '<option value="28">Outra</option>';
        $bodyPrint .= '</select>';
        return $bodyPrint;
    }
}

/*
 * Function gets all youtube videos and prints them
 *
 */
function getYoutubeVideos(){
    $controlTotal = false;
    $startIndex = 1;
    $maxResults = 50;
    $htmlBody = "";
    $totalResults = 0;
    $curItem = 0;

    //ASK VIDEOS
    $getData = file_get_contents("https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId=UCZ4ahHZTZzvZEEY87C8x4XA&key=AIzaSyAlMSgzWARfVJ81FEGHHqSsO5qjEUtnDLQ&maxResults=".$maxResults);
    //$getData = file_get_contents("http://gdata.youtube.com/feeds/api/users/GoGeocaching/uploads?v=2&alt=jsonc&start-index=".$startIndex."&max-results=".$maxResults);

    //CONVERT TO ARRAY
    $resultado=json_decode($getData,true);

    //TOTAL TIMES NEEDED REQUESTS
    $totalResults = count($resultado["items"]);

    //CREATE BEGINING OF HTML
    //$boxDiv = '<div class="prevList"><i class="fa fa-chevron-left fa-2x"></i></div>';

    //DISABLE NEXT BTN IF NO MORE THAN 5
    /*if ($totalResults<5){
        $boxDiv.='<div class="nextList" style="display:none;"><i class="fa fa-chevron-right fa-2x"></i></div>';
    }else{
        $boxDiv.='<div class="nextList"><i class="fa fa-chevron-right fa-2x"></i></div>';
    }*/

    $boxDiv.='<div class="videosBox">
        <div class="videosMask owl-carousel">';

    //DUE TO REQUEST LIMIT, REPEAT REQUEST UNTIL GET ALL
        foreach($resultado['items'] as $video){
            $curItem++;

            $htmlBody.='<span class="videoItem" id="'.$video["id"]["videoId"].'" title="'.htmlentities($video["snippet"]["title"],ENT_NOQUOTES,"UTF-8").'">';
                $htmlBody.='<div class="thumbImg"><img src="'.$video["snippet"]["thumbnails"]["high"]["url"].'" alt="'.htmlentities($video["snippet"]["title"],ENT_NOQUOTES,"UTF-8").'"/></div>';
                $htmlBody.='<div class="thumbTitle">'.htmlentities(truncate($video["snippet"]["title"],60),ENT_NOQUOTES,"UTF-8").'</div>';
            $htmlBody.='</span>';
        }
        //$startIndex += 50;
    


    $boxDiv.=$htmlBody.'</div></div>';

    //PRINT BODY
    echo $boxDiv;
}

/*
 * Function gets all testimonies
 *
 */

function getTestimonies($int="first"){
    global $mysqli;
    $bodyHtml = "";

    $sql = "SELECT
                *
            FROM
                testemunhos
            WHERE
                status=1 AND av=1 ";
    if ($int=="first"){
        $sql.=" ORDER BY
                    date DESC
                LIMIT
                    0,11 ";
    }else{
        $sql.="
                ORDER BY
                    date DESC
                LIMIT
                    ".$int.",12 ";
    }


    $query = $mysqli->query($sql);

    if ($query->num_rows>0){
        $count=2;
        while ($dados = $query->fetch_assoc()) {

            if ($dados["tipo"]==2 || $dados["tipo"]==3){
                //GET PROPORTIONS RIGHT
                list($width, $height, $type, $attr) = getimagesize('img/testthumbnails/'.$dados["id_testemunhos"].'/'.$dados["foto"]);
                $ratio = 1.5;

                if ($width>$height){
                    $finalHeight = 234;
                    $finalWidth = round(234*$ratio);
                }
                if ($height>$width){
                    $finalHeight = round(225*$ratio);
                    $finalWidth = 225;
                }
                /*END PROPORTIONS*/
            }

            switch($dados["tipo"]){
                //ONLY TEXT
                case 1:
                    $testemunhoTxt = truncate(html_entity_decode($dados["testemunho"], ENT_NOQUOTES, 'UTF-8'),160);
                    $testemunhoTxt = str_replace(array("&lt;br/&gt;"), array("<br/>"), $testemunhoTxt);

                    $nomeUser = mb_strtoupper(html_entity_decode($dados["nome"], ENT_NOQUOTES, 'UTF-8'), "UTF-8");
                    $sobreNome = mb_strtoupper(html_entity_decode($dados["sobrenome"], ENT_NOQUOTES, 'UTF-8'), "UTF-8");

                    /*if ($count%4==0){
                        $bodyHtml.='<div class="testemunhoBox" id="'.$dados["id_testemunhos"].'">';
                    }else{
                        $bodyHtml.='<div class="testemunhoBox rmar"  id="'.$dados["id_testemunhos"].'">';
                    }*/

                    $bodyHtml.='<div class="testemunhoBox rmar"  id="'.$dados["id_testemunhos"].'">';

                    $bodyHtml.='<div class="authorName">'.$nomeUser.' '.$sobreNome.'</div>';
                    $bodyHtml.='<div class="type1Text">'.$testemunhoTxt.'</div>';
                    $bodyHtml.='<div class="plus"><i class="fa fa-plus"></i></div>';
                    $bodyHtml.='</div>';
                    break;

                //ONLY PHOTO
                case 2:
                    $nomeUser = mb_strtoupper(html_entity_decode($dados["nome"], ENT_NOQUOTES, 'UTF-8'), "UTF-8");
                    $sobreNome = mb_strtoupper(html_entity_decode($dados["sobrenome"], ENT_NOQUOTES, 'UTF-8'), "UTF-8");
                    $foto = $dados["foto"];

                    /*if ($count%4==0){
                        $bodyHtml.='<div class="testemunhoBox" id="'.$dados["id_testemunhos"].'">';
                    }else{
                        $bodyHtml.='<div class="testemunhoBox rmar" id="'.$dados["id_testemunhos"].'">';
                    }*/

                    $bodyHtml.='<div class="testemunhoBox rmar" id="'.$dados["id_testemunhos"].'">';

                    $bodyHtml.='<div class="testPic"><img src="img/testthumbnails/'.$dados["id_testemunhos"].'/'.$foto.'" width="'.$finalWidth.'" height="'.$finalHeight.'"></div>';
                    $bodyHtml.='<div class="descBoxType2">';
                    $bodyHtml.='<div class="type2Text">Fotografia de :<br/><span>'.$nomeUser.' '.$sobreNome.'</span></div>';
                    $bodyHtml.='</div>';
                    $bodyHtml.='<div id="'.$dados["id_testemunhos"].'" class="plus"><i class="fa fa-plus"></i></div>';
                    $bodyHtml.='</div>';
                    break;

                //PHOTO + TEXT
                case 3:
                    $testemunhoTxt = truncate(html_entity_decode($dados["testemunho"], ENT_NOQUOTES, 'UTF-8'),160);
                    $testemunhoTxt = str_replace(array("&lt;br/&gt;"), array("<br/>"), $testemunhoTxt);

                    $nomeUser = mb_strtoupper(html_entity_decode($dados["nome"], ENT_NOQUOTES, 'UTF-8'), "UTF-8");
                    $sobreNome = mb_strtoupper(html_entity_decode($dados["sobrenome"], ENT_NOQUOTES, 'UTF-8'), "UTF-8");
                    $foto = $dados["foto"];

                    /*if ($count%4==0){
                        $bodyHtml.='<div class="testemunhoBox" id="'.$dados["id_testemunhos"].'">';
                    }else{
                        $bodyHtml.='<div class="testemunhoBox rmar" id="'.$dados["id_testemunhos"].'">';
                    }*/

                    $bodyHtml.='<div class="testemunhoBox rmar" id="'.$dados["id_testemunhos"].'">';

                    $bodyHtml.='<div class="testPic"><img src="img/testthumbnails/'.$dados["id_testemunhos"].'/'.$foto.'" width="'.$finalWidth.'" height="'.$finalHeight.'"></div>';
                    $bodyHtml.='<div class="descBox">';
                    $bodyHtml.='<div class="authorName">'.$nomeUser.' '.$sobreNome.'</div>';
                    $bodyHtml.='<div class="type3Text">'.$testemunhoTxt.'</div>';
                    $bodyHtml.='</div>';
                    $bodyHtml.='<div id="'.$dados["id_testemunhos"].'" class="plus"><i class="fa fa-plus"></i></div>';
                    $bodyHtml.='</div>';
                    break;
            }
            $count++;
        }

        return $bodyHtml;

    }else{
        return false;
    }
}

/*
* Function prints testimonial on lightbox
*
*/
function printTestimonial($id){
    global $mysqli;
    $bodyHtml = "";

    $sql='SELECT 
        testemunhos.*,freguesias.descricao as freguesiaNome 
    FROM 
        testemunhos inner join freguesias on freguesia_id = id_freguesia 
    WHERE
        id_testemunhos = '.$id;


    $query = $mysqli->query($sql);

    if ($query->num_rows>0){
        while ($dados = $query->fetch_assoc()) {

            switch($dados["tipo"]){
                //ONLY TEXT
                case 1:

                    $testemunhoTxt = $dados["testemunho"];
                    $testemunhoTxt = str_replace(array("&lt;br/&gt;"), array("<br/>"), $testemunhoTxt);

                    $bodyHtml='<div class="type1Box" id="details-box_'.$dados["id_testemunhos"].'">';
                        $bodyHtml.='<div class="miniTestAuthor">Testemunho de <br/><span>'.$dados["nome"].' '.$dados["sobrenome"].'</span></div>';

                        if ($dados["data_nasc"]!="" && isset($dados["data_nasc"]) && $dados["data_nasc"]!="0000-00-00"){
                            $age = printAge($dados["data_nasc"]);
                            $bodyHtml.='<div class="miniTestAge">'.$age.', '.$dados["freguesiaNome"].'</div>';    
                        }else{
                            $bodyHtml.='<div class="miniTestAge">'.$dados["freguesiaNome"].'</div>'; 
                        }

                        $bodyHtml.='<div class="miniTestDesc"><i class="fa fa-quote-left"></i> '.$testemunhoTxt.' <i class="fa fa-quote-right"></i> </div>';

                        $bodyHtml.='<div class="fb-like" data-href="http://sismodoitenta.com/emocoes#'.$dados["id_testemunhos"].'" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>';
                        $bodyHtml.='<div class="faceCom"><div class="fb-comments" data-href="http://sismodoitenta.com/emocoes#'.$dados["id_testemunhos"].'" data-numposts="5"></div></div>';
                    
                    $bodyHtml.='</div>';
                break;

                //ONLY PHOTO
                case 2:
                    $bodyHtml='<div class="type2Box" id="details-box_'.$dados["id_testemunhos"].'">';
                        $bodyHtml.='<div class="miniTestAuthor">Fotografia de <br/><span>'.$dados["nome"].' '.$dados["sobrenome"].'</span></div>';

                        if ($dados["data_nasc"]!="" && isset($dados["data_nasc"]) && $dados["data_nasc"]!="0000-00-00"){
                            $age = printAge($dados["data_nasc"]);
                            $bodyHtml.='<div class="miniTestAge">'.$age.', '.$dados["freguesiaNome"].'</div>';    
                        }else{
                            $bodyHtml.='<div class="miniTestAge">'.$dados["freguesiaNome"].'</div>'; 
                        }

                        $bodyHtml.='<div class="miniTestImg"><img src="img/testimg/'.$dados["id_testemunhos"].'/'.$dados["foto"].'" ></div>';
                        $bodyHtml.='<div class="miniTestFotoDesc">'.$dados["foto_desc"].'</div>';

                        $bodyHtml.='<div class="fb-like" data-href="http://sismodoitenta.com/emocoes#'.$dados["id_testemunhos"].'" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>';
                        $bodyHtml.='<div class="faceCom"><div class="fb-comments" data-href="http://sismodoitenta.com/emocoes#'.$dados["id_testemunhos"].'" data-numposts="5"></div></div>';
                    $bodyHtml.='</div>';
                break;

                //PHOTO + TEXT
                case 3:
                    $testemunhoTxt = $dados["testemunho"];
                    $testemunhoTxt = str_replace(array("&lt;br/&gt;"), array("<br/>"), $testemunhoTxt);

                    $bodyHtml='<div class="type2Box" id="details-box_'.$dados["id_testemunhos"].'">';
                        $bodyHtml.='<div class="miniTestAuthor">Testemunho e fotografia de <br/><span>'.$dados["nome"].' '.$dados["sobrenome"].'</span></div>';

                        if ($dados["data_nasc"]!="" && isset($dados["data_nasc"]) && $dados["data_nasc"]!="0000-00-00"){
                            $age = printAge($dados["data_nasc"]);
                            $bodyHtml.='<div class="miniTestAge">'.$age.', '.$dados["freguesiaNome"].'</div>';    
                        }else{
                            $bodyHtml.='<div class="miniTestAge">'.$dados["freguesiaNome"].'</div>'; 
                        }
                        
                        $bodyHtml.='<div class="miniTestImg"><img src="img/testimg/'.$dados["id_testemunhos"].'/'.$dados["foto"].'" ></div>';
                        $bodyHtml.='<div class="miniTestDesc"><i class="fa fa-quote-left"></i> '.$testemunhoTxt.' <i class="fa fa-quote-right"></i> </div>';

                        $bodyHtml.='<div class="fb-like" data-href="http://sismodoitenta.com/emocoes#'.$dados["id_testemunhos"].'" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>';
                        $bodyHtml.='<div class="faceCom"><div class="fb-comments" data-href="http://sismodoitenta.com/emocoes#'.$dados["id_testemunhos"].'" data-numposts="5"></div></div>';
                    $bodyHtml.='</div>';
                break;
            }
        }
       
        return $bodyHtml;
    }
}

/*
*Prints full age
*
*/
function printAge($age){
    $time = time(); // Store time for consistency

        if (isset($age) && !empty($age)) {
            list($birthYear, $birthMonth, $birthDay) = explode("-", $age);
            $day = 60 * 60 * 24;
            $year = $day * 365;
            $thisYear = date("Y", $time);
            $numYears = $thisYear - $birthYear;
            $leapYears = $numYears / 4 * $day; // Calculate for accuracy
            $ageTime = mktime(0, 0, 0, $birthMonth, $birthDay, $birthYear);
            $age = $time - $ageTime - $leapYears;
            return floor($age / $year)." anos";
        }
}

/**
 * Truncates text.
 *
 * Cuts a string to the length of $length and replaces the last characters
 * with the ending if the text is longer than length.
 *
 * @param string  $text String to truncate.
 * @param integer $length Length of returned string, including ellipsis.
 * @param string  $ending Ending to be appended to the trimmed string.
 * @param boolean $exact If false, $text will not be cut mid-word
 * @param boolean $considerHtml If true, HTML tags would be handled correctly
 * @return string Trimmed string.
 */
function truncate($text, $length = 78, $ending = ' ...', $exact = false, $considerHtml = false) {
    if ($considerHtml) {
        // if the plain text is shorter than the maximum length, return the whole text
        if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
            return $text;
        }

        // splits all html-tags to scanable lines
        preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);

        $total_length = strlen($ending);
        $open_tags = array();
        $truncate = '';

        foreach ($lines as $line_matchings) {
            // if there is any html-tag in this line, handle it and add it (uncounted) to the output
            if (!empty($line_matchings[1])) {
                // if it's an "empty element" with or without xhtml-conform closing slash (f.e. <br/>)
                if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
                    // do nothing
                    // if tag is a closing tag (f.e. </b>)
                } else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
                    // delete tag from $open_tags list
                    $pos = array_search($tag_matchings[1], $open_tags);
                    if ($pos !== false) {
                        unset($open_tags[$pos]);
                    }
                    // if tag is an opening tag (f.e. <b>)
                } else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
                    // add tag to the beginning of $open_tags list
                    array_unshift($open_tags, strtolower($tag_matchings[1]));
                }
                // add html-tag to $truncate'd text
                $truncate .= $line_matchings[1];
            }

            // calculate the length of the plain text part of the line; handle entities as one character
            $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
            if ($total_length+$content_length> $length) {
                // the number of characters which are left
                $left = $length - $total_length;
                $entities_length = 0;
                // search for html entities
                if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
                    // calculate the real length of all entities in the legal range
                    foreach ($entities[0] as $entity) {
                        if ($entity[1]+1-$entities_length <= $left) {
                            $left--;
                            $entities_length += strlen($entity[0]);
                        } else {
                            // no more characters left
                            break;
                        }
                    }
                }
                $truncate .= substr($line_matchings[2], 0, $left+$entities_length);
                // maximum lenght is reached, so get off the loop
                break;
            } else {
                $truncate .= $line_matchings[2];
                $total_length += $content_length;
            }

            // if the maximum length is reached, get off the loop
            if($total_length>= $length) {
                break;
            }
        }
    } else {
        if (strlen($text) <= $length) {
            return $text;
        } else {
            $truncate = substr($text, 0, $length - strlen($ending));
        }
    }

    // if the words shouldn't be cut in the middle...
    if (!$exact) {
        // ...search the last occurance of a space...
        $spacepos = strrpos($truncate, ' ');
        if (isset($spacepos)) {
            // ...and cut the text in this position
            $truncate = substr($truncate, 0, $spacepos);
        }
    }

    // add the defined ending to the text
    $truncate .= $ending;

    if($considerHtml) {
        // close all unclosed html-tags
        foreach ($open_tags as $tag) {
            $truncate .= '</' . $tag . '>';
        }
    }

    return $truncate;
}

/*
 * Prints selection for date
 * params @type
 */
function returnSelectionDate($type,$year="",$month=""){
    $selection = '';
    $curMonth = date("n");
    $curYear = date("Y");
    switch($type){
        //DAY
        case 1:
            //$selection .= '<select id="dia" name="dia">
            //            <option value="0">Selecione um dia</option>';
            $count=1;
            $goto=0;

            //se ano e mês selecionados forem iguais aos atuais
            if ($year==$curYear && $month==$curMonth){
                $goTo=date("j");

            //ano bisexto
            }else if ($year%4==0 && $month==2 ){
                $goTo=29;
            }else if ($month==2){
                $goTo=28;
            }else if ($month==1 || $month==3 || $month==5 || $month==7 || $month==8 || $month==10 || $month==12){
                $goTo=31;
            }else{
                $goTo=30;
            }

            while ($count <= $goTo) {
                $selection.='<option value="'.$count.'">'.$count.'</option>';
                $count++;
            }
            //$selection .= '</select>';
            return $selection;
            break;

        //MONTH
        case 2:
            //$selection .= '<select id="mes" name="mes">
            //            <option value="0">Selecione um mês</option>';

            $goTo=0;

            //se ano selecionado for igual ao atual
            if ($year!="" && $year==$curYear){
                $goTo=$curMonth;
            }else{
                $goTo=12;
            }
            $count=1;
            while($count<=$goTo){
                $selection.='<option value="'.$count.'">'.printMonth($count).'</option>';
                $count++;
            }
            //$selection .= '</select>';
            return $selection;
            break;

        //YEAR
        case 3:
            $selection .= '<select id="ano" name="ano">
                        <option value="0">Selecione o ano</option>';
            $count=1900;
            while ($count <= $curYear) {
                $selection.='<option value="'.$count.'">'.$count.'</option>';
                $count++;
            }
            $selection .= '</select>';
            return $selection;
            break;
    }
}

/*
 * Prints the months
 */
function printMonth($num){
    switch($num){
        case 1:
            return "Janeiro";
            break;
        case 2:
            return "Fevereiro";
            break;
        case 3:
            return "Março";
            break;
        case 4:
            return "Abril";
            break;
        case 5:
            return "Maio";
            break;
        case 6:
            return "Junho";
            break;
        case 7:
            return "Julho";
            break;
        case 8:
            return "Agosto";
            break;
        case 9:
            return "Setembro";
            break;
        case 10:
            return "Outubro";
            break;
        case 11:
            return "Novembro";
            break;
        case 12:
            return "Dezembro";
            break;

    }
}

/*
 * Checks the month day
 *
 *
 */
function checkDateBirth($month,$day,$year){
    switch($month){
        case '2':
            //ver se o ano é bisexto
            if($year %4 == 0){
                //bisexto
                if($day >29){
                    echo 'Esse mes não tem '.$day.' dias';
                }
            }else{
                if($day >28){
                    echo 'Esse mes não tem '.$day.' dias';
                }
            }

            break;
        case '4':
        case '6':
        case '9':
        case '11':
            if($day >30){
                echo 'Esse mes não tem '.$day.' dias';
            }
            break;
        default:
            break;
    }
}

/*
 * Returns testemunho form
 *
 */
function returnTestForm(){
    $bodyHtml = '
            <form id="testemunhos" action="#">
                <label>Nome</label>
                <input type="text" name="name" id="name" placeholder="ex: João"/>
                <label>Apelido</label>
                <input type="text" name="surname" id="surname" placeholder="ex: Silva"/>

                <label>Contacto</label>
                <input type="text" name="contact" id="contact" placeholder="ex:email@email.com ou 900111222"/>

                <label>Data de nascimento</label>'.returnSelectionDate("3").'
                <select id="mes" name="mes" disabled>
                    <option value="0">Selecione o mês</option>
                </select>
                <select id="dia" name="dia" disabled>
                    <option value="0">Selecione o dia</option>
                </select><br/>
                <div class="clearAll"></div>
                <label>Freguesia</label>'.
                returnFreguesia().'
                <label>Testemunho</label>
                <textarea name="testemunhoTXT" id="testemunhoTXT" cols="50" rows="10" placeholder="Escreva o seu testemunho..."></textarea>
                <div id="characters" style="margin-bottom:15px;margin-top:2px;">Caracteres disponíveis: <span>4500</span></div>

                <!--<input type="file" name="newImg[]"/><br/>-->
                <!--<input type="checkbox" id="status" name="status" value="status" checked="checked"><span id="statusText">Colocar visível para o público <i class="fa fa-question-circle">
                    <div class="arrow"></div>
                    <div class="invisHelp">Ao escolher esta opção, o seu testemunho estará disponível para o público, bem como para os administradores do projeto.</div>
                </i></span><br>-->

                <input type="submit" name="submeter" id="submeter" value="Submeter"/>
                <div id="agreed">Ao clicar no botão "Submeter", está a concordar com os <a href="termos_condicoes.php" target="_blank">Termos e Condições.</a></div>
                </form>
                <script type="text/javascript" src="scripts/validate.js"></script>';
    return $bodyHtml;
}

/*
 * Changes Testemunho AV
 *
 */
function changeStatus($id,$data){
    global $mysqli;

    //INSERT DATA
    $stmt = $mysqli->prepare("UPDATE testemunhos SET
               av = ?
               WHERE id_testemunhos = ?");
    $stmt->bind_param('ii',
        $data,
        $id);
    $stmt->execute();
    $stmt->close();
}
?>