<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'slug', 'body', 'image'];

    /**
     * Summary of getSlug
     * @param mixed $title
     * @return \Illuminate\Support\Stringable|string
     */
    public static function getSlug($title)
    {
        $slug = Str::of($title)->slug("-");
        $count = 1;

        // Prendi il primo project il cui slug è uguale a $slug
        // se è presente allora genero un nuovo slug aggiungendo -$count
        while (Project::where("slug", $slug)->first()) {
            $slug = Str::of($title)->slug("-") . "-{$count}";
            $count++;
        }

        return $slug;
    }
}

#user_id --- inizialmente non c'è ma lo metto, poi lo aggiungiamo a mano
#slug --- aggiungo anche lui, perchè ci permette di avere dei percorsi come: project/titolo del project     che sono più user friendly ed utili per il SEO
