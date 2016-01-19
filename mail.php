<?php header("Content-Type:text/html;charset=utf-8"); ?>
<?php //error_reporting(E_ALL | E_STRICT);
##-----------------------------------------------------------------------------------------------------------------##
#
#  PHPメールプログラム　フリー版 最終更新日2014/1/26
#　改造や改変は自己責任で行ってください。
#	
#  今のところ特に問題点はありませんが、不具合等がありましたら下記までご連絡ください。
#  MailAddress: info@php-factory.net
#  name: K.Numata
#  HP: http://www.php-factory.net/
#
#  重要！！サイトでチェックボックスを使用する場合のみですが。。。
#  チェックボックスを使用する場合はinputタグに記述するname属性の値を必ず配列の形にしてください。
#  例　name="当サイトをしったきっかけ[]"  として下さい。
#  nameの値の最後に[と]を付ける。じゃないと複数の値を取得できません！
#
##-----------------------------------------------------------------------------------------------------------------##

/*-------------------------------------------------------------------------------------------------------------------
* ★以下設定時の注意点　
* ・値（=の後）は数字以外の文字列（一部を除く）はダブルクオーテーション「"」、または「'」で囲んでいます。
* ・これをを外したり削除したりしないでください。後ろのセミコロン「;」も削除しないください。
* ・また先頭に「$」が付いた文字列は変更しないでください。数字の1または0で設定しているものは必ず半角数字で設定下さい。
* ・メールアドレスのname属性の値が「Email」ではない場合、以下必須設定箇所の「$Email」の値も変更下さい。
* ・name属性の値に半角スペースは使用できません。
*以上のことを間違えてしまうとプログラムが動作しなくなりますので注意下さい。
-------------------------------------------------------------------------------------------------------------------*/


//---------------------------　必須設定　必ず設定してください　-----------------------

//サイトのトップページのURL　※デフォルトでは送信完了後に「トップページへ戻る」ボタンが表示されますので
$site_top = "http://anqish.com/";

// 管理者メールアドレス ※メールを受け取るメールアドレス(複数指定する場合は「,」で区切ってください 例 $to = "aa@aa.aa,bb@bb.bb";)
$to = "fk@anqish.com";

//フォームのメールアドレス入力箇所のname属性の値（name="○○"　の○○部分）
$Email = "メールアドレス";

/*------------------------------------------------------------------------------------------------
以下スパム防止のための設定　
※有効にするにはこのファイルとフォームページが同一ドメイン内にある必要があります
------------------------------------------------------------------------------------------------*/

//スパム防止のためのリファラチェック（フォームページが同一ドメインであるかどうかのチェック）(する=1, しない=0)
$Referer_check = 0;

//リファラチェックを「する」場合のドメイン ※以下例を参考に設置するサイトのドメインを指定して下さい。
$Referer_check_domain = "php-factory.net";

//---------------------------　必須設定　ここまで　------------------------------------


//---------------------- 任意設定　以下は必要に応じて設定してください ------------------------


// 管理者宛のメールで差出人を送信者のメールアドレスにする(する=1, しない=0)
// する場合は、メール入力欄のname属性の値を「$Email」で指定した値にしてください。
//メーラーなどで返信する場合に便利なので「する」がおすすめです。
$userMail = 1;

// Bccで送るメールアドレス(複数指定する場合は「,」で区切ってください 例 $BccMail = "aa@aa.aa,bb@bb.bb";)
$BccMail = "";

// 管理者宛に送信されるメールのタイトル（件名）
$subject = "ANQishサイト「Contact」からのお問い合わせ";

// 送信確認画面の表示(する=1, しない=0)
$confirmDsp = 1;

// 送信完了後に自動的に指定のページ(サンクスページなど)に移動する(する=1, しない=0)
// CV率を解析したい場合などはサンクスページを別途用意し、URLをこの下の項目で指定してください。
// 0にすると、デフォルトの送信完了画面が表示されます。
$jumpPage = 1;

// 送信完了後に表示するページURL（上記で1を設定した場合のみ）※httpから始まるURLで指定ください。
$thanksPage = "http://anqish.com/thanks.html";

