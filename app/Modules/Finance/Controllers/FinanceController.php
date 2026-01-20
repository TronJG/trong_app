<?php

namespace App\Modules\Finance\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MoneyTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function index()
    {
        $ym = Carbon::now()->format('Y-m');
        return redirect()->route('apps.finance.month', ['ym' => $ym]);
    }

    public function month(Request $request, string $ym)
    {
        // ym: YYYY-MM
        if (!preg_match('/^\d{4}-\d{2}$/', $ym)) {
            abort(404);
        }

        $start = Carbon::createFromFormat('Y-m', $ym)->startOfMonth()->toDateString();
        $end = Carbon::createFromFormat('Y-m', $ym)->endOfMonth()->toDateString();

        $q = MoneyTransaction::query()->whereBetween('trans_date', [$start, $end]);

        if ($type = $request->get('type')) {
            if (in_array($type, ['income', 'expense'], true)) {
                $q->where('type', $type);
            }
        }

        if ($s = trim((string)$request->get('s'))) {
            $q->where('note', 'like', "%{$s}%");
        }

        $items = $q->orderBy('trans_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(12)
            ->withQueryString();

        // Tổng thu/chi/thực nhận theo tháng
        $totals = MoneyTransaction::query()
            ->selectRaw("SUM(CASE WHEN type='income' THEN amount ELSE 0 END) as income_total")
            ->selectRaw("SUM(CASE WHEN type='expense' THEN amount ELSE 0 END) as expense_total")
            ->whereBetween('trans_date', [$start, $end])
            ->first();

        $incomeTotal = (int)($totals->income_total ?? 0);
        $expenseTotal = (int)($totals->expense_total ?? 0);
        $net = $incomeTotal - $expenseTotal;

        // Danh sách các tháng đã có dữ liệu để xem lại
        $months = MoneyTransaction::query()
            ->selectRaw("DATE_FORMAT(trans_date, '%Y-%m') as ym")
            ->groupBy('ym')
            ->orderBy('ym', 'desc')
            ->limit(24)
            ->pluck('ym')
            ->toArray();

        return view('modules.finance.index', compact(
            'items', 'ym', 'incomeTotal', 'expenseTotal', 'net', 'months'
        ));
    }

    public function create()
    {
        return view('modules.finance.form', [
            'mode' => 'create',
            'item' => new MoneyTransaction(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateInput($request);
        MoneyTransaction::create($data);

        $ym = Carbon::parse($data['trans_date'])->format('Y-m');
        return redirect()->route('apps.finance.month', ['ym' => $ym])->with('success', 'Đã thêm giao dịch.');
    }

    public function edit($id)
    {
        $item = MoneyTransaction::findOrFail($id);

        return view('modules.finance.form', [
            'mode' => 'edit',
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = MoneyTransaction::findOrFail($id);
        $data = $this->validateInput($request);

        $item->update($data);

        $ym = Carbon::parse($data['trans_date'])->format('Y-m');
        return redirect()->route('apps.finance.month', ['ym' => $ym])->with('success', 'Đã cập nhật.');
    }

    public function destroy($id)
    {
        $item = MoneyTransaction::findOrFail($id);
        $ym = $item->trans_date ? $item->trans_date->format('Y-m') : Carbon::now()->format('Y-m');

        $item->delete();
        return redirect()->route('apps.finance.month', ['ym' => $ym])->with('success', 'Đã xoá.');
    }

    private function validateInput(Request $request): array
    {
        $validated = $request->validate([
            'trans_date' => 'required|string',   // dd/mm/yyyy hoặc yyyy-mm-dd
            'type'       => 'required|in:income,expense',
            'amount'     => 'required|integer|min:0',
            'note'       => 'nullable|string|max:255',
        ]);

        $validated['trans_date'] = $this->parseDate($validated['trans_date']);

        return $validated;
    }

    private function parseDate(string $d): string
    {
        $d = trim($d);

        // cho nhập dd/mm/yyyy hoặc dd-mm-yyyy
        if (preg_match('/^\d{2}[\/-]\d{2}[\/-]\d{4}$/', $d)) {
            $d = str_replace('-', '/', $d);
            [$day, $month, $year] = explode('/', $d);
            if (!checkdate((int)$month, (int)$day, (int)$year)) {
                abort(422, 'Ngày không hợp lệ');
            }
            return Carbon::create((int)$year, (int)$month, (int)$day)->toDateString();
        }

        // hoặc yyyy-mm-dd
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $d)) {
            return Carbon::parse($d)->toDateString();
        }

        abort(422, 'Định dạng ngày phải là dd/mm/yyyy hoặc yyyy-mm-dd');
    }
}
