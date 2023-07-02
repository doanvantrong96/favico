<?php

namespace backend\components;

use Yii;
use yii\base\Component;
use yii\base\BaseObject;
use yii\queue\Job;
use backend\models\News;
use backend\models\Course;
use backend\models\CourseViewed;
use backend\models\NewsViewed;
use backend\models\LogView;
use common\models\MobileDetect;
class ProcessLogView extends BaseObject implements Job
{
    CONST TYPE_COURSE   = 1;
    CONST TYPE_NEWS     = 2;

    CONST SOURCE_WEB = 'WEB';
    CONST SOURCE_WAP = 'WAP';
    CONST SOURCE_APP = 'APP';
    
    public $id;//Mã khoá học, bài viết
    public $type;//Loại: 1: Khoá học / 2: Bài viết
    public $date;//Ngày add vào queue (Định dạng yyyy-mm-dd H:i:s)
    public $session_id;
    public $user_agent;
    public $ip_address;
    public $user_id;
    public $device_id;
    public $source;
    public $url;
    public $arrCate;

    public function execute($queue){
        echo '-------------Start ProcessView-------------' . PHP_EOL;
        $time_start     = microtime(true);
        try {
        $configLogView  = Yii::$app->params['log_view'];
        $error_code     = 1;
        $device_id      = $this->device_id;
        $source         = $this->source;
        $flagSaveLog    = true;
        //Nếu là bot quét bỏ qua không lưu dữ liệu
        if( ($this->user_agent && $this->isBot($this->user_agent)) || empty($this->session_id) )
            $flagSaveLog= false;
        if( $flagSaveLog ){
            if( !$this->source && $this->user_agent ){
                $detect     = new MobileDetect;
                $detect->setUserAgent($this->user_agent);
                $source     = $detect->isMobile() ? 'WAP' : 'WEB';
            }
            if( !$this->device_id && $this->user_agent ){
                $device_id  = $this->getOS($this->user_agent);
            }
            $minutes                = 0;
            if( $this->type === self::TYPE_NEWS )
                $minutes            = $configLogView['news_distance_time_check']/60;
            else if( $this->type === self::TYPE_COURSE )
                $minutes            = $configLogView['course_distance_time_check']/60;
            
            $last_time_check        = date('Y-m-d H:i:s', strtotime("- $minutes minutes", strtotime($this->date)));

            $lastViewOfSessionId    = LogView::find()->select('id')->where(['item_id'=> $this->id, 'type' => $this->type, 'error_code' => 0, 'session_id' => $this->session_id])->andWhere(['>=', 'created_at', $last_time_check])->one();
            
            if( !$lastViewOfSessionId )
                $error_code         = 0;
            
            $transaction = \Yii::$app->db->beginTransaction();

            $modelLog               = new LogView;
            $modelLog->item_id      = $this->id;
            $modelLog->type         = $this->type;
            $modelLog->created_at   = $this->date;
            $modelLog->user_id      = $this->user_id;
            $modelLog->url          = $this->url;
            $modelLog->session_id   = $this->session_id;
            $modelLog->ip_address   = $this->ip_address;
            $modelLog->source       = $source;
            $modelLog->user_agent   = $this->user_agent;
            $modelLog->device_id    = $device_id;
            $modelLog->error_code   = $error_code;

            $modelLog->save(false);

            if( $error_code == 0 ){
                $date_view          = date('Y-m-d', strtotime($this->date));
                if( $this->type === self::TYPE_NEWS ){
                    NewsViewed::saveNewsViewed($this->id, $date_view);
                    News::saveTotalView($this->id);
                }
                else if( $this->type === self::TYPE_COURSE ){
                    CourseViewed::saveCourseViewed($this->id, $date_view);
                    Course::saveTotalView($this->id);
                }
            }

            try {
                $transaction->commit();
            } catch(\Exception $e) {
                var_dump($e->getMessage());
                $this->writeLog('error_process_log_view',$e->getMessage());            
                $transaction->rollback();
            }
        }
    } catch(\Exception $e) {
        var_dump($e->getMessage());
    }
        $time_end     = microtime(true);
        echo 'Total time endcode: ' . ($time_end - $time_start) . PHP_EOL;
        echo '-------------End ProcessView-------------' . PHP_EOL;
    }


