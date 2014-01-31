<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Cmssnippets extends Model
{

	protected $groups;
	protected $ids;
	protected $locales;

	public function __construct($db_instance = FALSE)
	{
		if (Kohana::$environment == Kohana::DEVELOPMENT)
			Cmssnippet::factory(); // This is needed to create the SQL table if it does not exist

		parent::__construct($db_instance); // Connect to the database
	}

	public function get()
	{
		$sql = 'SELECT * FROM cms_snippets WHERE 1';

		if ($this->ids)     $sql .= ' AND id     IN ('.implode(',', $this->ids).')';
		if ($this->locales) $sql .= ' AND locale IN ('.implode(',', $this->locales).')';
		if ($this->groups)  $sql .= ' AND group  IN ('.implode(',', $this->groups).')';

		$sql .= ' ORDER BY name';

		return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	}

	public function groups($array)
	{
		if (is_array($array))
		{
			$this->groups = array();
			foreach ($array as $part)
				$this->groups[] = $this->pdo->quote($part);
		}
		else $this->groups = NULL;

		return $this;
	}

	public function ids($array)
	{
		if ($array === NULL) $this->ids = NULL;
		else
		{
			if ( ! is_array($array)) $array = array($array);

			if (empty($array)) $array = array(-1); // No matches should be found
			else
			{
				$array = array_map('intval', $array);

				$this->ids = $array;
			}
		}

		return $this;
	}

	public function locales($array)
	{
		if (is_array($array))
		{
			$this->locales = array();
			foreach ($array as $part)
				$this->locales[] = $this->pdo->quote($part);
		}
		else $this->locales = NULL;

		return $this;
	}

}