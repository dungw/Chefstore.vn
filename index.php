<?php

/**
 * @author duchanh
 * @copyright 2012
 */

if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
include("config.php");

$cms = new cms();
$cms->run();

if(isset($_REQUEST['query'])){
    $_SESSION['query'] = $_REQUEST['query'];
}

if(SHOW_QUERY_INFO == 'on' && $_SESSION['query'] == 1){
    echo '<pre>';
    foreach($oDb->listQuery as $query){
        echo '<p style="text-align:left">'.trim($query) .'</p>';
    }
    echo '</pre>';
}
if($oDb)@$oDb->close();
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-43611327-1', 'chefstore.vn');
  ga('send', 'pageview');
</script>