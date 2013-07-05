<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public $layout='//layouts/column2';

	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->layout = '//layouts/hnn-3col';

		$data = array('data' => array(
			'recent_articles' => Article::getMostRecentArticles(15)
		));

		$this->render('index', $data);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionMoved()
	{
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: http://www.New-Website.com");


    }

    private function checkLegacyUrls()
    {
        $request_uri = substr($_SERVER['REQUEST_URI'], 1);

        $matches = array();
        preg_match('/node\/([0-9]+)/', $request_uri, $matches);
        if(!empty($matches))
        {
            $id = $matches[1];
            $article = Article::model()->findbyPk($id);
            if(!empty($article) and $article->getAttribute('created') < strtotime('7/1/2013'))
                $this->redirect301("article/{$id}");

            $blog = Blog::model()->findbyPk($id);
            if(!empty($blog) and $blog->getAttribute('created') < strtotime('7/1/2013'))
                $this->redirect301("blog/{$id}");
        }

        $matches = array();
        preg_match('/articles\/([0-9]+)\.html/', $request_uri, $matches);
        if(!empty($matches))
        {
            $id = $matches[1];
            $article = Article::model()->findbyPk($id);
            if(!empty($article))
                $this->redirect301("article/{$id}");
        }

        $matches = array();
        preg_match('/blogs\/entries\/([0-9]+)\.html/', $request_uri, $matches);
        if(!empty($matches))
        {
            $id = $matches[1];
            $article = Blog::model()->findbyPk($id);
            if(!empty($article))
                $this->redirect301("blog/{$id}");
        }

        $result = SeoUrlAlias::model()->findByAttributes(array('alias' => $request_uri));
        if(!empty($result))
        {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: http://{$_SERVER['HTTP_HOST']}/{$result->getAttribute('path')}");
        }
    }
    private function redirect301($path)
    {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: http://{$_SERVER['HTTP_HOST']}/{$path}");
    }

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
            if($error['code'] == 404)
            {
                $this->checkLegacyUrls();
            }

			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$this->layout = '//layouts/hnn-3col';

		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}