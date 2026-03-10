<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="UploadGuestRequest",
 *     type="object",
 *     required={"event_id", "file"},
 *     @OA\Property(
 *         property="event_id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="file",
 *         type="string",
 *         format="binary",
 *         description="The file to upload"
 *     )
 * )
 */
class UploadGuestRequest {}
