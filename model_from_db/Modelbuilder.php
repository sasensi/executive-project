<?php

require 'ModelTableBuilder.php';

/**
 * Created by PhpStorm.
 * User: SASENSI
 * Date: 30/06/2016
 * Time: 11:11
 */
class Modelbuilder
{
	/**
	 * @var \ModelBuilderConfig
	 */
	protected $config;

	/**
	 * @var \PDO
	 */
	protected $pdo;

	/**
	 * @var ModelTableBuilder[]
	 */
	protected $tables;

	/**
	 * Modelbuilder constructor.
	 *
	 * @param ModelBuilderConfig $config
	 */
	public function __construct(ModelBuilderConfig $config)
	{
		$this->config = $config;
		$this->tables = [];
		$this->pdo    = new PDO('mysql:'.$this->config->dbName, $this->config->dbUser, $this->config->dbPassword);

		$query = $this->pdo->prepare("SELECT table_name FROM information_schema.tables WHERE table_schema = ?");
		$query->execute([$this->config->dbName]);

		foreach ($query->fetchAll() as $row)
		{
			$this->tables[ $row['table_name'] ] = new ModelTableBuilder($this->pdo, $this->config->dbName, $row['table_name']);
		}
	}

	public function build()
	{
		foreach ($this->tables as $tableName => $modelTableBuilder)
		{
			// row
			$fileName = 'ModelRow'.ucfirst($tableName).'.php';
			$file     = fopen($this->config->renderDir.$fileName, 'w');
			fwrite($file, $modelTableBuilder->buildRowClass());
			fclose($file);

			// table
			$fileName = 'ModelTable'.ucfirst($tableName).'.php';
			$file     = fopen($this->config->renderDir.$fileName, 'w');
			fwrite($file, $modelTableBuilder->buildtableclass());
			fclose($file);
		}
		echo "done !";
	}
}