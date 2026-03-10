<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    //

    public function __construct(private EventService $service) {}


    /**
     * @OA\Get(
     *     path="/api/events",
     *     summary="Get all events for authenticated user",
     *      security={
     *  {"passport": {}},
     *   },
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function index()
    {
        return EventResource::collection($this->service->getAllForAuth());
    }

    /**
     * @OA\Post(
     *     path="/api/events",
     *     summary="Create a new event",
     * security={
     *  {"passport": {}},
     *   },
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/EventRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created"
     *     )
     * )
     */
    public function store(EventRequest $request)
    {
        $event = $this->service->store($request->validated());
        return new EventResource($event);
    }

    /**
     * @OA\Get(
     *     path="/api/events/{id}",
     *     summary="Get a specific event",
     * security={
     *  {"passport": {}},
     *   },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function show($id)
    {
        $event = $this->service->getById($id);
        return new EventResource($event);
    }
}
