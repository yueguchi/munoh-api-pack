<?php

namespace App\Models;

use Baopham\DynamoDb\DynamoDbModel as Model;

class Word extends Model
{
    protected $table = 'words';
    
    protected $primaryKey = 'id';
    
    protected $fillable = ['id', 'word1', 'word2', 'word3'];
    
    // GSIの設定。これを有効にしてしまうと、word1絞り込み時にQuery検索になってくれるのは嬉しいが、POST400エラーになる問題...
//    protected $dynamoDbIndexKeys = [
//      'word1-index' => [
//        'hash' => 'word1'
//      ],
//    ];
}
