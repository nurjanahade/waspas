<?php

namespace App\Http\Controllers;

use App\Models\AlternatifModel;
use Illuminate\Http\Request;
use App\Models\KriteriaModel;
use App\Models\PenilaianModel;
use App\Models\subKriteriaModel;
use Illuminate\Support\Facades\Redirect;

class PenilaianController extends Controller
{
    public function index()
    {
        $kriteria = KriteriaModel::all();
        $alternatif = AlternatifModel::all();
        $subKriteria = subKriteriaModel::all();
        $penilaian = PenilaianModel::all();

        // dd($subrelation);
        $kriteriaCount = KriteriaModel::count();
        $alternatifCount = AlternatifModel::count();


        for ($i = 0; $i < $kriteriaCount; $i++) {
            ${'kriteria' . $i} = $kriteria->get($i);
            $kriteriaJenis[] =  ${'kriteria' . $i}->jenis_kriteria;
        }

        for ($i = 0; $i < $kriteriaCount; $i++) {
            ${'kriteria' . $i} = $kriteria->get($i);
            $kriteriaKode[] =  ${'kriteria' . $i}->kode_kriteria;
        }

        for ($i = 0; $i < $alternatifCount; $i++) {
            ${'alternatif' . $i} = $alternatif->get($i);
            $alternatifJenis[] =  ${'alternatif' . $i}->nama_guru;
        }

        for ($i = 0; $i < $alternatifCount; $i++) {
            ${'alternatif' . $i} = $alternatif->get($i);
            $alternatifKode[] =  ${'alternatif' . $i}->kode_alternatif;
        }

        // foreach ($penilaian as $key) {
        //     $test[] = $key->nilai;
        //     # code...
        // }
        // dd($test);
        // dd($penilaian->where('kode_alternatif', $alternatifKode[3])->where('kode_kriteria', $kriteriaKode[3 + 1])->first());
        // dd($alternatifJenis);
        return view('penilaian', [
            'kriteria' => $kriteriaJenis,
            'kriteriaCount' => $kriteriaCount,
            'kriteriaKode' => $kriteriaKode,
            'penilaian' => $penilaian,

            'alternatif' => $alternatifJenis,
            'alternatifCount' => $alternatifCount,
            'alternatifKode' => $alternatifKode,
            'subKriteria' => $subKriteria
        ]);
    }

    public function tambahPenilaian(Request $request)
    {
        // $nilai = subKriteriaModel::where('keterangan', $request->kriteria2)->first();
        // dd($nilai->nilai);

        for ($i = 1; $i <=  $kriteriaCount = KriteriaModel::count(); $i++) {
            ${'nilai' . $i} = subKriteriaModel::where('keterangan', $request->{'kriteria' . $i})->first();
            PenilaianModel::create([
                'kode_alternatif' => $request->kode_alternatif,
                'kode_kriteria' => 'C' . $i,
                'nilai' => ${'nilai' . $i}->nilai,
                'sub_kriteria' =>  ${'nilai' . $i}->id,
            ]);
        }
        return Redirect("/penilaian");
    }
    public function editPenilaian($alternatif)
    {
        for ($i = 1; $i <= KriteriaModel::count(); $i++) {
            # code...
            $get[] = PenilaianModel::where('kode_alternatif', $alternatif)
                ->where('kode_kriteria', 'C' . $i)
                ->first();
        }
        // dd($get);
        foreach ($get as $key) {
            $data[] = $key->sub->keterangan;
        }

        return response()->json($data);
    }

    public function updatePenilaian(Request $request)
    {
        // dd($request);
        $alternatif = $request->kode_alternatif_edit;
        for ($i = 1; $i <=  $kriteriaCount = KriteriaModel::count(); $i++) {
            ${'nilai' . $i} = subKriteriaModel::where('keterangan', $request->{'kriteriaEdit' . $i})->first();
            PenilaianModel::where('kode_alternatif', $alternatif)
                ->where('kode_kriteria', 'C' . $i)
                ->update([
                    // 'kode_alternatif' => $request->kode_alternatif_edit,
                    // 'kode_kriteria' => 'C' . $i,
                    'nilai' => ${'nilai' . $i}->nilai,
                    'sub_kriteria' =>  ${'nilai' . $i}->id,
                ]);
            // dd(${'nilai' . $i});
        }
        return Redirect("/penilaian");
    }

