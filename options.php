<?php

/**
 * Option Page Code
 * 
 * @author jigen.he (2009-2-23)
 */
function option_admin(){
        global $starbox;
        if($_POST['starbox_submit']){

          update_option("starbox_image",$_POST['starstyle']);

          $message = '<div class="updated fade" id="message" style="background-color: rgb(255, 251, 204); margin-top: 40px;"><p>Starbox Setting Updated.</p></div>';
        }
        $starboxstyle = stripslashes(get_option('starbox_image'));
  ?>
        <div class="wrap">
          <?php $starbox->load_script();?>
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
          <?php if($message)
                echo $message ;
              ?>
        <form method="post" action="">
        <ul class="starbox_style">    
          <li class='star last'>
            <input type="radio" <?if(!$starboxstyle) echo "checked" ; ?> name="starstyle" value="" />
                  <div id='demo_0' style="float:left" class='loading'></div></span>
                  <script>
                                    new Starbox('demo_0', 2);
                      </script>
          </li>
          <li class='star last'>
            <input type="radio" name="starstyle" <?if($starboxstyle=="className: 'dotted'") echo "checked" ; ?> value="className: 'dotted'" />
                  <div id='demo_1' style="float:left" class='loading'></div></span>
                  <script>
                                    new Starbox('demo_1', 2, { className: 'dotted' });
                      </script>
          </li>
          <li class='star last'>
            <input type="radio" name="starstyle" <?if($starboxstyle=="className: 'dotted', buttons: 10") echo "checked" ; ?> value="className: 'dotted', buttons: 10" />
                  <div id='demo_2' style="float:left" class='loading'></div></span>
                  <script language='javascript' type='text/javascript'>
                    new Starbox('demo_2', 2.5, { className: 'dotted', buttons: 10});
                  </script>
          </li>
          <li class='star last'>
            <input type="radio" name="starstyle" <?if($starboxstyle=="className: 'dotted', stars: 7, buttons: 7, max: 7") echo "checked" ; ?> value="className: 'dotted', stars: 7, buttons: 7, max: 7" />
                  <div id='demo_3' style="float:left" class='loading'></div></span>
            <script language='javascript' type='text/javascript'>
              new Starbox('demo_3', 4, { className: 'dotted', stars: 7, buttons: 7, max: 7 });
            </script>
          </li>
          <li class='star last'>
            <input type="radio" name="starstyle" <?if($starboxstyle=="overlay: 'pointy.png', className: 'pointy'") echo "checked" ; ?> value="overlay: 'pointy.png', className: 'pointy'" />
                  <div id='demo_4' style="float:left" class='loading'></div></span>

            <script language='javascript' type='text/javascript'>
              new Starbox('demo_4', 3, { overlay: 'pointy.png', className: 'pointy' } );
            </script>
          </li>
          <li class='star last'>
            <input type="radio" name="starstyle" <?if($starboxstyle=="overlay: 'pointy.png', className: 'pointy', max: 8, buttons: 16, stars: 8") echo "checked" ; ?> value="overlay: 'pointy.png', className: 'pointy', max: 8, buttons: 16, stars: 8" />
                  <div id='demo_5' style="float:left" class='loading'></div></span>
            <script language='javascript' type='text/javascript'>
              new Starbox('demo_5', 4, { overlay: 'pointy.png', className: 'pointy', max: 8, buttons: 16, stars: 8} );
            </script>
          </li>
          <li class='star last'>
            <input type="radio" name="starstyle" />
                  <div id='demo_6' style="float:left" class='loading'  <?if($starboxstyle=="overlay: 'pointy.png', className: 'pointy', max: 8, buttons: 8, stars: 8") echo "checked" ; ?> value="overlay: 'pointy.png', className: 'pointy', max: 8, buttons: 8, stars: 8"></div></span>

            <script language='javascript' type='text/javascript'>
              new Starbox('demo_6', 6, { overlay: 'pointy.png', className: 'pointy', max: 8, buttons: 8, stars: 8 } );
            </script>
          </li>
          <li class='star last'>
            <input type="radio" name="starstyle" <?if($starboxstyle=="max: 10, buttons: 10, stars: 10") echo "checked" ; ?> value="max: 10, buttons: 10, stars: 10" />
                  <div id='demo_7' style="float:left" class='loading'></div></span>
            <script language='javascript' type='text/javascript'>
              new Starbox('demo_7', 6, { max: 10, buttons: 10, stars: 10 });
            </script>
          </li>
          <li class='star last'>
            <input type="radio" name="starstyle" value="overlay: 'big.png', buttons: 10, rated: 3.5" />
                  <div id='demo_9' style="float:left" class='loading'></div></span>
            <script language='javascript' type='text/javascript'>
              new Starbox('demo_9', 3.5, { overlay: 'big.png', buttons: 10, stars: 5 });
            </script>
          </li>
        </ul>
        <p style="float:left;" class="submit"><input type="submit" value="<?php _e("Update Setting &raquo;",'starbox');?>" name="starbox_submit" /></p>
        </form>
      </div>
      <?
}

?>
