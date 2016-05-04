<?php

namespace Application\Form;

class InputFilterConfigProvider
{
	public static function getStringLength($min=null, $max=null)
	{
	    return [
		    'name'    => 'string_length',
		    'options' => [
		        'min' => $min,
			    'max' => $max,
		    ],
	    ];
	}
}