<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * This method return all users associated with the company
     * 
     * @return object
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * This method return all employees associated with the company
     * 
     * @return object
     */
    public function employees()
    {
        return $this->users->where('account_type', 'Employee');
    }

    /**
     * This function gets the company logo
     * 
     * @param bool $absolute_path
     * @return String
     */
    public function getLogo($absolute_path = FALSE)
    {
        if ($absolute_path)
            return asset('/storage/images/companies/'.$this->logo);

        return '/storage/images/companies/'.$this->logo;
    }   
}
