<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * MY_Loader
 *
 * @author Simon Emms <simon@simonemms.com>
 */
class MY_Loader extends CI_Loader {


    public function __construct() {
        parent::__construct();

        $this->_ci_view_paths = array(TEMPLATE_PATH => TRUE);


    }
    /**
     * Database Loader
     *
     * @access    public
     * @param    string    the DB credentials
     * @param    bool    whether to return the DB object
     * @param    bool    whether to enable active record (this allows us to override the config setting)
     * @return    object
     */
    function database($params = '', $return = FALSE, $query_builder = NULL)
    {
        // Grab the super object
        $CI =& get_instance();

        // Do we even need to load the database class?
        if (class_exists('CI_DB') AND $return == FALSE AND $query_builder == NULL AND isset($CI->db) AND is_object($CI->db)) {
            return FALSE;
        }

        require_once(BASEPATH.'database/DB'.EXT);

        // Load the DB class
        $db =& DB($params, $query_builder);

        $my_driver = config_item('subclass_prefix').'DB_'.$db->dbdriver.'_driver';
        $my_driver_file = APPPATH.'core/'.$my_driver.EXT;

        if (file_exists($my_driver_file)) {
            require_once($my_driver_file);
            $db = new $my_driver(get_object_vars($db));
        }

        if ($return === TRUE) {
            return $db;
        }

        // Initialize the db variable.  Needed to prevent
        // reference errors with some configurations
        $CI->db = '';
        $CI->db = $db;
    }
}
?>