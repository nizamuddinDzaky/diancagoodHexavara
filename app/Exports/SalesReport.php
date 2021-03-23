<?php
namespace App\Exports;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SalesReport implements FromView
{
    protected $start;
    protected $end;

    function __construct($start, $end){
        $this->start = $start;
        $this->end = $end;
    }

    public function view(): View
    {
        return view('report.sales-report-excel', [
            'orders' => Order::with('details')->whereBetween('created_at', [$this->start, $this->end])->get()
        ]);
    }
}