<?php

namespace App\Modules\Accounts\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GameAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GameAccountController extends Controller
{
    // Trang danh sách + filter
    public function index(Request $request)
    {
        $q = GameAccount::query();

        // search theo account / note
        if ($s = trim((string)$request->get('s'))) {
            $q->where(function ($w) use ($s) {
                $w->where('account', 'like', "%{$s}%")
                  ->orWhere('note', 'like', "%{$s}%");
            });
        }

        // filter trạng thái đổi số
        if ($request->filled('changed')) {
            $changed = $request->get('changed'); // 0/1
            if ($changed === '0' || $changed === '1') {
                $q->where('is_changed', $changed === '1');
            }
        }

        // filter "đến hạn" (chưa đổi + due_date <= today)
        if ($request->get('due') === '1') {
            $today = Carbon::today()->toDateString();
            $q->where('is_changed', false)
              ->whereNotNull('change_due_date')
              ->where('change_due_date', '<=', $today);
        }

        $items = $q->orderByRaw('is_changed asc')
                   ->orderByRaw('change_due_date is null asc')
                   ->orderBy('change_due_date', 'asc')
                   ->orderBy('id', 'desc')
                   ->paginate(12)
                   ->withQueryString();

        $today = Carbon::today();

        return view('modules.accounts.index', compact('items', 'today'));
    }

    public function due(Request $request)
    {
        $request->merge(['due' => '1']);
        return $this->index($request);
    }

    public function create()
    {
        return view('modules.accounts.form', [
            'mode' => 'create',
            'item' => new GameAccount(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateInput($request);

        GameAccount::create($data);

        return redirect()->route('apps.accounts.index')->with('success', 'Đã thêm acc.');
    }

    public function edit($id)
    {
        $item = GameAccount::findOrFail($id);

        return view('modules.accounts.form', [
            'mode' => 'edit',
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = GameAccount::findOrFail($id);
        $data = $this->validateInput($request, $item->id);

        // Nếu user tick "đã đổi" thì set changed_at
        if (($data['is_changed'] ?? false) && !$item->is_changed) {
            $data['changed_at'] = now();
        }
        if (!($data['is_changed'] ?? false)) {
            $data['changed_at'] = null;
        }

        $item->update($data);

        return redirect()->route('apps.accounts.index')->with('success', 'Đã cập nhật.');
    }

    public function toggleChanged($id)
    {
        $item = GameAccount::findOrFail($id);
        $new = !$item->is_changed;

        $item->is_changed = $new;
        $item->changed_at = $new ? now() : null;
        $item->save();

        return back()->with('success', 'Đã đổi trạng thái.');
    }

    public function destroy($id)
    {
        $item = GameAccount::findOrFail($id);
        $item->delete();
        return back()->with('success', 'Đã xoá.');
    }

    private function validateInput(Request $request, $ignoreId = null): array
    {
        $validated = $request->validate([
            'account' => 'required|string|max:190|unique:game_accounts,account' . ($ignoreId ? ',' . $ignoreId : ''),
            'password' => 'required|string|max:255',
            'note' => 'nullable|string',
            'change_due_date' => 'nullable|string', // nhập dd/mm/yyyy
            'is_changed' => 'nullable|boolean',
        ]);

        // parse dd/mm/yyyy -> Y-m-d
        $due = trim((string)($validated['change_due_date'] ?? ''));
        $validated['change_due_date'] = $due ? $this->parseVNDate($due) : null;

        // checkbox
        $validated['is_changed'] = (bool)($request->input('is_changed', false));

        return $validated;
    }

    private function parseVNDate(string $d): string
    {
        // chấp nhận: dd/mm/yyyy hoặc dd-mm-yyyy
        $d = str_replace('-', '/', $d);
        $parts = explode('/', $d);
        if (count($parts) !== 3) {
            abort(422, 'Ngày đổi số không đúng định dạng dd/mm/yyyy');
        }
        [$day, $month, $year] = $parts;
        $day = (int)$day; $month = (int)$month; $year = (int)$year;

        if (!checkdate($month, $day, $year)) {
            abort(422, 'Ngày đổi số không hợp lệ');
        }

        return Carbon::create($year, $month, $day)->toDateString(); // Y-m-d
    }
}