    public function getOS($user_agent) {
        
        $os_array = [
            'windows nt 10'                              =>  'Windows 10',
            'windows nt 6.3'                             =>  'Windows 8.1',
            'windows nt 6.2'                             =>  'Windows 8',
            'windows nt 6.1|windows nt 7.0'              =>  'Windows 7',
            'windows nt 6.0'                             =>  'Windows Vista',
            'windows nt 5.2'                             =>  'Windows Server 2003/XP x64',
            'windows nt 5.1'                             =>  'Windows XP',
            'windows xp'                                 =>  'Windows XP',
            'windows nt 5.0|windows nt5.1|windows 2000'  =>  'Windows 2000',
            'windows me'                                 =>  'Windows ME',
            'windows nt 4.0|winnt4.0'                    =>  'Windows NT',
            'windows ce'                                 =>  'Windows CE',
            'windows 98|win98'                           =>  'Windows 98',
            'windows 95|win95'                           =>  'Windows 95',
            'win16'                                      =>  'Windows 3.11',
            'mac os x 10.1[^0-9]'                        =>  'Mac OS X Puma',
            'macintosh|mac os x'                         =>  'Mac OS X',
            'mac_powerpc'                                =>  'Mac OS 9',
            'ubuntu'                                     =>  'Linux - Ubuntu',
            'iphone'                                     =>  'iPhone',
            'ipod'                                       =>  'iPod',
            'ipad'                                       =>  'iPad',
            'android'                                    =>  'Android',
            'blackberry'                                 =>  'BlackBerry',
            'webos'                                      =>  'Mobile',
            'linux'                                      =>  'Linux',
    
            '(media center pc).([0-9]{1,2}\.[0-9]{1,2})'=>'Windows Media Center',
            '(win)([0-9]{1,2}\.[0-9x]{1,2})'=>'Windows',
            '(win)([0-9]{2})'=>'Windows',
            '(windows)([0-9x]{2})'=>'Windows',
    
            // Doesn't seem like these are necessary...not totally sure though..
            //'(winnt)([0-9]{1,2}\.[0-9]{1,2}){0,1}'=>'Windows NT',
            //'(windows nt)(([0-9]{1,2}\.[0-9]{1,2}){0,1})'=>'Windows NT', // fix by bg
    
            'Win 9x 4.90'=>'Windows ME',
            '(windows)([0-9]{1,2}\.[0-9]{1,2})'=>'Windows',
            'win32'=>'Windows',
            '(java)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2})'=>'Java',
            '(Solaris)([0-9]{1,2}\.[0-9x]{1,2}){0,1}'=>'Solaris',
            'dos x86'=>'DOS',
            'Mac OS X'=>'Mac OS X',
            'Mac_PowerPC'=>'Macintosh PowerPC',
            '(mac|Macintosh)'=>'Mac OS',
            '(sunos)([0-9]{1,2}\.[0-9]{1,2}){0,1}'=>'SunOS',
            '(beos)([0-9]{1,2}\.[0-9]{1,2}){0,1}'=>'BeOS',
            '(risc os)([0-9]{1,2}\.[0-9]{1,2})'=>'RISC OS',
            'unix'=>'Unix',
            'os/2'=>'OS/2',
            'freebsd'=>'FreeBSD',
            'openbsd'=>'OpenBSD',
            'netbsd'=>'NetBSD',
            'irix'=>'IRIX',
            'plan9'=>'Plan9',
            'osf'=>'OSF',
            'aix'=>'AIX',
            'GNU Hurd'=>'GNU Hurd',
            '(fedora)'=>'Linux - Fedora',
            '(kubuntu)'=>'Linux - Kubuntu',
            '(ubuntu)'=>'Linux - Ubuntu',
            '(debian)'=>'Linux - Debian',
            '(CentOS)'=>'Linux - CentOS',
            '(Mandriva).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)'=>'Linux - Mandriva',
            '(SUSE).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)'=>'Linux - SUSE',
            '(Dropline)'=>'Linux - Slackware (Dropline GNOME)',
            '(ASPLinux)'=>'Linux - ASPLinux',
            '(Red Hat)'=>'Linux - Red Hat',
            // Loads of Linux machines will be detected as unix.
            // Actually, all of the linux machines I've checked have the 'X11' in the User Agent.
            //'X11'=>'Unix',
            '(linux)'=>'Linux',
            '(amigaos)([0-9]{1,2}\.[0-9]{1,2})'=>'AmigaOS',
            'amiga-aweb'=>'AmigaOS',
            'amiga'=>'Amiga',
            'AvantGo'=>'PalmOS',
            //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1}-([0-9]{1,2}) i([0-9]{1})86){1}'=>'Linux',
            //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1} i([0-9]{1}86)){1}'=>'Linux',
            //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1})'=>'Linux',
            '[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}'=>'Linux',
            '(webtv)/([0-9]{1,2}\.[0-9]{1,2})'=>'WebTV',
            'Dreamcast'=>'Dreamcast OS',
            'GetRight'=>'Windows',
            'go!zilla'=>'Windows',
            'gozilla'=>'Windows',
            'gulliver'=>'Windows',
            'ia archiver'=>'Windows',
            'NetPositive'=>'Windows',
            'mass downloader'=>'Windows',
            'microsoft'=>'Windows',
            'offline explorer'=>'Windows',
            'teleport'=>'Windows',
            'web downloader'=>'Windows',
            'webcapture'=>'Windows',
            'webcollage'=>'Windows',
            'webcopier'=>'Windows',
            'webstripper'=>'Windows',
            'webzip'=>'Windows',
            'wget'=>'Windows',
            'Java'=>'Unknown',
            'flashget'=>'Windows',
    
            // delete next line if the script show not the right OS
            //'(PHP)/([0-9]{1,2}.[0-9]{1,2})'=>'PHP',
            'MS FrontPage'=>'Windows',
            '(msproxy)/([0-9]{1,2}.[0-9]{1,2})'=>'Windows',
            '(msie)([0-9]{1,2}.[0-9]{1,2})'=>'Windows',
            'libwww-perl'=>'Unix',
            'UP.Browser'=>'Windows CE',
            'NetAnts'=>'Windows',
        ];
    
        $arch_regex = '/\b(x86_64|x86-64|Win64|WOW64|x64|ia64|amd64|ppc64|sparc64|IRIX64)\b/ix';
        $arch = preg_match($arch_regex, $user_agent) ? '64' : '32';
    
        foreach ($os_array as $regex => $value) {
            if (preg_match('{\b('.$regex.')\b}i', $user_agent)) {
                return $value.' x'.$arch;
            }
        }
    
        return 'Unknown';
    }
    public function writeLog($typeLog, $stringlog){
        try {
            $dir = __DIR__;
            $path = "logs/" . $typeLog;
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $timeWrite = date("Y_m_d");
            $fileName = $path . "/log." . $timeWrite . ".log";
            $fh = fopen($fileName, 'a+') or die("Can't create file");
            fwrite($fh, date('Y-m-d H:i:s', time()) . ": " . $stringlog . "\n");
            fclose($fh);
        } catch (Exception $e) {

        }
    }

