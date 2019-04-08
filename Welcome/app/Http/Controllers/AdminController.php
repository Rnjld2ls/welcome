<?php

    namespace App\Http\Controllers;

    use App\Models\Major;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;

    use App\Models\Students as Students;
    use App\Models\EnrollCfg as EnrollCfg;

    class AdminController extends Controller
    {
        public function __construct()
        {
            // $this->middleware('checkAuth');
        }

        // 管理员-首页
        public function index()
        {
            $res = Students::where([
                ["stu_status", "PREPARE"]
            ])->count();
            $enroll = Students::where([
                ["stu_status", "ENROLL"]
            ])->count();
            $current = Students::where([
                ["stu_status", "CURRENT"]
            ])->count();
            $enrollcfg = EnrollCfg::all()->first();
            $enrollTime = ($enrollcfg) ? $enrollcfg['enrl_begin_time'] : "暂无信息";
            return view('admin.index', [
                'sysType' => "管理员",  // 系统运行模式，新生，老生，管理员
                'user' => session("name"), // 用户名
                'userImg' => "userImg",// 用户头像链接 url(site)
                'toInformationURL' => "toInformationURL", // 更多消息url
                'toSettingURL' => "toSettingURL", // 个人设置
                'newStuNumber' => $res, // 新生人数
                'oldStuNumber' => $current, // 老生人数
                'hasReportNumber' => $enroll, // 已报到人数
                'stuReportTime' => $enrollTime, // 报到时间
                'schoolInfo' => "<div class=\"text-center\"><img class=\"img-fluid px-3 px-sm-4 mt-3 mb-4\" style=\"width: 25rem;\" src=\"img/undraw_posting_photo.svg\" alt=\"\"></div><p>
            哈尔滨工业大学（以下简称哈工大）是一所有着近百年历史、世界知名的工科强校，2017年入选国家“双一流”建设A类高校，是我国首批入选国家“985工程”重点建设的大学，拥有以38位院士为带头人的雄厚师资，有9个国家一级重点学科，10个学科名列全国前五名，其中，名列前茅的工科类重点学科数量位居全国第二，工程学在全球排名第六。</p>", // 学校信息 可以html
                'toSetSchoolInfoURL' => "toSetSchoolInfoURL", // 设置学校信息URL
                'schoolStatistics' => array(), // 院系状态
                'systemStatus' => array( // 系统状态
                    'newsStatus' => "未导入", // 新生状态
                    'deptStatus' => "已导入，共23个系", // 院系状态
                    'reportStatus' => "等待开始报到", // 报到状态
                ),

                'toLogoutURL' => "/logout",      // 退出登录
            ]);
        }

        // 管理员-学校信息录入
        public function manageSchoolInfo()
        {
            $res = Students::where([
                ["stu_status", "PREPARE"]
            ])->count();
            $enroll = Students::where([
                ["stu_status", "ENROLL"]
            ])->count();
            $current = Students::where([
                ["stu_status", "CURRENT"]
            ])->count();
            // 报到配置
            $enrollcfg = EnrollCfg::all()->first();
            $enrollTime = ($enrollcfg) ? $enrollcfg['enrl_begin_time'] : "暂无信息";
            // 专业信息
            $majorInfos = Major::orderBy('major_num', 'asc')->get();

            return view('admin.insertSchoolInfo', [
                'sysType' => "管理员",  // 系统运行模式，新生，老生，管理员
                'user' => session("name"), // 用户名
                'userImg' => "userImg",// 用户头像链接 url(site)
                'toInformationURL' => "toInformationURL", // 个人设置url
                'toSettingURL' => "toSettingURL", // 个人设置
                'newStuNumber' => $res, // 新生人数
                'oldStuNumber' => $current, // 老生人数
                'hasReportNumber' => $enroll, // 已报到人数
                'stuReportTime' => $enrollTime, // 报到时间
                'schoolInfo' => "<p>学校信息在这里更改</p>", // 设置学校信息
                'majorInfos' => $majorInfos, // 专业信息
                'schoolInfoPostURL' => "", // 学校信息提交URL
                'majorInfoPostURL' => "/admin/majorInfoUpload", // 专业信息提交URL

                'toLogoutURL' => "/logout",      // 退出登录
            ]);
        }

        // 管理员-新生信息录入
        public function manageNewsInfo()
        {
            $res = Students::where([
                ["stu_status", "PREPARE"]
            ])->count();
            $enroll = Students::where([
                ["stu_status", "ENROLL"]
            ])->count();
            $current = Students::where([
                ["stu_status", "CURRENT"]
            ])->count();
            $enrollcfg = EnrollCfg::all()->first();
            $enrollTime = ($enrollcfg) ? $enrollcfg['enrl_begin_time'] : "暂无信息";
            return view('admin.newStudentManage', [
                'sysType' => "管理员",  // 系统运行模式，新生，老生，管理员
                'user' => session("name"), // 用户名
                'userImg' => "userImg",// 用户头像链接 url(site)
                'toInformationURL' => "toInformationURL", // 个人设置url
                'toSettingURL' => "toSettingURL", // 个人设置
                'newStuNumber' => $res, // 新生人数
                'oldStuNumber' => $current, // 老生人数
                'hasReportNumber' => $enroll, // 已报到人数
                'stuReportTime' => $enrollTime, // 报到时间
                'majorInfos' => array(), // 专业新生情况
                'newsInfoPostURL' => "/admin/stuInfoUpload", // 新生信息提交URL

                'toLogoutURL' => "/logout",      // 退出登录
            ]);
        }


    }
