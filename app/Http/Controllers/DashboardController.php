<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $apps = [
            [
                'title' => 'Quản lý tài khoản',
                'desc' => 'Acc / mật khẩu / ghi chú / hạn đổi số / đến hạn chưa đổi',
                'icon' => '🔐',
                'href' => route('apps.accounts.index'),
            ],
            [
                'title' => 'Thu / Chi bán acc',
                'desc' => 'Nhập thu/chi + tổng kết theo tháng + xem lại tháng cũ',
                'icon' => '💸',
                'href' => route('apps.finance.index'),
            ],
            [
                'title' => 'Treo hộ tài khoản',
                'desc' => 'Mã acc + ảnh + giá (nghìn) + phân khúc + xuất TXT/ZIP',
                'icon' => '🧷',
                'href' => route('apps.consignment.index'),
            ],

        ];

        return view('dashboard', compact('apps'));
    }
}
