
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

        echo "Sitemap Generator Tool - Web Version\r\n\r\n";


        //File handle
        $sFilename = "sitemap.hnn.us.xml";
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

        $aPage = Seo::getSitemapData();

        foreach ($aPage as $i => $aData)
        {
            echo $i."\n";

            $sContent = "<url>
                    <loc>".htmlspecialchars($aData['loc'], ENT_QUOTES, "UTF-8")."</loc>
                    <lastmod>{$aData['lastmod']}</lastmod>
                    <changefreq>{$aData['changefreq']}</changefreq>
                    <priority>{$aData['priority']}</priority>
                    </url>";

            unset($aData[$i]);
            fwrite($fh, $sContent);
        }


        echo "FINISHING .. .. \r\n\r\n";

        $sContent = "</urlset>";

        fwrite($fh, $sContent);
        fclose($fh);

        echo "[COMPLETE]\r\n\r\n";
    }
}



?>
