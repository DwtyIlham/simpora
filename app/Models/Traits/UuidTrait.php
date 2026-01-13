<?php

namespace App\Models\Traits;

use Ramsey\Uuid\Uuid;

trait UuidTrait
{
    protected function generateUUID()
    {
        return Uuid::uuid4()->toString();
    }

    protected function insertUUID(array $data)
    {
        if (empty($data['data'][$this->primaryKey])) {
            $data['data'][$this->primaryKey] = $this->generateUUID();
        }

        return $data;
    }

    protected function updateUUID(array $data)
    {
        return $data;
    }
}
