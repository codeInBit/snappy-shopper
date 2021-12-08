<?php

namespace App\Http\Controllers;

use Str;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\AgentResource;
use App\Http\Requests\LinkPropertiesRequest;
use App\Http\Requests\DeLinkPropertiesRequest;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param LinkPropertiesRequest $request
     * @return JsonResponse
     */
    public function linkProperties(LinkPropertiesRequest $request): JsonResponse
    {
        $agent = Agent::findorFail($request->agent_id);
        $agent->properties()->attach($request->property_id, ['role' => $request->role]);

        return $this->successResponse(null, "Link properties to an agent", Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DeLinkPropertiesRequest $request
     * @return JsonResponse
     */
    public function delinkProperties(DeLinkPropertiesRequest $request)
    {
        $agent = Agent::findorFail($request->agent_id);
        $agent->properties()->where('property_id', $request->property_id)
            ->wherePivot('role', $request->role)->detach($request->property_id);

        return $this->successResponse(null, "Delink property from an agent", Response::HTTP_OK);
    }
}
