<?php

namespace App\Http\Controllers;

use App\Models\CheckInNonPersonalTrainer;
use App\Models\Staff\PersonalTrainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class AbsensiNonPTController extends Controller
{
    public function index()
    {
        $data = [
            'title'                     => 'Absensi Non PT',
            'personalTrainers'          => PersonalTrainer::where('type', 'Non-PT')->get(),
            'content'                   => 'admin/absensi-non-pt/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pt_code' => 'required|exists:personal_trainers,pt_code',
        ], [
            'pt_code.exists' => 'CARD NOT FOUND',
        ]);

        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first('pt_code');
            echo "<script>alert('$errorMessage');</script>";
            echo "<script>window.location.href = '" . route('absensi-non-pt') . "';</script>";
            return;
        }

        $nonPt = PersonalTrainer::checkInNonPT($request->pt_code);
        // dd($nonPt[0]);
        // dd($nonPt[0]->current_check_in_trainer_sessions_id);
        $message = "";

        if ($nonPt[0]->check_in_time && !$nonPt[0]->check_out_time) {
            $checkInNonPt = CheckInNonPersonalTrainer::find($nonPt[0]->current_check_in_trainer_sessions_id);
            // dd($checkInNonPt);
            $checkInNonPt->update([
                'check_out_time' => now()->tz('Asia/Jakarta'),
            ]);
            $message = 'Trainer Session Checked Out Successfully';
            return redirect()->back()->with('success', 'Trainer Berhasil Absen Pulang');
        } else {
            $data = [
                'pt_id' => $nonPt[0]->id,
                'check_in_time' => now()->tz('Asia/Jakarta'),
                'user_id' => Auth::user()->id
            ];
            CheckInNonPersonalTrainer::create($data);
            $message = 'Trainer Session Checked In Successfully';
            return redirect()->back()->with('success', 'Trainer Berhasil Absen Datang');
        }
        // return redirect()->route('absensi-non-pt');
    }

    public function show($id)
    {
        $pt = PersonalTrainer::find($id);
        $detail = PersonalTrainer::test($id);
        // dd($detail);

        $data = [
            'title'             => 'Detail Absensi ' . $pt->full_name,
            'personalTrainers'  => $detail,
            'content'           => 'admin/absensi-non-pt/detail',
        ];

        return view('admin.layouts.wrapper', $data);
    }


    public function report()
    {
        $fromDate       = Request()->input('fromDate');
        $fromDate       = $fromDate ?  DateFormat($fromDate) : NowDate();

        $toDate         = Request()->input('toDate');
        $toDate         = $toDate ? DateFormat($toDate) : NowDate();
        $personalTrainer = Request()->input('trainerName');
        $pdf            = Request()->input('pdf');

        $results = PersonalTrainer::select('personal_trainers.full_name as trainer_name', DB::raw('COUNT(personal_trainers.id) as pt_total'))
            ->join('check_in_trainer_sessions', 'check_in_trainer_sessions.pt_id', '=', 'personal_trainers.id')
            ->whereNotNull('check_in_trainer_sessions.check_out_time')
            ->whereDate('check_in_trainer_sessions.check_in_time', '>=', $fromDate) // Ini bukannya harus pakai start_date ?
            ->whereDate('check_in_trainer_sessions.check_in_time', '<=', $toDate)
            ->where('personal_trainers.id', '=', $personalTrainer)
            ->groupBy('personal_trainers.id', 'personal_trainers.full_name')
            ->orderBy('personal_trainers.full_name', 'asc')
            ->get();

        if ($pdf && $pdf == '1') {
            $pdf = Pdf::loadView('admin/gym-report/pt-total', [
                'result'   => $results,
            ]);
            return $pdf->stream('PT-Total-Report.pdf');
        }

        $data = [
            'title'                 => 'Personal Trainer Total Report',
            'personalTrainer'       => $personalTrainer,
            'administrator'         => User::where('role', 'ADMIN')->get(),
            'result'                => $results,
            'fromDate'              => $fromDate,
            'toDate'                => $toDate,
            'page'                  => Request()->input('page'),
            'content'               => 'admin/gym-report/pt-total'
        ];

        return view('admin.layouts.wrapper', $data);
    }
}
