<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Todos extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = "todos";
    protected $fillable = ['userid', 'title', 'description', 'due_date', 'status', 'completed'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
