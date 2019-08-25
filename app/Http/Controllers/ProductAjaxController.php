<?php
//namespaces can be defined as a class of elements in

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTable;

/**
 * Class ProductAjaxController
 * @package App\Http\Controllers
 */
class ProductAjaxController extends Controller
{


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = Product::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                $btn ='<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" 
                data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';

               $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';
                 return $btn;
            })->rawCloumns(['action'])
            ->make(true);
        }
        return view('productAjax', compact('products'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        Product::updateOrCreate(['id'=>$request->product_id],
            ['name'=>$request->name, 'detail'=>$request->detail]);
        return response()->json(['success'=>'Product saved successfully.']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destory($id)
    {
        Product::find($id);
        return response()->json(['success'=>'Product deleted.']);
    }

}
