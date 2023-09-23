<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

//Relation::enforceMorphMap([
//	"MoneyTransfer" => "App\Models\MoneyTransfer"
//]);

class Transaction extends Model
{
	use HasFactory;

	public function transactional()
	{
		return $this->morphTo();
	}
}