// 必須入力項目を設定する(する=1, しない=0)
$requireCheck = 1;

/* 必須入力項目(入力フォームで指定したname属性の値を指定してください。（上記で1を設定した場合のみ）
値はシングルクォーテーションで囲み、複数の場合はカンマで区切ってください。フォーム側と順番を合わせると良いです */
$require = array('メールアドレス','お問い合わせ内容');


//----------------------------------------------------------------------
//  自動返信メール設定(START)
//----------------------------------------------------------------------

// 差出人に送信内容確認メール（自動返信メール）を送る(送る=1, 送らない=0)
// 送る場合は、フォーム側のメール入力欄のname属性の値が上記「$Email」で指定した値と同じである必要があります
$remail = 0;

//自動返信メールの送信者欄に表示される名前　※あなたの名前や会社名など（もし自動返信メールの送信者名が文字化けする場合ここは空にしてください）
$refrom_name = "";

// 差出人に送信確認メールを送る場合のメールのタイトル（上記で1を設定した場合のみ）
$re_subject = "送信ありがとうございました";

//フォーム側の「名前」箇所のname属性の値　※自動返信メールの「○○様」の表示で使用します。
//指定しない、または存在しない場合は、○○様と表示されないだけです。あえて無効にしてもOK
$dsp_name = 'お名前';

//自動返信メールの冒頭の文言 ※日本語部分のみ変更可
$remail_text = <<< TEXT

お問い合わせありがとうございました。
早急にご返信致しますので今しばらくお待ちください。

送信内容は以下になります。

TEXT;


//自動返信メールに署名（フッター）を表示(する=1, しない=0)※管理者宛にも表示されます。
$mailFooterDsp = 0;

//上記で「1」を選択時に表示する署名（フッター）（FOOTER～FOOTER;の間に記述してください）
$mailSignature = <<< FOOTER

──────────────────────
株式会社○○○○　佐藤太郎
〒150-XXXX 東京都○○区○○ 　○○ビル○F　
TEL：03- XXXX - XXXX 　FAX：03- XXXX - XXXX
携帯：090- XXXX - XXXX 　
E-mail:xxxx@xxxx.com
URL: http://www.php-factory.net/
──────────────────────

FOOTER;


//----------------------------------------------------------------------
//  自動返信メール設定(END)
//----------------------------------------------------------------------

//メールアドレスの形式チェックを行うかどうか。(する=1, しない=0)
//※デフォルトは「する」。特に理由がなければ変更しないで下さい。メール入力欄のname属性の値が上記「$Email」で指定した値である必要があります。
$mail_check = 1;

//------------------------------- 任意設定ここまで ---------------------------------------------


// 以下の変更は知識のある方のみ自己責任でお願いします。


//----------------------------------------------------------------------
//  関数実行、変数初期化
//----------------------------------------------------------------------
$encode = "UTF-8";//このファイルの文字コード定義（変更不可）

if(isset($_GET)) $_GET = sanitize($_GET);//NULLバイト除去//
if(isset($_POST)) $_POST = sanitize($_POST);//NULLバイト除去//
if(isset($_COOKIE)) $_COOKIE = sanitize($_COOKIE);//NULLバイト除去//
if($encode == 'SJIS') $_POST = sjisReplace($_POST,$encode);//Shift-JISの場合に誤変換文字の置換実行
$funcRefererCheck = refererCheck($Referer_check,$Referer_check_domain);//リファラチェック実行

//変数初期化
$sendmail = 0;
$empty_flag = 0;
$post_mail = '';
$errm ='';
$header ='';

