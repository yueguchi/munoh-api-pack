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
    protected $mecabService;
    
    public function __construct(MecabService $mecabService)
    {
        $this->mecabService = $mecabService;
    }
    
    public function index(WordsPutCommandRequest $request) :\Illuminate\Http\Response
    {
        $this->mecabService->putWords($request->input('word'));
        return response(['message' => 'Created'], 201);
    }
}
