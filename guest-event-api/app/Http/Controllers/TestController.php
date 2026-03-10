<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use OpenApi\Annotations as OA;


class TestController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/",
     *     summary="Home endpoint",
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function index()
    {
        return response()->json([
            'message' => 'Hello, World!',
        ]);
    }
}
