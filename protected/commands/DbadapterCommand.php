<?php



class DbadapterCommand extends CConsoleCommand
{
	public function getHelp()
	{

	}


	public function run($args)
	{
//		$this->processUsers();
//		$this->processArticles();
//		$this->processBlogs();
//		$this->processTerms();
//		$this->processFiles();
//		$this->processComments();

//		$this->processSeo();
		$this->processSeoSitemap();
//		$this->processAds();
//		$this->processStats();


//		$this->testHelpers();
	}

//--------------------------------------------------------------------------------------------------->

	private function processUsers()
	{
		$sql = "
            DROP TABLE IF EXISTS hnn.user;
            CREATE TABLE hnn.user (
              id int(10) unsigned NOT NULL AUTO_INCREMENT,
              pass varchar(128) NOT NULL DEFAULT '',
              mail varchar(64) DEFAULT '',
              first_name varchar(32) DEFAULT '',
              middle_name varchar(32) DEFAULT '',
              last_name varchar(32) DEFAULT '',
              created int(11) NOT NULL DEFAULT '0',
              login int(11) NOT NULL DEFAULT '0',
              status tinyint(4) NOT NULL DEFAULT '0',
              PRIMARY KEY (id),
              KEY mail (mail),
              KEY created (created)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
		";
		$this->executeQuery($sql);

		$sql = "
            insert into hnn.user (id, pass, mail, first_name, middle_name, last_name, created, login, status)

                select u.uid as id, '', u.mail, pv1.value as first_name, pv2.value as middle_name, pv3.value as last_name,
                  u.created, u.login, u.status
                from hnn_edit.hnn_users u
                left join hnn_edit.hnn_profile_values pv1 on u.uid = pv1.uid and pv1.fid = 1
                left join hnn_edit.hnn_profile_values pv2 on u.uid = pv2.uid and pv2.fid = 2
                left join hnn_edit.hnn_profile_values pv3 on u.uid = pv3.uid and pv3.fid = 3
                where
                  u.uid in
                    (select distinct(b.uid) from hnn.blog b
                    union
                    select distinct(ba.uid) from hnn.blog_author ba
                    union
                    select distinct(a.uid) from hnn.article a)
                and u.uid != 0
                group by u.uid;
		";
		$result = $this->executeQuery($sql);

		echo "result: {$result}\n";
	}

	private function processArticles()
	{
		$sql = "
			DROP TABLE IF EXISTS hnn.article;
			CREATE TABLE hnn.article (
			  id int(10) unsigned NOT NULL AUTO_INCREMENT,
			  category_id int(10) unsigned NOT NULL,
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
			insert into hnn.article (id, category_id, title, uid, status, created, body, teaser, author,
									 source, source_url, source_date, source_bio)
				select n.nid as id, tn.tid, n.title, n.uid, n.status, n.created,
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
				left join hnn_edit.hnn_term_node tn on n.nid = tn.nid
				where n.type = 'hnn'
				group by n.nid
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
			  uid int(11) unsigned NOT NULL DEFAULT 0,
			  author_id int(11) unsigned NOT NULL DEFAULT 0,
			  category_id int(10) unsigned NOT NULL,
			  title varchar(255) NOT NULL DEFAULT '',
			  author varchar(255) NOT NULL DEFAULT '',
			  source varchar(255) NOT NULL DEFAULT '',
			  body longtext NOT NULL,
			  teaser longtext NOT NULL,
			  status int(11) NOT NULL DEFAULT 1,
			  created int(11) NOT NULL DEFAULT 0,
			  PRIMARY KEY (id),
			  KEY uid (uid),
			  KEY author_id (author_id)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
		";
		$this->executeQuery($sql);

		$sql = "
			insert into hnn.blog (id, category_id, title, uid, status, created, body, teaser, author, source)
				select n.nid as id, tn.tid, n.title, n.uid, n.status, n.created,
					nr.body, nr.teaser,
					cfa.field_author_value as author,
					cfsn.field_source_name_value as source
				from hnn_edit.hnn_node n
				left join hnn_edit.hnn_node_revisions nr on n.nid = nr.nid
				left join hnn_edit.hnn_content_field_author cfa on n.nid = cfa.nid
				left join hnn_edit.hnn_content_field_source_name cfsn on n.nid = cfsn.nid
				left join hnn_edit.hnn_term_node tn on n.nid = tn.nid
				where n.type = 'hnn_b_type'
				group by n.nid
		";
		$result = $this->executeQuery($sql);

		echo "result: {$result}\n";

		$sql = "
			DROP TABLE IF EXISTS hnn.blog_author;
			CREATE TABLE hnn.blog_author (
			  id int(10) unsigned NOT NULL AUTO_INCREMENT,
			  uid int(10) unsigned NOT NULL,
			  author varchar(255) NOT NULL DEFAULT '',
			  description text default '',
			  PRIMARY KEY (id)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
		";
		$this->executeQuery($sql);

        $sql = "
			insert into hnn.blog_author (author, uid)
                SELECT DISTINCT (author) as author, uid
                FROM hnn.blog
                WHERE author !=  ''
                GROUP BY author
		";
        $result = $this->executeQuery($sql);

        $sql = "
            DROP TABLE IF EXISTS hnn.user_blog_author_xref;
            CREATE TABLE hnn.user_blog_author_xref (
              id int(10) unsigned NOT NULL AUTO_INCREMENT,
              user_id int(10) unsigned NOT NULL,
              blog_author_id int(10) unsigned NOT NULL,
              PRIMARY KEY (id)
            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
		";
		$this->executeQuery($sql);

		$sql = "
			insert into hnn.user_blog_author_xref (id, user_id, blog_author_id)
                SELECT '', ba.uid, ba.id
                FROM hnn.blog_author ba;
		";
		$result = $this->executeQuery($sql);

		$connection = Yii::app()->db;
		$command = $connection->createCommand('select * from hnn.blog_author');
		$rows = $command->queryAll();
		foreach($rows as $entry)
		{
            if(!empty($entry['author']))
            {
                $sql = "
                    update hnn.blog set author_id = {$entry['id']} where author = '{$entry['author']}';
                ";
                $command = $connection->createCommand($sql);
                $command->execute();
            }
		}

        $sql = "ALTER TABLE hnn.blog DROP COLUMN author;";
        $command = $connection->createCommand($sql);
        $command->execute();

        $sql = "ALTER TABLE hnn.blog_author DROP COLUMN uid;";
        $command = $connection->createCommand($sql);
        $command->execute();
	}

	private function processTerms()
	{
		$sql = "
			DROP TABLE IF EXISTS hnn.category;
			CREATE TABLE hnn.category (
			  id int(10) unsigned NOT NULL AUTO_INCREMENT,
			  name varchar(255) NOT NULL DEFAULT '',
			  description longtext NOT NULL,
			  weight tinyint(4) NOT NULL DEFAULT 0,
			  PRIMARY KEY (id)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
		";
		$this->executeQuery($sql);

		$sql = "
			insert into hnn.category (id, name, description, weight)
				select tid as id, name, description, weight
				from hnn_edit.hnn_term_data
				where vid = 1;
		";
		$result = $this->executeQuery($sql);

		echo "result: {$result}\n";

		$sql = "
            DROP TABLE IF EXISTS user_category_xref;
            CREATE TABLE user_category_xref (
              id int(10) unsigned NOT NULL AUTO_INCREMENT,
              user_id int(10) unsigned NOT NULL,
              category_id int(10) unsigned NOT NULL,
              PRIMARY KEY (id)
            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
		";
		$this->executeQuery($sql);

		$sql = "
			DROP TABLE IF EXISTS hnn.article_category_xref;
			CREATE TABLE hnn.article_category_xref (
			  article_id int(10) unsigned NOT NULL,
			  category_id int(10) unsigned NOT NULL,
			  UNIQUE KEY article_category_index (article_id,category_id)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
		";
		$this->executeQuery($sql);

		$sql = "
			insert into hnn.article_category_xref (article_id, category_id)
				select tn.nid, tn.tid
				from hnn_edit.hnn_term_node tn
				left join hnn_edit.hnn_term_data td on tn.tid = td.tid
				where td.vid = 1;
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
			  nid int(10) unsigned NOT NULL DEFAULT '0',
			  filename varchar(255) NOT NULL DEFAULT '',
			  filepath varchar(255) NOT NULL DEFAULT '',
			  filemime varchar(255) NOT NULL DEFAULT '',
			  filesize int(10) unsigned NOT NULL DEFAULT 0,
			  type varchar(32) NOT NULL DEFAULT '',
			  timestamp int(10) unsigned NOT NULL DEFAULT '0',
			  PRIMARY KEY (id),
			  KEY nid (nid),
			  KEY type (type),
			  KEY timestamp (timestamp)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";
		$this->executeQuery($sql);

		$sql = "
			insert into hnn.file (id, nid, filename, filepath, filemime, filesize, type, timestamp)
				select f.fid as id, u.nid, f.filename, f.filepath, f.filemime, f.filesize, n.type,
					f.timestamp
				from hnn_edit.hnn_files f
				left join hnn_edit.hnn_upload u on u.fid = f.fid
				left join hnn_edit.hnn_node n on n.nid = u.nid

				group by f.fid
		";
		$result = $this->executeQuery($sql);

        $sql = "update file set type = 'article' where type = 'hnn'";
        $this->executeQuery($sql);
        $sql = "update file set type = 'blog' where type = 'hnn_b_type'";
        $this->executeQuery($sql);

		echo "result: {$result}\n";
	}

    private function processComments()
    {
        $sql = "
			DROP TABLE IF EXISTS hnn.comment;
			CREATE TABLE hnn.comment (
			  id int(10) unsigned NOT NULL AUTO_INCREMENT,
              nid int(11) NOT NULL DEFAULT '0',
              user_id int(11) NOT NULL DEFAULT '0',
              name varchar(60) DEFAULT NULL,
              subject varchar(64) NOT NULL DEFAULT '',
              comment longtext NOT NULL,
              timestamp int(11) NOT NULL DEFAULT '0',
              PRIMARY KEY (id),
              KEY nid (nid),
              KEY comment_uid (user_id)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";
        $this->executeQuery($sql);

        $sql = "
            INSERT INTO hnn.comment (id, nid, user_id, name, subject, comment, timestamp)
				select c.cid as id, c.nid, c.uid as user_id, c.name, c.subject, c.comment, c.timestamp
				from hnn_edit.hnn_comments c
		";
        $result = $this->executeQuery($sql);

        echo "result: {$result}\n";
    }


    private function processSeoSitemap()
	{
        $sql = "
            DROP TABLE IF EXISTS hnn.seo_sitemap;
            CREATE TABLE hnn.seo_sitemap (
              id int(10) unsigned NOT NULL AUTO_INCREMENT,
              loc varchar(255) NOT NULL DEFAULT '',
              priority float(5) NOT NULL DEFAULT 0.5,
              changefreq varchar(20) NOT NULL DEFAULT 'never',
              lastmod varchar(10) NOT NULL DEFAULT '',
              PRIMARY KEY (id)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
        ";
        $this->executeQuery($sql);

        $sql = "
            INSERT INTO hnn.seo_sitemap (id, loc, lastmod)
                SELECT '', concat('http://hnn.us/article/', id), DATE_FORMAT(from_unixtime(created),'%Y-%m-%d')
                FROM hnn.article
            ";
        $this->executeQuery($sql);

        $sql = "
            INSERT INTO hnn.seo_sitemap (id, loc, lastmod)
                SELECT '', concat('http://hnn.us/blog/', id), DATE_FORMAT(from_unixtime(created),'%Y-%m-%d')
                FROM hnn.blog
            ";
        $this->executeQuery($sql);

        $sql = "
            INSERT INTO hnn.seo_sitemap (id, loc, priority, changefreq, lastmod)
                SELECT '', concat('http://hnn.us/category/', id), 0.8, 'weekly', DATE_FORMAT(NOW(),'%Y-%m-%d')
                FROM hnn.category
            ";
        $this->executeQuery($sql);

        $sql = "
            INSERT INTO hnn.seo_sitemap (id, loc, priority, changefreq, lastmod)
                SELECT '', concat('http://hnn.us/group/', id), 0.8, 'weekly', DATE_FORMAT(NOW(),'%Y-%m-%d')
                FROM hnn.category_group
            ";
        $this->executeQuery($sql);

    }

    private function processSeo()
	{
        $sql = "
            DROP TABLE IF EXISTS hnn.seo;
            CREATE TABLE hnn.seo (
              id int(10) unsigned NOT NULL AUTO_INCREMENT,
              type varchar(16) NOT NULL DEFAULT '',
              nid int(10) unsigned NOT NULL DEFAULT '0',
              url varchar(255) NOT NULL DEFAULT '',
              title varchar(255) NOT NULL DEFAULT '',
              description longtext,
              keywords longtext,
              robots varchar(50) NOT NULL DEFAULT '',
              PRIMARY KEY (id),
              KEY nid (nid)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            DROP TABLE IF EXISTS hnn.seo_url_alias;
            CREATE TABLE hnn.seo_url_alias (
              id int(10) unsigned NOT NULL AUTO_INCREMENT,
              nid int(10) unsigned NOT NULL DEFAULT '0',
              alias varchar(128) NOT NULL DEFAULT '',
              path varchar(128) NOT NULL DEFAULT '',
              PRIMARY KEY (id),
              KEY alias (alias)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
        ";
        $this->executeQuery($sql);

        $sql = "
            INSERT INTO hnn.seo (id, type, nid, keywords, title)
                SELECT '', n.type, snl.nid, snl.caption, n.title
                FROM hnn_edit.hnn_search_node_links snl
                LEFT JOIN hnn_edit.hnn_node n on n.nid = snl.nid
                group by snl.nid
                ORDER BY snl.nid
            ";
        $result = $this->executeQuery($sql);
        echo "result: {$result}\n";

        $sql = "
            INSERT INTO hnn.seo_url_alias (id, alias, path, nid)
                SELECT '', dst, src, REPLACE(src, 'node/', '') as nid
                FROM hnn_edit.hnn_url_alias
                where src like 'node/%'
                ORDER BY src
            ";
        $result = $this->executeQuery($sql);

        $sql = "
            UPDATE seo_url_alias as sua, article as a
            SET
            sua.path = replace(sua.path, 'node', 'article')
            where sua.nid = a.id
            ";
        $result = $this->executeQuery($sql);

        $sql = "
            UPDATE seo_url_alias as sua, blog as b
            SET
            sua.path = replace(sua.path, 'node', 'blog')
            where sua.nid = b.id
            ";
        $result = $this->executeQuery($sql);

        $sql = "update seo set type = 'article' where type = 'hnn'";
        $this->executeQuery($sql);
        $sql = "update seo set type = 'blog' where type = 'hnn_b_type'";
        $this->executeQuery($sql);

        echo "result: {$result}\n";
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