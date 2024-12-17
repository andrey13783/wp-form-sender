<!DOCTYPE html>
<html>
<head>
  <title>Файлы</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Cache-Control" content="no-cache">
  <meta http-equiv="Cache-Control" content="private">
</head>
<body>
<div class="container">
<?php
  $dir = array_reverse(explode('/', __DIR__))[0];
  echo '<h2>Файлы</h2>';
  echo '<div class="flex flex-3 flex-left">';
  $handle = opendir($dir);
  while (false !==($fil = readdir($handle))){ 
    if ($fil!='.' && $fil!='..' && $fil!='index.php'){
      $image = '';
      if (strstr($fil, '.jpg') || strstr($fil, '.jpeg') || strstr($fil, '.png') || strstr($fil, '.gif') || strstr($fil, '.svg') || strstr($fil, '.jpg') || strstr($fil, '.jpg')){
        $image = $fil;
      }
      else{
        $image = '/wp-content/plugins/form-sender/filestypes/'.explode('.', $fil)[1].'.png';
      }
      echo '<div class="item"><a href="'.$fil.'"><img src="'.$image.'"><br>'.$fil.'</a><br><br><br></div>';
    }
  }
  closedir($handle);
  echo '</div>';
?>
</div>
<style type="text/css">
.flex {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
}
.flex-nowrap {
  flex-wrap: nowrap;
}
.flex-left {
  justify-content: flex-start;
}
.flex-right {
  justify-content: flex-end;
}
.flex-top {
  align-items: flex-start;
}
.flex-bottom {
  align-items: flex-end;
}
.flex-center {
  justify-content: center;
}
.flex-stretch {
  align-items: stretch;
}
.flex-2 > * {
  width: 49%;
}
.flex-3 > * {
  width: 32%;
}
.flex-4 > * {
  width: 24%;
}
@media (max-width:950px){
  .flex, 
  .flex- > div {
    margin:0;
  }
  .flex-2 > * {
    width:100%;
  }
  .flex-3 > *,
  .flex-4 > * {
    width:47%;
  }
}
@media (max-width:600px){
  .flex-2 > *,
  .flex-3 > *,
  .flex-4 > * {
    width:100%;
  }
}

.item {
  text-align: center;
}
.item img {
  object-fit: cover;
  width: 100%;
  max-width: 200px;
  height: 200px;
  border: solid 1px #aaa;
}
</style>
</body>
</html>