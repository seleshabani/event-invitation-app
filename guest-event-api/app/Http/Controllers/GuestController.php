<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadGuestRequest;
use App\Services\GuestService;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class GuestController extends Controller
{
    //

    public function __construct(private GuestService $service) {}

    /**
     * @OA\Post(
     *     path="/api/guests/upload",
     *     summary="Upload guests for an event",
     *     security={{"passport": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/UploadGuestRequest")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Fichier traité avec succès"),
     *     @OA\Response(response=422, description="Erreur de validation ou fichier manquant")
     * )
     */
    public function upload(UploadGuestRequest $request) {
        $validated = $request->validated();
        $eventId = $validated['event_id'];
        $file = $validated['file'];

        try {
            $this->service->uploadGuests($eventId, $file);
            return response()->json(['message' => 'Fichier traité avec succès'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors du traitement du fichier: ' . $e->getMessage()], 422);
        }
    }
}
