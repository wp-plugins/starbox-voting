<?php

$url = $_SERVER['REQUEST_URI'];

$pluginUrl = explode('js',$url);

$ajaxurl =  $pluginUrl[0] . 'ajax.php';
?>
function vote(id,rate,img,event){
                        var url = "<?php echo $ajaxurl ;?>";
                        
                        new Ajax.Request(url, {
                              method: "post",
                              parameters: "rate=" + rate + "&id=" + id,
                              onSuccess: function(transport) {
                              }
                        });
                }

function starboxThankYou(event) {
      var indicator = event.findElement('.starbox').down('.indicator'),
      restore = indicator.innerHTML;
      indicator.update('Thanks for voting');
      (function() { indicator.update(restore) }).delay(2);
}

