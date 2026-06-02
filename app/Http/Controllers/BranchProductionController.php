<?php

namespace App\Http\Controllers;

use App\Enums\BranchProductionStatus;
use App\Http\Requests\BranchProduction\StoreBranchProductionRequest;
use App\Models\BranchProduction;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BranchProductionController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->value();
        $branchId = $request->user()->id_branch;

        $productions = BranchProduction::query()
            ->with(['product', 'branch'])
            ->where('id_branch', $branchId)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('product', fn ($q) => $q->where('name', 'like', '%'.$search.'%')
                        ->orWhere('code', 'like', '%'.$search.'%'))
                        ->orWhere('notes', 'like', '%'.$search.'%');
                });
            })
            ->orderByDesc('production_date')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('features.branch-productions.index', [
            'productions' => $productions,
            'search' => $search,
            'readOnly' => $request->user()->isKepalaCabang(),
        ]);
    }

    public function create(Request $request): View
    {
        $products = Product::query()->orderBy('name')->get();

        return view('features.branch-productions.create', [
            'products' => $products,
            'branchName' => $request->user()->branch?->branch_name,
        ]);
    }

    public function store(StoreBranchProductionRequest $request): RedirectResponse
    {
        BranchProduction::query()->create([
            ...$request->validated(),
            'id_branch' => $request->user()->id_branch,
            'status' => BranchProductionStatus::Pending,
        ]);

        return redirect()
            ->route('branch-productions.index')
            ->with('success', 'Data produksi harian berhasil disimpan.');
    }

    public function show(Request $request, BranchProduction $branchProduction): View
    {
        $this->authorizeSameBranch($request, $branchProduction);

        $branchProduction->load(['product', 'branch']);

        return view('features.branch-productions.show', [
            'production' => $branchProduction,
            'readOnly' => $request->user()->isKepalaCabang(),
        ]);
    }

    private function authorizeSameBranch(Request $request, BranchProduction $branchProduction): void
    {
        if ((int) $branchProduction->id_branch !== (int) $request->user()->id_branch) {
            abort(403, 'Anda tidak dapat mengakses data produksi cabang lain.');
        }
    }
}
