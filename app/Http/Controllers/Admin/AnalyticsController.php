<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Analytics\Period;
use Analytics;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AnalyticsController extends Controller
{
    private $defaultStartDate;
    private $defaultEndDate;

    public function __construct()
    {
        $this->defaultStartDate = Carbon::now()->subDays(7);
        $this->defaultEndDate = Carbon::now();
    }
    public function index()
    {
        $analyticsData = Analytics::performQuery(
            Period::years(2),
            'ga:sessions',
            [
                'metrics' => 'ga:sessions, ga:pageviews, ga:sessionDuration, ga:bounces,ga:exits',
                'dimensions' => 'ga:yearMonth'
            ]
        );
        $mobileData = Analytics::performQuery(
            Period::years(2),
            'ga:sessions',
            [
                'metrics' => 'ga:sessions',
                'dimensions' => 'ga:operatingSystem',
                'sort' => '-ga:sessions'
            ]
        );
        $countryData = Analytics::performQuery(
            Period::years(2),
            'ga:sessions',
            [
                'metrics' => 'ga:sessions',
                'dimensions' => 'ga:country',
                'sort' => '-ga:sessions'
            ]
        );
        $total = $analyticsData->totalsForAllResults;
        $total['activeVisitors'] = Analytics::getAnalyticsService()->data_realtime->get('ga:'.env('ANALYTICS_VIEW_ID'), 'rt:activeVisitors')->totalsForAllResults['rt:activeVisitors'];
        $browers = Analytics::fetchTopBrowsers(Period::create(Carbon::parse(Session::get('analytics.date_start',$this->defaultStartDate)),Carbon::parse(Session::get('analytics.date_end',$this->defaultEndDate))));
        $referrers = Analytics::fetchTopReferrers(Period::create(Carbon::parse(Session::get('analytics.date_start',$this->defaultStartDate)),Carbon::parse(Session::get('analytics.date_end',$this->defaultEndDate))));
        $types = Analytics::fetchUserTypes(Period::create(Carbon::parse(Session::get('analytics.date_start',$this->defaultStartDate)),Carbon::parse(Session::get('analytics.date_end',$this->defaultEndDate))));

        return $total;
        return view('admincp.analytics.index',compact('browers','referrers','types','total','mobileData','countryData'));
    }
    public function baseOnDay()
    {
        $analytics = Analytics::fetchTotalVisitorsAndPageViews(Period::create(Carbon::parse(Session::get('analytics.date_start',$this->defaultStartDate)),Carbon::parse(Session::get('analytics.date_end',$this->defaultEndDate))));
        return view('admin.analytics.day',compact('analytics'));
    }
    public function baseOnHour()
    {
        $analytics = Analytics::fetchVisitorsAndPageViews(Period::create(Carbon::parse(Session::get('analytics.date_start',$this->defaultStartDate)),Carbon::parse(Session::get('analytics.date_end',$this->defaultEndDate))));
        return view('admincp.analytics.hour',compact('analytics'));
    }
    public function viewMost()
    {
        $analytics = Analytics::fetchMostVisitedPages(Period::create(Carbon::parse(Session::get('analytics.date_start',$this->defaultStartDate)),Carbon::parse(Session::get('analytics.date_end',$this->defaultEndDate))));
        return view('admincp.analytics.most',compact('analytics'));
    }
    public function setAnalyticsDays(Request $request)
    {
        $this->validate($request,[
            'type' => 'required',
            'date_start' => 'required|date|before:'.now(),
            'date_end' => 'required|date|after:date_start|before:'.now()
        ],[
            'type.required' => 'Bạn chưa chọn kiểu hiển thị',
            'date_start.required' => 'Bạn chưa chọn ngày bắt đầu',
            'date_start.before' => 'Ngày bắt đầu phải nhỏ hơn hiện tại',
            'date_end.required' => 'Bạn chưa chọn ngày kết thúc',
            'date_end.after' => 'Ngày kết thúc phải lớn hơn ngày bắt đầu',
            'date_end.before' => 'Ngày kết thúc phải nhỏ hơn hiện tại'
        ]);
        Session::put('analytics.type',$request->type);
        Session::put('analytics.date_start',$request->date_start);
        Session::put('analytics.date_end',$request->date_end);

        return back();
    }
}
