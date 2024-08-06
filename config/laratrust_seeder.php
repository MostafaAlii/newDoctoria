<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'super_admin' => [
            'roles'                 => 'c,r,u,d',
            'admins'                => 'c,r,u,d',
            'users'                 => 'c,r,u,d',
            'providers'             => 'c,r,u,d',
            'doctors'               => 'c,r,u,d',
            'laboratories'          => 'c,r,u,d',
            'analysis'              => 'c,r,u,d',
            'radiology_center'      => 'c,r,u,d',
            'insurance_people'      => 'c,r,u,d',
            'insurance_companies'   => 'c,r,u,d',
            'main_services'         => 'c,r,u,d',
            'package'               => 'c,r,u,d',
            'specializations'       => 'c,r,u,d',
            'experiences'           => 'c,r,u,d',
            'governorates'          => 'c,r,u,d',
            'cities'                => 'c,r,u,d',
            'families'              => 'c,r,u,d',
            'types'                 => 'c,r,u,d',
            'areas'                 => 'c,r,u,d',
            'employees'             => 'c,r,u,d',
            'patients'              => 'c,r,u,d',
            'days'                  => 'c,r,u,d',
            'sliders'               => 'c,r,u,d',
            'patient_subscribe'     => 'c,r,u,d',
            'medication_ways'       => 'c,r,u,d',
            'medication_units'      => 'c,r,u,d',
            'solution_types'        => 'c,r,u,d',
            'solution_priorities'   => 'c,r,u,d',
            'diagnoses'             => 'c,r,u,d',
            'booking'               => 'c,r,u,d',
            'hospitals'             => 'c,r,u,d',
            'request_booking'       => 'c,r,u,d',
            'notifications'         => 'c,r,u,d',
            'select_providers'      => 'c,r,u,d',
            'pharmacies'            => 'c,r,u,d',
            'radiology'             => 'c,r,u,d',
            'sign'                  => 'c,r,u,d',
            'chronic_diseases'      => 'c,r,u,d',
            'medical_operation'     => 'c,r,u,d',
            'nationalities'         => 'c,r,u,d',
            'vouchers'              => 'c,r,u,d',
            'settings'              => 'c,r,u,d',
        ],
        'admin' => [],
        'user' => [],
    ],


    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
