<?php

namespace App\Services;

use App\Models\Word;

/**
 * Created by PhpStorm.
 * User: eguchi
 * Date: 2019/02/06
 * Time: 18:15
 */
class MecabService
{
    /**
     * mecabコマンドで単語を分ち書きにして返す
     * @param String $word
     * @return Array
     */
    public function separateWord(String $word): Array
    {
        $command = "echo ${word} | mecab -E '' -F '%m\n'";
        exec($command, $output, $return_value);
        return $output;
    }
    
    public function putWords(String $word): void
    {
        $words = $this->separateWord($word);
        if (count($words) <= 0) {
            return;
        }
        // ↓以下のように分かち書き結果を3要素の配列の配列に分割する
        //        [
        //          [1,2,3],
        //          [4,5,6],
        //          [7,8]
        //        ]
        $chunk_words = array_chunk($words, 3);
        foreach ($chunk_words as $index => $wordsArray) {
            //
            $padded_words = array_pad($wordsArray, 3, null);
            Word::create([
              'id' => uniqid(),
              'word1' => $padded_words[0],
              'word2' => $padded_words[1],
              'word3' => $padded_words[2]
            ]);
        }
    }
}
