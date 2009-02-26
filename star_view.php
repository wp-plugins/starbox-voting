<?php

/**
 * Show Starbox Star voting
 * 
 * @author jigen.he (2009-2-23)
 * 
 * @param $postid 
 */
function starbox_voting($postid){
        echo '<div id="starbox_' . $postid . '"></div>'."\n";
        echo "<script>\n";
        $style = get_option('starbox_image') ;
        if(check_voted($postid)){
                        if(empty($style))
                                $style .= "locked: true";
                        else
                                $style .= ",locked: true";
        }
        echo "new Starbox('starbox_" . $postid . "', " . get_post_star($postid).(empty($style) ? "" : ",{ ".$style." }") . ");";
        echo "document.observe('dom:loaded', function() { $('starbox_".$postid."').observe('starbox:rated', function(event) {vote(".$postid.",event.memo.rated,'" . get_option('starbox_image') . "');});});";
        echo "</script>\n";
}

/**
 * get post voting rate
 * 
 * @author jigen.he (2009-2-23)
 * 
 * @param $postid 
 */
function get_post_star($postid){
        global $wpdb,$starbox ;

        $allvote = $wpdb->get_results("SELECT * FROM " . $starbox->table . " where object_id = ".$postid);

        $rate = 0 ;

        foreach($allvote as $vote){
                $rates += $vote->vote;
        }
        if(count($rates) != 0)
                $rate = round($rates / count($allvote));
        return $rate ;
}

/**
 * check post voted by ip
 * 
 * @author jigen.he (2009-2-23)
 */
function check_voted($postid){
        global $wpdb,$starbox ;

        $ip = $_SERVER['REMOTE_ADDR'] ;
        
        $rows = $wpdb->get_results("SELECT * FROM " . $starbox->table . " where object_id = ".$postid." and ip='".$ip."'");
        
        
        if($rows)
                return true ;
        else
                return false;

}

?>
