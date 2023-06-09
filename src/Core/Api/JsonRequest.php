<?php
namespace Simflex\Core\Api;

use Simflex\Core\Request;

class JsonRequest extends Request
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Returns JSON array
     * @return array
     */
    public function json(): array
    {
        return json_decode($this->requestBody, true) ?: [];
    }
}