    public function isBot($sistema){
        // bots de buscadores
           $bots = array(
                'Googlebot'
               , 'Baiduspider'
               , 'ia_archiver'
               , 'R6_FeedFetcher'
               , 'NetcraftSurveyAgent'
               , 'Sogou web spider'
               , 'bingbot'
               , 'Yahoo! Slurp'
               , 'facebookexternalhit'
               , 'PrintfulBot'
               , 'msnbot'
               , 'Twitterbot'
               , 'UnwindFetchor'
               , 'urlresolver'
               , 'Butterfly'
               , 'TweetmemeBot'
               , 'PaperLiBot'
               , 'MJ12bot'
               , 'AhrefsBot'
               , 'Exabot'
               , 'Ezooms'
               , 'YandexBot'
               , 'SearchmetricsBot'
               , 'picsearch'
               , 'TweetedTimes Bot'
               , 'QuerySeekerSpider'
               , 'ShowyouBot'
               , 'woriobot'
               , 'merlinkbot'
               , 'BazQuxBot'
               , 'Kraken'
               , 'SISTRIX Crawler'
               , 'R6_CommentReader'
               , 'magpie-crawler'
               , 'GrapeshotCrawler'
               , 'PercolateCrawler'
               , 'MaxPointCrawler'
               , 'R6_FeedFetcher'
               , 'NetSeer crawler'
               , 'grokkit-crawler'
               , 'SMXCrawler'
               , 'PulseCrawler'
               , 'Y!J-BRW'
               , '80legs'
               , 'Mediapartners-Google'
               , 'Spinn3r'
               , 'InAGist'
               , 'Python-urllib'
               , 'NING'
               , 'TencentTraveler'
               , 'Feedfetcher-Google'
               , 'mon.itor.us'
               , 'spbot'
               , 'Feedly'
               , 'bitlybot'
               , 'ADmantX'
               , 'Niki-Bot'
               , 'Pinterest'
               , 'python-requests'
               , 'DotBot'
               , 'HTTP_Request2'
               , 'linkdexbot'
               , 'A6-Indexer'
               , 'Baiduspider'
               , 'TwitterFeed'
               , 'Microsoft Office'
               , 'Pingdom'
               , 'BTWebClient'
               , 'KatBot'
               , 'SiteCheck'
               , 'proximic'
               , 'Sleuth'
               , 'Abonti'
               , '(BOT for JCE)'
               , 'Baidu'
               , 'Tiny Tiny RSS'
               , 'newsblur'
               , 'updown_tester'
               , 'linkdex'
               , 'baidu'
               , 'searchmetrics'
               , 'genieo'
               , 'majestic12'
               , 'spinn3r'
               , 'profound'
               , 'domainappender'
               , 'VegeBot'
               , 'terrykyleseoagency.com'
               , 'CommonCrawler Node'
               , 'AdlesseBot'
               , 'metauri.com'
               , 'libwww-perl'
               , 'rogerbot-crawler'
               , 'MegaIndex.ru'
               , 'ltx71'
               , 'Qwantify'
               , 'Traackr.com'
               , 'Re-Animator Bot'
               , 'Pcore-HTTP'
               , 'BoardReader'
               , 'omgili'
               , 'okhttp'
               , 'CCBot'
               , 'Java/1.8'
               , 'semrush.com'
               , 'feedbot'
               , 'CommonCrawler'
               , 'AdlesseBot'
               , 'MetaURI'
               , 'ibwww-perl'
               , 'rogerbot'
               , 'MegaIndex'
               , 'BLEXBot'
               , 'FlipboardProxy'
               , 'techinfo@ubermetrics-technologies.com'
               , 'trendictionbot'
               , 'Mediatoolkitbot'
               , 'trendiction'
               , 'ubermetrics'
               , 'ScooperBot'
               , 'TrendsmapResolver'
               , 'Nuzzel'
               , 'Go-http-client'
               , 'Applebot'
               , 'LivelapBot'
               , 'GroupHigh'
               , 'SemrushBot'
               , 'ltx71'
               , 'commoncrawl'
               , 'istellabot'
               , 'DomainCrawler'
               , 'cs.daum.net'
               , 'StormCrawler'
               , 'GarlikCrawler'
               , 'The Knowledge AI'
               , 'getstream.io/winds'
               , 'YisouSpider'
               , 'archive.org_bot'
               , 'semantic-visions.com'
               , 'FemtosearchBot'
               , '360Spider'
               , 'linkfluence.com'
               , 'glutenfreepleasure.com'
               , 'Gluten Free Crawler'
               , 'YaK/1.0'
               , 'Cliqzbot'
               , 'app.hypefactors.com'
               , 'axios'
               , 'semantic-visions.com'
               , 'webdatastats.com'
               , 'schmorp.de'
               , 'SEOkicks'
               , 'DuckDuckBot'
               , 'Barkrowler'
               , 'ZoominfoBot'
               , 'Linguee Bot'
               , 'Mail.RU_Bot'
               , 'OnalyticaBot'
               , 'Linguee Bot'
               , 'admantx-adform'
               , 'Buck/2.2'
               , 'Barkrowler'
               , 'Zombiebot'
               , 'Nutch'
               , 'SemanticScholarBot'
               , 'Jetslide'
               , 'scalaj-http'
               , 'XoviBot'
               , 'sysomos.com'
               , 'PocketParser'
               , 'newspaper'
               , 'serpstatbot'
               , 'MetaJobBot'
               , 'SeznamBot/3.2'
               , 'VelenPublicWebCrawler/1.0'
               , 'WordPress.com mShots'
               , 'adscanner'
               , 'BacklinkCrawler'
               , 'netEstate NE Crawler'
               , 'Astute SRM'
               , 'GigablastOpenSource/1.0'
               , 'DomainStatsBot'
               , 'Winds: Open Source RSS & Podcast'
               , 'dlvr.it'
               , 'BehloolBot'
               , '7Siters'
               , 'AwarioSmartBot'
               , 'Apache-HttpClient/5'
               , 'Seekport Crawler'
               , 'AHC/2.1'
               , 'eCairn-Grabber'
               , 'mediawords bot'
               , 'PHP-Curl-Class'
               , 'Scrapy'
               , 'curl/7'
               , 'Blackboard'
               , 'NetNewsWire'
               , 'node-fetch'
               , 'admantx'
               , 'metadataparser'
               , 'Domains Project'
               , 'SerendeputyBot'
               , 'Moreover'
               , 'DuckDuckGo' 
               , 'monitoring-plugins'
               , 'Selfoss'
               , 'Adsbot'
               , 'acebookexternalhit'
               , 'SpiderLing'
               , 'Cocolyzebot'
               , 'AhrefsBot'
               , 'TTD-Content'
               , 'superfeedr'
               , 'Twingly'
               , 'Google-Apps-Scrip'
               , 'LinkpadBot'
               , 'CensysInspect'
               , 'Reeder'
               , 'tweetedtimes'
               , 'Amazonbot'
               , 'MauiBot'
               , 'Symfony BrowserKit'
               , 'DataForSeoBot'
               , 'GoogleProducer'
               , 'TinEye-bot-live'
               , 'sindresorhus/got'
               , 'CriteoBot'
               , 'Down/5'
               , 'Yahoo Ad monitoring'
               , 'MetaInspector'
               , 'PetalBot'
               , 'MetadataScraper'
               , 'Cloudflare SpeedTest'
               , 'CriteoBot'
               , 'aiohttp'
               , 'AppEngine-Google'
               , 'heritrix'
               , 'sqlmap'
               , 'Buck'
               , 'MJ12bot'
               , 'wp_is_mobile'
               , 'SerendeputyBot'
               , '01h4x.com'
               , '404checker'
               , '404enemy'
               , 'AIBOT'
               , 'ALittle Client'
               , 'ASPSeek'
               , 'Aboundex'
               , 'Acunetix'
               , 'AfD-Verbotsverfahren'
               , 'AiHitBot'
               , 'Aipbot'
               , 'Alexibot'
               , 'AllSubmitter'
               , 'Alligator'
               , 'AlphaBot'
               , 'Anarchie'
               , 'Anarchy'
               , 'Anarchy99'
               , 'Ankit'
               , 'Anthill'
               , 'Apexoo'
               , 'Aspiegel'
               , 'Asterias'
               , 'Atomseobot'
               , 'Attach'
               , 'AwarioRssBot'
               , 'BBBike'
               , 'BDCbot'
               , 'BDFetch'
               , 'BackDoorBot'
               , 'BackStreet'
               , 'BackWeb'
               , 'Backlink-Ceck'
               , 'BacklinkCrawler'
               , 'Badass'
               , 'Bandit'
               , 'Barkrowler'
               , 'BatchFTP'
               , 'Battleztar Bazinga'
               , 'BetaBot'
               , 'Bigfoot'
               , 'Bitacle'
               , 'BlackWidow'
               , 'Black Hole'
               , 'Blackboard'
               , 'Blow'
               , 'BlowFish'
               , 'Boardreader'
               , 'Bolt'
               , 'BotALot'
               , 'Brandprotect'
               , 'Brandwatch'
               , 'Buck'
               , 'Buddy'
               , 'BuiltBotTough'
               , 'BuiltWith'
               , 'Bullseye'
               , 'BunnySlippers'
               , 'BuzzSumo'
               , 'CATExplorador'
               , 'CCBot'
               , 'CODE87'
               , 'CSHttp'
               , 'Calculon'
               , 'CazoodleBot'
               , 'Cegbfeieh'
               , 'CensysInspect'
               , 'CheTeam'
               , 'CheeseBot'
               , 'CherryPicker'
               , 'ChinaClaw'
               , 'Chlooe'
               , 'Citoid'
               , 'Claritybot'
               , 'Cliqzbot'
               , 'Cloud mapping'
               , 'Cocolyzebot'
               , 'Cogentbot'
               , 'Collector'
               , 'Copier'
               , 'CopyRightCheck'
               , 'Copyscape'
               , 'Cosmos'
               , 'Craftbot'
               , 'Crawling at Home Project'
               , 'CrazyWebCrawler'
               , 'Crescent'
               , 'CrunchBot'
               , 'Curious'
               , 'Custo'
               , 'CyotekWebCopy'
               , 'DBLBot'
               , 'DIIbot'
               , 'DSearch'
               , 'DTS Agent'
               , 'DataCha0s'
               , 'DatabaseDriverMysqli'
               , 'Demon'
               , 'Deusu'
               , 'Devil'
               , 'Digincore'
               , 'DigitalPebble'
               , 'Dirbuster'
               , 'Disco'
               , 'Discobot'
               , 'Discoverybot'
               , 'Dispatch'
               , 'DittoSpyder'
               , 'DnBCrawler-Analytics'
               , 'DnyzBot'
               , 'DomCopBot'
               , 'DomainAppender'
               , 'DomainCrawler'
               , 'DomainSigmaCrawler'
               , 'DomainStatsBot'
               , 'Domains Project'
               , 'Dotbot'
               , 'Download Wonder'
               , 'Dragonfly'
               , 'Drip'
               , 'ECCP/1.0'
               , 'EMail Siphon'
               , 'EMail Wolf'
               , 'EasyDL'
               , 'Ebingbong'
               , 'Ecxi'
               , 'EirGrabber'
               , 'EroCrawler'
               , 'Evil'
               , 'Exabot'
               , 'Express WebPictures'
               , 'ExtLinksBot'
               , 'Extractor'
               , 'ExtractorPro'
               , 'Extreme Picture Finder'
               , 'EyeNetIE'
               , 'Ezooms'
               , 'FDM'
               , 'FHscan'
               , 'FemtosearchBot'
               , 'Fimap'
               , 'Firefox/7.0'
               , 'FlashGet'
               , 'Flunky'
               , 'Foobot'
               , 'Freeuploader'
               , 'FrontPage'
               , 'Fuzz'
               , 'FyberSpider'
               , 'Fyrebot'
               , 'G-i-g-a-b-o-t'
               , 'GT::WWW'
               , 'GalaxyBot'
               , 'Genieo'
               , 'GermCrawler'
               , 'GetRight'
               , 'GetWeb'
               , 'Getintent'
               , 'Gigabot'
               , 'Go!Zilla'
               , 'Go-Ahead-Got-It'
               , 'GoZilla'
               , 'Gotit'
               , 'GrabNet'
               , 'Grabber'
               , 'Grafula'
               , 'GrapeFX'
               , 'GrapeshotCrawler'
               , 'GridBot'
               , 'HEADMasterSEO'
               , 'HMView'
               , 'HTMLparser'
               , 'HTTP::Lite'
               , 'HTTrack'
               , 'Haansoft'
               , 'HaosouSpider'
               , 'Harvest'
               , 'Havij'
               , 'Heritrix'
               , 'Hloader'
               , 'HonoluluBot'
               , 'Humanlinks'
               , 'HybridBot'
               , 'IDBTE4M'
               , 'IDBot'
               , 'IRLbot'
               , 'Iblog'
               , 'Id-search'
               , 'IlseBot'
               , 'Image Fetch'
               , 'Image Sucker'
               , 'IndeedBot'
               , 'Indy Library'
               , 'InfoNaviRobot'
               , 'InfoTekies'
               , 'Intelliseek'
               , 'InterGET'
               , 'InternetSeer'
               , 'Internet Ninja'
               , 'Iria'
               , 'Iskanie'
               , 'IstellaBot'
               , 'JOC Web Spider'
               , 'JamesBOT'
               , 'Jbrofuzz'
               , 'JennyBot'
               , 'JetCar'
               , 'Jetty'
               , 'JikeSpider'
               , 'Joomla'
               , 'Jorgee'
               , 'JustView'
               , 'Jyxobot'
               , 'Kenjin Spider'
               , 'Keybot Translation-Search-Machine'
               , 'Keyword Density'
               , 'Kinza'
               , 'Kozmosbot'
               , 'LNSpiderguy'
               , 'LWP::Simple'
               , 'Lanshanbot'
               , 'Larbin'
               , 'Leap'
               , 'LeechFTP'
               , 'LeechGet'
               , 'LexiBot'
               , 'Lftp'
               , 'LibWeb'
               , 'Libwhisker'
               , 'LieBaoFast'
               , 'Lightspeedsystems'
               , 'Likse'
               , 'LinkScan'
               , 'LinkWalker'
               , 'Linkbot'
               , 'LinkextractorPro'
               , 'LinkpadBot'
               , 'LinksManager'
               , 'LinqiaMetadataDownloaderBot'
               , 'LinqiaRSSBot'
               , 'LinqiaScrapeBot'
               , 'Lipperhey'
               , 'Lipperhey Spider'
               , 'Litemage_walker'
               , 'Lmspider'
               , 'Ltx71'
               , 'MFC_Tear_Sample'
               , 'MIDown tool'
               , 'MIIxpc'
               , 'MJ12bot'
               , 'MQQBrowser'
               , 'MSFrontPage'
               , 'MSIECrawler'
               , 'MTRobot'
               , 'Mag-Net'
               , 'Magnet'
               , 'Mail.RU_Bot'
               , 'Majestic-SEO'
               , 'Majestic12'
               , 'Majestic SEO'
               , 'MarkMonitor'
               , 'MarkWatch'
               , 'Mass Downloader'
               , 'Masscan'
               , 'Mata Hari'
               , 'MauiBot'
               , 'Mb2345Browser'
               , 'MeanPath Bot'
               , 'Meanpathbot'
               , 'Mediatoolkitbot'
               , 'MegaIndex.ru'
               , 'Metauri'
               , 'MicroMessenger'
               , 'Microsoft Data Access'
               , 'Microsoft URL Control'
               , 'Minefield'
               , 'Mister PiX'
               , 'Moblie Safari'
               , 'Mojeek'
               , 'Mojolicious'
               , 'MolokaiBot'
               , 'Morfeus Fucking Scanner'
               , 'Mozlila'
               , 'Mr.4x3'
               , 'Msrabot'
               , 'Musobot'
               , 'NICErsPRO'
               , 'NPbot'
               , 'Name Intelligence'
               , 'Nameprotect'
               , 'Navroad'
               , 'NearSite'
               , 'Needle'
               , 'Nessus'
               , 'NetAnts'
               , 'NetLyzer'
               , 'NetMechanic'
               , 'NetSpider'
               , 'NetZIP'
               , 'Net Vampire'
               , 'Netcraft'
               , 'Nettrack'
               , 'Netvibes'
               , 'NextGenSearchBot'
               , 'Nibbler'
               , 'Niki-bot'
               , 'Nikto'
               , 'NimbleCrawler'
               , 'Nimbostratus'
               , 'Ninja'
               , 'Nmap'
               , 'Not'
               , 'Nuclei'
               , 'Nutch'
               , 'Octopus'
               , 'Offline Explorer'
               , 'Offline Navigator'
               , 'OnCrawl'
               , 'OpenLinkProfiler'
               , 'OpenVAS'
               , 'Openfind'
               , 'Openvas'
               , 'OrangeBot'
               , 'OrangeSpider'
               , 'OutclicksBot'
               , 'OutfoxBot'
               , 'PECL::HTTP'
               , 'PHPCrawl'
               , 'POE-Component-Client-HTTP'
               , 'PageAnalyzer'
               , 'PageGrabber'
               , 'PageScorer'
               , 'PageThing.com'
               , 'Page Analyzer'
               , 'Pandalytics'
               , 'Panscient'
               , 'Papa Foto'
               , 'Pavuk'
               , 'PeoplePal'
               , 'Petalbot'
               , 'Pi-Monster'
               , 'Picscout'
               , 'Picsearch'
               , 'PictureFinder'
               , 'Piepmatz'
               , 'Pimonster'
               , 'Pixray'
               , 'PleaseCrawl'
               , 'Pockey'
               , 'ProPowerBot'
               , 'ProWebWalker'
               , 'Probethenet'
               , 'Psbot'
               , 'Pu_iN'
               , 'Pump'
               , 'PxBroker'
               , 'PyCurl'
               , 'QueryN Metasearch'
               , 'Quick-Crawler'
               , 'RSSingBot'
               , 'RankActive'
               , 'RankActiveLinkBot'
               , 'RankFlex'
               , 'RankingBot'
               , 'RankingBot2'
               , 'Rankivabot'
               , 'RankurBot'
               , 'Re-re'
               , 'ReGet'
               , 'RealDownload'
               , 'Reaper'
               , 'RebelMouse'
               , 'Recorder'
               , 'RedesScrapy'
               , 'RepoMonkey'
               , 'Ripper'
               , 'RocketCrawler'
               , 'Rogerbot'
               , 'SBIder'
               , 'SEOkicks'
               , 'SEOkicks-Robot'
               , 'SEOlyticsCrawler'
               , 'SEOprofiler'
               , 'SEOstats'
               , 'SISTRIX'
               , 'SMTBot'
               , 'SalesIntelligent'
               , 'ScanAlert'
               , 'Scanbot'
               , 'ScoutJet'
               , 'Scrapy'
               , 'Screaming'
               , 'ScreenerBot'
               , 'ScrepyBot'
               , 'Searchestate'
               , 'SearchmetricsBot'
               , 'Seekport'
               , 'SemanticJuice'
               , 'Semrush'
               , 'SemrushBot'
               , 'SentiBot'
               , 'SeoSiteCheckup'
               , 'SeobilityBot'
               , 'Seomoz'
               , 'Shodan'
               , 'Siphon'
               , 'SiteCheckerBotCrawler'
               , 'SiteExplorer'
               , 'SiteLockSpider'
               , 'SiteSnagger'
               , 'SiteSucker'
               , 'Site Sucker'
               , 'Sitebeam'
               , 'Siteimprove'
               , 'Sitevigil'
               , 'SlySearch'
               , 'SmartDownload'
               , 'Snake'
               , 'Snapbot'
               , 'Snoopy'
               , 'SocialRankIOBot'
               , 'Sociscraper'
               , 'Sogou web spider'
               , 'Sosospider'
               , 'Sottopop'
               , 'SpaceBison'
               , 'Spammen'
               , 'SpankBot'
               , 'Spanner'
               , 'Spbot'
               , 'Spinn3r'
               , 'SputnikBot'
               , 'Sqlmap'
               , 'Sqlworm'
               , 'Sqworm'
               , 'Steeler'
               , 'Stripper'
               , 'Sucker'
               , 'Sucuri'
               , 'SuperBot'
               , 'SuperHTTP'
               , 'Surfbot'
               , 'SurveyBot'
               , 'Suzuran'
               , 'Swiftbot'
               , 'Szukacz'
               , 'T0PHackTeam'
               , 'T8Abot'
               , 'Teleport'
               , 'TeleportPro'
               , 'Telesoft'
               , 'Telesphoreo'
               , 'Telesphorep'
               , 'TheNomad'
               , 'The Intraformant'
               , 'Thumbor'
               , 'TightTwatBot'
               , 'Titan'
               , 'Toata'
               , 'Toweyabot'
               , 'Tracemyfile'
               , 'Trendiction'
               , 'Trendictionbot'
               , 'True_Robot'
               , 'Turingos'
               , 'Turnitin'
               , 'TurnitinBot'
               , 'TwengaBot'
               , 'Twice'
               , 'Typhoeus'
               , 'URLy.Warning'
               , 'URLy Warning'
               , 'UnisterBot'
               , 'Upflow'
               , 'V-BOT'
               , 'VB Project'
               , 'VCI'
               , 'Vacuum'
               , 'Vagabondo'
               , 'VelenPublicWebCrawler'
               , 'VeriCiteCrawler'
               , 'VidibleScraper'
               , 'Virusdie'
               , 'VoidEYE'
               , 'Voil'
               , 'Voltron'
               , 'WASALive-Bot'
               , 'WBSearchBot'
               , 'WEBDAV'
               , 'WISENutbot'
               , 'WPScan'
               , 'WWW-Collector-E'
               , 'WWW-Mechanize'
               , 'WWW::Mechanize'
               , 'WWWOFFLE'
               , 'Wallpapers'
               , 'Wallpapers/3.0'
               , 'WallpapersHD'
               , 'WeSEE'
               , 'WebAuto'
               , 'WebBandit'
               , 'WebCollage'
               , 'WebCopier'
               , 'WebEnhancer'
               , 'WebFetch'
               , 'WebFuck'
               , 'WebGo IS'
               , 'WebImageCollector'
               , 'WebLeacher'
               , 'WebPix'
               , 'WebReaper'
               , 'WebSauger'
               , 'WebStripper'
               , 'WebSucker'
               , 'WebWhacker'
               , 'WebZIP'
               , 'Web Auto'
               , 'Web Collage'
               , 'Web Enhancer'
               , 'Web Fetch'
               , 'Web Fuck'
               , 'Web Pix'
               , 'Web Sauger'
               , 'Web Sucker'
               , 'Webalta'
               , 'WebmasterWorldForumBot'
               , 'Webshag'
               , 'WebsiteExtractor'
               , 'WebsiteQuester'
               , 'Website Quester'
               , 'Webster'
               , 'Whack'
               , 'Whacker'
               , 'Whatweb'
               , 'Who.is Bot'
               , 'Widow'
               , 'WinHTTrack'
               , 'WiseGuys Robot'
               , 'Wonderbot'
               , 'Woobot'
               , 'Wotbox'
               , 'Wprecon'
               , 'Xaldon WebSpider'
               , 'Xaldon_WebSpider'
               , 'Xenu'
               , 'YoudaoBot'
               , 'Zade'
               , 'Zauba'
               , 'Zermelo'
               , 'Zeus'
               , 'Zitebot'
               , 'ZmEu'
               , 'ZoomBot'
               , 'ZoominfoBot'
               , 'ZumBot'
               , 'ZyBorg'
               , 'adscanner'
               , 'archive.org_bot'
               , 'arquivo-web-crawler'
               , 'arquivo.pt'
               , 'autoemailspider'
               , 'backlink-check'
               , 'cah.io.community'
               , 'check1.exe'
               , 'clark-crawler'
               , 'coccocbot'
               , 'cognitiveseo'
               , 'com.plumanalytics'
               , 'crawl.sogou.com'
               , 'crawler.feedback'
               , 'crawler4j'
               , 'dataforseo.com'
               , 'demandbase-bot'
               , 'domainsproject.org'
               , 'eCatch'
               , 'evc-batch'
               , 'facebookscraper'
               , 'gopher'
               , 'heritrix'
               , 'instabid'
               , 'internetVista monitor'
               , 'ips-agent'
               , 'isitwp.com'
               , 'iubenda-radar'
               , 'linkdexbot'
               , 'lwp-request'
               , 'lwp-trivial'
               , 'magpie-crawler'
               , 'meanpathbot'
               , 'mediawords'
               , 'muhstik-scan'
               , 'netEstate NE Crawler'
               , 'oBot'
               , 'page scorer'
               , 'pcBrowser'
               , 'plumanalytics'
               , 'polaris version'
               , 'probe-image-size'
               , 'ripz'
               , 's1z.ru'
               , 'satoristudio.net'
               , 'scalaj-http'
               , 'scan.lol'
               , 'seobility'
               , 'seocompany.store'
               , 'seoscanners'
               , 'seostar'
               , 'serpstatbot'
               , 'sexsearcher'
               , 'sitechecker.pro'
               , 'siteripz'
               , 'sogouspider'
               , 'sp_auditbot'
               , 'spyfu'
               , 'sysscan'
               , 'tAkeOut'
               , 'trendiction.com'
               , 'trendiction.de'
               , 'ubermetrics-technologies.com'
               , 'voyagerx.com'
               , 'webgains-bot'
               , 'webmeup-crawler'
               , 'webpros.com'
               , 'webprosbot'
               , 'x09Mozilla'
               , 'x22Mozilla'
               , 'xpymep1.exe'
               , 'zauba.io'
               , 'zgrab'
               , 'TelegramBot'
       
               );
       
        
           foreach($bots as $b){
                if( stripos( $sistema, $b ) !== false ){
                    return true;
                    break;
                }
            }
           return false;
       }
       
}
