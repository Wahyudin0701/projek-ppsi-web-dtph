<?php

namespace Database\Seeders;

use App\Models\Alsintan;
use Illuminate\Database\Seeder;

class AlsintanSeeder extends Seeder
{
    public function run(): void
    {
        $catTraktor = \App\Models\AlsintanCategory::firstOrCreate(['slug' => 'traktor'], ['name' => 'Traktor', 'description' => 'Mesin pengolah tanah dan penarik alat pertanian lainnya.']);
        $catPompa = \App\Models\AlsintanCategory::firstOrCreate(['slug' => 'pompa-air'], ['name' => 'Pompa Air', 'description' => 'Alat untuk memompa air irigasi ke lahan pertanian.']);
        $catPascaPanen = \App\Models\AlsintanCategory::firstOrCreate(['slug' => 'pasca-panen'], ['name' => 'Pasca Panen', 'description' => 'Alat dan mesin untuk proses setelah panen seperti perontok dan penggiling.']);
        $catAlatBerat = \App\Models\AlsintanCategory::firstOrCreate(['slug' => 'alat-berat'], ['name' => 'Alat Berat', 'description' => 'Alat berat untuk keperluan pertanian dan konstruksi lahan.']);

        $data = [
            [
                'category_id' => $catAlatBerat->id,
                'name' => 'Excavator',
                'merk' => 'SANY',
                'inventories' => [
                    ['SY007CFT671K8', 'SY57C', 'APBD', 2025, -1.450351, 103.522794]
                ]
            ],
            [
                'category_id' => $catPascaPanen->id,
                'name' => 'Combine Harvester',
                'merk' => 'TANIKAYA MEGATRON HT 99',
                'inventories' => [
                    ['FTHRGG50CSS001803', 'TMS-HT 99B00151', 'APBN', 2026, -1.450351, 103.522794],
                    ['FTHRGG50CSS001795', 'TMS-HT 99B00266', 'APBN', 2026, -1.450351, 103.522794]
                ]
            ],
            [
                'category_id' => $catTraktor->id,
                'name' => 'Traktor Roda 4',
                'merk' => '5045D',
                'inventories' => [
                    ['1PY5045DHSK095224', 'PY3029D862923', 'APBN', 2026, -1.450351, 103.522794],
                    ['1PY5045DLSK095271', 'PY3029D863471', 'APBN', 2026, -1.450351, 103.522794],
                    ['1PY5045DVSK095252', 'PY3029D863534', 'APBN', 2026, -1.450351, 103.522794]
                ]
            ],
            [
                'category_id' => $catTraktor->id,
                'name' => 'Traktor Roda 4',
                'merk' => 'AVERY-ANR 127',
                'inventories' => [
                    ['WFYN504E250305', 'T25109546', 'APBN', 2026, -1.450351, 103.522794],
                    ['WFYN504E250302', 'T25108720', 'APBN', 2026, -1.450351, 103.522794],
                    ['WFYN504E250354', 'T25107385', 'APBN', 2026, -1.450351, 103.522794],
                    ['WFYN504E250295', 'T25108286', 'APBN', 2026, -1.450351, 103.522794]
                ]
            ],
            [
                'category_id' => $catTraktor->id,
                'name' => 'Traktor Roda 4',
                'merk' => 'JOHN DEERE 5045 D',
                'inventories' => [
                    ['PY3029D863471', 'DZ120998', 'APBN', 2026, -1.450351, 103.522794],
                    ['PY3029D863593', 'DZ120905', 'APBN', 2026, -1.450351, 103.522794],
                    ['PY3029D863189', 'DZ120967', 'APBN', 2026, -1.450351, 103.522794]
                ]
            ],
            [
                'category_id' => $catTraktor->id,
                'name' => 'Traktor Roda 4',
                'merk' => 'CHEVALT TYPE CHE-50',
                'inventories' => [
                    ['WFYN504E250514', 'T26017145', 'APBN', 2026, -1.450351, 103.522794],
                    ['WFYN504E250517', 'T26017129', 'APBN', 2026, -1.450351, 103.522794],
                    ['WFYN504E250565', 'T25255238', 'APBN', 2026, -1.450351, 103.522794],
                    ['WFYN504E250571', 'T25255240', 'APBN', 2026, -1.450351, 103.522794]
                ]
            ],
            [
                'category_id' => $catTraktor->id,
                'name' => 'Traktor Roda 2',
                'merk' => 'AMBERJACK',
                'inventories' => [
                    ['C2501706ACD1', 'ASS0696', 'APBN', 2026, -1.450351, 103.522794],
                    ['C2502000ACD1', 'ASS0712', 'APBN', 2026, -1.450351, 103.522794]
                ]
            ],
            [
                'category_id' => $catTraktor->id,
                'name' => 'Traktor Roda 2',
                'merk' => 'ISHOKU ISTR-02',
                'inventories' => [
                    ['BF15042', 'TBF16013', 'APBN', 2026, -1.450351, 103.522794],
                    ['BF15038', 'TBF16053', 'APBN', 2026, -1.450351, 103.522794],
                    ['BF15040', 'TBF16015', 'APBN', 2026, -1.450351, 103.522794],
                    ['BF15044', 'TBF17031', 'APBN', 2026, -1.450351, 103.522794],
                    ['BF16036', 'TBF16029', 'APBN', 2026, -1.450351, 103.522794],
                    ['BF15039', 'TBF16025', 'APBN', 2026, -1.450351, 103.522794],
                    ['BF15041', 'TBF16054', 'APBN', 2026, -1.450351, 103.522794],
                    ['BF17015', 'TBF17044', 'APBN', 2026, -1.450351, 103.522794],
                    ['BF17013', 'TBF16051', 'APBN', 2026, -1.450351, 103.522794],
                    ['BF17012', 'TBF16050', 'APBN', 2026, -1.450351, 103.522794]
                ]
            ],
            [
                'category_id' => $catTraktor->id,
                'name' => 'Traktor Roda 2',
                'merk' => 'QUICK ZEVA G300',
                'inventories' => [
                    ['KI-ATE1305', 'A2601650AAH1', 'APBN', 2026, -1.450351, 103.522794],
                    ['KI-ATE1372', 'A2601634AAH1', 'APBN', 2026, -1.450351, 103.522794],
                    ['KI-ATE11266', 'A260798AAH1', 'APBN', 2026, -1.450351, 103.522794]
                ]
            ],
            [
                'category_id' => $catPompa->id,
                'name' => 'Mesin Pompa Air',
                'merk' => 'Yasuka WP 30 Titanium',
                'inventories' => [
                    ['SNB802510082', 'YSD20025U191212', 'APBN', 2026, -1.450351, 103.522794],
                    ['SNB802509663', 'YSD20025U191148', 'APBN', 2026, -1.450351, 103.522794],
                    ['SNB802509164', 'YSD20025U191133', 'APBN', 2026, -1.450351, 103.522794],
                    ['SNB802507183', 'YSD20025U190658', 'APBN', 2026, -1.450351, 103.522794],
                    ['SNB802507193', 'YSD20025S040089', 'APBN', 2026, -1.450351, 103.522794],
                    ['SNB802507194', 'YSD20025S040301', 'APBN', 2026, -1.450351, 103.522794],
                    ['SNB802507616', 'YSD20025S040600', 'APBN', 2026, -1.450351, 103.522794],
                    ['SNB802507716', 'YSD20025S040610', 'APBN', 2026, -1.450351, 103.522794],
                    ['SNB802507786', 'YSD20025S040652', 'APBN', 2026, -1.450351, 103.522794],
                    ['SNB802507789', 'YSD20025S042032', 'APBN', 2026, -1.450351, 103.522794],
                    ['SNB802507790', 'YSD20025S042033', 'APBN', 2026, -1.450351, 103.522794],
                    ['SNB802507791', 'YSD20025S042862', 'APBN', 2026, -1.450351, 103.522794]
                ]
            ]
        ];

        foreach ($data as $item) {
            $alsintan = Alsintan::firstOrCreate(
                ['name' => $item['name'], 'merk' => $item['merk']],
                [
                    'alsintan_category_id' => $item['category_id'],
                    'description' => 'Unit ' . $item['name'] . ' ' . $item['merk'],
                ]
            );

            foreach ($item['inventories'] as $inv) {
                $alsintan->inventories()->firstOrCreate([
                    'nomor_rangka' => $inv[0],
                    'nomor_mesin' => $inv[1],
                ], [
                    'sumber_dana' => $inv[2],
                    'tahun_pengadaan' => $inv[3],
                    'latitude' => $inv[4],
                    'longitude' => $inv[5],
                    'status_ketersediaan' => 'Tersedia',
                ]);
            }
        }
    }
}
