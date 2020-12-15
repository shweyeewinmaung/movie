<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertising extends Model
{
    protected $fillable = [
        'company_name','from_date','to_date','display_time','display_type','advertisingfile_id'
    ];
  
}
