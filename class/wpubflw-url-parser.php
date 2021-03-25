<?php

defined( 'ABSPATH' ) OR exit; //disallow direct file access when core isn't loaded

require WPUBIPATH.'views/datafields_immo.php';

class WPublfwParser
{

    protected   $_url;

    /**
     * Constructeur : nécessite une url
     *
     * @param string url valide
     *
     */
    public function __construct( $url ){
        $this->setURL( $url );
        setlocale(LC_MONETARY, 'fr_FR');
    }

    /**
     *
     *  Setter & Getter
     *
     **/
    protected function setURL($url)
    {
        $this->_url = $url;
    }

    protected function getURL()
    {
        return $this->_url;
    }

    /**
     *
     *  Tester si string est une url
     *
     *  @param string
     *  @return bool
     *
     **/
    public static function is_url( $url ){
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     *
     *  Recherche récursive dans un tableau où needle est la clef à trouver dans le tableau
     *  Optimal Pour PHP 7
     *  cette fonction ne peut pas être appelé ici en self
     *  elle ne fonctionne que lorsqu'on instancie déjà la classe
     *
     *  @return string / false
     *
     **/
    public static function recursive_find( array $array, $needle ) {
        $iterator  = new RecursiveArrayIterator($array);
        $recursive = new RecursiveIteratorIterator(
                            $iterator,
                            RecursiveIteratorIterator::SELF_FIRST
                        );
        foreach ($recursive as $key => $value) {
            if ($key == $needle) {
                return $value;
            }
        }
    }

    /**
     *
     *  Retourne la valeur d'un noeud s'il existe
     *
     *  @return string / array / empty
     *
     **/
    public static function to_string_node_value ($node){
        if ( !empty( $node ) ){ $value = end( $node )->__toString(); }else{ $value = ''; }
        return $value;
    }

    /**
     *
     *  Enlève la fin du texte à partir de DPE et nettoie la description (beurk! tout pas beau!)
     *
     *  @return string / array / empty
     *
     **/
    public static function clean_description ($texte){
        $texte = trim($texte);
        if ( !empty( $texte ) ){

            $dpe_pos = stripos( $texte, 'dpe ' );

            // on coupe à partir du dpe
            if ( $dpe_pos ){
                $texte = substr( $texte, 0, $dpe_pos );
            }

            // on coupe à partir du prix de l'anonnce
            $new_texte = preg_split( "#[A-z]*[0-9]{2,9} euros Honoraires#", $texte );
            $texte     = $new_texte[0];

            // double espace
            $pattn = array('/\s\s+/');
            $texte = preg_replace( $pattn,' ', $texte);

            // virgule collée
            $pattn = array('/,[a-zA-Z]/');
            $texte = preg_replace( $pattn,', ', $texte);

            // tout ce qui est point
            $pattn = array( '/,\s\./', '/\s\.\s\./' , '/\.\s\./', '/\.\./' , '/\?\./' , '/\!\./' );
            $texte = preg_replace( $pattn,'.', $texte);

            // les m2 décolés
            $pattn = array('/\sm&sup2;/', '/\sm2/', '/m2/');
            $texte = preg_replace( $pattn, 'm&sup2;', $texte);

        }
        return $texte;
    }

    /**
     *
     *  Clean les titres en collant les m2 par exmeple
     *
     *  @return string / array / empty
     *
     **/
    public static function clean_titre ($titre){
        $titre = trim($titre);
        if ( !empty( $titre ) ){

            // les m2 décolés
            $pattn = array('/\sm&sup2;/', '/\sm2/', '/m2/');
            $titre = preg_replace( $pattn, 'm&sup2;', $titre);

        }
        return $titre;
    }

    /**
     *
     *  Teste si la chaîne de caractère est une URL et récupére le contenu de l'url
     *
     *  @return string / false
     *
     **/
    private function getUrlContent(){

        $url = $this->getURL();

        if( self::is_url($url) === false ){ return false; }

        $ch         = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);

        $data       = curl_exec($ch);
        $httpcode   = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return ($httpcode>=200 && $httpcode<300) ? $data : false;
    }

    /**
     *
     *  récupére le flux XML
     *
     *  @return string / false
     *
     **/
    private function flux_XML(){

        $flux_xml = $this->getUrlContent();

        if( $flux_xml != false ){

            return $flux_xml;

        }else{
            return false;
        }
    }

