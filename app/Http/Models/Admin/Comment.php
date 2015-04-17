<?php namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    protected $table ="comments";

    public function belongsToUser()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function belongsToPage()
    {
        return $this->belongsTo('App\Http\Models\Admin\Page','page_id','id');
    }

}