if($requireCheck == 1) {
	$requireResArray = requireCheck($require);//必須チェック実行し返り値を受け取る
	$errm = $requireResArray['errm'];
	$empty_flag = $requireResArray['empty_flag'];
}
//メールアドレスチェック
if(empty($errm)){
	foreach($_POST as $key=>$val) {
		if($val == "confirm_submit") $sendmail = 1;
		if($key == $Email) $post_mail = h($val);
		if($key == $Email && $mail_check == 1 && !empty($val)){
			if(!checkMail($val)){
				$errm .= "<p class=\"error_messe\">【".$key."】はメールアドレスの形式が正しくありません。</p>\n";
				$empty_flag = 1;
			}
		}
	}
}
//差出人に届くメールをセット
if($remail == 1) {
	$userBody = mailToUser($_POST,$dsp_name,$remail_text,$mailFooterDsp,$mailSignature,$encode);
	$reheader = userHeader($refrom_name,$to,$encode);
	$re_subject = "=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($re_subject,"JIS",$encode))."?=";
}
//管理者宛に届くメールをセット
	$adminBody = mailToAdmin($_POST,$subject,$mailFooterDsp,$mailSignature,$encode,$confirmDsp);
	$header = adminHeader($userMail,$post_mail,$BccMail,$to);
	$subject = "=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($subject,"JIS",$encode))."?=";
  
