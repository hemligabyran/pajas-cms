<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Cmssnippet extends Model
{

	public function __construct($id = FALSE)
	{
		parent::__construct(); // Connect to the database

		if (Kohana::$environment == Kohana::DEVELOPMENT)
		{
			$db_name = $this->pdo->query('SELECT database()')->fetchColumn();

			$sql = 'SELECT count((1))
				FROM INFORMATION_SCHEMA.TABLES
				WHERE
					table_schema = '.$this->pdo->quote($db_name).'
					AND table_name = \'cms_snippets\'';

			if ( ! $this->pdo->query($sql)->fetchColumn())
			{
				// Table cms_images does not exist, create it dawg!
				$sql = 'CREATE TABLE `cms_snippets` (
						`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
						`name` VARCHAR(255) NOT NULL,
						`group` VARCHAR(255) NOT NULL,
						`locale` CHAR(5) NOT NULL,
						`content` TEXT NOT NULL
					) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;';
				$this->pdo->exec($sql);
			}
		}

		if ($id) $this->load($id);
	}

	public static function factory($id = FALSE)
	{
		return new self($id);
	}

	public static function factory_by_name($name, $locale = FALSE)
	{
		$pdo = Pajas_Pdo::instance();
		$sql = 'SELECT id FROM cms_snippets WHERE filename = '.$pdo->quote($url);

		foreach ($pdo->query($sql) as $row)
			return new self($row['id']);

		return FALSE;
	}

	public function load($id)
	{
		foreach (Cmssnippets::factory()->ids($id)->get() as $entry)
			return ($this->data = $entry);

		return FALSE;
	}

	public function rm()
	{
		if (is_array($this->data) && isset($this->data['id']))
		{
			$this->pdo->exec('DELETE FROM cms_snippets WHERE id = '.$this->pdo->quote($this->data['id']));
			$this->data = NULL;

			return TRUE;
		}

		return FALSE;
	}

	public function save()
	{
		if (is_array($this->data) && isset($this->data['id']))
		{
			$sql = 'UPDATE cms_snippets SET ';
			foreach ($this->data as $key => $value)
				if ($key != 'id')
					Mysql::quote_identifier($key).' = '.$this->pdo->quote($value).',';

			$sql = rtrim(',', $sql);
			$sql .= 'WHERE id = '.$this->pdo->quote($this->data['id']);
			$this->pdo->exec($sql);
			$this->load($this->data['id']);
		}

		return $this;
	}

}