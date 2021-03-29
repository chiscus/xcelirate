<?php

namespace App\Models;

use CodeIgniter\Model;

class QuotesModel extends Model
{
  protected $table      = 'quotes';
  protected $primaryKey = 'id';

  protected $useAutoIncrement = true;

  protected $allowedFields = ['id', 'quote', 'author'];

  protected $useSoftDeletes = false;
  protected $useTimestamps = false;
}
