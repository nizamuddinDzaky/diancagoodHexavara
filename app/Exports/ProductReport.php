<?php
namespace App\Exports;
use App\Models\Product;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductReport implements FromView
{
    protected $start;
    protected $end;

    function __construct($start, $end){
        $this->start = $start;
        $this->end = $end;
    }

    public function view(): View
    {
        return view('report.product-report-excel', [
            'products' => Product::with('variant')->whereBetween('updated_at', [$this->start, $this->end])->get(),
            'order_details' => OrderDetail::with('variant')->whereBetween('created_at', [$this->start, $this->end])->get()
        ]);
    }
}