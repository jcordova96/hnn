<?php

/**
 * This is the model class for table "file".
 *
 * The followings are the available columns in table 'file':
 * @property string $id
 * @property string $nid
 * @property string $filename
 * @property string $filepath
 * @property string $filemime
 * @property string $filesize
 * @property string $type
 * @property string $timestamp
 */
class File extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return File the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'file';
	}

	public static function saveUploadedImages($model)
	{
        $uploaded_files = CUploadedFile::getInstances($model, 'file');
//                echo "<pre>".print_r($uploaded_files, true)."</pre>";
        if(!empty($uploaded_files))
        {
            foreach($uploaded_files as $uploaded_file)
            {
                $filename = $model->id . "-" . $uploaded_file->getName();
                $filepath = 'sites' . DIRECTORY_SEPARATOR . 'default' . DIRECTORY_SEPARATOR .
                    'files'. DIRECTORY_SEPARATOR . $filename;
                $uploaded_file->saveAs($filepath);

                $file = new File();
                $file->setAttributes(
                    array(
                        'nid' => $model->id,
                        'filename' => $filename,
                        'filepath' => $filepath,
                        'filemime' => $uploaded_file->getType(),
                        'filesize' => $uploaded_file->getSize(),
                        'type' => get_class($model),
                        'timestamp' => strtotime('now'),
                    ));

                $file->insert();
                unset($file);
            }
        }
    }

	public static function deleteFilesByPath($filepaths)
	{
        if(!empty($filepaths))
        {
            foreach($filepaths as $filepath)
            {
                unlink($filepath);

                $connection = Yii::app()->db;
                $sql = "delete from file where filepath = '{$filepath}'";
                $command = $connection->createCommand($sql);
                $command->execute();
            }
        }
    }

	public static function getImages($nid, $type)
	{
		$connection = Yii::app()->db;

		$data = array();

		$sql = "
			select filepath
			from file
			where nid = {$nid}
			and type = '{$type}'
			";

		$command = $connection->createCommand($sql);
		$result = $command->queryAll();
		$data = array();
		foreach($result as $row)
			$data[] = $row['filepath'];

		return $data;
	}

	public static function getTnImage($nid, $type)
	{
		if(isset($_SESSION['tn_imgs'][$type][$nid]))
			return $_SESSION['tn_imgs'][$type][$nid];

		$connection = Yii::app()->db;

		$sql = "
			select filepath
			from file
			where nid = {$nid}
			and type = '{$type}'
			order by filesize asc
			limit 1;
			";

		$command = $connection->createCommand($sql);
		$result = $command->queryAll();

		$tn = (!empty($result)) ? $result[0]['filepath'] : false;
		$_SESSION['tn_imgs'][$type][$nid] = $tn;

		return $tn;
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nid, filesize, timestamp', 'length', 'max'=>10),
			array('filename, filepath, filemime', 'length', 'max'=>255),
			array('type', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nid, filename, filepath, filemime, filesize, type, timestamp', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nid' => 'Nid',
			'filename' => 'Filename',
			'filepath' => 'Filepath',
			'filemime' => 'Filemime',
			'filesize' => 'Filesize',
			'type' => 'Type',
			'timestamp' => 'Timestamp',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('nid',$this->nid,true);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('filepath',$this->filepath,true);
		$criteria->compare('filemime',$this->filemime,true);
		$criteria->compare('filesize',$this->filesize,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('timestamp',$this->timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}