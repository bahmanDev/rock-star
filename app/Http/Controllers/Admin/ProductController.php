<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\CreateProductRequest;
use App\Http\Requests\Admin\Products\UpdateProductRequest;
use App\Repositories\OptionRepository;
use App\Repositories\ProductRepository;
use App\Services\ResponseData;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public ProductRepository $product;

    public function __construct(ProductRepository $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = $this->product->paginate();
        return ResponseData::paginate(data: $products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateProductRequest $request)
    {
        $data = $request->validated();
        $product = $this->product->create($data['product']);

        foreach ($data['options'] as $optionItem) {
            $this->product->saveOptions($product, $optionItem);
        }

        return ResponseData::success(data: $product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $product = $this->product->find($id);
        return ResponseData::success(data: $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductRequest $request, $id, OptionRepository $option)
    {
        $data = $request->validated();
        $product = $this->product->find($id);
        if (isset($data['product']) and count($data['product']) > 0)
            $this->product->update($product, $data['product']);

        if (isset($data['options']) and is_array($data['options']) and count($data['options']) > 0) {
            foreach ($data['options'] as $optionItem) {
                $opt = $option->find($optionItem['id']);
                $option->update($opt, ['name' => $optionItem['name']]);
            }
        }

        return ResponseData::success(data: $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $product = $this->product->find($id);
        $this->product->delete($product);

        return ResponseData::success();
    }
}
