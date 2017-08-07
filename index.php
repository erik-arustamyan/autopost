<?
$access_token = "bc29cdc812630c6fdb55ecf4faaf07172cb843b019973c9f76e9fd9b3cf807945039cac56702cdeee1c57"; //ВАШ ТОКЕН

function GenTheText( $t ) {
	while ( preg_match( '#\{([^\{\}]+)\}#i', $t, $m ) ) {
		$v = explode( '|', $m[1] );
		$i = rand( 0, count( $v ) - 1 );
		$t = preg_replace( '#'.preg_quote($m[0]).'#i', $v[$i], $t, 1 );
	} return $t;
}
$str='';
function mb_ucfirst($str) { 
     return mb_substr(mb_strtoupper($str,'utf-8'),0,1,'utf-8').mb_strtolower(mb_substr($str,1,mb_strlen($str,'utf-8'),'utf-8'),'utf-8');
} 


$public = 151512018;
$attach = "photo366102093_456239024";
$rand36 = rand(3,6);
$attachments = "photo366102093_456239024";
$randtext = file_get_contents("text/".$public.".txt");

$text = GenTheText('Привет Гор');

echo $public."<br/>".$attach."<br/>".$attachments."<br/>".$text;
//Публикуем пост на стену
$ch = curl_init('https://api.vk.com/method/wall.post');
// получать заголовки
curl_setopt ($ch, CURLOPT_HEADER, 1); 
// если ведется проверка HTTP User-agent, то передаем один из возможных допустимых вариантов:
curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
// елси проверятся откуда пришел пользователь, то указываем допустимый заголовок HTTP Referer:
curl_setopt ($ch, CURLOPT_REFERER, 'https://api.vk.com/method/wall.post');
// использовать метод POST
curl_setopt ($ch, CURLOPT_POST, 1);
// сохранять информацию Cookie в файл, чтобы потом можно было ее использовать
curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
// передаем поля формы
curl_setopt ($ch, CURLOPT_POSTFIELDS, 'owner_id=-'.$public.'&v=5.28&access_token='.$access_token.'&attachments='.$attachments.'&message='.$text);
// возвращать результат работы
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
// не проверять SSL сертификат
curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
// не проверять Host SSL сертификата
curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
// это необходимо, чтобы cURL не высылал заголовок на ожидание
curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Expect:'));
// выполнить запрос
curl_exec ($ch);
// получить результат работы
$result = curl_multi_getcontent ($ch);
// вывести результат
echo "\n".'Login OK'."\n".'[result ===8<===>'."\n".$result."\n".'<===>8=== result]'."<br/>\n";
echo "http://vk.com/public".$public."";
// закрыть сессию работы с cURL
curl_close ($ch);

?>
