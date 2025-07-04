<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            'SUPER ADMIN',
            'Direktur (DIR-OPS)',
            'Manager QC (QC-MGR)',
            'Manager QA (QA-MGR)',
            'Manager PPIC & Warehouse (PW-MGR)',
            'Manager Produksi (PD-MGR)',
            'Manager R&D (RD-MGR)',
            'Manager HRGA (HG-MGR)',
            'Manager Purchasing (PR-MGR)',
            'Manager Teknik (EG-MGR)',
            'Manager Finance & Tax (FT-MGR)',
            'Manager Marketing& Sales (MS-MGR)',
            'Manager IT (IT-MGR)',
            'SPV QC (QC-SPV 1)',
            'SPV QC (QC-SPV 2)',
            'SPV QA (QA-SPV 1)',
            'SPV QA (QA-SPV 2)',
            'SPV PW (PW-SPV 1)',
            'SPV PW (PW-SPV 2)',
            'SPV Produksi (PD-SPV 1)',
            'SPV Produksi (PD-SPV 2)',
            'SPV R&D (RD-SPV 1)',
            'SPV R&D (RD-SPV 2)',
            'SPV HRGA (HG-SPV 1)',
            'SPV HRGA (HG-SPV 2)',
            'SPV Purchasing (PR-SPV 1)',
            'SPV Purchasing (PR-SPV 2)',
            'SPV Teknik (EG-SPV 1)',
            'SPV Teknik (EG-SPV 2)',
            'SPV Finance & Tax (FT-SPV 1)',
            'SPV Finance & Tax (FT-SPV 2)',
            'SPV MS (MS-SPV 1)',
            'SPV MS (MS-SPV 2)',
            'SPV IT (IT-SPV 1)',
            'SPV IT (IT-SPV 2)',
            'Staff QC (QC-STF 1)',
            'Staff QC (QC-STF 2)',
            'Staff QA (QA-STF 1)',
            'Staff QA (QA-STF 2)',
            'Staff PW (PW-STF 1)',
            'Staff PW (PW-STF 2)',
            'Staff Produksi (PD-STF 1)',
            'Staff Produksi (PD-STF 2)',
            'Staff R&D (RD-STF 1)',
            'Staff R&D (RD-STF 2)',
            'Staff HRGA (HG-STF 1)',
            'Staff HRGA (HG-STF 2)',
            'Staff Purchasing (PR-STF 1)',
            'Staff Purchasing (PR-STF 2)',
            'Staff Teknik (EG-STF 1)',
            'Staff Teknik (EG-STF 2)',
            'Staff Finance & Tax (FT-STF 1)',
            'Staff Finance & Tax (FT-STF 2)',
            'Staff MS (MS-STF 1)',
            'Staff MS (MS-STF 2)',
            'Staff IT (IT-STF 1)',
            'Staff IT (IT-STF 2)',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role], ['guard_name' => 'web']);
        }
    }
}
