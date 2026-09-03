<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['role_id', 'name', 'email', 'password', 'phone'];

    protected $hidden = ['password', 'remember_token'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
   public function projects()
{
    return $this->hasMany(Project::class, 'client_id');   // كان project::class بحرف صغير
}

    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class, 'author_id');
    }
    public function isAdmin(): bool
    {
        return $this->role?->name === 'admin';
    }
}
