<?php

namespace Database\Seeders;

use App\Models\Almacen;
use App\Models\Contratos;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Para base de 0

        // \App\Models\User::factory(10)->create();
        $this->call(RoleSeeder::class);
        $this->call(DivisioneSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(SubareaSeeder::class);
        $this->call(DatosuserSeeder::class);//C
        $this->call(UserStatusSeeder::class);
        $this->call(UserSeeder::class); //C
        $this->call(PuestosSeeder::class);
        $this->call(ContratoSeeder::class);

        $this->call(SeccionesSeeder::class);
        $this->call(PersonalConfianzaSeeder::class);
        // $this->call(ViewCounterSeeder::class);
        // $this->call(UnidadesMedicasSeeder::class);
        // $this->call(enfermedadesSeeder::class);

        // $this->call(FileTypeSeeder::class);
        $this->call(UbicacionesArchivoSeeder::class);
        // $this->call(ArchivoGeneralSeeder::class);
        // $this->call(ResultadosAudiometriaSeeder::class);
        // $this->call(AudiometriaSeeder::class);
        // $this->call(ProSaludSeeder::class);
        // $this->call(DopingSeeder::class);
        // $this->call(PadecimientosSeeder::class);
        // $this->call(IncapacidadSeeder::class);

        $this->call(PostSeeder::class);
    }
}
