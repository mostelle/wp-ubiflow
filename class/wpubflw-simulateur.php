<?php defined( 'ABSPATH' ) OR exit; //disallow direct file access when core isn't loaded

class Simulateur
{

    protected $_apport;
    protected $_duree;
    protected $_montant;
    protected $_taux_assurance;
    protected $_taux_credit;
    protected $_emprunt;
    
    /**
     * Constructeur : nécessite un tableau de valeur 
     * 
     * @param array( apport, duree, montant, taux_assurance, taux_credit)
     * 
     */
    public function __construct( array $data ){
        $this->setApport( intval( $data['apport'] ) );
        $this->setDuree( intval( $data['duree'] ) );
        $this->setMontant( intval( $data['montant'] ) );
        $this->setTauxAssurance( $data['taux_assurance'] );
        $this->setTauxCredit( $data['taux_credit'] );
        $this->setEmprunt( $this->getMontant() - $this->getApport() );
    }

    public function setApport($apport)
    {
        $this->_apport = $apport;
    }
    public function getApport()
    {
        return $this->_apport;
    }

    public function setDuree($duree)
    {
        $this->_duree = $duree;
    }
    public function getDuree()
    {
        return $this->_duree;
    }

    public function setMontant($montant)
    {
        $this->_montant = $montant;
    }
    public function getMontant()
    {
        return $this->_montant;
    }

    public function setTauxAssurance($taux_assurance)
    {
        $this->_taux_assurance = $taux_assurance;
    }
    public function getTauxAssurance()
    {
        return $this->_taux_assurance;
    }

    public function setTauxCredit($taux_credit)
    {
        $this->_taux_credit = $taux_credit;
    }
    public function getTauxCredit()
    {   
        return $this->_taux_credit;
    }

    public function setEmprunt($emprunt)
    {
        $this->_emprunt = $emprunt;
    }
    public function getEmprunt()
    {
        return $this->_emprunt;
    }

    /**
     *  
     *  Clean Float Value
     * 
     *  @return float
     *  
     **/
    public function tofloat( $num ) {
        $dotPos = strrpos($num, '.');
        $commaPos = strrpos($num, ',');
        $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos : 
            ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);
       
        if (!$sep) {
            return floatval(preg_replace("/[^0-9]/", "", $num));
        } 

        return floatval(
            preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
            preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
        );
    }

    /**
     *  
     *  Calcul des mensualités de crédit
     *  
     *  @return float 
     *  
     **/
    public function calcul_mens_credit(){

        $montant    = 0;
        $denom      = 0;
        $numer      = 0;
        $emprunt    = $this->getEmprunt();
        $taux       = $this->getTauxCredit();
        $duree      = $this->getDuree();

        $taux       = $taux/100;
        $numer      = $emprunt * $taux/12; 
        $denom      = 1- 1/(pow((1+$taux/12),$duree*12));

        if( $numer!=0 && $denom!=0 && $taux!=0 ){
            $montant = $numer/$denom;
            return $montant;
        }else{
            return false;
        }
    }

    /**
     *  
     *  Retourne le calcul credit formaté
     *  
     *  @return string/float
     *  
     **/
    public function calcul_mens_credit_format(){

        $montant    = $this->calcul_mens_credit();
        if ($montant != false){
            $montant = number_format($montant, 2, ',', '&nbsp;');
            return $montant;
        }else{
            return false;
        }
        
    }

    /**
     *  
     *  Calcul des mensualités d'assurance
     * 
     *  @return float 
     *  
     **/
    public function calcul_mens_assurance(){

        $montant    = 0;
        $emprunt    = $this->getEmprunt();
        $assurance  = $this->getTauxAssurance();

        if ($emprunt != 0){
            $montant = $emprunt*$assurance /12 /100;
            return $montant;
        }else{
            return false;
        }
    }

    /**
     *  
     *  Retourne le calcul assurance formaté
     *  
     *  @return string/float
     *  
     **/
    public function calcul_mens_assurance_format(){

        $montant    = $this->calcul_mens_assurance();
        
        if ($montant != false){
            $montant = number_format($montant, 2, ',', '&nbsp;');
            return $montant;
        }else{
            return false;
        }
    }

    /**
     *  
     *  Calcul des mensualités totales
     *  
     *  @return float 
     *  
     **/
    public function calcul_mens_globale(){
        
        $montant    = 0;
        $credit     = $this->calcul_mens_credit();
        $assurance  = $this->calcul_mens_assurance();
        
        if ($credit != false && $assurance != false){
            $montant    = $credit+$assurance;
            $montant    = number_format($montant, 2, ',', '&nbsp;');
            return $montant;
        }else{
            return false;
        }
    }

}
?>