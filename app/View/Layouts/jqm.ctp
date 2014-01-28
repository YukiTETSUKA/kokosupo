<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title_for_layout; ?></title>
         <meta name="viewport" content="width=device-width,minimum-scale=1">
         <link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.css" />
<script src="http://code.jquery.com/jquery-1.7.1.min.js"> </script>
<script type="text/javascript">
/* ajaxを無効にするための設定　*/
$(document).bind("mobileinit",function(){
    $.mobile.ajaxEnabled=false;
    $.mobile.pushStateEnabled=false;
});
</script>
         <script src="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.js"></script>
    </head>
    <body>
<script type="text/javascript">
if (window.location.hash == '#_=_')window.location.hash = '';
</script>
        <div data-role="page" data-theme="b">

             <div data-role="header" data-theme="b">
                 <h1><?php echo 'ここすぽっ！'; ?></h1>
                <!--  <a href="" data-rel="back">戻る</a> -->
                 <?php //echo $this->Html->link('Home',array('action'=>'index'),array('data-icon'=>'home','data-iconpos'=>'notext'));?>
             </div><!-- /header -->

             <div data-role="content">
                <?php echo $content_for_layout; ?>
             </div><!-- /content -->

             <div data-role="footer" data-theme="b">
                <h4><?php echo "Tetuka&Murakami@2014";?></h4>
             </div><!-- /footer -->


        </div><!-- /page -->
    </body>
</html>
