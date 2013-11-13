<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Performs install/uninstall methods for the VisitCount Plugin
 *

 */
class Visitcount_Install {
	
	/**
	 * Constructor to load the shared database library
	 */
	public function __construct()
	{
		$this->db = new Database();
        $this->character_set = Kohana::config('database.character_set');
        if (!empty($this->character_set)){
            $this->character = ' DEFAULT CHARSET '.$this->character_set.' ';
        }
        else
            $this->character = '';
	}

	/**
	 * Creates the required tables
	 */
    public function run_install()
    {
        // create database tables
        $this->db->query("CREATE TABLE IF NOT EXISTS `".Kohana::config('database.default.table_prefix')."visits_count` (
        `id_element` int(11) NOT NULL,
        `visits` int(11) NOT NULL
        ) ENGINE=InnoDB ".$this->character);
        // ****************************************		
       
    }

	/**
	 * Drops the table
	 */
	public function uninstall()
	{
        $this->db->query("DROP TABLE `".Kohana::config('database.default.table_prefix')."visits_count`;");
	}
}
