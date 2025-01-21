<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    public const MOODLE = 'moodle';

    public function __construct(mixed $resource, public ?string $param = '')
    {
        parent::__construct($resource);
        $this->resource = $resource;


    }

    public function toArray($request)
    {
        $error = [
            'error' => [
                'message' => $this->message($request),
                'code' => 422,
            ]];

        if ($this->param === self::MOODLE) {
            $error['error'] = [...$error['error'],  'moodle' => true];
        }

        return $error;
    }

    private function message($request)
    {
        if (method_exists($this->resource ,'getMessage')){
            return  $this->getMessage();
        }
        if ($request?->massage) {
            return $request->massage;
        }

        return $this->resource;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        return parent::toResponse($request)->setStatusCode(422);
    }

}
