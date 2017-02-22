<?php
/**
 * Created by PhpStorm.
 * User: sam
 * Date: 22/02/2017
 * Time: 10:04
 */

use Ulule\Db;

require_once __DIR__.'/ulule/vendor/autoload.php';

$map = [
	1  => [ // Technologie
	        794, // Technologeek
	        820, // Technologie
	],
	2  => [ // Éducation
	        804, // Enfance
	        810, // Enfance & Educ.
	],
	3  => [ // Gastronomie
	        786, // Cuisine
	        806, // Artisanat & Cuisine
	],
	5  => [ // Jeux
	        774, // Jeux
	        775, // Jeux de société
	        802, // Jeux de rôle
	],
	6  => [ // Communauté
	        770, // Solidaire & Citoyen
	        771, // Solidarité
	        791, // Entrepreneuriat
	        805, // Humanitaire
	        817, // Hacktivisme
	        823, // Politique
	        792, // Patrimoine
	],
	7  => [ // Innovation

	],
	8  => [ // Mode
	        776, // Beaux Arts
	        793, // Photographie
	        818, // Mode & Design
	        819, // Mode
	],
	9  => [ // Design
	        772, // DIY
	        807, // Art & Photo
	        811, // Design
	        796, // Artisanat
	],
	10 => [ // Sport
	        803, // Sports
	        801, // Spectacle vivant
	        814, // Danse
	        822, // Cirque
	],
	11 => [ // Cinéma
	        781, // Film et vidéo
	        784, // Documentaire
	        816, // Animation
	],
	12 => [ // Littérature
	        785, // Edition & Journal.
	        769, // Livres
	        821, // Journalisme
	        768, // BD
	],
	13 => [ // Évènementiel
	        790, // Autres projets
	        797, // Insolite
	],
	14 => [ // Voyage
	        773, // Espaces
	        782, // Écologie
	        783, // Voyage
	],
	4  => [ // Musique
	        795, // Musique
	        813, // Clips
	],
];

$db = new Db();

foreach ($map as $categoryId => $tagIds)
{
	if (empty($tagIds))
	{
		continue;
	}

	$statement = $db->prepare('
		UPDATE projectcategory SET category_id = ? WHERE project_id IN (
			SELECT DISTINCT project.id
			FROM project
			  JOIN (projecttag
			    JOIN tag
			      ON projecttag.tag_id = tag.id)
			    ON project.id = projecttag.project_id
			WHERE
			  projecttag.tag_id IN ('.implode(',', $tagIds).')
		);
	');

	$statement->execute([$categoryId]);
}

