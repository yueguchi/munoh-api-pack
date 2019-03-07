<?php

namespace App\Http\Controllers;

use App\Http\Requests\MecabGetRequest;
use App\Http\Requests\WordsPutRequest;
use App\Services\MecabService;
use App\Events\WordDiscovered;

/**
 * 単語クエリ操作系のコントローラ
 * Class WordsController
 * @package App\Http\Controllers
 */
class WordsController extends Controller
{
    /** @var MecabService */
    protected $mecabService;
    
    /**
     * WordsController constructor.
     * @param MecabService $mecabService
     */
    public function __construct(MecabService $mecabService)
    {
        $this->mecabService = $mecabService;
    }
    
    /**
     * wordクエリに指定した言葉を分かち書きにして結果JSON配列として返却する
     * @param MecabGetRequest $request
     * @return \Illuminate\Http\Response
     */
    public function separate(MecabGetRequest $request) :\Illuminate\Http\Response
    {
        return response(["words" => $this->mecabService->separateWord($request->input('word'))], 200);
    }
    
    /**
     * wordクエリに指定した言葉からマルコフ連鎖で作成された言葉を返す
     * @param MecabGetRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function repl(MecabGetRequest $request) :\Illuminate\Http\Response
    {
        $word = $request->input('word');
        $repl = $this->mecabService->getRepl($word);
        // 新出単語の登録処理()はイベントにdispatchして委譲する
        $separatedWords = $this->mecabService->separateWord($word);
        $isNotExistWords = $this->mecabService->getNotExistWord($separatedWords);
        if (count($isNotExistWords) > 0) {
            event(new WordDiscovered($word));
        }
        return response(['message' => $repl], 200);
    }
    
    /**
     * [PUT]wordに指定した言葉を分かち書きにかけ、データ登録する
     * @param WordsPutRequest $request
     * @return \Illuminate\Http\Response
     */
    public function putWord(WordsPutRequest $request) :\Illuminate\Http\Response
    {
        $separatedWords = $this->mecabService->separateWord($request->input('word'));
        $this->mecabService->putWords($this->mecabService->getNotExistWord($separatedWords));
        return response(['message' => 'Created'], 201);
    }
}
