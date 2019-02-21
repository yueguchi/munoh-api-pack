<?php

namespace App\Http\Controllers;

use App\Http\Requests\MecabQueryGetRequest;
use App\Services\MecabService;
use App\Events\WordDiscovered;

/**
 * 単語クエリ操作系のコントローラ
 * Class WordsQueryController
 * @package App\Http\Controllers
 */
class WordsQueryController extends Controller
{
    /** @var MecabService */
    protected $mecabService;
    
    /**
     * WordsQueryController constructor.
     * @param MecabService $mecabService
     */
    public function __construct(MecabService $mecabService)
    {
        $this->mecabService = $mecabService;
    }
    
    /**
     * wordクエリに指定した言葉を分かち書きにして結果JSON配列として返却する
     * @param MecabQueryGetRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(MecabQueryGetRequest $request) :\Illuminate\Http\Response
    {
        return response(["words" => $this->mecabService->separateWord($request->input('word'))], 200);
    }
    
    /**
     * wordクエリに指定した言葉からマルコフ連鎖で作成された言葉を返す
     * @param MecabQueryGetRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function repl(MecabQueryGetRequest $request) :\Illuminate\Http\Response
    {
        $word = $request->input('word');
        $repl = $this->mecabService->getRepl($word);
        // 新出単語の登録処理(Command)はイベントにdispatchして委譲する
        $separatedWords = $this->mecabService->separateWord($word);
        $isNotExistWords = $this->mecabService->isNotExistWord($separatedWords);
        if (count($isNotExistWords) > 0) {
            event(new WordDiscovered($word));
        }
        return response(['message' => $repl], 200);
    }
}
