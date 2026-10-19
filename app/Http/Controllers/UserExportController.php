<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserExportController extends Controller
{
    public function pdf(Request $request)
    {
        $users = $this->userQuery($this->validatedSearch($request))->get();

        return Pdf::loadView('exports.user', compact('users'))
            ->setPaper('a4', 'landscape')
            ->download('data-user.pdf');
    }

    public function excel(Request $request)
    {
        return Excel::download(
            new UserExport($this->userQuery($this->validatedSearch($request))),
            'data-user.xlsx',
        );
    }

    private function validatedSearch(Request $request): string
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
        ]);

        return trim($validated['search'] ?? '');
    }

    private function userQuery(string $search): Builder
    {
        return User::query()
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('nama', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('role', 'like', "%{$search}%");
                });
            })
            ->orderBy('role');
    }
}
