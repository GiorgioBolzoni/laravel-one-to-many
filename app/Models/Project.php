<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Project extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'slug', 'link', 'image', 'body', 'type_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    public static function getSlug($title)
    {
        $slug = Str::of($title)->slug('-');
        $count = 1;

        while (Project::where("slug", $slug)->first()) {
            $slug = Str::of($title)->slug('-') . "-{$count}";
            $count++;
        }
        return $slug;
    }
}

#user_id --- inizialmente non c'è ma lo metto, poi lo aggiungiamo a mano
#slug --- aggiungo anche lui, perchè ci permette di avere dei percorsi come: project/titolo del project     che sono più user friendly ed utili per il SEO