    /**
     *
     *  retourne le flux XML sous forme de tableau
     *
     *  @return array / false
     *
     **/
    public function flux_XML_to_arr(){

        $flux_xml = $this->flux_XML();

        if( $flux_xml ){

            require_once __DIR__.'/../asset/php/xml_parser.php';
            $parser     = new \Xmtk\Parser;
            $xml_arr    = $parser->xmlParseIntoArray($flux_xml);

            return $xml_arr;

        }else{
            return false;
        }
    }

    /**
     *
     *  retourne le flux XML sous form de ficher XML
     *
     *  @return XML / false
     *
     **/
    public function get_flux_XML(){

        $flux_xml = $this->flux_XML();

        if( $flux_xml ){

            $xml = new SimpleXMLElement($flux_xml);
            //$xml_path = $xml->xpath('//annonce');
            return $xml;

        }else{
            return false;
        }
    }

    /**
     *
     *  retourne les annonces du flux XML sous forme de ficher XML
     *
     *  @return XML / false
     *
     **/
    public function annonces_flux_XML(){

        $flux_xml = $this->flux_XML();

        if( $flux_xml ){

            $xml = new SimpleXMLElement($flux_xml);
            $xml_path = $xml->xpath('//annonce');
            return $xml_path;

        }else{
            return false;
        }
    }

     /**
     *
     *  retourne une chaîne de caractère avec la première lettre en majuscule même si c'est un accent
     *
     *  @param string $s
     *
     *  @return string
     *
     **/
    public static function mb_ucfirst( $s ){
        mb_internal_encoding( "UTF-8" );
        return mb_strtoupper(mb_substr( $s, 0, 1 )).mb_substr( $s, 1 );
    }


    /**
     *
     *  retourne la liste li des description
     *
     *  @param int $id - id du noeud parent
     *  @param xml $annonce - l'annonce
     *  @param string $class - classes
     *  @param string $sep - séparateur
     *
     *  @return string
     *
     **/
    public function template_li_details( $id, $annonce, $class='', $sep='' ){

        global $description_WPublfwParser;

        $details_bien = end($annonce->xpath("//*[@id='$id']//bien"));
        foreach ($details_bien as $key => $value) {

            if( array_key_exists( $key, $description_WPublfwParser ) ){
                // la dernière valeur du tableau est forcément la bonne on peut mettre [0] aussi
                $value = end($value);

                if(  $value == 'true' ){
                    $value = 'Oui';
                }elseif( $value == 'false'){
                    $value = '';
                }

                if( !empty($value) ) :

                    $field = $description_WPublfwParser[$key]; //nom du champ

                    // ajout unité de mesure au champ si nécessaire et autre
                    if( is_array($field) ){

                        $field_name = $field["name"];
                        $unit       = $field["unit"];

                        switch ($unit) {
                            case 'PRICE': // c'est un prix
                                $value = number_format( $value, 2, ',', ' ' ).'&nbsp;€';
                                break;

                            case false: // ne pas afficher
                                $value = false;
                                break;

                            default: // valeur avec unité de mesure
                                $value = number_format( $value, 0, ' ', ' ' ). $field["unit"];
                                break;
                        }

                    }else{
                        $field_name=$field;
                    }

                    if( $value !== false ) {
                    ?>
                    <li class="<?php echo $class .' field_'. $key ;?>">
                        <?php
                        echo '<mark>'.self::mb_ucfirst($field_name) .'</mark>'.
                        $sep .
                        self::mb_ucfirst($value); ?>
                    </li>
                    <?php
                    }
                endif;
            }
        }

    }

    /**
     *
     *  test elégibilité DPE
     *
     *  @param int $id - id du noeud parent
     *  @param xml $annonce - l'annonce
     *
     *  @return bool
     *
     **/
    public function is_dpe_ok( $id, $annonce ){

        if( !empty($annonce->xpath("//*[@id='$id']//soumis_dpe")) ){

            $dpe = end($annonce->xpath("//*[@id='$id']//soumis_dpe"))->__toString();

            $dpe == 'true' ? $dpe : $dpe = false;

            if($dpe===false){
                return false;
            }else{
                return true;
            }

        }else{
            return false;
        }
    }

