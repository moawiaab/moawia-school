<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Item;
use App\Models\Material;
use App\Models\SellItem;
use App\Models\Stage;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Tutorial;
use App\Models\User;
use App\Services\ChartsService;
use Illuminate\Support\Facades\DB;

class DashboardApiController extends Controller
{
    public function index()
    {



        $line4 = new ChartsService([
            'title'              => 'Set sellitem',
            'chart_type'         => 'line',
            'model'              => 'App\Models\User',
            'group_by_field'     => 'created_at',
            'group_by_period'    => 'day',
            'column_class'       => 'col-md-12',
            'aggregate_function' => 'sum',
            'aggregate_field'    => 'amount',
            'filter_by_field'    => 'created_at',
            'filter_by_period'   => 30,
        ]);

        $bar5 = [
            // 'labels' => auth()->user()->account->products()->get()->transform(function ($e) {
            //     return $e->name;
            // }),
            'labels' => User::whereIn('id', $this->getData(0,true))->orderBy('id', 'desc')->get('name')->pluck('name'),
            'datasets' => [
                [
                    'label' => 'عدد أجوبة الأختبارات الخاطأ',
                    'backgroundColor'    => '#f800ff',
                    'data' => $this->getData(0)
                ],

            ]
        ];

        $bar2 = [
            'labels' => User::whereIn('id', $this->getData(1,true))->orderBy('id', 'desc')->get('name')->pluck('name'),
            'datasets' => [
                [
                    'label' => 'عدد أجوبة  الأختبارات الصحيحة',
                    'backgroundColor'    => '#00796b',
                    'data' => $this->getData(1)
                ],

            ]
        ];

        $pie6 = new ChartsService([
            'title'              => 'Ok2order',
            'chart_type'         => 'pie',
            'model'              => 'App\Models\User',
            'group_by_field'     => 'created_at',
            'group_by_period'    => 'day',
            'column_class'       => 'col-md-4',
            'aggregate_function' => 'count',
            'aggregate_field'    => '',
            'filter_by_field'    => 'created_at',
            'filter_by_period'   => 7,
        ]);

        $dataNum = [
            'tutorial'    => Tutorial::count(),
            'student' => Student::count(),
            'teacher' => Teacher::count(),
            'material' => Material::count(),
            ''
        ];
        return [
            'bar2' => $bar2,
            'bar' => $bar5,
            'pie6' => $pie6,
            'line4' => $line4,
            'num' => $dataNum,
            'users' => $this->getLabel()
        ];
    }

    private function getData($data, $label = false)
    {
        return Answer::select(
            DB::raw("COUNT(id) as date, user_id"),
        )->groupBy('user_id')->orderBy('user_id', 'desc')
        ->where("status", $data)
            ->get()->take(20)->pluck($label == false ? 'date' : 'user_id');
    }

    private function getLabel()
    {
        return $this->getData(1)->count() > $this->getData(0)->count()
            ? $this->getData(1, false)
            : $this->getData(0, false);
    }
}
