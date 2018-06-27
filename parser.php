<?
require_once 'vendor/autoload.php';
use DiDom\Document;

$url = 'https://life.ru';

$str = new Document($url, true);


$re = '/(App.newsFeedPosts =) (.*)/';
preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
$result = strstr($matches[0][0], '[');
$result = trim($result,";");
$res = json_decode($result, true);
$i = 0;
$items = array();
while ($i <= 1) {
	// Save IMAGE 

$output = 'uploads/'.$res[$i]['id'].'.png';

	
file_put_contents($output, file_get_contents($res[$i]['image']['url']));

$htm = new Document();

$htm->loadHtmlFile($res[$i]['canonical_url'],LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
$data = $htm->find('.content-note');

$arrData['title'] = $res[$i]['title'];
$arrData['image'] = $res[$i]['id'].'.png';
$arrData['description'] = $res[$i]['subtitle'];
$arrData['content'] = $data[0]->html();

array_push($items, $arrData);

	?>
	 <article data-initial="feed-block" data-current="feed-block" class="news-feed-item feed-block with-image trending">

<img src="<?= 'uploads/'.$res[$i]['id'].'.png'; ?>">
  <?=  $res[$i]['title'];?>
  <?=  $res[$i]['description'];?>
  <?=  $res[$i]['content'];?>
</article> 
<?
	$i++;
}
print_r($items);
?>
