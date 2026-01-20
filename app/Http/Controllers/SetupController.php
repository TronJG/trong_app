<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SetupController extends Controller
{
    public function show()
    {
        return view('setup');
    }

    public function connect(Request $request)
    {
        $data = $request->validate([
            'host' => 'required|string',
            'port' => 'required|string',
            'database' => 'required|string',
            'username' => 'required|string',
            'password' => 'nullable|string',
        ]);

        try {
            // 1) kết nối MySQL server không cần chọn database
            $tmpConfig = [
                'driver' => 'mysql',
                'host' => $data['host'],
                'port' => $data['port'],
                'database' => null,
                'username' => $data['username'],
                'password' => $data['password'] ?? '',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
                'options' => extension_loaded('pdo_mysql') ? array_filter([]) : [],
            ];

            config(['database.connections._setup' => $tmpConfig]);
            DB::purge('_setup');
            DB::connection('_setup')->select('SELECT 1');

            $dbName = $data['database'];

            // 2) check DB exist
            $exists = DB::connection('_setup')
                ->select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$dbName]);

            // 3) nếu chưa có thì tạo
            if (empty($exists)) {
                DB::connection('_setup')->statement("CREATE DATABASE `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            }

            // 4) ghi vào .env
            $this->writeEnv([
                'DB_CONNECTION' => 'mysql',
                'DB_HOST' => $data['host'],
                'DB_PORT' => $data['port'],
                'DB_DATABASE' => $dbName,
                'DB_USERNAME' => $data['username'],
                'DB_PASSWORD' => $data['password'] ?? '',
            ]);

            // 5) clear config để nhận env mới
            Artisan::call('config:clear');

            // 6) migrate tạo bảng cơ bản
            Artisan::call('migrate', ['--force' => true]);

            // 7) tạo cờ installed
            if (!is_dir(storage_path('app'))) {
                mkdir(storage_path('app'), 0777, true);
            }
            file_put_contents(storage_path('app/installed.flag'), now()->toDateTimeString());

            return redirect()->route('login')->with('success', 'Đã setup DB xong!');
        } catch (\Throwable $e) {
            return redirect()->route('setup.show')->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    private function writeEnv(array $pairs): void
    {
        $path = base_path('.env');
        $env = file_exists($path) ? file_get_contents($path) : '';

        foreach ($pairs as $key => $value) {
            $value = is_null($value) ? '' : (string)$value;

            // nếu có khoảng trắng thì bọc ""
            if (preg_match('/\s/', $value)) {
                $value = '"' . str_replace('"', '\"', $value) . '"';
            }

            if (preg_match("/^{$key}=.*/m", $env)) {
                $env = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $env);
            } else {
                $env .= PHP_EOL . "{$key}={$value}";
            }
        }

        file_put_contents($path, $env);
    }
}
