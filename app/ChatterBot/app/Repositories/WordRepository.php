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
        // WORD1
        $words1 = Word::where('word1', '=', $word)->get(['id', 'word2']);
        if (count($words1) === 0) return $ret;
        $chatRandomWord1 = $words1[rand(0, count($words1) - 1)]->word2;
        $ret .= $chatRandomWord1;
        // WORD2
        $words2 = Word::where('word2', '=', $chatRandomWord1)->get(['id', 'word3']);
        if (count($words2) === 0) return $ret;
        $chatRandomWord2 = $words2[rand(0, count($words2) - 1)]->word3;
        $ret .= $chatRandomWord2;
        // WORD3
        $words3 = Word::where('word3', '=', $chatRandomWord2)->get(['id', 'word3']);
        if (count($words3) === 0) return $ret;
        $ret .= $words3[rand(0, count($words3) - 1)]->word3;
        return $ret;
    }
}
