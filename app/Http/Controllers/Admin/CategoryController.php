<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Section;
use Session;
use Image;

class CategoryController extends Controller
{
    public function categories(){
        Session::put('page','categories');
        $categories = Category::with(['section','parentcategory'])->get()->toArray();
        // dd($categories);
        return view('admin.categories.categories')->with(compact('categories'));
    }
    public function updateCategoryStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Category::where('id',$data['category_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'category_id'=>$data['category_id']]);
        }
    }
    public function addEditCategory(Request $request,$id=null){
        Session::put('page','categories');
        if($id==""){
            // Add Category Functionality
            $title = "Add Category";
            $category = new Category; 
            $getCategories = array();
            $message = "Category added successfully!";           
        }else{
            // Edit Category Functionality
            $title = "Edit Category";
            $category = Category::find($id);
            $getCategories = Category::with('subcategories')->where(['parent_id'=>0,'section_id'=>$category['section_id']])->get(); 
            $message = "Category updated successfully!";
        }
        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id' => 'required',
                'url' => 'required',
            ];
            $customMessages = [
                'category_name.required' => 'Category Name is required',
                'category_name.regex' => 'Valid Category name is required',
                'section_id.regex' => 'Section is required',
                'category_name.required' => 'Category URL is required',
            ];
            $this->validate($request,$rules,$customMessages);
            if($data['category_discount']==""){
                $data['category_discount'] = 0;                
            }
            if($data['description']==""){
                $data['description'] = "";                
            }

            //upload Admin Photo
            if($request->hasFile('category_image')){
            $image_tmp = $request->file('category_image');
                if($image_tmp->isValid()){
                    // Get Image
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'front/images/category_images/'.$imageName;
                    // upload the image
                    Image::make($image_tmp)->save($imagePath);
                    $category->category_image = $imageName;
                }
            }else{
                $category->category_image = "";
            }
            $category->section_id = $data['section_id'];
            $category->parent_id = $data['parent_id'];
            $category->category_name = $data['category_name'];
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = 1;
            $category->save();

            return redirect('admin/categories')->with('success_message',$message);
        }

        // Get All Sections
        $getSections = Section::get()->toArray();

        return view('admin.categories.add_edit_category')->with(compact('title','category','getSections','getCategories'));
    }
    public function deleteCategory($id){
        // Delete Section
        Category::where('id',$id)->delete();
        $message = "Category has been deleted successfully!";
        return redirect()->back()->with('success_message',$message);
    }
    public function appendCategoryLevel(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $getCategories = Category::with('subcategories')->where(['parent_id'=>0,'section_id'=>$data['section_id']])->get()->toArray();
            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
        }
    }
    public function deleteCategoryImage($id){
        // Get Category Image
        $categoryImage = Category::select('category_image')->where('id',$id)->first();

        //Get Category Image Path
        $category_image_path = 'front/images/category_images/';

        //Delete Category Image from category_images folder if exists
        if(file_exists($category_image_path.$categoryImage->category_image)){
            unlink($category_image_path.$categoryImage->category_image);
        }

        // Delete Category image from the categories folder
        Category::where('id',$id)->update(['category_image'=>'']);
        $message = "Image has been successfully deleted!";
        return redirect()->back()->with('success_message',$message);
    }
}
