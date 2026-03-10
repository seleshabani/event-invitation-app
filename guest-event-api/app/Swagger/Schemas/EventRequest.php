<?php

namespace App\Swagger\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="EventRequest",
 *     type="object",
 *     required={"name","date"},
 *     
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         example="Birthday Party"
 *     ),
 * 
 *    @OA\Property(
 *        property="description",
 *       type="string",
 *       example="A fun birthday party with friends and family."
 *     ),
 * 
 *     @OA\Property(
 *         property="location",
 *         type="string",
 *         example="Kinshasa"
 *     ),
 *     
 *     @OA\Property(
 *         property="start_time",
 *         type="string",
 *         format="date",
 *         example="2026-03-10"
 *     ),
 *     @OA\Property(
 *         property="end_time",
 *         type="string",
 *         format="date",
 *         example="2026-03-10"
 *     ),
 *     
 
 * )
 */
class EventRequest {}