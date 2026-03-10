<?php
namespace App\Swagger\Schemas;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="RegisterRequest",
 *     type="object",
 *     required={"name","email","password"},
 *     
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="John Doe"
 *     ),
 * 
 *    @OA\Property(
 *        property="email",
 *       type="string",
 *       format="email",
 *       example="john.doe@example.com"
 *    ),
 * 
 *   @OA\Property(
 *       property="password",
 *       type="string",
 *       format="password",
 *       example="secret"
 *   ),
 * 
 *      @OA\Property(
 *       property="password_confirmation",
 *      type="string",
 *      format="password",
 *      example="secret" 
 *    ),
 * )
 */

class RegisterRequest {}