if(($confirmDsp == 0 || $sendmail == 1) && $empty_flag != 1){
  mail($to,$subject,$adminBody,$header);
  if($remail == 1) mail($post_mail,$re_subject,$userBody,$reheader);
}
else if($confirmDsp == 1){ 

/*　▼▼▼送信確認画面のレイアウト※編集可　オリジナルのデザインも適用可能▼▼▼　*/
?>

<!DOCTYPE html>
<!--[if IE 6]> <html class="no-js lt-ie9 lt-ie8 lt-ie7 eq-ie6" lang="ja"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8 eq-ie7" lang="ja"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9 eq-ie8" lang="ja"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="ja"> <!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Language" content="ja" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="imagetoolbar" content="no" />
<meta name="Keywords" content="ANQish.com,アンキッシュ,webデザイナー,ホームページ制作">
<meta name="description" content="都内在住のWebサイト制作者の個人サイト ANQish「アンキッシュ」">
<meta name="viewport" content="user-scalable=0,width=device-width,initial-scale=1,maximum-scale=1">
<title>ANQish.com| Web Desighn</title>
<link rel="stylesheet" href="css/import.css" type="text/css" media="all">
<link rel="shortcut icon" href="./favicon.ico">
</head>
<body>
    
<div id="wrapper">

  <div id="mask">

    <div class="keyboardable" title="キーボードでページ移動が可能です。">Keyboard Move</div>
    
             <nav class="navPane">
                 <div id="LogoArea"><a href="/#Home"><img id="Logo"  alt="Logo" src="./images/spacer.gif"><span>ANQish</span></a></div>
                    <ul class="links-to-floor">
                        <li><a href="http://anqish.com/#Home">Home<span>Wellcome</span></a></li>
                        <li><a href="http://anqish.com/#About">About<span>What site</span></a></li>
                        <li><a href="http://anqish.com/#Works">Works<span>Design</span></a></li>
                        <li><a href="http://anqish.com/#Blog">Blog<span>Blog</span></a></li>
                        <li><a href="http://anqish.com/#Access">Access<span>Access</span></a></li>
                        <li><a href="http://anqish.com/#Contact">Contact<span>Contact</span></a></li>
                    </ul>
                </nav>
                        <div class="navScrollMask" style="right: 15px;"></div>

<div id="keymove">

    <section id="Contact" class="content">
    <article class="container">
     <div id="welcome">


<div class="inner">
<p class="pan">入&nbsp;力&nbsp;>&nbsp;<strong>確&nbsp;認</strong>&nbsp;>&nbsp;送&nbsp;信</p>
<?php if($empty_flag == 1){ ?>
<div align="center">
<h4>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h4>
<?php echo $errm; ?><br /><br /><input type="button" value=" 前画面に戻る " onClick="history.back()">
</div>
<?php }else{ ?>
<p align="center">以下の内容で間違いがなければ、「送信する」ボタンを押してください。</p>
<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="POST">
<table class="formTable">
<?php echo confirmOutput($_POST);//入力内容を表示?>
</table>
<p align="center"><input type="hidden" name="mail_set" value="confirm_submit">
<input type="hidden" name="httpReferer" value="<?php echo $_SERVER['HTTP_REFERER'] ;?>">
<input type="submit" value="　送信する　">
<input type="button" value="前画面に戻る" onClick="history.back()"></p>
</form>
<?php } ?>
</div>
         
</div>

     <div class="footer">
         <ul class="links-to-floor">
                        <li><a href="http://anqish.com/#Home">Home<span>Wellcome</span></a></li>
                        <li><a href="http://anqish.com/#About">About<span>What site</span></a></li>
                        <li><a href="http://anqish.com/#Works">Works<span>Design</span></a></li>
                        <li><a href="http://anqish.com/#Blog">Blog<span>Blog</span></a></li>
                        <li><a href="http://anqish.com/#Access">Access<span>Access</span></a></li>
                        <li><a href="http://anqish.com/#Contact">Contact<span>Contact</span></a></li>
         </ul>
         <ul class="links-to-out">
             <li class="fb-link-btn"><a href="https://www.facebook.com/kouta.fujii" target="_blank"><img src="./images/fb_btn.jpg" width="29px" height="29px" alt="facebook-link-btn"></a></li>
             <li class="tw-link-btn"><a href="https://twitter.com/JiFukooon" target="_blank"><img src="./images/tw_btn.jpg" width="29px" height="29px" alt="twitter-link-btn"></a></li>
         </ul>
         <div class="copyright">© 2015 ANQish.com</div>
     </div>
  </article>
  </section>   

      
</div> 
</div>  
</div>  



<script src="http://code.jquery.com/jquery-1.9.0.js"></script>
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<![endif]-->
    
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35379509-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

  </body>
</html>

<?php /* ▲▲▲送信確認画面のレイアウト　※オリジナルのデザインも適用可能▲▲▲　*/
}if(($jumpPage == 0 && $sendmail == 1) || ($jumpPage == 0 && ($confirmDsp == 0 && $sendmail == 0))) { 
/* ▼▼▼送信完了画面のレイアウト　編集可 ※送信完了後に指定のページに移動しない場合のみ表示▼▼▼　*/?>



<!DOCTYPE html>
<!--[if IE 6]> <html class="no-js lt-ie9 lt-ie8 lt-ie7 eq-ie6" lang="ja"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8 eq-ie7" lang="ja"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9 eq-ie8" lang="ja"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="ja"> <!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Language" content="ja" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="imagetoolbar" content="no" />
<meta name="Keywords" content="ANQish.com,アンキッシュ,webデザイナー,ホームページ制作">
<meta name="description" content="都内在住のWebサイト制作者の個人サイト ANQish「アンキッシュ」">
<meta name="viewport" content="user-scalable=0,width=device-width,initial-scale=1,maximum-scale=1">
<title>ANQish.com| Web Desighn</title>
<link rel="stylesheet" href="css/import.css" type="text/css" media="all">
<link rel="shortcut icon" href="./favicon.ico">
</head>
<body>

<div id="wrapper">

  <div id="mask">

    <div class="keyboardable" title="キーボードでページ移動が可能です。">Keyboard Move</div>
    
             <nav class="navPane">
                 <div id="LogoArea"><a href="/#Home"><img id="Logo"  alt="Logo" src="./images/spacer.gif"><span>ANQish</span></a></div>
                    <ul class="links-to-floor">
                        <li><a href="http://anqish.com/#Home">Home<span>Wellcome</span></a></li>
                        <li><a href="http://anqish.com/#About">About<span>What site</span></a></li>
                        <li><a href="http://anqish.com/#Works">Works<span>Design</span></a></li>
                        <li><a href="http://anqish.com/#Blog">Blog<span>Blog</span></a></li>
                        <li><a href="http://anqish.com/#Access">Access<span>Access</span></a></li>
                        <li><a href="http://anqish.com/#Contact">Contact<span>Contact</span></a></li>
                    </ul>
                </nav>
                        <div class="navScrollMask" style="right: 15px;"></div>


<div id="keymove">

<section id="Contact" class="content">
<article class="container">
    <div id="welcome">
         
    <div class="inner">
<?php if($empty_flag == 1){ ?>
<h4>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h4>
<div style="color:red"><?php echo $errm; ?></div>
<br /><br /><input type="button" value=" 前画面に戻る " onClick="history.back()">
</div>
</div>




     <div class="footer">
         <ul class="links-to-floor">
                        <li><a href="http://anqish.com/#Home">Home<span>Wellcome</span></a></li>
                        <li><a href="http://anqish.com/#About">About<span>What site</span></a></li>
                        <li><a href="http://anqish.com/#Works">Works<span>Design</span></a></li>
                        <li><a href="http://anqish.com/#Blog">Blog<span>Blog</span></a></li>
                        <li><a href="http://anqish.com/#Access">Access<span>Access</span></a></li>
                        <li><a href="http://anqish.com/#Contact">Contact<span>Contact</span></a></li>
         </ul>
         <ul class="links-to-out">
             <li class="fb-link-btn"><a href="https://www.facebook.com/kouta.fujii" target="_blank"><img src="./images/fb_btn.jpg" width="29px" height="29px" alt="facebook-link-btn"></a></li>
             <li class="tw-link-btn"><a href="https://twitter.com/JiFukooon" target="_blank"><img src="./images/tw_btn.jpg" width="29px" height="29px" alt="twitter-link-btn"></a></li>
         </ul>
         <div class="copyright">© 2015 ANQish.com</div>
     </div>
  </article>
  </section>   



</div> 
</div> 
</div>




<script src="http://code.jquery.com/jquery-1.9.0.js"></script>
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<![endif]-->
    
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35379509-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

  </body>
</html>






<?php }else{ ?>




<!DOCTYPE html>
<!--[if IE 6]> <html class="no-js lt-ie9 lt-ie8 lt-ie7 eq-ie6" lang="ja"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8 eq-ie7" lang="ja"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9 eq-ie8" lang="ja"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="ja"> <!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Language" content="ja" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="imagetoolbar" content="no" />
<meta name="Keywords" content="ANQish.com,アンキッシュ,webデザイナー,ホームページ制作">
<meta name="description" content="都内在住のWebサイト制作者の個人サイト ANQish「アンキッシュ」">
<meta name="viewport" content="user-scalable=0,width=device-width,initial-scale=1,maximum-scale=1">
<title>ANQish.com| Web Desighn</title>
<link rel="stylesheet" href="css/import.css" type="text/css" media="all">
<link rel="shortcut icon" href="./favicon.ico">
</head>
<body>

<div id="wrapper">

  <div id="mask">

    <div class="keyboardable" title="キーボードでページ移動が可能です。">Keyboard Move</div>
    
             <nav class="navPane">
                 <div id="LogoArea"><a href="/#Home"><img id="Logo"  alt="Logo" src="./images/spacer.gif"><span>ANQish</span></a></div>
                    <ul class="links-to-floor">
                        <li><a href="http://anqish.com/#Home">Home<span>Wellcome</span></a></li>
                        <li><a href="http://anqish.com/#About">About<span>What site</span></a></li>
                        <li><a href="http://anqish.com/#Works">Works<span>Design</span></a></li>
                        <li><a href="http://anqish.com/#Blog">Blog<span>Blog</span></a></li>
                        <li><a href="http://anqish.com/#Access">Access<span>Access</span></a></li>
                        <li><a href="http://anqish.com/#Contact">Contact<span>Contact</span></a></li>
                    </ul>
                </nav>
                        <div class="navScrollMask" style="right: 15px;"></div>

<div id="keymove">
    
<section id="Contact" class="content">
<article class="container">
<div id="welcome">
<div class="inner">
<p class="pan">入&nbsp;力&nbsp;>&nbsp;確&nbsp;認&nbsp;>&nbsp;<strong>送&nbsp;信</strong></p>
<p>送信ありがとうございました。<br />
送信は正常に完了しました。<br /></p>
<a href="<?php echo $site_top ;?>">トップページへ戻る&raquo;</a>
</div>
</div>


     <div class="footer">
         <ul class="links-to-floor">
                        <li><a href="http://anqish.com/#Home">Home<span>Wellcome</span></a></li>
                        <li><a href="http://anqish.com/#About">About<span>What site</span></a></li>
                        <li><a href="http://anqish.com/#Works">Works<span>Design</span></a></li>
                        <li><a href="http://anqish.com/#Blog">Blog<span>Blog</span></a></li>
                        <li><a href="http://anqish.com/#Access">Access<span>Access</span></a></li>
                        <li><a href="http://anqish.com/#Contact">Contact<span>Contact</span></a></li>
         </ul>
         <ul class="links-to-out">
             <li class="fb-link-btn"><a href="https://www.facebook.com/kouta.fujii" target="_blank"><img src="./images/fb_btn.jpg" width="29px" height="29px" alt="facebook-link-btn"></a></li>
             <li class="tw-link-btn"><a href="https://twitter.com/JiFukooon" target="_blank"><img src="./images/tw_btn.jpg" width="29px" height="29px" alt="twitter-link-btn"></a></li>
         </ul>
         <div class="copyright">© 2015 ANQish.com</div>
     </div>
  </article>
  </section>   
    
</div>  
</div>  
</div>  


<script src="http://code.jquery.com/jquery-1.9.0.js"></script>
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<![endif]-->
    
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35379509-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

  </body>
</html>






<?php /* ▲▲▲送信完了画面のレイアウト 編集可 ※送信完了後に指定のページに移動しない場合のみ表示▲▲▲　*/
  }
}
//確認画面無しの場合の表示、指定のページに移動する設定の場合、エラーチェックで問題が無ければ指定ページヘリダイレクト
else if(($jumpPage == 1 && $sendmail == 1) || $confirmDsp == 0) { 
	if($empty_flag == 1){ ?>





<?php 
	}else{ header("Location: ".$thanksPage); }
}

