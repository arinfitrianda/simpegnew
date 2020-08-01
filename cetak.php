<?php
$nip=$_GET["id"];
$nama=$_GET["nama"];
echo "<html>
<body onload='window.print();'>
<img src=\"http://chart.apis.google.com/chart?chl=$nip&chs=100x100&cht=qr&chld=H%7C0\" align=\"left\" hspace=\"10\">$nama
</body>
</html>";

//ini nyobain ajaaaaa
?>