<?php

namespace App\Http\Controllers;

use App\Http\Requests\MecabQueryGetRequest;
use App\Services\MecabService;

/**
 * 単語クエリ操作系のコントローラ
 * Class WordsQueryController
 * @package App\Http\Controllers
 */
class WordsQueryController extends Controller
{
    protected $mecabService;
    
    public function __construct(MecabService $mecabService)
    {
        $this->mecabService = $mecabService;
    }
    
    /**
     * @param MecabQueryGetRequest $request
     * @return Array
     */
    public function index(MecabQueryGetRequest $request) :\Illuminate\Http\Response
    {
        return response(["words" => $this->mecabService->separateWord($request->input('word'))], 200);
    }
}