    /**
     *
     *  retourne les diagnostiques
     *
     *  @param int $id - id du noeud parent
     *  @param xml $annonce - l'annonce
     *  @param string $class - classes
     *  @param string $sep - séparateur
     *
     *  @return string
     *
     **/
    public function template_diagnostique( $id, $annonce, $class='', $sep='' ){

        global $diagnostic_WPublfwParser;

        foreach ( $diagnostic_WPublfwParser as $description => $value) {

            if(
                !empty( $descr_str = $annonce->xpath("//*[@id='$id']//".$description) ) && $description != 'soumis_dpe'
            ){
                $descr_str = end($descr_str);

                // ajout unité de mesure pour DPE et GES
                if( is_array( $value ) ){
                    $descr_str  = $descr_str .'&nbsp;'.$value["unit"];
                    $value      = $value["name"];
                }

                // ajout de la classe
                $class_add = sanitize_text_field($description);

                //chercher si dpe ou ges
                $seek_to_dpe_ges = strtolower($value);

                $dpe_etiquette_conso =  $annonce->xpath("//*[@id='$id']//dpe_etiquette_conso");
                $dpe_etiquette_ges   =  $annonce->xpath("//*[@id='$id']//dpe_etiquette_ges");

                if ($seek_to_dpe_ges=='dpe'|| $seek_to_dpe_ges=='ges'){

                    if( $seek_to_dpe_ges=='dpe'){
                    ?>
                        <li class="grille_dpe">
                            <ul>
                                <li class="dpe_tableau" >
                                    <div class="dpe_fleche_1 dpe_consommation_A">
                                        <span class="info">&lt;51</span>
                                        <span class="lettre"> A</span>
                                    </div>
                                    <div class="dpe_fleche_2 dpe_consommation_B">
                                        <span class="info">51 à 90</span>
                                        <span class="lettre"> B</span>
                                    </div>
                                    <div class="dpe_fleche_3 dpe_consommation_C">
                                        <span class="info">91 à 150</span>
                                        <span class="lettre"> C</span>
                                    </div>
                                    <div class="dpe_fleche_4 dpe_consommation_D">
                                        <span class="info">151 à 230</span>
                                        <span class="lettre"> D</span>
                                    </div>
                                    <div class="dpe_fleche_5 dpe_consommation_E">
                                        <span class="info">231 à 330</span>
                                        <span class="lettre"> E</span>
                                    </div>
                                    <div class="dpe_fleche_6 dpe_consommation_F">
                                        <span class="info">331 à 450</span>
                                        <span class="lettre"> F</span>
                                    </div>
                                    <div class="dpe_fleche_7 dpe_consommation_G">
                                        <span class="info">&gt;450</span>
                                        <span class="lettre"> G</span>
                                    </div>
                                </li>

                                <li class="dpe_logement <?php echo $class .' field_'.$class_add ;?>">
                                    <input class="dpe_etiquette_conso" type="hidden" value="<?php echo end($dpe_etiquette_conso); ?>">
                                <?php
                                    echo '<mark>' . $value . '</mark>' .
                                         $sep .
                                         '<span class="value_' . $class_add .'">'.
                                         $descr_str .
                                         '</span>';
                                ?>
                                </li>
                            </ul>
                        </li>
                    <?php
                    }

                    if( $seek_to_dpe_ges=='ges'){
                    ?>
                        <li class="grille_ges">
                            <ul>
                                <li class="ges_tableau" >
                                    <div class="ges_fleche_1 ges_consommation_A">
                                        <span class="info">&lt;6</span>
                                        <span class="lettre"> A</span>
                                    </div>
                                    <div class="ges_fleche_2 ges_consommation_B">
                                        <span class="info">6 à 10</span>
                                        <span class="lettre"> B</span>
                                    </div>
                                    <div class="ges_fleche_3 ges_consommation_C">
                                        <span class="info">11 à 20</span>
                                        <span class="lettre"> C</span>
                                    </div>
                                    <div class="ges_fleche_4 ges_consommation_D">
                                        <span class="info">21 à 35</span>
                                        <span class="lettre"> D</span>
                                    </div>
                                    <div class="ges_fleche_5 ges_consommation_E">
                                        <span class="info">36 à 55</span>
                                        <span class="lettre"> E</span>
                                    </div>
                                    <div class="ges_fleche_6 ges_consommation_F">
                                        <span class="info">56 à 80</span>
                                        <span class="lettre"> F</span>
                                    </div>
                                    <div class="ges_fleche_7 ges_consommation_G">
                                        <span class="info">&gt;80</span>
                                        <span class="lettre"> G</span>
                                    </div>
                                </li>

                                <li class="ges_logement <?php echo $class .' field_'.$class_add ;?>">
                                    <input class="dpe_etiquette_ges" type="hidden" value="<?php echo end($dpe_etiquette_ges); ?>">
                                <?php
                                    echo '<mark>' . $value . '</mark>' .
                                         $sep .
                                         '<span class="value_' . $class_add .'">'.
                                         $descr_str .
                                         '</span>';
                                ?>
                                </li>
                            </ul>
                        </li>
                    <?php
                    }

                }
            }
        }
    }

}
?>