<?php

namespace App\Services;

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
     * DBに存在しない単語群のみを抽出して返す
     * @param $words
     * @return Array
     */
    public function isNotExistWord($words) : Array
    {
        /* ▼3要素ずつに分割
         * [
         *  [1,2,3],
         *  [4,5,6],
         *  [7,8]
         * ]
         */
        $chunk_words = array_chunk($words, 3);
        return array_filter($chunk_words, function ($wordsArray) {
            // 3要素の不足分をnullで穴埋めする。[7,8] -> [7,8, ]となる。
            $padded_words = array_pad($wordsArray, 3, null);
            $count = $this->wordRepository->getExistenceWordsCount($padded_words);
            if ($count === 0) {
                return $padded_words;
            }
        });
    }
    
    /**
     * 分かち書きした3要素の単語配列をデータ登録する
     * @param array $words 3要素の配列を包括した配列
     */
    public function putWords(Array $words): void
    {
        if (count($words) <= 0) {
            return;
        }
        foreach ($words as $index => $wordsArray) {
            if (count($wordsArray) < 3) {
                continue;
            }
            $this->wordRepository->insert($wordsArray);
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
