<?php
namespace App\Repositories;

use App\Models\Word;

/**
 * Created by PhpStorm.
 * User: eguchi
 * Date: 2019/02/10
 * Time: 21:28
 */

class WordRepository
{
    /**
     * マルコフ理論
     * @param String $word
     * @return String
     */
    public function markov(String $word) :String
    {
        $ret = '';
        $whereWord = $word;
        // WORD1
        $words1 = Word::where('word1', '=', $whereWord)->get(['id', 'word2']);
        if (count($words1) > 0) {
            $chatRandomWord1 = $words1[rand(0, count($words1) - 1)]->word2;
            $whereWord = $chatRandomWord1;
            $ret .= $chatRandomWord1;
        }
        // WORD2
        $words2 = Word::where('word2', '=', $whereWord)->get(['id', 'word3']);
        if (count($words2) > 0) {
            $chatRandomWord2 = $words2[rand(0, count($words2) - 1)]->word3;
            $whereWord = $chatRandomWord2;
            $ret .= $chatRandomWord2;
        }
        // WORD3
        $words3 = Word::where('word2', '=', $whereWord)->get(['id', 'word3']);
        if (count($words3) === 0) {
            return $ret;
        }
        $ret .= $words3[rand(0, count($words3) - 1)]->word3;
        return $ret;
    }
    
    /**
     * 3単語配列がDBに登録されている数を取得する
     * @param $padded_words
     * @return mixed
     */
    public function getExistenceWordsCount($padded_words): int
    {
        return Word::where('word1', '=', $padded_words[0])
          ->where('word2', '=', $padded_words[1])
          ->where('word3', '=', $padded_words[2])->count();
    }
    
    /**
     * 登録
     * @param array $words
     * @return Void
     */
    public function insert(Array $words) :Void
    {
        Word::create([
          'id' => uniqid(),
          'word1' => $words[0],
          'word2' => $words[1],
          'word3' => $words[2]
        ]);
    }
}
