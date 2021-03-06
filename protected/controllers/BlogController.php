<?php

class BlogController extends Controller
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
				'actions'=>array('index','view','detail','author'),
				'users'=>array('*'),
			),
            array('allow',
                'actions'=>array('admin', 'create', 'update', 'delete'),
                'roles'=>array('superadmin', 'blog_author'),
            ),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	public function actionView($id)
	{
		$this->layout = '//layouts/hnn-2col';

		$blog = Blog::model()->findByPk($id)->getAttributes();
		$blog['lead_text'] = '';
//		$blog['images'] = Blog::getBlogImages($id);

		$data = array('data' => array(
			'blog' => $blog
		));

//		echo '<pre>'.print_r($blog['images'], true).'</pre>';

		$this->render('detail', $data);
	}


	public function actionAuthor($id)
	{
		$this->layout = '//layouts/hnn-3col';

		$data = array('data' => array(
			'blog_entries' => Blog::getBlogByAuthor($id)
		));

		$this->render('author', $data);
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
		$model=new Blog;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Blog']))
		{
			$model->attributes=$_POST['Blog'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

        $user = User::model()->findByAttributes(array('mail' => Yii::app()->user->name));
        $blog_authors = array();
        if(!empty($user->blog_authors))
            foreach($user->blog_authors as $blog_author)
                $blog_authors[$blog_author->id] = $blog_author->author;

        $this->render('create',array(
			'model'=>$model,
            'user' => $user,
            'blog_authors' => $blog_authors,
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

		if(isset($_POST['Blog']))
		{
			$model->attributes=$_POST['Blog'];
			if($model->save())
            {
//				$this->redirect(array('view','id'=>$model->id));
            }
		}

        $user = User::model()->findByAttributes(array('mail' => Yii::app()->user->name));
        $blog_authors = array();
        if(!empty($user->blog_authors))
            foreach($user->blog_authors as $blog_author)
                $blog_authors[$blog_author->id] = $blog_author->author;

        $blog_author_ids = array_keys($blog_authors);
        if(!in_array($model->author_id, $blog_author_ids) && !empty($model->author_id)) {
            throw new CHttpException( 403, 'Forbidden!  You are not authorized to modify this blog entry.' );
        }

        $this->render('update',array(
            'model'=>$model,
            'user' => $user,
            'blog_authors' => $blog_authors,
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
		$dataProvider=new CActiveDataProvider('Blog');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Blog('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Blog']))
			$model->attributes=$_GET['Blog'];

        $user = User::model()->findByAttributes(array('mail' => Yii::app()->user->name));
        $blog_authors = array();
        if(!empty($user->blog_authors))
            foreach($user->blog_authors as $blog_author)
                $blog_authors[$blog_author->id] = $blog_author->author;

        $this->render('admin',array(
            'model'=>$model,
            'user' => $user,
            'blog_authors' => $blog_authors,
        ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Blog the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Blog::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Blog $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='blog-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
