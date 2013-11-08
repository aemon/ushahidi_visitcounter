<?php defined('SYSPATH') OR die('No direct access allowed.');
    // table alias in filter
    $config['table_alias'] = 'i';
    //action display visits counts and add visit
    $config['display_counter']  = 'ushahidi_action.display_counter';
    //action display visits counts in list
    $config['display_counter_in_list']  = 'ushahidi_action.display_counter_in_list';    //action get visits counts
    $config['get_visits_counter']  = 'ushahidi_action.get_visits_counter';
    $config['order_by_view_counter']  = 'ushahidi_action.order_by_view_counter';
    // list pages come from that do not need  add visit count
    $config['no_add_pages'] = array("http://46.182.27.147/","http://46.182.27.147/main");
   
?>