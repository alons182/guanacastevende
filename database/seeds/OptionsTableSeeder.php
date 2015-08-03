<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use App\Option;
use Illuminate\Database\Seeder;



class OptionsTableSeeder extends Seeder {



    public function run()
    {


        factory(Option::class, 1)->create([
            'name' => 'Opcion 1: Confirmación automática de anuncio',
            'price' => 1500,
            'description' => 'Precio ¢ 1,500 Seleccione esta opción si desea que su anuncio aparezca inmediatamente en línea sin tener que esperar a nuestra confirmación telefónica. <b>Esta opción NO es necesaria si escoge cualquiera de las siguientes 3 opciones.</b>'
        ]);

        factory(Option::class, 1)->create([
            'name' => 'Opcion 2: Mensaje de “NUEVO” y confirmación automática del anuncio.',
            'price' => 2000,
            'description' => 'Con esta opción, su anuncio aparecerá con el mensaje de "Nuevo" <b>durante los primeros 4 días de publicación.</b> (Nota: esta opción no estará disponible después de completado este proceso, y no aparece en los anuncios destacados más recientes en la página principal, pero sí en la página que le corresponda según el criterio de búsqueda de los usuarios). Precio ¢ 2,000'
        ]);

        factory(Option::class, 1)->create([
            'name' => 'Opcion 3: Destacado y confirmación automática del anuncio',
            'price' => 7000,
            'description' => 'Con esta opción, su anuncio aparecerá "Destacado" en la página que le corresponda según los criterios de búsqueda de los usuarios. Además, aparecerá TEMPORALMENTE en el HOME PRINCIPAL dependiendo de la cantidad de anuncios "destacados" que ingresen. Precio ¢ 7,000'
        ]);


        factory(Option::class, 1)->create([
            'name' => 'Opcion 4: Mensaje ESPECIAL, etiqueta de “FLAMA” y confirmación automática de anuncio.',
            'price' => 5000,
            'description' => 'Con esta opción su anuncio aparecerá como destacado (de primero) en las categorías o criterios de búsqueda de los usuarios, además su anuncio tendrá un MENSAJE Y ETIQUETA ESPECIAL durante todo el tiempo que esté publicado el anuncio. Además, aparecerá TEMPORALMENTE en el HOME o PÁGINA PRINCIPAL dependiendo de la cantidad de anuncios "destacados" que ingresen. Precio ¢4,000 ó ¢5,000 dependiendo de la opción seleccionada.'
        ]);

    }
}