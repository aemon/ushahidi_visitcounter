<?php defined('SYSPATH') or die('No direct script access.');
/**
 * VisitCount - Load All Events
 **/

class visit_counter {
    
    protected $table_prefix;

    public function __construct()
    {
//        mysql_query("SET NAMES utf8");
        Event::add('system.pre_controller', array($this, 'add'));
        
        $this->table_prefix = Kohana::config('database.default.table_prefix');
        $this->table_alias = Kohana::config('visit_counter.table_alias');
        $this->no_add_pages = Kohana::config('visit_counter.no_add_pages');
        $this->request = ($_SERVER['REQUEST_METHOD'] == 'POST')? $_POST : $_GET;
        
    }

    public function add()
    {
        Event::add( Kohana::config('visit_counter.display_counter'), array($this, 'display_counter')); 
        Event::add( Kohana::config('visit_counter.display_counter_in_list'), array($this, 'display_counter_in_list')); 
        Event::add( Kohana::config('visit_counter.order_by_view_counter'), array($this, 'order_by_view_counter')); 
        Event::add( Kohana::config('visit_counter.get_visits_counter'), array($this, 'get_visits_counter')); 
    }
    
    public function  display_counter(){      

        $element_id = Event::$data;
        $view = View::factory('visit_counter_show'); 
        $view->visit_count = 0;
        // check need add
        $refer = (!empty($_SERVER['HTTP_REFERER']))?$_SERVER['HTTP_REFERER']:'';
        if ((!empty($refer))&&in_array($refer,$this->no_add_pages,true)){
            $need_add = 0;
        }
        else $need_add = 1;
              
        if (!empty($element_id)){
            $db = Database::instance();
            $query = 'SELECT id_element, visits '
                    . 'FROM '.$this->table_prefix.'visits_count as v '
                    . 'WHERE v.id_element = '.$element_id;
            $query = $db->query($query);
            
            $visits_result = $query->result_array(FALSE);  
            if (!empty($visits_result)){
                $view->visit_count = $visits_result[0]['visits'];
                if ($need_add==1){
                    $view->visit_count++;
                    $query = 'UPDATE '.$this->table_prefix.'visits_count  SET visits='.$view->visit_count.
                    ' WHERE id_element = '.$element_id;
                    $query = $db->query($query);
                }
            }
            else{
                if ($need_add==1){
                    $view->visit_count = 1;
                    $query = 'INSERT INTO '.$this->table_prefix.'visits_count  SET visits='.$view->visit_count.
                    ', id_element = '.$element_id;
                    $query = $db->query($query);
  
                }
            }
             
            $view->render(TRUE);    
        }
    }   
    
    public function  display_counter_in_list(){      

        $element_id = Event::$data;
        $view = View::factory('visit_counter_show'); 
        $view->visit_count = 0;
              
        if (!empty($element_id)){
            $db = Database::instance();
            $query = 'SELECT id_element, visits '
                    . 'FROM '.$this->table_prefix.'visits_count as v '
                    . 'WHERE v.id_element = '.$element_id;
            $query = $db->query($query);
            
            $visits_result = $query->result_array(FALSE);  
            if (!empty($visits_result)){
                $view->visit_count = $visits_result[0]['visits'];
                } 
            $view->render(TRUE);    
        }
    }   
    
    public function  get_visits_counter(){      

        $element_id = Event::$data['element_id'];
        Event::$data['visit_count'] = 0;
              
        if (!empty($element_id)){
            $db = Database::instance();
            $query = 'SELECT id_element, visits '
                    . 'FROM '.$this->table_prefix.'visits_count as v '
                    . 'WHERE v.id_element = '.$element_id;
            $query = $db->query($query);
            
            $visits_result = $query->result_array(FALSE);  
            if (!empty($visits_result)){
                Event::$data['visit_count'] = $visits_result[0]['visits'];
                } 
   
        }
    }   
    
    function order_by_view_counter(){
        Event::$data['select'] = ', vc.visits as views_count ';
        Event::$data['join'] = ' LEFT JOIN visits_count as vc ON vc.id_element='.$this->table_alias.'.id ';
        Event::$data['order'] = ' views_count ';
        Event::$data['sort'] = ' DESC ';
               
    }
    
    
}
new visit_counter();
