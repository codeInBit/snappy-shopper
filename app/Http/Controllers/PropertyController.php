<?php

namespace App\Http\Controllers;

use Str;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\PropertyResource;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use Symfony\Component\HttpFoundation\Response;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $properties = Property::query();

        return $this->datatableResponse(
            $properties,
            "App\Http\Resources\PropertyResource"
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePropertyRequest  $request
     * @return JsonResponse
     */
    public function store(StorePropertyRequest $request): JsonResponse
    {
        $property = Property::updateOrCreate(
            ['name' => $request->name],
            [
                'uuid' => Str::uuid(),
                'price' => $request->price,
                'type' => Property::TYPE[$request->type]
            ]
        );
        $response = new PropertyResource($property);

        return $this->successResponse($response, "Property created successfully", Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  Property  $property
     * @return JsonResponse
     */
    public function show(Property $property): JsonResponse
    {
        $response = new PropertyResource($property);
        return $this->successResponse($response, "Show property", Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePropertyRequest  $request
     * @param  Property  $property
     * @return JsonResponse
     */
    public function update(UpdatePropertyRequest $request, Property $property): JsonResponse
    {
        $property->update([
            'name' => $request->name,
            'price' => $request->price,
            'type' => Property::TYPE[$request->type]
        ]);

        return $this->successResponse(null, "Property record updated", Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Property  $property
     * @return JsonResponse
     */
    public function destroy(Property $property): JsonResponse
    {
        $property->delete();
        return $this->successResponse(null, "Property has been deleted", Response::HTTP_NO_CONTENT);
    }
}
