<?php

class ArticleController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
				'actions'=>array('index', 'view', 'detail', 'category', 'group'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('admin', 'create', 'update', 'delete'),
				'roles'=>array('superadmin', 'article_editor'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionView($id)
	{
		$this->layout = '//layouts/hnn-3col';

		$article = Article::model()->findByPk($id)->getAttributes();
		$article['lead_text'] = '';
//		$article['images'] = File::getImages($id, "hnn");

        $result = Comment::model()->findAllByAttributes(array('nid' => $article['id']), array('order' => 'timestamp desc'));
        $comments = array();
        foreach($result as $row)
            $comments[] = $row->getAttributes();

//        echo print_r($comments, true);

        $data = array('data' => array(
			'article' => $article,
            'legacy_comments' => $comments
		));

//		echo '<pre>'.print_r($article['images'], true).'</pre>';

		$this->render('detail', $data);
	}


	public function actionCategory($id)
	{
		$this->layout = '//layouts/hnn-3col';

		$data = array('data' => array(
			'articles' => Article::getArticleByCategory($id, array('limit' => 20)),
            'category' => Category::model()->findByPk($id)->getAttribute('name')
		));

		$this->render('category', $data);
	}


    public function actionGroup($id)
    {
        $this->layout = '//layouts/hnn-3col';

        $data = array('data' => array(
            'articles' => Article::getArticleByCategoryGroup($id, array('limit' => 20)),
            'category' => CategoryGroup::model()->findByPk($id)->getAttribute('name')
        ));

        $this->render('category', $data);
    }


    /**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView2($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Article;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Article']))
		{
			$model->attributes=$_POST['Article'];
			if($model->save())
            {
                File::saveUploadedImages($model);
				$this->redirect(array('view','id'=>$model->id));
            }
		}

        $user = User::model()->findByAttributes(array('mail' => Yii::app()->user->name));
        $categories = array();
        if(!empty($user->categories))
            foreach($user->categories as $category)
                $categories[$category->id] = $category->name;

		$this->render('create', array(
            'model' => $model,
            'user' => $user,
            'categories' => $categories,
		));
	}

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     * @throws CHttpException
     */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Article']))
		{
			$model->attributes=$_POST['Article'];
			if($model->save())
            {
                File::saveUploadedImages($model);
                if(!empty($_POST['delete_files']))
                    File::deleteFilesByPath($_POST['delete_files']);

//				$this->redirect(array('view','id'=>$model->id));
            }
		}

        $user = User::model()->findByAttributes(array('mail' => Yii::app()->user->name));
        $categories = array();
        if(!empty($user->categories))
            foreach($user->categories as $category)
                $categories[$category->id] = $category->name;

        $category_ids = array_keys($categories);
//        echo $model->category_id.' - '.print_r($category_ids, true);
        if(!in_array($model->category_id, $category_ids) && !empty($model->category_id)) {
            throw new CHttpException( 403, 'Forbidden!  You are not authorized to modify this article.' );
        }

        $this->render('update',array(
			'model'=>$model,
            'user' => $user,
            'categories' => $categories,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Article');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Article('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Article']))
			$model->attributes=$_GET['Article'];

        $user = User::model()->findByAttributes(array('mail' => Yii::app()->user->name));
        $categories = array();
        if(!empty($user->categories))
            foreach($user->categories as $category)
                $categories[$category->id] = $category->name;

        $this->render('admin', array(
            'model' => $model,
            'user' => $user,
            'categories' => $categories,
        ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Article the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Article::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
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
