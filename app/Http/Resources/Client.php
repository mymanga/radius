<?php

namespace App\Http\Resources;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Client",
 *     description="Client object",
 * )
 */
class Client
{
    /**
     * @OA\Property(
     *     property="id",
     *     type="integer",
     *     example=4
     * )
     *
     * @var int
     */
    public $id;

    /**
     * @OA\Property(
     *     property="firstname",
     *     type="string",
     *     example="John"
     * )
     *
     * @var string
     */
    public $firstname;

    /**
     * @OA\Property(
     *     property="lastname",
     *     type="string",
     *     example="Doe"
     * )
     *
     * @var string
     */
    public $lastname;

    /**
     * @OA\Property(
     *     property="username",
     *     type="string",
     *     example="270653"
     * )
     *
     * @var string
     */
    public $username;

    /**
     * @OA\Property(
     *     property="email",
     *     type="string",
     *     example="johndoe@gmail.com"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *     property="location",
     *     type="string",
     *     nullable=true
     * )
     *
     * @var string|null
     */
    public $location;

    /**
     * @OA\Property(
     *     property="latitude",
     *     type="string",
     *     example="-11.224234"
     * )
     *
     * @var string
     */
    public $latitude;

    /**
     * @OA\Property(
     *     property="longitude",
     *     type="string",
     *     example="45.7312161"
     * )
     *
     * @var string
     */
    public $longitude;

    /**
     * @OA\Property(
     *     property="phone",
     *     type="string",
     *     example="04256668225"
     * )
     *
     * @var string
     */
    public $phone;

    /**
     * @OA\Property(
     *     property="category",
     *     type="string",
     *     example="individual"
     * )
     *
     * @var string
     */
    public $category;

    /**
     * @OA\Property(
     *     property="billingType",
     *     type="string",
     *     example="monthly"
     * )
     *
     * @var string
     */
    public $billingType;

    /**
     * @OA\Property(
     *     property="birthday",
     *     type="string",
     *     format="date",
     *     nullable=true
     * )
     *
     * @var string|null
     */
    public $birthday;

    /**
     * @OA\Property(
     *     property="identification",
     *     type="string",
     *     nullable=true
     * )
     *
     * @var string|null
     */
    public $identification;

    /**
     * @OA\Property(
     *     property="avatar",
     *     type="string",
     *     nullable=true
     * )
     *
     * @var string|null
     */
    public $avatar;

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
     *     property="wallet_balance",
     *     type="number",
     *     format="float",
     *     example=200
     * )
     *
     * @var float
     */
    public $wallet_balance;

    /**
     * @OA\Property(
     *     property="status",
     *     type="string",
     *     example="No Service"
     * )
     *
     * @var string
     */
    public $status;

    /**
     * @OA\Property(
     *     property="tags_data",
     *     type="array",
     *     @OA\Items(
     *         type="object",
     *         @OA\Property(property="id", type="integer"),
     *         @OA\Property(property="name", type="string")
     *     )
     * )
     *
     * @var array
     */
    public $tags_data;

    // Add other properties if needed
}
