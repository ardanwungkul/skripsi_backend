<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function template()
    {
        return $this->belongsTo(Template::class);
    }
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    public function todolist()
    {
        return $this->hasOne(TodoList::class);
    }
}