// 以下の変更は知識のある方のみ自己責任でお願いします。

//----------------------------------------------------------------------
//  関数定義(START)
//----------------------------------------------------------------------
function checkMail($str){
	$mailaddress_array = explode('@',$str);
	if(preg_match("/^[\.!#%&\-_0-9a-zA-Z\?\/\+]+\@[!#%&\-_0-9a-z]+(\.[!#%&\-_0-9a-z]+)+$/", "$str") && count($mailaddress_array) ==2){
		return true;
	}else{
		return false;
	}
}
function h($string) {
	global $encode;
	return htmlspecialchars($string, ENT_QUOTES,$encode);
}
function sanitize($arr){
	if(is_array($arr)){
		return array_map('sanitize',$arr);
	}
	return str_replace("\0","",$arr);
}
//Shift-JISの場合に誤変換文字の置換関数
function sjisReplace($arr,$encode){
	foreach($arr as $key => $val){
		$key = str_replace('＼','ー',$key);
		$resArray[$key] = $val;
	}
	return $resArray;
}
//送信メールにPOSTデータをセットする関数
function postToMail($arr){
	$resArray = '';
	foreach($arr as $key => $val){
		$out = '';
		if(is_array($val)){
			foreach($val as $item){ 
				$out .= $item . ', '; 
			}
			$out = rtrim($out,', ');
		}else{
			$out = $val;
		}
		if(get_magic_quotes_gpc()) { $out = stripslashes($out); }
		if($out != "confirm_submit" && $key != "httpReferer") {
			$resArray .= "【 ".$key." 】 ".$out."\n";
		}
	}
	return $resArray;
}
//確認画面の入力内容出力用関数
function confirmOutput($arr){
	$html = '';
	foreach($arr as $key => $val) {
		$out = '';
		if(is_array($val)){
			foreach($val as $item){ 
				$out .= $item . ', '; 
			}
			$out = rtrim($out,', ');
		}else { $out = $val; }//チェックボックス（配列）追記ここまで
		if(get_magic_quotes_gpc()) { $out = stripslashes($out); }
		$out = nl2br(h($out));//※追記 改行コードを<br>タグに変換
		$key = h($key);
		
		$html .= "<tr><th>".$key."</th><td>".$out;
		$html .= '<input type="hidden" name="'.$key.'" value="'.str_replace(array("<br />","<br>"),"",$out).'" />';
		$html .= "</td></tr>\n";
	}
	return $html;
}
//管理者宛送信メールヘッダ
function adminHeader($userMail,$post_mail,$BccMail,$to){
	$header = '';
	if($userMail == 1 && !empty($post_mail)) {
		$header="From: $post_mail\n";
		if($BccMail != '') {
		  $header.="Bcc: $BccMail\n";
		}
		$header.="Reply-To: ".$post_mail."\n";
	}else {
		if($BccMail != '') {
		  $header="Bcc: $BccMail\n";
		}
		$header.="Reply-To: ".$to."\n";
	}
		$header.="Content-Type:text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
		return $header;
}
//管理者宛送信メールボディ
function mailToAdmin($arr,$subject,$mailFooterDsp,$mailSignature,$encode,$confirmDsp){
	$adminBody="「".$subject."」からメールが届きました\n\n";
	$adminBody .="＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
	$adminBody.= postToMail($arr);//POSTデータを関数からセット
	$adminBody.="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n";
	$adminBody.="送信された日時：".date( "Y/m/d (D) H:i:s", time() )."\n";
	$adminBody.="送信者のIPアドレス：".@$_SERVER["REMOTE_ADDR"]."\n";
	$adminBody.="送信者のホスト名：".getHostByAddr(getenv('REMOTE_ADDR'))."\n";
	if($confirmDsp != 1){
		$adminBody.="問い合わせのページURL：".@$_SERVER['HTTP_REFERER']."\n";
	}else{
		$adminBody.="問い合わせのページURL：".@$arr['httpReferer']."\n";
	}
	if($mailFooterDsp == 1) $adminBody.= $mailSignature;
	return mb_convert_encoding($adminBody,"JIS",$encode);
}

