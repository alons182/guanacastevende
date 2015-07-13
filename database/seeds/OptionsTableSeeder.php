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
            'description' => 'Precio ¢ 1,500 Seleccione esta opción si desea que su anuncio aparezca inmediatamente en línea sin tener que esperar a nuestra confirmación telefónica. Esta opción NO es necesaria si escoje cualquiera de las siguientes 2 opciones.'
        ]);

        factory(Option::class, 1)->create([
            'name' => 'Opcion 2: Destacado y confirmación automática de anuncio',
            'price' => 5000,
            'description' => 'Con esta opción, su anuncio aparecerá "Destacado" en la página que le corresponda según los criterios de búsqueda de los usuarios. Además, aparecerá TEMPORALMENTE en la página principal de acuerdo a la cantidad de anuncios "destacados" que ingresen. Precio ¢ 5,000'
        ]);

        factory(Option::class, 1)->create([
            'name' => 'Opcion 3: Mensaje de NUEVO y confirmación automática de anuncio.',
            'price' => 2000,
            'description' => 'Precio ¢2,000. Con esta opción, su anuncio aparecerá con el mensaje de "Nuevo" durante los primeros 4 días de publicación. (Nota: esta opción no estará disponible después de completado este proceso, y no aparece en los anuncios destacados más recientes en la página principal, pero sí en la página que le corresponda según el criterio de búsqueda de los usuarios)'
        ]);

        factory(Option::class, 1)->create([
            'name' => 'Opcion 4: Mensaje ESPECIAL y confirmación automática de anuncio.',
            'price' => 4000,
            'description' => 'Precio ¢4,000 ó ¢5,000 dependiendo de la opción seleccionada. Con esta opción, su anuncio aparecerá con el mensaje ESPECIAL que escoja durante todo el tiempo que esté publicado el anuncio.'
        ]);

    }
}