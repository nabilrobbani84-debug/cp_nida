<?php

namespace App\Http\Controllers;

use App\Enums\BranchProductionStatus;
use App\Http\Requests\BranchProduction\RejectBranchProductionRequest;
use App\Models\Branch;
use App\Models\BranchProduction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BranchProductionVerificationController extends Controller
{
    public function index(Request $request): View
    {
        $branchId = $request->input('id_branch');
        $productionDate = $request->input('production_date');

        $productions = BranchProduction::query()
            ->with(['product', 'branch'])
            ->where('status', BranchProductionStatus::Pending)
            ->when(filled($branchId), fn ($q) => $q->where('id_branch', $branchId))
            ->when(filled($productionDate), fn ($q) => $q->whereDate('production_date', $productionDate))
            ->orderByDesc('production_date')
            ->orderBy('id_branch')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $branches = Branch::query()
            ->whereIn('branch_name', ['Cabang 1', 'Cabang 2'])
            ->orderBy('branch_name')
            ->get();

        return view('features.branch-production-verifications.index', [
            'productions' => $productions,
            'branches' => $branches,
            'filters' => [
                'id_branch' => $branchId,
                'production_date' => $productionDate,
            ],
        ]);
    }

    public function validate(BranchProduction $branchProduction): RedirectResponse
    {
        $this->ensurePending($branchProduction);

        $branchProduction->update([
            'status' => BranchProductionStatus::Validated,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Data produksi berhasil divalidasi.');
    }

    public function reject(RejectBranchProductionRequest $request, BranchProduction $branchProduction): RedirectResponse
    {
        $this->ensurePending($branchProduction);

        $branchProduction->update([
            'status' => BranchProductionStatus::Rejected,
            'notes' => $request->validated('notes'),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Data produksi ditolak. Operator cabang dapat melihat alasan penolakan.');
    }

    private function ensurePending(BranchProduction $branchProduction): void
    {
        if ($branchProduction->status !== BranchProductionStatus::Pending) {
            abort(422, 'Hanya data berstatus pending yang dapat diproses.');
        }
    }
}
