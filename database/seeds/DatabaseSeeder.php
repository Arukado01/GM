<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $data = [
            ['name' => 'Administrador'],
            ['name' => 'Supervisor'],
            ['name' => 'Cliente']
        ];

        foreach ($data as $dt) {
            $this->command->info("Creando el Role: " . $dt['name']);
            \App\Role::create($dt);
        }

        $this->command->info("Creando el Usuario Admin");
        $user = \App\User::create([
            'first_name'    => 'Admin',
            'last_name'     => 'Admin',
            'email'         => 'admin@gm-proyectos.com',
            'password'      => \Illuminate\Support\Facades\Hash::make('admin@Admin'),
            'first_session' => 1,
            'role_id'       => 1
        ]);

        /* $user = \App\User::create([
             'first_name' => 'Sandra',
             'last_name'  => 'Ferreira',
             'email'      => 'smilenaferr22@gmail.com',
             'password'   => \Illuminate\Support\Facades\Hash::make('kdc*8510'),
             'role_id'    => 2
         ]);*/

        /*$this->command->info("Creando el Usuario Daniel Cifuentes");
        $user = \App\User::create([
            'first_name'    => 'Isaac',
            'last_name'     => 'Cifuentes Ferreira',
            'email'         => 'dany2011@gmail.com',
            'password'      => \Illuminate\Support\Facades\Hash::make('kdc*8510'),
            'first_session' => 0,
            'role_id'       => 3
        ]);*/
    }
}
