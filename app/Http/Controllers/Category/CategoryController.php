<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('created_at', 'DESC')->get();
        if (!$categories) {
            $response = [
                'message' => 'We are not categories already stored . You can create a new one',
            ];
            return response($response, 404);
        }

        return response($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'category_name' => ['required', 'string', 'max:255', 'unique:categories'],
        ]);

        $new_category = Category::create([
            'category_name' => $fields['category_name'],
            'user_id' => auth()->user()->id
        ]);
        $response = [
            'category' => $new_category,
            'message' => 'Category create successfully'
        ];

        return response($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $a_category = Category::find($id);
        if (!$a_category) {
            $response = [
                'message' => 'Category not found at id ' . $id . '. Try an other',
            ];
            return response($response, 404);
        }
        return response($a_category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $a_category = Category::find($id);
        if (!$a_category) {
            $response = [
                'message' => 'Category not found at id ' . $id . '. Try an other',
            ];
            return response($response, 404);
        }
        $a_category->update($request->all());
        $response = [
            'category' => $a_category,
            'message' => 'Update successfully'
        ];

        return response($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::destroy($id);
        $response = [
            'message' => 'Delete successfully'
        ];
        return response($response);
    }
}
