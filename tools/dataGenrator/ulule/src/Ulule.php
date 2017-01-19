<?php
/**
 * Created by: STAGIAIRE
 * the 18/01/2017
 */

namespace Ulule;


class Ulule
{
	private $iterations;

	public function __construct($iterations)
	{
		$this->iterations = $iterations;
	}

	public function build()
	{
		$this->clearDb();

		for ($i = 1; $i <= $this->iterations; $i++)
		{
			$projects = new \Ulule\Projects('http://fr.ulule.com/discover/all/'.$i);
			$projects->build();
		}
	}

	private function clearDb()
	{
		$db = DbFactory::getDb();

		$db->beginTransaction();

		$db->exec('
			DELETE FROM projectcategory;
			DELETE FROM projecttag;
			DELETE FROM tag;
			DELETE FROM gift;
			DELETE FROM transaction;
			DELETE FROM picture;
			DELETE FROM video;
			DELETE FROM projectview;
			DELETE FROM project;
			DELETE FROM favouritecategory WHERE user_id IN (SELECT id FROM user WHERE usertype_id = 2);
			DELETE FROM user WHERE usertype_id = 2;
		');

		$db->commit();
	}
}