//ユーザ宛送信メールヘッダ
function userHeader($refrom_name,$to,$encode){
	$reheader = "From: ";
	if(!empty($refrom_name)){
		$default_internal_encode = mb_internal_encoding();
		if($default_internal_encode != $encode){
			mb_internal_encoding($encode);
		}
		$reheader .= mb_encode_mimeheader($refrom_name)." <".$to.">\nReply-To: ".$to;
	}else{
		$reheader .= "$to\nReply-To: ".$to;
	}
	$reheader .= "\nContent-Type: text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
	return $reheader;
}
//ユーザ宛送信メールボディ
function mailToUser($arr,$dsp_name,$remail_text,$mailFooterDsp,$mailSignature,$encode){
	$userBody = '';
	if(isset($arr[$dsp_name])) $userBody = h($arr[$dsp_name]). " 様\n";
	$userBody.= $remail_text;
	$userBody.="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
	$userBody.= postToMail($arr);//POSTデータを関数からセット
	$userBody.="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
	$userBody.="送信日時：".date( "Y/m/d (D) H:i:s", time() )."\n";
	if($mailFooterDsp == 1) $userBody.= $mailSignature;
	return mb_convert_encoding($userBody,"JIS",$encode);
}
//必須チェック関数
function requireCheck($require){
	$res['errm'] = '';
	$res['empty_flag'] = 0;
	foreach($require as $requireVal){
		$existsFalg = '';
		foreach($_POST as $key => $val) {
			if($key == $requireVal && empty($val)) {
				$res['errm'] .= "<p class=\"error_messe\">【".$key."】は必須入力項目です。</p>\n";
				$res['empty_flag'] = 1;
				$existsFalg = 1;
				break;
			}elseif($requireVal == $key){
				$existsFalg = 1;
				break;
			}
		}
		if($existsFalg != 1){
				$res['errm'] .= "<p class=\"error_messe\">【".$requireVal."】が未選択です。</p>\n";
				$res['empty_flag'] = 1;
		}
	}
	
	return $res;//連想配列で値を返す
}
//リファラチェック
function refererCheck($Referer_check,$Referer_check_domain){
	if($Referer_check == 1 && !empty($Referer_check_domain)){
		if(strpos($_SERVER['HTTP_REFERER'],$Referer_check_domain) === false){
			return exit('<p align="center">リファラチェックエラー。フォームページのドメインとこのファイルのドメインが一致しません</p>');
		}
	}
}
function copyright(){
	echo '';
}
//----------------------------------------------------------------------
//  関数定義(END)
//----------------------------------------------------------------------
?>