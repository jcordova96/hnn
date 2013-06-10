<?php



class DbadapterCommand extends CConsoleCommand
{
	public function getHelp()
	{

	}


	public function run($args)
	{
//		$this->processArticles();
		$this->processBlogs();
//		$this->processTerms(true);
//		$this->processNodeCategories();
//		$this->processFiles(true);
//		$this->insertSelectFiles();
//		$this->processUsers();
//		$this->processComments();
//		$this->processSeo();
//		$this->processAds();
//		$this->processStats();


//		$this->testHelpers();
	}

//--------------------------------------------------------------------------------------------------->

	private function processArticles()
	{
		$sql = "
			DROP TABLE IF EXISTS hnn.article;
			CREATE TABLE hnn.article (
			  id int(10) unsigned NOT NULL AUTO_INCREMENT,
			  nid int(10) unsigned NOT NULL,
			  type varchar(32) NOT NULL DEFAULT '',
			  title varchar(255) NOT NULL DEFAULT '',
			  author varchar(255) NOT NULL DEFAULT '',
			  source varchar(255) NOT NULL DEFAULT '',
			  source_url varchar(255) NOT NULL DEFAULT '',
			  source_date varchar(50) NOT NULL DEFAULT '',
			  source_bio longtext NOT NULL,
			  body longtext NOT NULL,
			  teaser longtext NOT NULL,
			  uid int(11) NOT NULL DEFAULT 0,
			  status int(11) NOT NULL DEFAULT 1,
			  created int(11) NOT NULL DEFAULT 0,
			  PRIMARY KEY (id),
			  KEY node_created (created),
			  KEY uid (uid)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
		";
		$this->executeQuery($sql);

		$sql = "
			insert into hnn.article (nid, type, title, author, source, source_url, source_date, source_bio,
									 body, teaser, uid, status, created)
				select n.nid, n.type, n.title, n.uid, n.status, n.created,
					nr.body, nr.teaser,
					cfa.field_author_value as author,
					cfsn.field_source_name_value as source,
					cth.field_source_url_value as source_url, cth.field_source_date_value as source_date,
					cth.field_bio_value as source_bio
				from hnn_edit.hnn_node n
				left join hnn_edit.hnn_node_revisions nr on n.nid = nr.nid
				left join hnn_edit.hnn_content_field_author cfa on n.nid = cfa.nid
				left join hnn_edit.hnn_content_field_source_name cfsn on n.nid = cfsn.nid
				left join hnn_edit.hnn_content_type_hnn cth on n.nid = cth.nid
				where n.type = 'hnn'
		";
		$result = $this->executeQuery($sql);

		echo "result: {$result}\n";
	}

	private function processBlogs()
	{
		$sql = "
			DROP TABLE IF EXISTS hnn.blog;
			CREATE TABLE hnn.blog (
			  id int(10) unsigned NOT NULL AUTO_INCREMENT,
			  nid int(10) unsigned NOT NULL,
			  uid int(11) unsigned NOT NULL DEFAULT 0,
			  type varchar(32) NOT NULL DEFAULT '',
			  title varchar(255) NOT NULL DEFAULT '',
			  author varchar(255) NOT NULL DEFAULT '',
			  source varchar(255) NOT NULL DEFAULT '',
			  body longtext NOT NULL,
			  teaser longtext NOT NULL,
			  status int(11) NOT NULL DEFAULT 1,
			  created int(11) NOT NULL DEFAULT 0,
			  PRIMARY KEY (id),
			  KEY nid (nid),
			  KEY uid (uid)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
		";
		$this->executeQuery($sql);

		$sql = "
			insert into hnn.blog (nid, uid, type, title, author, source, body, teaser, status, created)
				select n.nid, n.type, n.title, n.uid, n.status, n.created,
					nr.body, nr.teaser,
					cfa.field_author_value as author,
					cfsn.field_source_name_value as source
				from hnn_edit.hnn_node n
				left join hnn_edit.hnn_node_revisions nr on n.nid = nr.nid
				left join hnn_edit.hnn_content_field_author cfa on n.nid = cfa.nid
				left join hnn_edit.hnn_content_field_source_name cfsn on n.nid = cfsn.nid
				where n.type = 'hnn_b_type'
		";
		$result = $this->executeQuery($sql);

		echo "result: {$result}\n";
	}

	private function processTerms()
	{
		$sql = "
			DROP TABLE IF EXISTS hnn.term;
			CREATE TABLE hnn.term (
			  id int(10) unsigned NOT NULL AUTO_INCREMENT,
			  name varchar(255) NOT NULL DEFAULT '',
			  description longtext NOT NULL,
			  weight tinyint(4) NOT NULL DEFAULT 0,
			  PRIMARY KEY (id)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
		";
		$this->executeQuery($sql);

		$sql = "
			insert into hnn.term (id, name, description, weight)
				select tid as id, name, description, weight
				from hnn_edit.hnn_term_data
		";
		$result = $this->executeQuery($sql);

		echo "result: {$result}\n";
	}

	private function processFiles()
	{
		$sql = "
			DROP TABLE IF EXISTS hnn.file;
			CREATE TABLE hnn.file (
			  id int(10) unsigned NOT NULL AUTO_INCREMENT,
			  fid int(10) unsigned NOT NULL DEFAULT '0',
			  nid int(10) unsigned NOT NULL DEFAULT '0',
			  filename varchar(255) NOT NULL DEFAULT '',
			  filepath varchar(255) NOT NULL DEFAULT '',
			  filemime varchar(255) NOT NULL DEFAULT '',
			  timestamp int(10) unsigned NOT NULL DEFAULT '0',
			  PRIMARY KEY (id),
			  KEY fid (fid),
			  KEY nid (nid)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";
		$this->executeQuery($sql);

		$sql = "
			insert into hnn.file (fid, nid, filename, filepath, filemime, timestamp)
				select f.fid, u.nid, f.filename, f.filepath, f.filemime, f.timestamp
				from hnn_edit.hnn_files f
				left join hnn_edit.hnn_upload u on u.fid = f.fid
		";
		$result = $this->executeQuery($sql);

		echo "result: {$result}\n";
	}

	private function processUsers()
	{
		$connection = Yii::app()->db;

		$sql = "
			select *
			from hnn_role
			left join hnn_permissions

		;";

		$sql = "
			select *
			from hnn_users

		;";

		$sql = "
			select *
			from hnn_profile_fields
			left join hnn_profile_values

		;";

		$command = $connection->createCommand($sql);
		$rows = $command->queryAll();
	}


	private function processComments()
	{
		$connection = Yii::app()->db;

		$sql = "
			select *
			from hnn_disqus

		;";

		$sql = "
			select *
			from hnn_comments

		;";

		$command = $connection->createCommand($sql);
		$rows = $command->queryAll();
	}


	private function processSeo()
	{
		$connection = Yii::app()->db;

		$sql = "
			select nid, caption
			from hnn_search_node_links
			limit 5
			offset 0;";

		$command = $connection->createCommand($sql);
		$rows = $command->queryAll();
	}


	private function processAds()
	{
		$connection = Yii::app()->db;

		$sql = "
			select *
			from hnn_ads
			left join hnn_ad_html
			left join hnn_ad_image
			left join hnn_ad_owners
			left join hnn_ad_priority
			left join hnn_ad_weight_probability
		;";

		$sql = "
			select *
			from hnn_ad_clicks
		;";

		$command = $connection->createCommand($sql);
		$rows = $command->queryAll();
	}


	private function processStats()
	{
		$connection = Yii::app()->db;

		$sql = "
			select *
			from hnn_accesslog

		;";

		$command = $connection->createCommand($sql);
		$rows = $command->queryAll();
	}










//------------------------------------------------------------------------------------------>
// Helpers

	private function executeQuery($sql)
	{
		$connection = Yii::app()->db;
		$command = $connection->createCommand($sql);
		return $command->execute();
	}

	private function getIniOffset($table_name)
	{
		$connection = Yii::app()->db;

		$sql = "select max(id) as max from hnn.{$table_name};";
		$command = $connection->createCommand($sql);
		$rows = $command->queryAll();
		return (int) $rows[0]['max'];
	}

	private function translate($select_query, $table_name, $chunk_size, $ini_i, $add_id_field=false)
	{
		$connection = Yii::app()->db;
		$chunk_it = true;

		if($chunk_it === true)
		{
			$max = 1000000;
			for($i = $ini_i; $i < $max; $i = $i + $chunk_size)
			{
				unset($rows);
				echo "count:".$chunk_size.",i:{$i}\n";

				$sql = $select_query." limit {$chunk_size} offset {$i};";
//				echo $sql."\n\n";
				$command = $connection->createCommand($sql);
				$rows = $command->queryAll();

				if(count($rows) <= 0)
				{
					echo "\n\nprocess complete..\n\n";
					break;
				}

				$insert_query = $this->makeInsertQueryFromRows($rows, $table_name, $add_id_field);
//				echo $insert_query."\n\n";
				$command = $connection->createCommand($insert_query);
				$rows_affected = $command->execute();

				echo "processed {$rows_affected} rows, i: {$i}...\n";
			}
		}
		else
		{

		}
	}

	private function makeInsertQueryFromRows($rows, $table_name, $add_id_field=false)
	{
		if(!empty($rows))
		{
			$keys = ($add_id_field) ?
				array_merge((array)'id', array_keys($rows[0])) : array_keys($rows[0]);
			$id_val = ($add_id_field === true) ? "''," : "";

			$fields = implode(',', $keys);
			$vals = array();
			foreach($rows as $row)
			{
				foreach($row as $j => $val)
					$row[$j] = mysql_real_escape_string($val);

				$vals[] = "({$id_val}'".implode("','", $row)."')";
			}
			$vals = implode(',', $vals);

			$sql = "
				INSERT INTO hnn.{$table_name}
				({$fields})
				VALUES
				{$vals};";

			return $sql;
		}
	}









/*

	private function makeArticles()
	{
		$sql = "
			DROP TABLE IF EXISTS hnn.article;
			CREATE TABLE hnn.article (
			  id int(10) unsigned NOT NULL AUTO_INCREMENT,
			  nid int(10) unsigned NOT NULL,
			  type varchar(32) NOT NULL DEFAULT '',
			  title varchar(255) NOT NULL DEFAULT '',
			  author varchar(255) NOT NULL DEFAULT '',
			  source varchar(255) NOT NULL DEFAULT '',
			  source_url varchar(255) NOT NULL DEFAULT '',
			  source_date varchar(50) NOT NULL DEFAULT '',
			  source_bio longtext NOT NULL,
			  body longtext NOT NULL,
			  teaser longtext NOT NULL,
			  uid int(11) NOT NULL DEFAULT 0,
			  status int(11) NOT NULL DEFAULT 1,
			  created int(11) NOT NULL DEFAULT 0,
			  PRIMARY KEY (id),
			  KEY node_created (created),
			  KEY uid (uid)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
		";
		$this->executeQuery($sql);
	}

	private function processArticles($from_scratch=false)
	{
		$table_name = 'article';
		$chunk_size = 100;
		if($from_scratch === true) $this->makeArticles();

		$select_query = "
				select n.nid, n.type, n.title, n.uid, n.status, n.created,
					nr.body, nr.teaser,
					cfa.field_author_value as author,
					cfsn.field_source_name_value as source,
					cth.field_source_url_value as source_url, cth.field_source_date_value as source_date,
					cth.field_bio_value as source_bio
				from hnn_edit.hnn_node n
				left join hnn_edit.hnn_node_revisions nr on n.nid = nr.nid
				left join hnn_edit.hnn_content_field_author cfa on n.nid = cfa.nid
				left join hnn_edit.hnn_content_field_source_name cfsn on n.nid = cfsn.nid
				left join hnn_edit.hnn_content_type_hnn cth on n.nid = cth.nid
				where n.type = 'hnn'
		";

		$ini_i = ($from_scratch === true) ? 0 : $this->getIniOffset($table_name);
		$this->translate($select_query, $table_name, $chunk_size, $ini_i, true);
	}

*/







}