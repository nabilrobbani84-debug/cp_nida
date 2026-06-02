<?php

namespace App\Http\Controllers;

use App\Http\Requests\Branch\StoreBranchRequest;
use App\Http\Requests\Branch\UpdateBranchRequest;
use App\Models\Branch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BranchController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->value();

        $branches = Branch::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('branch_name', 'like', '%'.$search.'%')
                        ->orWhere('location', 'like', '%'.$search.'%');
                });
            })
            ->orderBy('id_branch')
            ->paginate(10)
            ->withQueryString();

        return view('features.branches.index', compact('branches', 'search'));
    }

    public function create(): View
    {
        return view('features.branches.create');
    }

    public function store(StoreBranchRequest $request): RedirectResponse
    {
        Branch::query()->create($request->validated());

        return redirect()
            ->route('branches.index')
            ->with('success', 'Cabang berhasil ditambahkan.');
    }

    public function show(Branch $branch): View
    {
        $branch->loadCount('users');

        return view('features.branches.show', compact('branch'));
    }

    public function edit(Branch $branch): View
    {
        return view('features.branches.edit', compact('branch'));
    }

    public function update(UpdateBranchRequest $request, Branch $branch): RedirectResponse
    {
        $branch->update($request->validated());

        return redirect()
            ->route('branches.index')
            ->with('success', 'Data cabang berhasil diperbarui.');
    }

    public function destroy(Branch $branch): RedirectResponse
    {
        if ($branch->users()->exists()) {
            return redirect()
                ->route('branches.index')
                ->with('error', 'Cabang tidak dapat dihapus karena masih digunakan oleh pengguna.');
        }

        $branch->delete();

        return redirect()
            ->route('branches.index')
            ->with('success', 'Cabang berhasil dihapus.');
    }
}
