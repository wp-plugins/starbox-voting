<?php

/**
 * Option Page Code
 * 
 * @author jigen.he (2009-2-23)
 */
function option_admin(){
        if($_POST['starbox_submit']){

          update_option("starbox_image",$_POST['starstyle'].".png");

          $message = '<div class="updated fade" id="message" style="background-color: rgb(255, 251, 204); margin-top: 40px;"><p>Starbox Setting Updated.</p></div>';
        }
        $starboxstyle = get_option('starbox_image') == "default.png" ? true : false;
  ?>
        <div class="wrap">
        <h2 id="write-post"><?php _e("Starbox Setting&hellip;",'starbox');?></h2>
        <div style="float:right;">
          <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
          <input type="hidden" name="cmd" value="_donations">
          <input type="hidden" name="business" value="again.0120@gmail.com">
          <input type="hidden" name="item_name" value="Donate to Starbox">
          <input type="hidden" name="no_shipping" value="0">
          <input type="hidden" name="no_note" value="1">
          <input type="hidden" name="currency_code" value="USD">
          <input type="hidden" name="tax" value="0">
          <input type="hidden" name="lc" value="US">
          <input type="hidden" name="bn" value="PP-DonationsBF">
          <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
          <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1"><br />
          </form>
        </div>
          <?php if($message)
                echo $message ;
              ?>
        <form method="post" action="">
          <h4>Style Setting</h4>
        <ul>    
          <li style="padding-top:10px;" class='star last'>
            <div id='demo_9'><input type="radio" <?php if(!$starboxstyle) echo "checked" ; ?> name="starstyle" value="big" /><img src='<?php echo STARBOX_URLPATH . "images/5big.jpg"?>' /></div>
          </li>
          <li style="padding-top:10px;" class='star last'>
            <div id='demo_9'><input type="radio" <?php if($starboxstyle) echo "checked" ; ?> name="starstyle" value="default" /><img src='<?php echo STARBOX_URLPATH . "images/5small.jpg"?>' /></div>
          </li>

        </ul>
        <p class="submit"><input type="submit" value="<?php _e("Update Setting &raquo;",'starbox');?>" name="starbox_submit" /></p>
        </form>
      </div>
      <?
}

?>
