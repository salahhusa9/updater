<?php

namespace Project;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class Updater extends Controller
{
    public function view()
    {
        $ver=$this->versions();

        return view('updater::index',['lastversion' => $ver[0]['name'] , 'localversion' => env('SELF_UPDATER_VERSION_INSTALLED')]);
    }

    public function start($mode = false)
    {

        $response_array = $this->versions();

        $versionAvailable = $response_array[0]['name'] ?? response()->json([
                                                                                'status' => false,
                                                                                'message' => $response_array['message']
                                                                            ]);

        if ($versionAvailable != $last_version=env('SELF_UPDATER_VERSION_INSTALLED')) {

            if (config('updater.maintenance-mode') == 'true') {
                $this->maintenanceMode(true);
            }else if (config('updater.maintenance-mode') == 'false') {
                // not active maintenanceMode
            }else if (!$mode) {
                $this->maintenanceMode($mode);
            }

            $this->updating($versionAvailable)
                ->updatingDatabase($versionAvailable)
                ->maintenanceMode(false);
            
            $this->changeVersion($versionAvailable);

            return response()->json([
                'status' => true,
                'message' => 'You updated To '.$versionAvailable.', From : '.$last_version
            ]);

        }else{
            return response()->json([
                'status' => true,
                'message' => 'Your have last Version , is ' . $last_version,
            ]);
        }

    }

    public function versions()
    {
        $owner = env('SELF_UPDATER_REPO_VENDOR');
        $repo = env('SELF_UPDATER_REPO_NAME');

        $url = "https://api.github.com/repos/{$owner}/{$repo}/tags";

        $ch=curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "test");

        $headers = array();
        $headers[] = 'Authorization: Bearer '.env('SELF_UPDATER_GITHUB_PRIVATE_ACCESS_TOKEN');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $r=curl_exec($ch);
        curl_close($ch);

        return json_decode($r, true);
    }

    public function updating($to)
    {
        shell_exec('git pull');
        shell_exec('git checkout tags/'.$to);

        return $this;
    }

    public function updatingDatabase($to)
    {
        if (env('SELF_UPDATER_DATABASE_TYPE') == 'sql') {
            $path = env('SELF_UPDATER_SQL_PATH') . '/' . $to . '.sql';
            // $path = env('SELF_UPDATER_SQL_PATH') . '/' . 'test' . '.sql';
            DB::unprepared(file_get_contents(base_path($path)));
            return $this;
        }
        return $this;
    }

    public function changeVersion($to,$key='SELF_UPDATER_VERSION_INSTALLED')
    {
        $path = base_path('.env');

        if (file_exists($path)) {
        file_put_contents($path, str_replace(
            $key.'='.env($key),
            $key.'='.$to,
            file_get_contents($path)
        ));
        }

        return $this;
    }

    public function maintenanceMode(bool $mode)
    {
        if ($mode) {
            info($mode);
            return Artisan::call("down");
        }else {
            info($mode);
            return Artisan::call("up");
        }
        
    }
}
