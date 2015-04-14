<?php namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Page extends Model {

	//
    protected $table ="pages";

    public function belongsToUser()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
