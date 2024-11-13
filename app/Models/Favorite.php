<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorites';

    public function getItem()
    {
        switch ($this->table_name) {
            case 'hotels':
                return Hotel::find($this->item_id);
            case 'news':
                return News::find($this->item_id);
            default:
                return null;
        }
    }
}
