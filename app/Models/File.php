<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Models
{
	protected $fillable = [
		'name', 'url',
	];
}