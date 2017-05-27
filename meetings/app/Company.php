<?php namespace App;

use Illuminate\Database\Eloquent\Model;


class Company extends Model{

    protected $table = 'company';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'name'
    ];



    /**
     * Get the comments for the blog post.
     */
    public function users()
    {
        return $this->belongstoMany('App\Users', 'company_user');
    }

}