<?php /*
  Quotes
  License: GPLv3
  Homepage: https://github.com/mathisdt/quotes
*/ ?>
<html>
<head>
<title>Zitate</title>
<style>
body {
  background-color: linen;
  padding-top: 15px;
  padding-left: 40px;
  padding-right: 40px;
}
h1, h2, h3 {
  color: maroon;
  margin-top: 20px;
  margin-bottom: 20px;
}
span {
  display: inline-block;
  white-space: nowrap;
  background-color: #c0c0c0;
  border: 1px solid #a0a0a0;
  border-radius: 8px;
  cursor: pointer;
  margin-bottom: 20px;
  margin-right: 15px;
  padding: 10px;
}
</style>
<script>
function play(filename) {
  var source = document.getElementById('audioSource');
  source.src = filename;
  var audio = document.getElementById('audio');
  audio.load();
  audio.play();
}
</script>
</head>
<body>
<h1>Zitate</h1>
<audio id="audio">
  <source id="audioSource" src=""></source>
</audio>
<?php

function render_buttons($directory) {
  $files = scandir($directory);
  $subdir = preg_replace("#^" . dirname(__FILE__) . "/?#", '', $directory);
  foreach ($files as $key => $value) {
    if (is_file($directory . '/' . $value) && preg_match('/\.mp3$/', $value)) {
      $name = preg_replace('/\.mp3$/', '', $value);
      print("<span onclick='play(\"{$subdir}/{$value}\");'>{$name}</span> ");
    }
  }
}

render_buttons(dirname(__FILE__) . '/data');

$files = scandir(dirname(__FILE__) . '/data');
foreach ($files as $key => $value) {
  if ($value == "." || $value == "..") {
    continue;
  }
  if (is_dir(dirname(__FILE__) . '/data/' . $value)) {
    print("<h3>{$value}</h3>");
    render_buttons(dirname(__FILE__) . '/data/' . $value);
  }
}

?>
</body>
</html>
