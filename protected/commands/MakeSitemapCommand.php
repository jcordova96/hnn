<?php
/**
 * User: dataskills dataskills@gmail.com
 * Date: 7/7/13
 * Time: 9:14 PM
 */

class MakeSitemapCommand extends CConsoleCommand
{
    public function getHelp()
    {
        echo "Make Sitemap program";
        echo "\r\n\r\n";
    }

    public function run($args)
    {
        echo "\r\nProcess running\r\n\r\n";
        $this->process();
    }

    public function process()
    {

        echo "{$_SERVER['HTTP_HOST']} - Sitemap Generator Tool - Web Version\r\n\r\n";


        $sPathToRoot = "";
        $sLastMod = date("Y-m-d", strtotime("now"));


        //File handle
        $sFilename = "sitemap.{$_SERVER['HTTP_HOST']}.xml";
        $sFilename = str_replace(array(".loc", ".com"), "", $sFilename);

        $aSitemap[] = $sFilename;

        //Erase old file
        if (file_exists($sFilename))
        {
            if (!unlink($sFilename))
            {
                die("Old file deletion did not work. Check permissions.\r\n\r\n");
            }
        }

        $fh = fopen($sFilename, "a+");

        echo "===== Trying to create {$sFilename} =====\r\n\r\n";

        if (!$fh)
        {
            die("File handle did not work. Check permissions.\r\n\r\n");
        }

        //Content begin
        echo "Begin Write ... \r\n\r\n";

        $sContent = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
        $sContent .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
        fwrite($fh, $sContent);

        //Put something HERE to fetch page info to make $aPage array

        /*
        $aPage should have the page url as the key and priority as the value. "0.5" is default priority,
        "1.0" is maximum priority. The priority should be seo importance priority. Example: array("articles/1029"=>"0.8")
        */
        $aPage = array();


        foreach ($aPage as $sPageName => $sPriority)
        {
            $sContent .= "<url>
                    <loc>" . htmlspecialchars("http://{$_SERVER['HTTP_HOST']}/{$sPageName}", ENT_QUOTES, "UTF-8") . "</loc>
                    <lastmod>{$sLastMod}</lastmod>
                    <changefreq>monthly</changefreq>
                    <priority>{$sPriority}</priority>
                    </url>";
        }
        fwrite($fh, $sContent);


        echo "FINISHING .. .. \r\n\r\n";

        $sContent = "</urlset>";

        fwrite($fh, $sContent);
        fclose($fh);

        echo "[COMPLETE]\r\n\r\n";
    }
}

?>
