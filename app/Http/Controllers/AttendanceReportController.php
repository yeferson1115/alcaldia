<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Empleoyes;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AusentismoExport;

class AttendanceReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.ausentismo');
    }

    public function data(Request $request)
    {
        $start = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfMonth();
        $end   = $request->end_date ? Carbon::parse($request->end_date)->endOfDay()   : Carbon::now()->endOfDay();

        $rows = $this->buildRows($start, $end);

        return response()->json(['data' => $rows]);
    }

    public function export(Request $request)
    {
        $start = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfMonth();
        $end   = $request->end_date ? Carbon::parse($request->end_date)->endOfDay()   : Carbon::now()->endOfDay();

        $rows = $this->buildRows($start, $end);

        return Excel::download(new AusentismoExport($rows), 'ausentismo.xlsx');
    }

    private function buildRows(Carbon $start, Carbon $end)
    {
        $empleados = Empleoyes::with('area')->get();
        $rows = [];
        $tz = config('app.timezone', 'America/Bogota');

        foreach ($empleados as $emp) {
            $attendances = Attendance::where('empleoye_id', $emp->id)
                ->whereBetween('created_at', [$start, $end])
                ->orderBy('created_at')
                ->get()
                ->groupBy(function ($a) {
                    return Carbon::parse($a->created_at)->toDateString();
                });

            $period = \Carbon\CarbonPeriod::create($start, $end);

            foreach ($period as $date) {
                $dateStr = $date->toDateString();
                $dayAtt  = $attendances->get($dateStr, collect());

                // Bloques de trabajo
                $morningStart    = $date->copy()->setTime(7, 30);
                $morningEnd      = $date->copy()->setTime(12, 0);
                $afternoonStart  = $date->copy()->setTime(13, 30);
                $afternoonEnd    = $date->copy()->setTime(18, 0);

                $morningBlock   = $this->calculateBlockPresence($dayAtt, $morningStart, $morningEnd, $tz);
                $afternoonBlock = $this->calculateBlockPresence($dayAtt, $afternoonStart, $afternoonEnd, $tz);

                $totalWorked   = $morningBlock['worked'] + $afternoonBlock['worked'];
                $totalAbsence  = $morningBlock['absence'] + $afternoonBlock['absence'];

                $allStamps = $dayAtt->map(function ($a) {
                    return $a->type == 1
                        ? "INGRESO " . $a->created_at
                        : "SALIDA " . $a->created_at;
                })->toArray();

                $rows[] = [
                    'fecha'            => $dateStr,
                    'empleado'         => trim($emp->name . ' ' . $emp->last_name),
                    'documento'        => $emp->document,
                    'area'             => optional($emp->area)->name ?? '',
                    'trabajado_manana' => $morningBlock['worked'],
                    'ausente_manana'   => $morningBlock['absence'],
                    'trabajado_tarde'  => $afternoonBlock['worked'],
                    'ausente_tarde'    => $afternoonBlock['absence'],
                    'total_trabajado'  => $totalWorked,
                    'total_ausente'    => $totalAbsence,
                    'estado'           => $totalAbsence > 0 ? "Ausente {$totalAbsence} min" : 'Presente',
                    'notas'            => implode(', ', $allStamps),
                ];
            }
        }

        return $rows;
    }

    private function calculateBlockPresence($attendances, Carbon $blockStart, Carbon $blockEnd, $tz)
    {
        $marks = $attendances->sortBy('created_at')->values();

        $intervals = [];
        $lastIn = null;

        foreach ($marks as $mark) {
            $time = Carbon::parse($mark->created_at)->setTimezone($tz);

            if ($mark->type == 1) { // Entrada
                if ($lastIn === null) {
                    $lastIn = $time;
                }
            } elseif ($mark->type == 0 && $lastIn !== null) { // Salida
                $intervals[] = [$lastIn, $time];
                $lastIn = null;
            }
        }

        // Si quedó adentro al terminar el bloque
        if ($lastIn !== null) {
            $intervals[] = [$lastIn, $blockEnd];
        }

        $workedMinutes = 0;

        foreach ($intervals as [$in, $out]) {
            // Ajustar a los límites del bloque
            $in  = $in->lessThan($blockStart) ? $blockStart : $in;
            $out = $out->greaterThan($blockEnd) ? $blockEnd : $out;

            if ($out->gt($in)) {
                $workedMinutes += $out->diffInMinutes($in);
            }
        }

        $expectedMinutes = $blockStart->diffInMinutes($blockEnd);
        $absenceMinutes  = max(0, $expectedMinutes - $workedMinutes);

        return [
            'worked'   => $workedMinutes,
            'absence'  => $absenceMinutes,
            'expected' => $expectedMinutes,
        ];
    }
}
