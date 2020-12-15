<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;


class Avator extends Model implements HasMedia
{
    use HasMediaTrait;
    
    public function registerMediaCollections()
    {
        $this->addMediaCollection('avator');
    }
}
