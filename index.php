<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="icon" 
      type="image/png" 
      href="favicon.ico" />
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-40189140-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TubeTube</title>
<meta name="description" content="Watch TV online like it's 1980">
<meta property="og:title" content="TubeTube" />
<meta property="og:type" content="video.movie" />
<meta property="og:url" content="http://colinurban.com/Lab/tv/" />
<meta property="og:image" content="http://colinurban.com/Lab/tv/fb.jpg" />
<link href="tvstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>   
</head>
<body onload="load()">
<?php
$q = "%20";
$input .= $_GET['q'];
$q .= urlencode($input);
$videos = array();
$url ="https://gdata.youtube.com/feeds/api/videos?q=full%20episode".$q."&duration=long&alt=json&v=2";
        
        
$ch = curl_init($url);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
$c = curl_exec($ch);
curl_close($ch);
$json = json_decode($c,TRUE);
//var_dump($json['feed']['entry']);
foreach ($json['feed']['entry'] as $v)
{
	$videos[] = array
		(
		'title'=>$v['title']['$t'],
		'link'=>str_replace('/v/', '/embed/', $v['content']['src'])
		);
}
//var_dump($videos);
?>

<div id="tv">
<screen class="off"><iframe id="frame" width="620" height="460" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></screen>
<div id="controls"><a><div id="b" class="dial"></div></a><c><div onclick="alert('This dial doesn\'t do anything yet')" class="dial"></div></c></div>
<div id="speaker">
<form action="tv.php" method="get">

<input onclick="this.value=''" style="background:#ddd;margin:10px;width:140px;margin-bottom:0;" value="Show Name" type="text" name="q"/>
<input id="button" type="submit" value="Find Episodes"/>
</form>

</div>
</div>
<div id="cont">
<ul style="">
<?php
//foreach ($videos as $v){
//	echo '<li><a style="cursor:pointer;" onclick="document.getElementById(\'frame\').setAttribute(\'src\',\''.$v['link'].'\');">'.$v['title'].'</a></li>';
//}

?>
</ul>
</div>

<script>
var now = 20;
var i =0;
<?php
$js_array = json_encode($videos);
echo "var videos = ". $js_array . ";\n";
?>

$("#b").click(function(){
now = now + 20;
i++;
if (i > videos.length){

	i=0;
}
var item = videos[i]['link'];
document.getElementById('frame').setAttribute('src',item+'&fs=1');
$("#b").css('-webkit-transform','rotateZ('+now+'deg)');
});

function load(){
var item = videos[Math.floor(Math.random()*videos.length)]['link'];
document.getElementById('frame').setAttribute('src',item);
}


</script>
</body>
</html>
