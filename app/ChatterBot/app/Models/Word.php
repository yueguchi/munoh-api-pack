<?php

namespace App\Models;

use Baopham\DynamoDb\DynamoDbModel as Model;

class Word extends Model
{
    protected $table = 'words';
    
    protected $primaryKey = 'id';
    
    protected $fillable = ['id', 'word1', 'word2', 'word3'];
}
