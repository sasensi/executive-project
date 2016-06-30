<?php

/**
 * Created by PhpStorm.
 * User: SASENSI
 * Date: 30/06/2016
 * Time: 13:57
 */
class ModelTableBuilder
{
	protected $dbName;
	protected $tableName;

	protected $columns;

	protected $pdo;

	/**
	 * ModelTableBuilder constructor.
	 *
	 * @param \PDO $pdo
	 * @param      $dbName
	 * @param      $tableName
	 */
	public function __construct($pdo, $dbName, $tableName)
	{
		$this->pdo       = $pdo;
		$this->dbName    = $dbName;
		$this->tableName = $tableName;
		$this->columns   = [];

		$query = $this->pdo->prepare("SELECT column_name, data_type FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?;");
		$query->execute([$dbName, $tableName]);

		$result = $query->fetchAll();
		foreach ($result as $row)
		{
			$this->columns[ $row['column_name'] ] = $row['data_type'];
		}
	}

	protected function buildRowProperties()
	{
		$result = '';
		foreach ($this->columns as $columnName => $type)
		{
			$result .= <<<PHP
	/**
	 * @var {$this->formatType($type)}
	 */
	protected \${$columnName};


PHP;
		}
		return $result;
	}

	protected function buildRowPropertiesSet()
	{
		$result = '';
		foreach ($this->columns as $columnName => $type)
		{
			$result .= <<<PHP
		\$this->{$columnName} = (isset(\$arr['{$columnName}'])) ? \$arr['{$columnName}'] : null;

PHP;
		}
		return $result;
	}

	public function buildRowClass()
	{
		$date = date('d/m/Y');
		$capitalizedTableName = ucfirst($this->tableName);

		return <<<PHP
<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: {$date}
 */
class {$capitalizedTableName} implements RowInterface
{
{$this->buildRowProperties()}
	public function exchangeArray(\$arr)
	{
{$this->buildRowPropertiesSet()}
	}
}

PHP;
	}

	public function buildtableclass()
	{
		$date = date('d/m/Y');
		$capitalizedTableName = ucfirst($this->tableName);

		return <<<PHP
<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: {$date}
 */
class {$capitalizedTableName}Table extends AbstractTable
{

}

PHP;
	}

	protected function formatType($type)
	{
		if ($type === 'integer' || $type === 'int4' || $type === 'int')
		{
			return 'integer';
		}
		elseif ($type === 'boolean')
		{
			return 'boolean';
		}
		elseif ($type === 'float')
		{
			return 'float';
		}
		return 'string';
	}

}