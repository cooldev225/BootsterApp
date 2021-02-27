<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
	protected $table = 'business';
    protected $hidden = [];
	public function fullname() {
		return ucfirst($this->firstname).' '.ucfirst($this->lastname);
	}
    /**
	 * [createdBy description]
	 * @return [type] [description]
	 */
	public function createdBy() {
		return $this->belongsTo(User::class, 'created_by', 'id');
	}

	/**
	 * [updatedBy description]
	 * @return [type] [description]
	 */
	public function updatedBy() {
		return $this->belongsTo(User::class, 'updated_by', 'id');
	}
}
