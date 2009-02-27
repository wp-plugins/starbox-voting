<?php

/**
 * Show Starbox Star voting
 * 
 * @author jigen.he (2009-2-23)
 * 
 * @param $postid 
 */
function starbox_voting($postid){
        $style = get_starbox_style($postid) ;
        echo '<div id="starbox_' . $postid . '"><img src="'.STARBOX_URLPATH.'images/loading.gif'.'" alt="loading" /></div>'."\n";
        echo "<script language='Javascript' type='text/javascript'>\n";
        echo "new Starbox('starbox_" . $postid . "', " . get_post_star($postid) .  ", { ".$style." });";
        echo "document.observe('dom:loaded', 
                function() { 
                        $('starbox_".$postid."').observe('starbox:rated', 
                        function(event) {
                                vote(".$postid.",event.memo.rated);
                                starboxThankYou(event);
                        });
                });";
        echo "</script>\n";
}

/**
 * get starbox style 
 * 
 * @author jigen.he (2009-2-27)
 * 
 * @param $postid 
 */
function get_starbox_style($postid){

        list($button,$overlay,$class,$ghost) = explode_style();

        $style = "overlay:'".$overlay."',buttons:".$button.",className:'".$class."',ghosting:".$ghost.",";

        $style .= "indicator: '#{average} rating from #{total} votes',";

        $total = "total: ".get_vote_amount($postid);

        $style .= check_voted($postid) ? $style . "locked: true," . $total : $style . $total ;

        return $style ;

}

/**
 * return average rate
 * 
 * @author jigen.he (2009-2-23)
 * 
 * @param $postid 
 */
function get_post_star($postid){

        $rates = get_total_rate($postid);

        $count = get_vote_amount($postid);

        $rate = 0 ;

        if(count($rates) != 0)
                $rate = round($rates / $count,1);

        return $rate ;
}

/**
 * get Total rate
 * 
 * @author jigen.he (2009-2-27)
 * 
 * @param $postid 
 */
function get_total_rate($postid){

        global $wpdb,$starbox ;

        $allvote = $wpdb->get_results("SELECT * FROM " . $starbox->table . " where object_id = ".$postid);

        $rate = 0 ;

        foreach($allvote as $vote){
                $rates += $vote->vote;
        }
        return $rates ;
}

/**
 * return Amount of votes cast
 * 
 * @author jigen.he (2009-2-27)
 * 
 * @param $postid 
 */
function get_vote_amount($postid){
        global $wpdb,$starbox ;

        $allvote = $wpdb->get_results("SELECT * FROM " . $starbox->table . " where object_id = ".$postid);

        return count($allvote);

}

/**
 * check vistor has voted by ip
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

/**
 * build style
 * 
 * @author jigen.he (2009-2-27)
 */
function implode_style($button,$overlay,$class,$ghost){
        update_option("starbox_button", $button);
        update_option("starbox_overlay", $overlay);
        update_option("starbox_class", $class);
        update_option("starbox_ghost", $ghost);
}

/**
 * get style from database
 * 
 * @author jigen.he (2009-2-27)
 */
function explode_style(){
        $button = get_option("starbox_button");
        $overlay = get_option("starbox_overlay");
        $class = get_option("starbox_class");
		$ghost = get_option("starbox_ghost");

        return array($button, $overlay, $class,$ghost);
}

?>
