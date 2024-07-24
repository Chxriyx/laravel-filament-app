<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contact;

class Customer extends Model
{
    use HasFactory;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'company_name',
        'email',
        'phone',
        'address',
        'website',
        'industry',
        'notes',
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
