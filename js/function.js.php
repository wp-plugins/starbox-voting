<?php

$url = $_SERVER['REQUEST_URI'];

$pluginUrl = explode('js',$url);

$ajaxurl =  $pluginUrl[0] . 'ajax.php';
?>
function vote(id,rate,img){
                        var url = "<?php echo $ajaxurl ;?>";
                        
                        new Ajax.Request(url, {
                              method: "post",
                              parameters: "rate=" + rate + "&id=" + id,
                              onSuccess: function(transport) {
                              }
                        });
                }
