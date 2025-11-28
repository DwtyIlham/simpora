<?php

namespace App\Models;

use CodeIgniter\Model;

class KompModel extends Model
{
    protected $table            = 'kompetisi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;
}
