<?php



/**
 * Option Page Code
 * 
 * @author jigen.he (2009-2-23)
 */
function starbox_option_admin(){

        global $starbox;

        require_once(dirname(__FILE__) . "/star_view.php") ;

        if($_POST['starbox_submit']){

          implode_starbox_style($_POST['button'], $_POST['overlay'], $_POST['classname'], $_POST['ghost']) ;

          $message = 1;
        }
        list($button,$overlay,$class,$ghost) = explode_starbox_style();
  ?>
        <div class="wrap">
        <h2 id="write-post"><?php _e("Starbox Style Setting&hellip;",'starbox');?></h2>
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
          <?php if($message){ ?>
                <div class="updated fade" id="message" style="background-color: rgb(255, 251, 204); width:50%;"><p><?php _e("Starbox Setting Updated.",'starbox') ?></p></div>             <? } ?>
        <form method="post" action="">
            <h3 style="float:left"><?php _e('Example Style Setting','starbox') ?></h3>
        <ul class="starbox_style">    
          <li class='star last'>
                <div id='demo_0' style="float:left"><img src="<?php echo STARBOX_URLPATH.'/images/loading.gif';?>"></div></span>
                <script>new Starbox('demo_0', 2);</script>
                <div class="starbox_note"> <?php _e("overlay='default', buttons=5, className='default'",'starbox') ?></div>
          </li>
          <li class='star last'>
                 <div id='demo_1' style="float:left"><img src="<?php echo STARBOX_URLPATH.'/images/loading.gif';?>"></div></span>
                 <script>new Starbox('demo_1', 2, { className: 'dotted' });</script>
            <div class="starbox_note"> <?php _e("overlay='default', buttons=5, className='dotted'",'starbox') ?></div>
          </li>
          <li class='star last'>
                <div id='demo_2' style="float:left"><img src="<?php echo STARBOX_URLPATH.'/images/loading.gif';?>"></div></span>
                <script language='javascript' type='text/javascript'>new Starbox('demo_2', 2.5, { className: 'dotted', buttons: 10});</script>
            <div class="starbox_note"> <?php _e("overlay='default', buttons=10, className='dotted'",'starbox') ?></div>
          </li>
          <li class='star last'>
                <div id='demo_4' style="float:left"><img src="<?php echo STARBOX_URLPATH.'/images/loading.gif';?>"></div></span>
                <script>new Starbox('demo_4', 3, { overlay: 'pointy.png', className: 'pointy' } );</script>
                <div class="starbox_note"> <?php _e("overlay='pointy', buttons=5, className='default'",'starbox') ?></div>
          </li>
          <li class='star last'>
                <div id='demo_9' style="float:left"></div></span>
                <script>new Starbox('demo_9', 3.5, {overlay:'big.png',buttons:10 });</script>
                <div style="padding-top:5px;" class="starbox_note"> <?php _e("overlay='Big', buttons=10, className='Default'",'starbox') ?></div>
          </li>

          
          <li class='star last'>
                <div id='demo_10' style="float:left"></div></span>
                <script>new Starbox('demo_10', 3.5, {overlay:'big.png',buttons:10,ghosting: true });</script>
                <div style="padding-top:5px;" class="starbox_note"> <?php _e("overlay='Big', buttons=10, className='Default', ghosting=Yes",'starbox') ?></div>
          </li>

        </ul>
        <h3 style="float:left"><?php _e('Your Style Setting','starbox') ?></h3>
            <ul class="starbox_style">
                <li><span><?php _e('Overlay',"starbox") ?>:</span>
                    <div class="overlay"><input type="radio" <?php if($overlay == 'big.png') echo "checked"; ?> name="overlay" value="big.png"><?php _e('Big',"starbox") ?></div> 
                    <div class="overlay"><input type="radio" <?php if($overlay == 'pointy.png') echo "checked"; ?> name="overlay" value="pointy.png"><?php _e('Pointy',"starbox") ?></div 
                    <div class="overlay"><input type="radio" <?php if($overlay == 'default.png') echo "checked"; ?> name="overlay" value="default.png"><?php _e('Default',"starbox") ?></div</li>
                <li>
                    <span><?php _e('Buttons',"starbox") ?>:</span><input style="text"  name="button" value="<?php echo $button;?>" /><div  style="padding-top:5px;" class="starbox_note">(<?php _e('Amount of clickable areas,5 or 10','starbox') ?>)</div>
                </li>
                <li><span><?php _e('ClassName',"starbox") ?>:</span>
                    <div class="overlay"><input type="radio" <?php if($class == 'dotted') echo "checked"; ?> name="classname" value="dotted"><?php _e('dotted',"starbox") ?></div> 
                    <div class="overlay"><input type="radio" <?php if($class == 'pointy') echo "checked"; ?> name="classname" value="pointy"><?php _e('Pointy',"starbox") ?></div 
                    <div class="overlay"><input type="radio" <?php if($class == 'default') echo "checked"; ?> name="classname" value="default"><?php _e('Default',"starbox") ?></div</li>
                <li>
                <li><span><?php _e('Ghosting',"starbox") ?>:</span>
                    <div class="overlay"><input type="radio" <?php if($ghost == 'true') echo "checked"; ?> name="ghost" value="true"><?php _e('Yes',"starbox") ?></div> 
                    <div class="overlay"><input type="radio" <?php if($ghost == 'false') echo "checked"; ?> name="ghost" value="false"><?php _e('No',"starbox") ?></div 
                <li>
            </ul>
        <p style="float:left;" class="submit"><input type="submit" value="<?php _e("Update Setting &raquo;",'starbox');?>" name="starbox_submit" /></p>
        </form>
      </div>
      <?
}

?>
