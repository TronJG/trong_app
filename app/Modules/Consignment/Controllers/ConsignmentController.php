<?php

namespace App\Modules\Consignment\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ConsignmentAccount;
use App\Models\ConsignmentImage;
use Illuminate\Http\Request;

class ConsignmentController extends Controller
{
    private array $segments = [
        'Dưới 200k',
        '200k - 500k',
        '500k - 1tr',
        '1tr - 2tr',
        'Trên 2tr',
    ];

    public function index(Request $request)
    {
        $q = ConsignmentAccount::query()->with('images');

        // ✅ Search: nếu nhập số -> tìm theo skins, còn lại tìm theo code/note
        if ($s = trim((string) $request->get('s'))) {
            $q->where(function ($qq) use ($s) {

                // nhập số -> tìm đúng số skin
                if (ctype_digit($s)) {
                    $qq->orWhere('skins', (int) $s);
                }

                // vẫn tìm theo mã / ghi chú
                $qq->orWhere('code', 'like', "%{$s}%")
                    ->orWhere('note', 'like', "%{$s}%");
            });
        }

        // filter phân khúc
        if (($seg = $request->get('segment')) !== null && $seg !== '') {
            $q->where('segment', $seg);
        }

        // ✅ Slider giá: cố định max = 25 triệu => price_k max = 25000
        $sliderMax = 25000;

        $minK = $request->filled('min_k') ? (int) $request->get('min_k') : 0;
        $maxK = $request->filled('max_k') ? (int) $request->get('max_k') : $sliderMax;

        // clamp để không vượt giới hạn
        $minK = max(0, min($minK, $sliderMax));
        $maxK = max(0, min($maxK, $sliderMax));

        // nếu kéo min > max thì đổi lại
        if ($minK > $maxK) {
            $t = $minK;
            $minK = $maxK;
            $maxK = $t;
        }

        // áp lọc giá
        $q->whereBetween('price_k', [$minK, $maxK]);

        $items = $q->orderBy('id', 'desc')->paginate(12)->withQueryString();
        $segments = $this->segments;

        return view('modules.consignment.index', compact('items', 'segments', 'sliderMax'));
    }

    public function create()
    {
        $segments = $this->segments;

        return view('modules.consignment.form', [
            'mode' => 'create',
            'item' => new ConsignmentAccount(),
            'segments' => $segments,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateInput($request);
        $item = ConsignmentAccount::create($data);

        $this->saveImagesToPublic($request, $item);

        return redirect()->route('apps.consignment.index')->with('success', 'Đã thêm tài khoản treo hộ.');
    }

    public function edit($id)
    {
        $item = ConsignmentAccount::with('images')->findOrFail($id);
        $segments = $this->segments;

        return view('modules.consignment.form', [
            'mode' => 'edit',
            'item' => $item,
            'segments' => $segments,
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = ConsignmentAccount::with('images')->findOrFail($id);

        $data = $this->validateInput($request, $item->id);
        $item->update($data);

        $this->saveImagesToPublic($request, $item);

        $deleteIds = $request->input('delete_images', []);
        if (is_array($deleteIds) && count($deleteIds)) {
            $imgs = ConsignmentImage::whereIn('id', $deleteIds)
                ->where('consignment_account_id', $item->id)
                ->get();

            foreach ($imgs as $img) {
                $abs = public_path($img->path);
                if (is_file($abs))
                    @unlink($abs);
                $img->delete();
            }
        }

        return redirect()->route('apps.consignment.index')->with('success', 'Đã cập nhật.');
    }

    public function destroy($id)
    {
        $item = ConsignmentAccount::with('images')->findOrFail($id);

        foreach ($item->images as $img) {
            $abs = public_path($img->path);
            if (is_file($abs))
                @unlink($abs);
        }

        $item->delete();

        return back()->with('success', 'Đã xoá.');
    }

    public function exportTxt(Request $request)
    {
        $ids = $this->selectedIds($request);

        $items = ConsignmentAccount::whereIn('id', $ids)
            ->orderBy('id', 'desc')
            ->get();

        $lines = []; // phải khởi tạo mảng trước

        foreach ($items as $it) {
            $lines[] =
                $it->heroes . '|' . $it->skins
                . ' - Giá : ' . number_format($it->price_vnd) . 'đ'
                . ' - mã : ' . $it->code
                . ($it->note ? ' - note : ' . $it->note : '');
        }

        $content = implode("\r\n", $lines) . "\r\n";
        $filename = $this->safeName($request->input('filename', 'treoho')) . '.txt';

        return response($content, 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }


    public function exportImages(Request $request)
    {
        $ids = $this->selectedIds($request);
        $items = ConsignmentAccount::with('images')->whereIn('id', $ids)->get();

        $baseName = $this->safeName($request->input('filename', 'images'));

        $files = [];
        foreach ($items as $it) {
            $img = $it->images->first();
            if (!$img)
                continue;

            $abs = public_path($img->path);
            if (is_file($abs))
                $files[] = $abs;
        }

        if (count($files) === 0) {
            return back()->with('success', 'Không có ảnh nào để xuất.');
        }

        if (count($files) === 1) {
            $ext = pathinfo($files[0], PATHINFO_EXTENSION);
            return response()->download($files[0], $baseName . '.' . $ext);
        }

        foreach ($files as $i => $abs) {
            $ext = pathinfo($abs, PATHINFO_EXTENSION);
            $filename = $baseName . '_' . ($i + 1) . '.' . $ext;

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Length: ' . filesize($abs));
            readfile($abs);
        }
        exit;
    }

    private function validateInput(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            'code' => 'required|string|max:190|unique:consignment_accounts,code' . ($ignoreId ? ',' . $ignoreId : ''),
            'price_k' => 'required|integer|min:0',
            'segment' => 'nullable|string|max:50',
            'heroes' => 'required|integer|min:0|max:9999',
            'skins' => 'required|integer|min:0|max:9999',
            'note' => 'nullable|string',
            'images.*' => 'nullable|image|max:4096',
        ]);
    }

    private function saveImagesToPublic(Request $request, ConsignmentAccount $item): void
    {
        if (!$request->hasFile('images'))
            return;

        $files = $request->file('images');
        if (!is_array($files))
            $files = [$files];

        $dir = public_path('uploads/consignment');
        if (!is_dir($dir))
            @mkdir($dir, 0777, true);

        foreach ($files as $file) {
            if (!$file || !$file->isValid())
                continue;

            $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
            $name = $item->code . '_' . date('Ymd_His') . '_' . uniqid() . '.' . $ext;

            $file->move($dir, $name);

            ConsignmentImage::create([
                'consignment_account_id' => $item->id,
                'path' => 'uploads/consignment/' . $name,
            ]);
        }
    }

    private function selectedIds(Request $request): array
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || count($ids) === 0) {
            abort(422, 'Bạn chưa chọn tài khoản nào.');
        }
        return array_map('intval', $ids);
    }

    private function safeName(string $name): string
    {
        $name = trim($name) ?: 'export';
        $name = preg_replace('/[^a-zA-Z0-9_\-]+/', '_', $name);
        return substr($name, 0, 60);
    }
}
