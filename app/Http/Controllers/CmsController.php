<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;
use DB;
use Maatwebsite\Excel\Facades\Excel;

//use App\Http\Controllers\Controller;

class CmsController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = \App\WechatUser::count();

        return view('cms/dashboard', ['count' => $count]);
    }

    /**
     * 微信授权用户.
     *
     * @return mixed
     */
    public function wechat()
    {
        $id = \Request::segment(3);
        if (null == $id) {
            $wechat_users = DB::table('wechat_users')->paginate(20);
        } else {
            $wechat_users = DB::table('wechat_users')->where('id', $id)->paginate(20);
        }

        return view('cms/wechat_user', ['wechat_users' => $wechat_users]);
    }

    /**
     * 账户管理.
     */
    public function users()
    {
        $users = DB::table('users')->paginate(20);

        return view('cms/users', ['users' => $users]);
    }
    /**
     * @return mixed
     *               session 查看
     */
    public function sessions($id = null)
    {
        if (null == $id) {
            $sessions = DB::table('sessions')->paginate(20);
        } else {
            $sessions = DB::table('sessions')->where('id', '=', $id)->paginate(20);
        }

        return view('cms/sessions', ['sessions' => $sessions]);
    }
    /**
     * @return mixed
     *               照片查看
     */
    public function infos()
    {
        $infos = \App\Info::paginate(20);

        return view('cms/infos', ['infos' => $infos]);
    }
    /**
     *账户管理.
     */
    public function account()
    {
        return view('cms/account');
    }
    public function accountPost(Requests\AccountFormRequest $request)
    {
        //var_dump($request->user()->id);
        $user = \App\User::find($request->user()->id);
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return redirect('cms/logout');
        //var_dump($request->input('password'));
    }
    public function userLogs()
    {
        $logs = \App\UserLog::limit(30)->offset(0)->orderBy('create_time', 'DESC')->get();

        return view('cms/userLogs', ['logs' => $logs]);
    }

    /**
     * 微信用户导出.
     */
    public function export($table)
    {
        if ($table == 'infos') {
            $collection = \App\Info::all();
            $data = $collection->map(function ($item) {
                return [
                    json_decode($item->user->nick_name),
                    $item->user->open_id,
                    $item->name,
                    $item->district,
                    $item->mobile,
                    $item->address,
                    $item->created_time,
                    $item->created_ip,
                ];
            });
            $titles = ['微信用户', '微信openId', '姓名', '地区', '手机号', '地址', '创建时间', '创建IP'];
            $excel_title = '用户信息';
        } elseif ($table == 'wechat') {
            $collection = \App\WechatUser::all();
            $data = $collection->map(function ($item) {
                return [
                    $item->id,
                    $item->open_id,
                    json_decode($item->nick_name),
                    $item->head_img,
                    $item->gender,
                    $item->country,
                    $item->province,
                    $item->city,
                    $item->create_time,
                    $item->create_ip,
                ];
            });
            $titles = ['ID', 'openid', '昵称', '头像', '性别', '国家', '省份', '城市', '授权时间', '授权IP'];
            $excel_title = '授权用户';
        }
        $filename = $table.date('_Y-m-d');
        Excel::create($filename, function ($excel) use ($data, $excel_title, $titles) {
            $excel->setTitle($excel_title);
            // Chain the setters
            $excel->setCreator('Alexa');
            // Call them separately
            $excel->setDescription($excel_title);
            $excel->sheet('Sheet', function ($sheet) use ($data, $titles) {
                $sheet->row(1, $titles);
                $sheet->fromArray($data, null, 'A2', false, false);
            });
        })->download('xlsx');
    }
}