    public function indexPerhitungan()
    {
        $kriteria = KriteriaModel::all();
        $alternatif = AlternatifModel::all();
        $subKriteria = subKriteriaModel::all();
        $penilaian = PenilaianModel::all();

        // dd($subrelation);
        $kriteriaCount = KriteriaModel::count();
        $alternatifCount = AlternatifModel::count();

        // dd($penilaian->where('kode_kriteria', 'C3')->max('nilai'));

        // GET JENIS KRITERIA
        for ($i = 0; $i < $kriteriaCount; $i++) {
            ${'kriteria' . $i} = $kriteria->get($i);
            $kriteriaJenis[] =  ${'kriteria' . $i}->jenis_kriteria;
        }
        // GET KODE KRITERIA
        for ($i = 0; $i < $kriteriaCount; $i++) {
            ${'kriteria' . $i} = $kriteria->get($i);
            $kriteriaKode[] =  ${'kriteria' . $i}->kode_kriteria;
        }

        // GET NAMA GURU
        for ($i = 0; $i < $alternatifCount; $i++) {
            ${'alternatif' . $i} = $alternatif->get($i);
            $alternatifJenis[] =  ${'alternatif' . $i}->nama_guru;
        }

        // GET KODE GURU
        for ($i = 0; $i < $alternatifCount; $i++) {
            ${'alternatif' . $i} = $alternatif->get($i);
            $alternatifKode[] =  ${'alternatif' . $i}->kode_alternatif;
        }

        // NORMALISASI
        for ($j = 1; $j <= $alternatifCount; $j++) {
            $first = collect($penilaian->where('kode_alternatif', 'A' . $j)->all());
            for ($i = 1; $i <= $kriteriaCount; $i++) {
                $seleksi = $kriteria->where('kode_kriteria', 'C' . $i)->first();
                ${'C' . $i . '_' . $j} = $penilaian->where('kode_kriteria', 'C' . $i)->first();
                ${'x' .  $i . '_' . $j} = $first->where('kode_kriteria', 'C' . $i)->first();
                if ($seleksi->keterangan == 'BENEFIT') {
                    ${'dataNormal' . $j}[] = ${'x' .  $i . '_' . $j}->nilai /  ${'C' . $i . '_' . $j}->max('nilai');
                    // ${'data' . $j}[] = ${'dataNormal' . $i};
                } else {
                    ${'dataNormal' . $i}[] = ${'C' . $i . '_' . $j}->max('nilai') / ${'x' .  $i . '_' . $j}->nilai;
                }
            }
        }

        for ($j = 1; $j <= $alternatifCount; $j++) {
            $data[] =  ${'dataNormal' . $j};
        }
        // $test = $kriteria->where('kode_kriteria', 'C' . 1)->first();
        // dd($test->);
        // 
        // Mencari Nilai Qi
        for ($j = 1; $j <= $alternatifCount; $j++) {
            for ($i = 1; $i <= $kriteriaCount; $i++) {
                ${'bobot' .  $i . '_' . $j} = $kriteria->where('kode_kriteria', 'C' . $i)->first();
                ${'bobot' .  $i . '_' . $j} = ${'kriteria' .  $i . '_' . $j}->bobot;
                // dd(${'bobot' .  $i . '_' . $j});
                ${'timesQ' .  $i . '_' . $j} =  ${'bobot' .  $i . '_' . $j}->bobot * $data[$j - 1][$i - 1];
                ${'powQ' .  $i . '_' . $j} =  pow($data[$j - 1][$i - 1], ${'bobot' .  $i . '_' . $j}->bobot);
            }
            // dd(${'bobot' .  5 . '_' . 3});

            ${'times2Q' . $j} =  ${'timesQ' . 1 . '_' . $j};
            ${'pow2Q' . $j} =  ${'powQ' . 1 . '_' . $j};
            for ($k = 2; $k <= $kriteriaCount; $k++) {
                ${'times2Q' . $j} =   ${'times2Q' . $j} + ${'timesQ' .  $k . '_' . $j};
                ${'pow2Q' . $j} =   ${'pow2Q' . $j} * ${'powQ' .  $k . '_' . $j};
            }
            ${'Q' . $j} = (${'times2Q' . $j} * 0.5) + (${'pow2Q' . $j} * 0.5);
        }


        for ($j = 1; $j <= $alternatifCount; $j++) {
            $dataQi[] =  ${'Q' . $j};
        }
        // dd((($bobot1_1->bobot * $data[0][0])
        //     + ($bobot2_1->bobot * $data[0][1])
        //     + ($bobot3_1->bobot * $data[0][2])
        //     + ($bobot4_1->bobot * $data[0][3])
        //     + ($bobot5_1->bobot * $data[0][4]))
        //     * 0.5);
        return view('perhitungan', [
            'kriteria' => $kriteriaJenis,
            'kriteriaCount' => $kriteriaCount,
            'kriteriaKode' => $kriteriaKode,
            'penilaian' => $penilaian,
            'data' => $data,
            'dataQi' => $dataQi,

            'alternatif' => $alternatifJenis,
            'alternatifCount' => $alternatifCount,
            'alternatifKode' => $alternatifKode,
            'subKriteria' => $subKriteria
        ]);
    }
}
