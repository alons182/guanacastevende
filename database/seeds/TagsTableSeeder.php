<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Illuminate\Database\Seeder;
use App\Tag;


class TagsTableSeeder extends Seeder {

    /**
     *
     */
    private $tags = [
        'En oferta','Ganga', 'Financio','Urge Vender','Escucho ofertas','Con Garantía','Edición Limitada','Vendo por viaje',
        'Llame yá !!','Perfecto estado','Vendo o cambio','Precio de oferta','Negociable','En buen estado','Ganga-Finacio-Llame ya !',
        'Urge vender-En buen estado-Negociable','Escucho ofertas-Perfecto estado'

    ];

    public function run()
    {
        foreach($this->tags as $tag)
        {
            factory(Tag::class, 1)->create([
                'name' => $tag,
                'price' => 4000
            ]);
        }

    }
}