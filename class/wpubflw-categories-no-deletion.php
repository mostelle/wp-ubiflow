<?php
/* -------------------------------------------- 
    Pour bloquer la suppression d'une catégorie
    d'annonce
------------------------------------------------ */
 
class blockCategoriesDeletionPlugin {
    /**
    * @var blockCategoriesDeletionPlugin
    */
    static $instance;
    private $categoryIDs = array();

    public function __construct(array $categoryIDs) {
        $this->categoryIDs = $categoryIDs;
        if ($this->isCategoryDeleteRequest()) {
            add_filter('check_admin_referer', array($this, 'check_referrer'), 10, 2);
            add_filter('check_ajax_referer', array($this, 'check_referrer'), 10, 2);
        }
    }

    public static function bootstrap(array $categoryIDs) {
        if (null===self::$instance) {
            self::$instance = new self($categoryIDs);
        } else {
            throw new BadFunctionCallException(sprintf('Plugin %s already instantiated', __CLASS__));
        }
        return self::$instance;
    }
 
    private function isCategoryDeleteRequest() {
        $notAnCategoryDeleteRequest =
        empty($_REQUEST['taxonomy'])
        || empty($_REQUEST['action'])
        || $_REQUEST['taxonomy'] !== 'annonces'
        || !( $_REQUEST['action'] === 'delete' || $_REQUEST['action'] === 'delete-tag');
 
        $isCategoryDeleteRequest = !$notAnCategoryDeleteRequest;
 
        return $isCategoryDeleteRequest;
    }
 
    private function blockCategoryID($categoryID) {
        return in_array($categoryID, $this->categoryIDs);
    }

    public function check_referrer($action, $result) {
 
        if (!$this->isCategoryDeleteRequest()) {
            return;
        }
 
        $prefix = 'delete-tag_';
        if (strpos($action, $prefix) !== 0)
            return;
 
        $actionID = substr($action, strlen($prefix));
        $categoryID = max(0, (int) $actionID);
 
        if ($this->blockCategoryID($categoryID)) {
            wp_die(__('Cette catégorie ne peut être supprimée.'));
        }
    }
}
?>