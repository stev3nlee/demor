<?php

namespace App\Http\Models;

class Converter
{
    public function dateFormat($date)
    {
		$date = date_create($date);
		return date_format($date, 'd F Y');
    }
	public function thousandSepator($money)
	{
		return str_replace(",",".",number_format($money));
	}
}