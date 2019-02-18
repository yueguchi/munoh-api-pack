<?php

namespace App\Services;

use App\Models\Word;
use App\Repositories\WordRepository;

/**
 * Created by PhpStorm.
 * User: eguchi
 * Date: 2019/02/06
 * Time: 18:15
 */
class MecabService
{
    /** @var WordRepository */
    private $wordRepository;

    /** 機械的なテンプレ返答シリーズ */
    private $defaultWords = [
        'ちょっと何言っているのかわからなかったです...'
    ];
    
    /**
     * MecabService constructor.
     * @param WordRepository $wordRepository
     */
    public function __construct(WordRepository $wordRepository)
    {
        $this->wordRepository = $wordRepository;
    }
    
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
    
    /**
     * 分かち書きした単語をデータ登録する
     * @param String $word
     */
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
    
    /**
     * 指定した言葉をマルコフ理論にかけて、結果リプライを取得返却する
     * @param String $word
     * @return String
     * @throws \Exception
     */
    public function getRepl(String $word): String
    {
        $words = $this->separateWord($word);
        if (count($words) <= 0) {
            throw new \Exception("${word}は不正な文言です。");
        }
        $targetWord = $words[rand(0, count($words) - 1)];
        $repl = $this->wordRepository->markov($targetWord);
        if (!$repl) {
            $repl = $this->getRandomWord();
        }
        return $repl;
    }

    /**
     * 該当する返答が得られなかった時にそれっぽい言葉を機械的に返す処理
     * @return String
     */
    protected function getRandomWord(): String
    {
        return $this->defaultWords[rand(0, count($this->defaultWords) - 1)];
    }
}
