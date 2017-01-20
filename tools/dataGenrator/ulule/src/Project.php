<?php
/**
 * Created by: STAGIAIRE
 * the 18/01/2017
 */

namespace Ulule;


class Project
{
	protected $url;
	/**
	 * @var \DOMXPath
	 */
	protected $xpath;

	public function __construct($url)
	{
		$this->url = $url;
	}

	public function build()
	{
		echo "\tparsing project: ".$this->url.PHP_EOL;

		$curl        = new CustomCurl();
		$this->xpath = $curl->getXpath($this->url);
		$db          = DbFactory::getDb();

		$db->beginTransaction();

		try
		{
			$userId    = $this->buildUser();
			$projectId = $this->buildProject($userId);
			$this->buildCategories($projectId);
			$this->buildTags($projectId);
			$this->buildGifts($projectId);
			$this->buildPictures($projectId);
			$this->buildVideos($projectId);
			$this->buildTransactions($projectId);
			$db->commit();
		}
		catch (\PDOException $e)
		{
			$db->rollBack();
			trigger_error("\tfailed parsing: {$this->url}. ERROR: {$e->getMessage()}".PHP_EOL, E_USER_WARNING);
		}
	}

	protected function buildUser()
	{
		$city  = $this->xpath->query("/html/body/div[@id='wrapper']/main/aside/section[@id='author']/ul/li[2]/b")[0]->nodeValue;
		$photo = $this->xpath->query("/html/body/div[@id='wrapper']/main/aside/section[@id='author']/ul/li[1]/a/div/img/@data-src")[0]->nodeValue;
		$login = $this->xpath->query("/html/body/div[@id='wrapper']/main/aside/section[@id='author']/ul/li[1]/a/h3")[0]->nodeValue;
		$parts = explode(' ', $login, 2);

		$statement = DbFactory::getDb()->prepare('
			INSERT INTO user
				(password, name, firstname, birthdate, email, sex, adress, postcode, city, country_id, phone, photo, subscriptiondate, confirmed, usertype_id) 
			VALUES 
				(:password, :name, :firstname, :birthdate, :email, :sex, :adress, :postcode, :city, :country_id, :phone, :photo, now(), TRUE, 2) 
		');

		$statement->execute([
			'password'   => 'password',
			'name'       => $parts[0],
			'firstname'  => count($parts) > 1 ? $parts[1] : 'Anonyme',
			'birthdate'  => rand(1970, 1990).'-'.rand(1, 12).'-'.rand(1, 28),
			'email'      => preg_replace('/[^a-zA-Z]/', '', $login).'@gmail.com',
			'sex'        => rand(0, 1) === 0 ? 'M' : 'F',
			'adress'     => '38 rue de la Pomme',
			'postcode'   => str_pad(rand(1, 95), 2, '0', STR_PAD_LEFT).'000',
			'city'       => $city,
			'country_id' => 75,
			'phone'      => '0612345678',
			'photo'      => $photo,
		]);

		return DbFactory::getDb()->lastInsertId();
	}

	protected function buildProject($userId)
	{
		$subtitle          = $this->xpath->query("/html/body/div[@id='wrapper']/main/div[2]/section[@id='project-content']/header/p")[0]->nodeValue;
		$subtitleMaxLength = 90;
		if (strlen($subtitle) > $subtitleMaxLength) $subtitle = substr($subtitle, 0, ($subtitleMaxLength - 4)).'...';

		$title            = $this->xpath->query("/html/body/div[@id='wrapper']/main/div[2]/section[@id='project-content']/header/h1")[0]->nodeValue;
		$mainPicture      = $this->xpath->query("/html/body/div[@id='wrapper']/main/div[2]/section[@id='project-content']/section/div[@id='project-media']/div[@id='media-image']/img/@data-src")[0]->nodeValue;
		$picturesElements = $this->xpath->query("//div[@id='project-description']//a/@href");
		$pictures         = [];
		foreach ($picturesElements as $picturesElement)
		{
			$pictures[] = $picturesElement->nodeValue;
		}

		$goal = $this->xpath->query("//p[@class='progress']/b")[0]->nodeValue;
		$goal = preg_replace('/[^0-9]/', '', $goal);

		// insert project
		$statement = DbFactory::getDb()->prepare('
			INSERT INTO project
				(user_id, title, subtitle, description, mainpicture, creationdate, deadline, goal, promotionend, transactionsum)
			VALUES
				(:userId, :title, :subtitle, :description, :mainpicture, now() - INTERVAL :startDateDelay DAY, now() + INTERVAL :projectTime DAY, :goal, NULL, 0)
		');

		$statement->execute([
			'userId'         => $userId,
			'title'          => $title,
			'subtitle'       => $subtitle,
			'description'    => $this->getDescription(),
			'mainpicture'    => $mainPicture,
			'startDateDelay' => rand(30, 45),
			'projectTime'    => rand(15, 45),
			'goal'           => $goal,
		]);

		return DbFactory::getDb()->lastInsertId();
	}

	protected function buildGifts($projectId)
	{
		$gifts = $this->xpath->query("//li[@class='reward-item']");
		/** @var \DOMElement $gift */
		foreach ($gifts as $i => $gift)
		{
			$descriptionElement = $this->xpath->query("./div[@class='reward-description']//text()", $gift);
			$description        = '';
			foreach ($descriptionElement as $text)
			{
				$description .= $text->nodeValue.' ';
			}
			$description = preg_replace('/ +/', ' ', $description);

			$title     = 'Contrepartie n°'.($i + 1);
			$minAmount = $gift->getAttribute('data-amount');
			$minAmount = (int) preg_replace('/[^0-9]/', '', $minAmount);

			$statement = DbFactory::getDb()->prepare('
				INSERT INTO gift
					(title, minamount, description, project_id)
				VALUES
					(:title, :minamount, :description, :projectId)
			');

			$statement->execute([
				'title'       => $title,
				'minamount'   => $minAmount,
				'description' => $this->limitString($description, 255),
				'projectId'   => $projectId,
			]);
		}
	}

	protected function buildPictures($projectId)
	{
		$imgs = $this->xpath->query("//div[@id='project-description']//img/@src");
		foreach ($imgs as $i => $img)
		{
			if ($i === 9)
			{
				break;
			}

			$statement = DbFactory::getDb()->prepare('
				INSERT INTO picture
					(url, project_id)
				VALUES
					(:url, :projectId)
			');

			$statement->execute([
				'url'       => $img->nodeValue,
				'projectId' => $projectId,
			]);
		}
	}

	protected function buildTransactions($projectId)
	{
		$targetAmount = $this->xpath->query("//div[@id='project-stats']/p/strong/span")[0]->nodeValue;
		$targetAmount = (int) preg_replace('/[^0-9]/', '', $targetAmount);

		$currentAmount = 0;
		while ($currentAmount < $targetAmount)
		{
			$statement = DbFactory::getDb()->prepare('
				INSERT INTO transaction
					(amount, user_id, project_id, paymentmethod_id, paymentdate)
				VALUES
					(:amount, :userId, :projectId, :paymentmethodId, now() - INTERVAL :paymentDelay DAY)
			');

			$amount = rand(5, 500);
			$delta  = $targetAmount - $currentAmount;
			if ($amount > $delta) $amount = $delta;

			$statement->execute([
				'amount'          => $amount,
				'userId'          => rand(1, 10),
				'projectId'       => $projectId,
				'paymentmethodId' => rand(1, 3),
				'paymentDelay'    => rand(1, 29),
			]);

			$currentAmount += $amount;
		}
	}

	protected function buildCategories($projectId)
	{
		$categoriesCount = rand(1, 3);
		$categoriesIds   = [];
		for ($i = 1; $i <= 13; $i++)
		{
			$categoriesIds[] = $i;
		}
		shuffle($categoriesIds);
		for ($i = 0; $i < $categoriesCount; $i++)
		{
			$statement = DbFactory::getDb()->prepare('
				INSERT INTO projectcategory
					(project_id, category_id)
				VALUES
					(:projectId, :categoryId)
			');

			$statement->execute([
				'projectId'  => $projectId,
				'categoryId' => $categoriesIds[ $i ],
			]);
		}
	}

	protected function buildTags($projectId)
	{
		$db   = DbFactory::getDb();
		$tags = $this->xpath->query("//ul[@class='tags']//text()");
		foreach ($tags as $tag)
		{
			$tag = trim($tag->nodeValue);
			$tag = $this->limitString($tag, 30);

			$statement = $db->prepare('SELECT id FROM tag WHERE upper(name) = ?');
			$statement->execute([strtoupper($tag)]);

			if ($statement->rowCount() === 0)
			{
				// create tag
				$insertStatement = $db->prepare("INSERT INTO tag (name) VALUES (?)");
				$insertStatement->execute([$tag]);
				$tagId = $db->lastInsertId();
			}
			else
			{
				$tagId = $statement->fetchColumn();
			}

			// create project tag
			$insertStatement = $db->prepare("INSERT INTO projecttag (project_id, tag_id) VALUES (?, ?)");
			$insertStatement->execute([$projectId, $tagId]);
		}
	}

	protected function buildVideos($projectId)
	{
		$db          = DbFactory::getDb();
		$videosCount = rand(0, 3);
		for ($i = 0; $i < $videosCount; $i++)
		{
			$statement = $db->prepare('INSERT INTO video (url, project_id) VALUES (?, ?)');
			$statement->execute(['/video/placeholder.mp4', $projectId]);
		}
	}

	protected function limitString($string, $maxLength)
	{
		if (strlen($string) < $maxLength)
		{
			return $string;
		}
		return substr($string, 0, ($maxLength - 3)).'...';
	}

	protected function getDescription()
	{
		$result                  = '';
		$descriptionMaxLength    = 6000;
		$subdescriptionMaxLength = 1000;

		$titles = $this->xpath->query("//div[@id='project-description']/h3");
		foreach ($titles as $title)
		{
			if (strlen($result) + $subdescriptionMaxLength > $descriptionMaxLength)
			{
				break;
			}
			$subdescription = '';
			$contents       = $this->xpath->query("./following-sibling::section[1]//*[text()[normalize-space()]][string-length() > 30]", $title);
			foreach ($contents as $content)
			{
				$content = $content->nodeValue;
				$content = trim(str_replace("\xC2\xA0", ' ', html_entity_decode($content)));
				if (strpos($content, '(') === 0)
				{
					continue;
				}
				$content = preg_replace('/\s+/', ' ', $content);
				if (strlen($subdescription) + strlen($content) > $subdescriptionMaxLength)
				{
					break;
				}
				$subdescription .= "<p>".$content."</p>";
			}
			if (empty($subdescription))
			{
				continue;
			}
			$titleText = trim($this->xpath->query("./text()", $title)[0]->nodeValue);
			$result .= "<h1>{$titleText}</h1>".$subdescription;
		}
		return $result;
	}
}