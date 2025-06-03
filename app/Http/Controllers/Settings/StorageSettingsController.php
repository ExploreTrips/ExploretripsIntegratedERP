<?php

namespace App\Http\Controllers\Settings;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StorageSettingsController extends Controller
{
    public function storageSettingStore(Request $request)
    {
        $post = [];
        $userId = auth()->id();
        switch ($request->storage_setting) {
            case 'local':
                $request->validate([
                    'local_storage_validation' => 'required|array',
                    'local_storage_max_upload_size' => 'required',
                ]);

                $post = [
                    'storage_setting' => 'local',
                    'local_storage_validation' => implode(',', $request->local_storage_validation),
                    'local_storage_max_upload_size' => $request->local_storage_max_upload_size,
                ];
                break;

            case 's3':
                $request->validate([
                    's3_key' => 'required',
                    's3_secret' => 'required',
                    's3_region' => 'required',
                    's3_bucket' => 'required',
                    's3_url' => 'required',
                    's3_endpoint' => 'required',
                    's3_max_upload_size' => 'required',
                    's3_storage_validation' => 'required|array',
                ]);

                $post = [
                    'storage_setting' => 's3',
                    's3_key' => $request->s3_key,
                    's3_secret' => $request->s3_secret,
                    's3_region' => $request->s3_region,
                    's3_bucket' => $request->s3_bucket,
                    's3_url' => $request->s3_url,
                    's3_endpoint' => $request->s3_endpoint,
                    's3_max_upload_size' => $request->s3_max_upload_size,
                    's3_storage_validation' => implode(',', $request->s3_storage_validation),
                ];
                break;

            case 'wasabi':
                $request->validate([
                    'wasabi_key' => 'required',
                    'wasabi_secret' => 'required',
                    'wasabi_region' => 'required',
                    'wasabi_bucket' => 'required',
                    'wasabi_url' => 'required',
                    'wasabi_root' => 'required',
                    'wasabi_max_upload_size' => 'required',
                    'wasabi_storage_validation' => 'required|array',
                ]);

                $post = [
                    'storage_setting' => 'wasabi',
                    'wasabi_key' => $request->wasabi_key,
                    'wasabi_secret' => $request->wasabi_secret,
                    'wasabi_region' => $request->wasabi_region,
                    'wasabi_bucket' => $request->wasabi_bucket,
                    'wasabi_url' => $request->wasabi_url,
                    'wasabi_root' => $request->wasabi_root,
                    'wasabi_max_upload_size' => $request->wasabi_max_upload_size,
                    'wasabi_storage_validation' => implode(',', $request->wasabi_storage_validation),
                ];
                break;
            case 'google_drive':
                $request->validate([
                    'google_drive_client_id' => 'required',
                    'google_drive_client_secret' => 'required',
                    'google_drive_refresh_token' => 'required',
                    'google_drive_folder_id' => 'required',
                    'google_drive_max_upload_size' => 'required',
                    'google_drive_storage_validation' => 'required|array',
                ]);

                $post = [
                    'storage_setting' => 'google_drive',
                    'google_drive_client_id' => $request->google_drive_client_id,
                    'google_drive_client_secret' => $request->google_drive_client_secret,
                    'google_drive_refresh_token' => $request->google_drive_refresh_token,
                    'google_drive_folder_id' => $request->google_drive_folder_id,
                    'google_drive_max_upload_size' => $request->google_drive_max_upload_size,
                    'google_drive_storage_validation' => implode(',', $request->google_drive_storage_validation),
                ];
                break;

            default:
                return redirect()->back()->with('error', 'Invalid storage type selected.');
        }
        foreach ($post as $key => $value) {
            $inser = DB::insert(
                'INSERT INTO settings (`value`, `name`, `created_by`)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)',
                [$value, $key, $userId]
            );
        }
        return redirect()->back()->with('success', 'Storage setting successfully updated.');
    }}
