<?php

namespace App\Http\Controllers;

use App\Fpdf;
use App\Models\Vote;
use App\Models\Position;
use DB;
use App\Models\Setting;
use Illuminate\Support\Str;

class AdminVoteController extends Controller
{
    public function index()
    {
        return view('admin.votes');
    }

    public function reset()
    {
        Vote::truncate();

        return redirect()->back()->withMessage("Votes resetted successfully"); 
    }

    public function list()
    {
        $votes = DB::select('
            select 
                c.name as candidate_name, 
                v.name as voter_name, 
                p.name as position_name 
            from 
                votes 
                inner join voters as v on v.id = votes.voter_id 
                inner join positions as p on p.id = votes.position_id 
                inner join (
                select 
                    vt.name as name, 
                    candidates.id 
                from 
                    candidates 
                    inner join voters as vt on vt.id = candidates.voter_id
                ) as c on c.id = votes.candidate_id
            '
        );

        return datatables()->of($votes)->make();
    }

    public function print(Fpdf $pdf)
    {
        $headers = ['ID','CANDIDATE NAME','VOTE COUNT(S)'];
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->SetFont('Arial','B',12);

        $positions = Position::with([
            'candidates' => fn($q) => $q->withCount('votes'),
            'candidates.voter'
        ])->get();

        foreach($positions as $position) {
            $pdf->Cell(63 * 3,12,strtoupper($position->name),1,0,'C');
            $pdf->Ln();
            foreach($headers as $header) {
                $pdf->Cell(63,12,$header,1,0,'C');
            }

            $pdf->Ln();

            $count = 1;
            foreach($position->candidates as $candidate) {
                $pdf->Cell(63,12,'#'.$count,1,0,'C');
                $pdf->CellFitScale(63,12,strtoupper($candidate->voter->name),1,0,'C');
                $pdf->Cell(63,12,$candidate->votes_count,1,0,'C');
                $pdf->Ln();
                $count++;
            }

            $pdf->Ln();
            $pdf->Ln();
        }

        $setting = Setting::find(1);

        $pdf->Output('I',Str::snake(strtolower($setting->election_title)).'_'.date('Y').'_'.(date('Y')+1).'.pdf');
    }
}
