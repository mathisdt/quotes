<?php /*
  Quotes
  License: GPLv3
  Homepage: https://github.com/mathisdt/quotes
*/ ?>
<html lang="de">
<head>
<title>Zitate</title>
<style>
body {
  background-color: linen;
  padding-top: 1em;
  padding-left: 4em;
  padding-right: 4em;
}
h1 {
  font-size: 2em;
  color: maroon;
  margin-top: 1em;
  margin-bottom: 1em;
}
h2 {
  font-size: 1.3em;
  color: maroon;
  margin-top: 1em;
  margin-bottom: 1em;
}
span {
  font-size: 1.3em;
  display: inline-block;
  white-space: nowrap;
  background-color: #d0d0d0;
  border: 1px solid #b0b0b0;
  border-radius: 1em;
  cursor: pointer;
  margin-bottom: 1.5em;
  margin-right: 1.5em;
  padding: 1em;
}
label {
    font-size: 1.2em;
}
fieldset {
    padding-left: 0;
    margin-left: 0;
    border: none;
}
@media screen and (max-width: 1010px) {
  body {
    font-size: 200%;
  }
}
</style>
<script>
function handle(filename) {
    if (document.getElementById('buttonShouldPlay').checked) {
        var source = document.getElementById('audioSource');
        source.src = filename;
        var audio = document.getElementById('audio');
        audio.load();
        audio.play();
    } else if (document.getElementById('buttonShouldDownload').checked) {
        const link = document.createElement("a");
        link.style.display = "none";
        link.href = filename;
        link.download = filename;

        document.body.appendChild(link);
        link.click();

        setTimeout(() => {
            URL.revokeObjectURL(link.href);
            link.parentNode.removeChild(link);
        }, 0);
    }
}
</script>
</head>
<body>
<h1>Zitate</h1>
<audio id="audio">
  <source id="audioSource" src="" />
</audio>
<?php

function render_buttons($directory) {
  $files = scandir($directory);
  $subdir = preg_replace("#^" . dirname(__FILE__) . "/?#", '', $directory);
  foreach ($files as $key => $value) {
    if (is_file($directory . '/' . $value) && preg_match('/\.mp3$/', $value)) {
      $name = preg_replace('/\.mp3$/', '', $value);
      print("<span onclick='handle(\"{$subdir}/{$value}\");'>{$name}</span> ");
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
    print("<h2>{$value}</h2>");
    render_buttons(dirname(__FILE__) . '/data/' . $value);
  }
}

?>
<br/>
<br/>
<br/>
<label for="buttonAction" style="color: maroon; font-weight: bold;">Buttons sollen</label>
<fieldset name="buttonAction" id="buttonAction">
    <input type="radio" name="buttonAction" id="buttonShouldPlay" value="play" checked="checked" />
    <label for="buttonShouldPlay">abspielen</label>
    <input type="radio" name="buttonAction" id="buttonShouldDownload" value="download"/>
    <label for="buttonShouldDownload">herunterladen</label>
</fieldset>
</body>
</html>
