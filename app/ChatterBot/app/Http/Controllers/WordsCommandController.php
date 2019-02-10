<?php

namespace App\Http\Controllers;

use App\Http\Requests\WordsPutCommandRequest;
use App\Services\MecabService;

/**
 * 単語登録系のコマンド管理コントローラ
 * Class WordsCommandControllerØ
 * @package App\Http\Controllers
 */
class WordsCommandController extends Controller
{
    /** @var MecabService */
    protected $mecabService;
    
    /**
     * WordsCommandController constructor.
     * @param MecabService $mecabService
     */
    public function __construct(MecabService $mecabService)
    {
        $this->mecabService = $mecabService;
    }
    
    /**
     * wordに指定した言葉を分かち書きにかけ、データ登録する
     * @param WordsPutCommandRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(WordsPutCommandRequest $request) :\Illuminate\Http\Response
    {
        $this->mecabService->putWords($request->input('word'));
        return response(['message' => 'Created'], 201);
    }
}
