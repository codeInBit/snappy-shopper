<?php

namespace App\Http\Controllers;

use Str;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\AgentResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;
use URL;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = AgentResource::collection(Agent::orderBy('first_name', 'ASC')->get());

        return $this->successResponse($response, "All agents", Response::HTTP_OK);
    }
}
