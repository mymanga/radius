<?php

namespace App\Http\Resources;

use OpenApi\Annotations as OA;


/**
 * @OA\Schema(
 *     title="Service",
 *     description="Service object",
 * )
 */
class Service
{
    /**
     * @OA\Property(
     *     property="id",
     *     type="integer",
     *     example=6
     * )
     *
     * @var int
     */
    public $id;

    /**
     * @OA\Property(
     *     property="user_id",
     *     type="integer",
     *     example=6
     * )
     *
     * @var int
     */
    public $user_id;

    /**
     * @OA\Property(
     *     property="package_id",
     *     type="integer",
     *     example=2
     * )
     *
     * @var int
     */
    public $package_id;

    /**
     * @OA\Property(
     *     property="nas_id",
     *     type="integer",
     *     example=1
     * )
     *
     * @var int
     */
    public $nas_id;

    /**
     * @OA\Property(
     *     property="price",
     *     type="number",
     *     format="float",
     *     example=500.00
     * )
     *
     * @var float
     */
    public $price;

    /**
     * @OA\Property(
     *     property="username",
     *     type="string",
     *     example="string"
     * )
     *
     * @var string
     */
    public $username;

    /**
     * @OA\Property(
     *     property="cleartextpassword",
     *     type="string",
     *     nullable=true
     * )
     *
     * @var string|null
     */
    public $cleartextpassword;

    /**
     * @OA\Property(
     *     property="ipaddress",
     *     type="string",
     *     example="192.168.0.2"
     * )
     *
     * @var string
     */
    public $ipaddress;

    /**
     * @OA\Property(
     *     property="is_active",
     *     type="integer",
     *     example=1
     * )
     *
     * @var int
     */
    public $is_active;

    /**
     * @OA\Property(
     *     property="renewal",
     *     type="string",
     *     nullable=true,
     *     format="date-time"
     * )
     *
     * @var string|null
     */
    public $renewal;

    /**
     * @OA\Property(
     *     property="expiry",
     *     type="string",
     *     format="date-time",
     *     example="2024-04-06T21:00:00.000000Z"
     * )
     *
     * @var string
     */
    public $expiry;

    /**
     * @OA\Property(
     *     property="description",
     *     type="string",
     *     example="string"
     * )
     *
     * @var string
     */
    public $description;

    /**
     * @OA\Property(
     *     property="grace_expiry",
     *     type="string",
     *     nullable=true,
     *     format="date-time"
     * )
     *
     * @var string|null
     */
    public $grace_expiry;

    /**
     * @OA\Property(
     *     property="deleted_at",
     *     type="string",
     *     nullable=true,
     *     format="date-time"
     * )
     *
     * @var string|null
     */
    public $deleted_at;

    /**
     * @OA\Property(
     *     property="created_at",
     *     type="string",
     *     format="date-time"
     * )
     *
     * @var string
     */
    public $created_at;

    /**
     * @OA\Property(
     *     property="updated_at",
     *     type="string",
     *     format="date-time"
     * )
     *
     * @var string
     */
    public $updated_at;

    /**
     * @OA\Property(
     *     property="mac_address",
     *     type="string",
     *     example="string"
     * )
     *
     * @var string
     */
    public $mac_address;

    /**
     * @OA\Property(
     *     property="type",
     *     type="string",
     *     example="DHCP"
     * )
     *
     * @var string
     */
    public $type;

    /**
     * @OA\Property(
     *     property="info",
     *     type="string",
     *     nullable=true
     * )
     *
     * @var string|null
     */
    public $info;

    // Add other properties if needed
}

