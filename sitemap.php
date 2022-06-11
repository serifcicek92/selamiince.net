<?php
header('Content-type: application/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>';
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors',1);
set_include_path('/home/cfjselam/public_html');
require_once 'system/define.php';
require_once INCLUDEPATH.'/system/Application.php';
require_once INCLUDEPATH.'/system/Router.php';
require_once INCLUDEPATH.'/system/View.php';
require_once INCLUDEPATH.'/system/Controller.php';
require_once INCLUDEPATH.'/system/Database.php';
require_once INCLUDEPATH.'/system/Model.php';
require_once INCLUDEPATH.'/system/functions.php';
require_once INCLUDEPATH.'/helper/SimpleImage.php';

require_once INCLUDEPATH.'/app/models/propertieModel.php';
require_once INCLUDEPATH.'/app/models/userModel.php';
require_once INCLUDEPATH.'/app/models/medyaModel.php';
require_once INCLUDEPATH.'/app/models/kombodegerleriModel.php';
use App\System\Application;
$app = new Application();

$properties = Application::$app->propertie->get(null);

$maxdate = max(array_map(function($properties)  { return $properties['eklemezamani']; }, $properties));
?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<!-- created with Free Online Sitemap Generator www.xml-sitemaps.com -->


<url>
  <loc>http://selamiince.net/</loc>
  <lastmod><?php echo (new \Datetime($maxdate))->format('c'); ?></lastmod>
</url>
<url>
  <loc>http://selamiince.net/anasayfa</loc>
  <lastmod><?php echo (new \Datetime($maxdate))->format('c'); ?></lastmod>
</url>
<url>
  <loc>http://selamiince.net/emlak-danismaniniz-hakkinda</loc>
  <lastmod>2022-06-08T12:58:26+00:00</lastmod>
</url>
<url>
  <loc>http://selamiince.net/emlak/satilik</loc>
  <lastmod><?php echo (new \Datetime($maxdate))->format('c'); ?></lastmod>
</url>
<url>
  <loc>http://selamiince.net/emlak/kiralik</loc>
  <lastmod><?php echo (new \Datetime($maxdate))->format('c'); ?></lastmod>
</url>
<url>
  <loc>http://selamiince.net/iletisim</loc>
  <lastmod>2022-06-08T12:58:26+00:00</lastmod>
</url>
<?php foreach ($properties as $propertie): ?>
<url>
  <loc>http://selamiince.net/gayrimenkul/<?php echo $propertie["id"]; ?></loc>
  <lastmod><?php echo (new \Datetime($propertie["eklemezamani"]))->format('c'); ?></lastmod>
</url>
<?php endforeach; ?>
</urlset>