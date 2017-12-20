<?php
	
	// Ruhum
	// 20.12.2017

?>
<!DOCTYPE html>
<html>
<head>
	<title>Youtube Video Information</title>
	<link rel="stylesheet" type="text/css" href="Style.css" />
</head>
<body>

<?php
	
	if(isset($_POST['VideoURL'])){

?>
	<center><h2>Youtube Videos Information</h2></center>

	<div class="Duzen">
		
		<div class="GenelBilgiler">
			<div class="Bilgiler Bold" style="width: 40px;">Count</div>
			<div class="Bilgiler Bold KanalAdi">Video Name</div>
			<div class="Bilgiler Bold">Views</div>
			<div class="Bilgiler Bold">Like</div>
			<div class="Bilgiler Bold">Dislike</div>
			<div class="Bilgiler Bold SonDiv" style="width: 150px;">Date</div>
			<div class="Temizle"></div>
		</div>
							
<?php
		$YtApiKey = 'REPLACE_API_KEY';

		$Videolar = $_POST['VideoURL'];
		$Videolar = explode("\n", $Videolar);
		$Videolar = array_map('trim', $Videolar);
		foreach ($Videolar as $Key => $Video) {

			$YtVideoID = explode('v=',$Video);
			$YtVideoID = end($YtVideoID);
			$YtVideoID = substr($YtVideoID, 0, 11);

		    $Baglanti = 'https://www.googleapis.com/youtube/v3/videos?part=statistics,snippet&id='.$YtVideoID.'&key='.$YtApiKey;
		    $Kaynak = file_get_contents($Baglanti);
		    $KaynakDecode = json_decode($Kaynak);

            $Izlenme = $KaynakDecode->items[0]->statistics->viewCount;
            $Begeni = $KaynakDecode->items[0]->statistics->likeCount;
            $Dislike = $KaynakDecode->items[0]->statistics->dislikeCount;
            $YayinTarih = $KaynakDecode->items[0]->snippet->publishedAt;
            $Baslik = $KaynakDecode->items[0]->snippet->title;
            $YayinTarih = strtotime($YayinTarih);
            $YayinTarih = date('d.m.Y H:i:s', $YayinTarih);

            $Baglanti = 'https://www.youtube.com/watch?v='.$YtVideoID;
?>

			<div class="GenelBilgiler" <?=$Key%2?'':'style="background-color: #eff7ff;"'?>>
				<div class="Bilgiler" style="width: 40px;"><?=($Key+1)?></div>
				<div class="Bilgiler KanalAdi"><a href="<?=$Baglanti?>" target="_blank"><?=$Baslik?></a></div>
				<div class="Bilgiler"><?=number_format($Izlenme)?></div>
				<div class="Bilgiler"><?=number_format($Begeni)?></div>
				<div class="Bilgiler"><?=number_format($Dislike)?></div>
				<div class="Bilgiler SonDiv" style="width: 150px;"><?=$YayinTarih?></div>
				<div class="Temizle"></div>
			</div>


<?php

		}

?>

	</div>

<?php

	}

?>
	<center><h2>Youtube Video Links</h2></center>
	<div class="Duzen">
		
		<form action="" method="post">
			<label style="margin-left: 10px; margin-top: 5px; font-weight: bold; color: #474747; float: left;">Video Links</label>
			<textarea placeholder="Examples:&#10;https://www.youtube.com/watch?v=vI4LHl4yFuo&#10;https://www.youtube.com/watch?v=Aia-B6_hrjo&#10;https://www.youtube.com/watch?v=3Hj3sFodt7E" name="VideoURL" id="VideoURL"></textarea>
			<input type="submit" value="Check" id="KontrolEt">
		</form>
		<div class="Temizle"></div>

	</div>

</body>
</html>
