<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class BaseCollection extends ResourceCollection
{
    protected $paginate;

    /**
     * BaseCollection constructor.
     * @param $resource
     * @param false $paginate
     */
    public function __construct($resource, $paginate = false)
    {
        parent::__construct($resource);
        $this->paginate = $paginate;
    }
}
