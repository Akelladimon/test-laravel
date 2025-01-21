<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    /**
     * Individual attribute constants.
     */
    public const NAME_ATTRIBUTE = 'name';
    public const PATH_ATTRIBUTE = 'path';
    public const SIZE_ATTRIBUTE = 'size';


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable  = [
        self::NAME_ATTRIBUTE,
        self::PATH_ATTRIBUTE,
        self::SIZE_ATTRIBUTE,
    ];
}
