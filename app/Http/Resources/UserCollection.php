<?php

namespace App\Http\Resources;

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
        $page = $request->input('pagina', 1);
        $getItems = $request->input('exibir', 5);
        $userCount = $request->input('user_total', 0);
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
