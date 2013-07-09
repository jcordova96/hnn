<?php
/**
 * User: dataskills dataskills@gmail.com
 * Date: 7/8/13
 * Time: 5:46 PM
 *
 * All this does is render static pages; it goes along with the route rules '<alias>' => 'website/page' as found in config/main.php
 */
class WebsiteController extends CController
{
    public $layout = '//layouts/hnn-3col';

    public function actionPage($alias)
    {
        $this->render('//site/pages/' . $alias, array());
    }
}