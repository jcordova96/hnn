<?php

class SearchController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column1';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index'),
                'users'=>array('*'),
            ),
            array('allow',
                'actions'=>array('admin', 'create', 'update', 'delete'),
                'roles'=>array('superadmin'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }


    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $q = urlencode($_GET['q']);
        $start = (isset($_GET['start'])) ? $_GET['start'] : 0;
        $nocache = 1372411994570;
        $api_req_url = "https://www.googleapis.com/customsearch/v1element?key=AIzaSyCVAXiUzRYsML1Pv6RwSG1gunmMikTzQqY&rsz=filtered_cse&num=10&hl=en&prettyPrint=false&cx=005019620910017069515:x5b3q1brjny&q={$q}&safe=active&googlehost=www.google.com&nocache={$nocache}&start={$start}";

        $result = json_decode(file_get_contents($api_req_url));

//        echo "<pre>".print_r($result, true)."</pre>";

        $this->render('index', array('data' => array(
                'results' => $result,
                'q' => $q
            )
        ));
    }


    /**
     * Performs the AJAX validation.
     * @param Article $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='article-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}

