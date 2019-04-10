<?php

namespace App\Models;

use Baopham\DynamoDb\DynamoDbModel as Model;

class Word extends Model
{
    protected $table = 'words';
    
    protected $primaryKey = 'id';
    
    protected $fillable = ['id', 'word1', 'word2', 'word3'];
    // 自動で作成されるcreated_atとupdated_atをISO型からマイクロ秒にする
    protected $dateFormat = 'U';
    
    // GSIの設定。これを有効にしてしまうと、word1絞り込み時にQuery検索になってくれるのは嬉しいが、POST400エラーになる問題...
    // ↑ロールで以下のようにindexを追記して解決
    /*
        "Resource": [
            "arn:aws:dynamodb:ap-northeast-1:リソース番号:table/words",
            "arn:aws:dynamodb:ap-northeast-1:リソース番号:table/words/index/word1-index"
        ]
    */
    protected $dynamoDbIndexKeys = [
      'word1-index' => [
        'hash' => 'word1'
      ],
    ];
}
