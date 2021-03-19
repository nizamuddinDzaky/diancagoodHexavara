<?php
namespace App\Exports;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransactionReport implements FromView
{
    protected $start;
    protected $end;

    function __construct($start, $end){
        $this->start = $start;
        $this->end = $end;
    }

    public function view(): View
    {
        return view('report.all-report-excel', [
            'orders' => Order::with('payment')->whereBetween('created_at', [$this->start, $this->end])->get()
        ]);
    }
}