<!-- output postcode & address in Japan -->
<?php
$postcode_1 = filter_input(INPUT_GET, 'postcode_1', FILTER_SANITIZE_SPECIAL_CHARS);	//住所検索欄
$postcode = filter_input(INPUT_GET, 'postcode', FILTER_SANITIZE_SPECIAL_CHARS);	//登録用
$submit1 = filter_input(INPUT_GET, 's1', FILTER_SANITIZE_SPECIAL_CHARS);	//住所検索ボタン
$submit2 = filter_input(INPUT_GET, 's2', FILTER_SANITIZE_SPECIAL_CHARS);	//登録ボタン


if ($submit2) {			//when send button pusshed
	$address = filter_input(INPUT_GET, 'address', FILTER_SANITIZE_SPECIAL_CHARS);

	echo $postcode;
	echo '<br>';
	echo $address;
	echo '<br>';
} elseif ($submit1) {			//when search button pusshed
	if (is_numeric($postcode_1)) {
		//$postcode = 7300031;	//郵便番号
		$url = "http://zipcloud.ibsnet.co.jp/api/search?zipcode=";		//郵便番号検索サイト
		$url = $url . $postcode_1;	//検索条件追加
		$json = file_get_contents($url);	//検索結果を$jsonに入れる
		$json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');	//utf8にエンコード
		$arr = json_decode($json, true);		//jsonをでコード

		if ($arr['results'] != "") {
			$pref = ($arr['results']['0']["address1"]);		//県表示 prefecture
			$city = ($arr['results']['0']["address2"]);		//市表示	city
			$cho =  ($arr['results']['0']["address3"]);		//住所表示	cho
			$address = $pref . $city . $cho;
			echo '<br>';
			echo '<br>';
		} else {
			$address = "";
			echo '郵便番号が未記入、または存在しません。';
			echo '<br>';
			echo '<br>';
		}
	}
} else {
	$address = "";
	echo "郵便番号、住所を入力してください。";
	echo '<br>';
	echo '<br>';
}
?>

<!-- input postcode form -->
<form method="get">
	postcode ( 7 digit ) <input type="text" name="postcode_1" value="<?php echo $postcode_1 ?>">
	<button type="submit" name="s1" value="1">search</button>
</form>
<form method="get">
	<input type="hidden" name="postcode" value="<?php echo $postcode_1 ?>">
	address <input type="text" name="address" id="2" value="<?php echo $address ?>">
	<button type="submit" name="s2" value="2">send</button>
</form>

<!-- to see button status only -->
<?php
// echo 'search ' . $submit1;
// echo '<br>';
// echo 'send ' . $submit2;
// echo '<br>';
?>
