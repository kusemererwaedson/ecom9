<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Section;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductsAttribute;
use App\Models\ProductsImages;
use Auth;
use Image;
use Session;

class ProductsController extends Controller
{
    public function products(){
        Session::put('page','products');
        $products = Product::with(['section'=>function($query){
            $query->select('id','name');
        },'category'=>function($query){
            $query->select('id','category_name');
        }])->get()->toArray();
        // dd($products);
        return view('admin.products.products')->with(compact('products'));
    }
    public function updateProductStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Product::where('id',$data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'product_id'=>$data['product_id']]);
        }
    }
    public function deleteProduct($id){
        // Delete Section
        Category::where('id',$id)->delete();
        $message = "Category has been deleted successfully!";
        return redirect()->back()->with('success_message',$message);
    }
    public function addEditProduct(Request $request, $id=null){
        Session::put('page','products');
        if($id==""){
            $title = "Add Product";
            $product = new Product;
            $message = "Product added successfully!";
        }else{
            $title = "Edit Product";
            $product = Product::find($id);
            $message = "Product updated successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $rules = [
                'category_id' => 'required',
                'product_name' => 'required',
                'product_code' => 'required|regex:/^\w+$/',
                'product_price' => 'required|numeric',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u',
                // 'url' => 'required',
            ];
            $customMessages = [
                'category_id.required' => 'Category is required',
                'product_name.required' => 'Product name is required',
                'product_code.regex' => 'Valid product code is required',
                'product_price.required' => 'Product price is required',
                'product_price.numeric' => 'Valid product price is required',
                'product_color.required' => 'Product color is required',
                'product_color.regex' => 'Valid product color is required', 
                // 'url.required' => 'url is required',
            ];
            $this->validate($request,$rules,$customMessages);

            // Upload Product Image after Resize small: 250x250, medium: 500x500,large: 1000x1000
            if($request->hasFile('product_image')){
                $image_tmp = $request->file('product_image');
                if($image_tmp->isValid()){
                    // upload image after resize
                    // Get image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $largeImagePath = 'front/images/product_images/large/'.$imageName;
                    $mediumImagePath = 'front/images/product_images/medium/'.$imageName;
                    $smallImagePath = 'front/images/product_images/small/'.$imageName;
                    // Upload the Large, Medium, Small Image after resizing
                    Image::make($image_tmp)->resize(1000,1000)->save($largeImagePath);
                    Image::make($image_tmp)->resize(500,500)->save($mediumImagePath);
                    Image::make($image_tmp)->resize(250,250)->save($smallImagePath);

                    // Insert Image Name in products table
                    $product->product_image = $imageName;
                }
            }

            // Upload Product Video
            if($request->hasFile('product_video')){
                $video_tmp = $request->file('product_video');
                if($video_tmp->isValid()){
                   // Upload Video
                   $extension = $video_tmp->getClientOriginalExtension();
                   $videoName = rand().'.'.$extension;
                   $videoPath = 'front/videos/product_videos/';
                   $video_tmp->move($videoPath,$videoName);
                   // Insert Video name in products table
                   $product->product_video = $videoName;
                }
            }
            


            //Save Product details in products table
            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->brand_id = $data['brand_id'];

            $adminType = Auth::guard('admin')->user()->type;
            $vendor_id = Auth::guard('admin')->user()->vendor_id;
            $admin_id = Auth::guard('admin')->user()->id;
            $product->admin_type = $adminType;
            $product->admin_id = $admin_id;
            if($adminType=="vendor"){
                $product->vendor_id = $vendor_id;
            }else{
                $product->vendor_id = 0;
            }
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];
            if(!empty($data['is_featured'])){
                $product->is_featured = $data['is_featured'];
            }else{
                $product->is_featured = "No";
            }
            $product->status = 1;
            $product->save();
            return redirect('admin/products')->with('success_message',$message);
        }

        // Get sections with categories and sub categories
        $categories = Section::with('categories')->get()->toArray();

        // Get all Brands
        $brands = Brand::where('status',1)->get()->toArray();

        return view('admin.products.add_edit_product')->with(compact('title','categories','brands','product'));
    }
    public function deleteProductImage($id){
        // Get product image
        $productImage = Product::select('product_image')->where('id',$id)->first();

        // Get Product Image Paths
        $small_image_path = 'front/images/product_images/small/';
        $medium_image_path = 'front/images/product_images/medium/';
        $large_image_path = 'front/images/product_images/large/';

                    // Delete small image if it exists in the small folder
        if (file_exists($small_image_path . $productImage->product_image)) {
            unlink($small_image_path . $productImage->product_image);
        }

        // Delete medium image if it exists in the medium folder
        if (file_exists($medium_image_path . $productImage->product_image)) {
            unlink($medium_image_path . $productImage->product_image);
        }

        // Delete large image if it exists in the large folder
        if (file_exists($large_image_path . $productImage->product_image)) {
            unlink($large_image_path . $productImage->product_image);
        }

        // Delete Product image from products table
        Product::where('id',$id)->update(['product_image'=>'']); 

        $message = "Product Image has been deleted successfully!";
        return redirect()->back()->with('success_message',$message);
    }
    public function deleteProductVideo($id){
        // Get Product Video
        $productVideo = Product::select('product_video')->where('id',$id)->first();

        // Get product video path 
        $product_video_path = 'front/videos/product_videos/';

        // Delete Product Video from product_video folder if exists
        if(file_exists($product_video_path.$productVideo->product_video)){
            unlink($product_video_path.$productVideo->product_video);
        }

        // Delete Product Video from products table
        Product::where('id',$id)->update(['product_video'=>'']);

        $message = "Product Video has been deleted successfully!";
        return redirect()->back()->with('success_message',$message);
    }
    public function addAttributes(Request $request, $id){
        Session::put('page','products');
        $product = Product::select('id','product_name','product_code','product_color','product_price','product_image')->with('attributes')->find($id);
        
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            foreach($data['sku'] as $key => $value){
                if(!empty($value)){

                    // SKU duplicate check
                    $skuCount = ProductsAttribute::where('sku',$value)->count();
                    if($skuCount>0){
                        return redirect()->back()->with('error_message','SKU Already exists! Please add another SKU');
                    }
                     // Size duplicate check
                     $sizeCount = ProductsAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                     if($sizeCount > 0){
                         return redirect()->back()->with('error_message','Size Already exists! Please add another Size!');
                     }

                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();
                }
            }
            return redirect()->back()->with('success_message','Product Attributes has been added successfully!');
        }

        return view('admin.attributes.add_edit_attributes')->with(compact('product'));
    }
    public function updateAttributeStatus(Request $request){
        Session::put('page','products');
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductsAttribute::where('id',$data['attribute_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'attribute_id'=>$data['attribute_id']]);
        }
    }
    public function editAttributes(Request $request){
        Session::put('page','products');
        if($request->isMethod('post')){
            $data=$request->all();
            foreach ($data['attributeid'] as $key => $attribute){
                if(!empty($attribute)){
                    ProductsAttribute::where(['id'=>$data['attributeid'][$key]])->update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);
                }
            }
            return redirect()->back()->with('success_message','Product Attribute has been updated successfully!');
        }
    }
    public function deleteAttribute($id){
        // Delete Section
        Category::where('id',$id)->delete();
        $message = "Attribute has been deleted successfully!";
        return redirect()->back()->with('success_message',$message);
    }
    public function addImages($id, Request $request){
        Session::put('page','products');
        $product = Product::select('id','product_name','product_code','product_color','product_price','product_image')->with('images')->find($id);

        if($request->isMethod('post')){
            $data = $request->all();
            if($request->hasFile('images')){
                $images = $request->file('images');
                // echo "<pre>"; print_r($images); die;
                foreach($images as $key => $image){
                    //Generate Temp Image
                    $image_tmp = Image::make($image); 
                    // Get image name
                    $image_name = $image->getClientOriginalName();
                    // Get image Extension
                    $extension = $image->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = $image_name.rand(111,99999).'.'.$extension;
                    $largeImagePath = 'front/images/product_images/large/'.$imageName;
                    $mediumImagePath = 'front/images/product_images/medium/'.$imageName;
                    $smallImagePath = 'front/images/product_images/small/'.$imageName;
                    // Upload the Large, Medium, Small Image after resizing
                    Image::make($image_tmp)->resize(1000,1000)->save($largeImagePath);
                    Image::make($image_tmp)->resize(500,500)->save($mediumImagePath);
                    Image::make($image_tmp)->resize(250,250)->save($smallImagePath);

                    // Insert Image Name in products table
                    $image = new ProductsImages;
                    $image->image = $imageName;
                    $image->product_id = $id;
                    $image->status = 1;
                    $image->save();
                }
            }
            return redirect()->back()->with('success_message','Product Image has been added successfully');
        }

        return view('admin.images.add_edit_images')->with(compact('product'));
    }
    public function updateImageStatus(Request $request){
        Session::put('page','products');
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductsImages::where('id',$data['image_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'image_id'=>$data['image_id']]);
        }
    }
    public function deleteImage($id){
        // Get product image
        $productImage = ProductsImages::select('image')->where('id',$id)->first();

        // Get Product Image Paths
        $small_image_path = 'front/images/product_images/small/';
        $medium_image_path = 'front/images/product_images/medium/';
        $large_image_path = 'front/images/product_images/large/';

                    // Delete small image if it exists in the small folder
        if (file_exists($small_image_path . $productImage->image)) {
            unlink($small_image_path . $productImage->image);
        }

        // Delete medium image if it exists in the medium folder
        if (file_exists($medium_image_path . $productImage->image)) {
            unlink($medium_image_path . $productImage->image);
        }

        // Delete large image if it exists in the large folder
        if (file_exists($large_image_path . $productImage->image)) {
            unlink($large_image_path . $productImage->image);
        }

        // Delete Product image from productsImages table
        ProductsImages::where('id',$id)->delete(); 

        $message = "Product Image has been deleted successfully!";
        return redirect()->back()->with('success_message',$message);
    }
}
