<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employes extends Model
{
    protected $fillable = [
        'user_id',
        'nip',
        'phone',
        'gender',
        'address',
        'is_active'
    ];

    protected $append = [
        'gender_label',
        'is_active_class',
        'is_active_label'
    ];

    public function getGenderLabelAttribute()
    {
        return $this->gender == '1' ? 'Gentelman' : 'Ladies';
    }

    public function getIsActiveLabelAttribute()
    {
        return $this->is_active == '1' ? 'Active' : 'Inactive';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
