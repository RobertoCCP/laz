<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\User;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;
use PDF;

class AuditController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-audit')->only(['index', 'show']);
        $this->middleware('permission:generar-pdf')->only(['generatePDF']);
    }

    public function index()
    {
        $audits = Audit::orderBy('created_at', 'desc')->paginate(5);
        $userEmail = Auth::user()->email;
        $tables = ['clientes', 'usuarios', 'roles'];

        $likertData = [];

        foreach ($audits as $audit) {
            $user = User::findOrFail($audit->user_id);

            $userData = [
                'user' => $user,
                'actions' => [],
            ];

            foreach ($tables as $table) {
                $actionCounts = Audit::where('user_id', $user->id)
                    ->where('table_name', $table)
                    ->select(DB::raw('SUM(CASE WHEN action = "never" THEN 1 ELSE 0 END) as never'), 
                             DB::raw('SUM(CASE WHEN action = "once" THEN 1 ELSE 0 END) as once'), 
                             DB::raw('SUM(CASE WHEN action = "twice" THEN 1 ELSE 0 END) as twice'), 
                             DB::raw('SUM(CASE WHEN action = "three_times" THEN 1 ELSE 0 END) as three_times'), 
                             DB::raw('SUM(CASE WHEN action = "excessive" THEN 1 ELSE 0 END) as excessive'),
                             DB::raw('COUNT(*) as total'))
                    ->groupBy('user_id')
                    ->groupBy('table_name')
                    ->first();

                $userData['actions'][$table] = $this->getLikertScale($actionCounts);
            }

            $likertData[] = $userData;
        }

        return view('audits.index', compact('audits', 'userEmail', 'likertData', 'tables'));
    }

    public function destroy($id)
    {
        $audit = Audit::findOrFail($id);
        $audit->delete();

        return redirect()->route('audits.index')->with('success', 'Registro de auditoría eliminado correctamente.');
    }

    public function show($id)
    {
        $audit = Audit::findOrFail($id);
        $user = User::findOrFail($audit->user_id);

        $relatedData = null;
        if ($audit->action === 'creación' && $audit->table_name === 'clientes') {
            $relatedData = Cliente::findOrFail($audit->new_data['id']);
        }

        return view('audits.show', compact('audit', 'user', 'relatedData'));
    }

    public function generatePDF()
    {
        $audits = Audit::orderBy('created_at', 'desc')->get();
        $userEmail = Auth::user()->email;

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);
        $html = view('audits.pdf', compact('audits', 'userEmail'))->render();
        $dompdf->loadHtml($html);
        $dompdf->render();

        return $dompdf->stream('audits_report.pdf');
    }

    public function likert()
    {
        $users = User::all();
        $tables = ['clientes', 'usuarios', 'roles'];

        $likertData = [];

        foreach ($users as $user) {
            $userData = [
                'user' => $user,
                'actions' => [],
            ];

            foreach ($tables as $table) {
                $actionCounts = Audit::where('user_id', $user->id)
                    ->where('table_name', $table)
                    ->select(DB::raw('SUM(CASE WHEN action = "never" THEN 1 ELSE 0 END) as never'), 
                             DB::raw('SUM(CASE WHEN action = "once" THEN 1 ELSE 0 END) as once'), 
                             DB::raw('SUM(CASE WHEN action = "twice" THEN 1 ELSE 0 END) as twice'), 
                             DB::raw('SUM(CASE WHEN action = "three_times" THEN 1 ELSE 0 END) as three_times'), 
                             DB::raw('SUM(CASE WHEN action = "excessive" THEN 1 ELSE 0 END) as excessive'),
                             DB::raw('COUNT(*) as total'))
                    ->groupBy('table_name')
                    ->first();

                $userData['actions'][$table] = $actionCounts ? $this->getLikertScale($actionCounts) : null;
            }

            $likertData[] = $userData;
        }

        return view('audits.likert', compact('likertData', 'tables'));
    }
    
    private function getLikertScale($actionCounts)
    {
        $scale = [
            'never' => '',
            'once' => '',
            'twice' => '',
            'three_times' => '',
            'excessive' => '',
            'total' => 0,
        ];
    
        if ($actionCounts && $actionCounts->total === 0) {
            $scale['never'] = 'checked';
        } elseif ($actionCounts && $actionCounts->total === 1) {
            $scale['once'] = 'checked';
        } elseif ($actionCounts && $actionCounts->total === 2) {
            $scale['twice'] = 'checked';
        } elseif ($actionCounts && $actionCounts->total === 3) {
            $scale['three_times'] = 'checked';
        } elseif ($actionCounts && $actionCounts->total >= 4) {
            $scale['excessive'] = 'checked';
        }
    
        if ($actionCounts) {
            $scale['total'] = $actionCounts->total;
        }
    
        return $scale;
    }

    public function showChart()
{
    $users = User::all();
    $tables = ['clientes', 'usuarios', 'roles'];

    $likertData = [];

    foreach ($users as $user) {
        $userData = [
            'user' => $user,
            'actions' => [],
        ];

        foreach ($tables as $table) {
            $actionCounts = Audit::where('user_id', $user->id)
                ->where('table_name', $table)
                ->select(DB::raw('SUM(CASE WHEN action = "never" THEN 1 ELSE 0 END) as never'),
                    DB::raw('SUM(CASE WHEN action = "once" THEN 1 ELSE 0 END) as once'),
                    DB::raw('SUM(CASE WHEN action = "twice" THEN 1 ELSE 0 END) as twice'),
                    DB::raw('SUM(CASE WHEN action = "three_times" THEN 1 ELSE 0 END) as three_times'),
                    DB::raw('SUM(CASE WHEN action = "excessive" THEN 1 ELSE 0 END) as excessive'),
                    DB::raw('COUNT(*) as total'))
                ->groupBy('table_name')
                ->first();

            $userData['actions'][$table] = $actionCounts ? $this->getLikertScale($actionCounts) : null;
        }

        $likertData[] = $userData;
    }

    return view('audits.chart', compact('likertData', 'tables'));
}
}
