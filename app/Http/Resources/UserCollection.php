<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $name = $request->input('nome');

        $page = $request->input('pagina', 1);
        $getItems = $request->input('exibir', 5);

        $userCount = User::name($name)->count();
        $pageCount = ceil($userCount / $getItems);

        return [
            "pagina" => (int) $page,
            "items_exibidos" => (int) $getItems,
            "total_items" => (int) $userCount,
            "total_paginas" => (int) $pageCount,
            "data" => $this->collection,
        ];
    }
}
