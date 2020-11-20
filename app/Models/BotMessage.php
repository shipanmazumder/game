<?php

namespace App\Models;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BotMessage extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(Config::get('tablePrefix').$this->getTable());
    }
}
