<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use AustinHeap\Database\Encryption\Traits\HasEncryptedAttributes;

class Member extends Model
{
    use HasEncryptedAttributes;

    protected $table = 'member';
    protected $primaryKey = 'member_id';
    protected $guarded = [
        'member_id',
    ];
    protected $encrypted = [
        'last_name', 'first_name', 'middle_name', 'contact_number','address','provincial_address','gender',
        'person_in_case_of_emergency','emergency_address','emergency_contactno','SSS','license_number'
    ];


    public function van()
    {
        return $this->belongsToMany(Van::class,'member_van','member_id','van_id');
    }

    public function operator()
    {
        return $this->belongsTo(Member::class, 'operator_id');
    }

    public function drivers()
    {
        return $this->hasMany(Member::class, 'operator_id','member_id');
    }
    
    public function trips()
    {
      return $this->hasMany(Trip::class, 'driver_id', 'member_id');
    }

    public function vanQueue()
    {
        return $this->hasOne(VanQueue::class,'driver_id','member_id');
    }

    public function user()
    {
      return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function archivedOperator()
    {
        return $this->belongsToMany(Member::class,'member_history','driver_id','operator_id')->as('archivedAt')->withTimestamps();
    }

    public function archivedDriver()
    {
        return $this->belongsToMany(Member::class,'member_history','operator_id','driver_id')->as('archivedAt')->withTimestamps();
    }

    public function archivedVan()
    {
        return $this->belongsToMany(Van::class,'van_history','member_id','van_id')->as('archivedAt')->withTimestamps();
    }

    public function countDriverTrip()
    {
      return $this->trips();
    }

    public static function scopeAllOperators($query)
    {
        return $query->where('role','Operator');
    }

    public static function scopeAllDrivers($query)
    {
        return $query->where('role','Driver');
    }


    public function getFullNameAttribute()
    {
        return "{$this->last_name}, {$this->first_name} {$this->middle_name}";
    }


    public function getExpiryDateAttribute($value)
    {
        return Carbon::parse($value)->format('m/d/Y');
    }

    public function getDateArchivedAttribute($value)
    {
        return Carbon::parse($value)->format('M d, Y h:i:s A');
    }

    public function setExpiryDateAttribute($value)
    {
        if(is_null($value)) {
            $this->attributes['expiry_date'] = $value;

        } else {
            $this->attributes['expiry_date'] = Carbon::parse($value);
        }
    }

}
