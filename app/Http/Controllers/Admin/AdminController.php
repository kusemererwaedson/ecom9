<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Models\Admin;
use App\Models\vendor;
use App\Models\VendorsBusinessDetails;
use App\Models\VendorsBankDetails;
use App\Models\Country;
use Image;
use Session;

class AdminController extends Controller
{
    public function dashboard(){
        Session::put('page','dashboard');
        return view('admin.dashboard');
    }
    public function updateAdminPassword(Request $request){
        Session::put('page','update_admin_password');
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;  
            //Check if current password entered by admin is correct
            if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
                // Check if new password is matching with confirm password
                if($data['new_password']==$data['confirm_password']){
                    Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_password'])]);
                    return redirect()->back()->with('success_message','Password has been updated successfully!');
                }else{
                    return redirect()->back()->with('error_message','Your new password does not match Confirm Password');
                }
            }else{
                return redirect()->back()->with('error_message','Your current password is incorrect');
            }
        }
        $adminDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first()->toArray();
        return view('admin.settings.update_admin_password')->with(compact('adminDetails'));
    }
    public function checkAdminPassword(Request $request){
        $data = $request->all();
        // echo "<pre>"; print_r($data); die;
        if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
            return "true";
        }else{
            return "false";
        }
    }
    public function updateAdminDetails(Request $request){
        Session::put('page','update_admin_details');
        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric', 
            ];
            $customMessages = [
                'admin_name.required' => 'Name is required',
                'admin_name.regex' => 'Valid Name is required',
                'admin_mobile.required' => 'Mobile is required',
                'admin_mobile.numeric' => 'Valid Mobile is required',
            ];

            $this->validate($request,$rules,$customMessages);

            //upload Admin Photo
            if($request->hasFile('admin_image')){
                $image_tmp = $request->file('admin_image');
                if($image_tmp->isValid()){
                    // Get Image
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'admin/images/photos/'.$imageName;
                    // upload the image
                    Image::make($image_tmp)->save($imagePath);
                }
            }else if(!empty($data['current_admin_image'])){
                $imageName = $data['current_admin_image'];
            }else{
                $imageName = "";
            }

            // Update Admin Details
            Admin::where('id',Auth::guard('admin')->user()->id)->update(['name'=>$data['admin_name'],'mobile'=>$data['admin_mobile'],'image'=>$imageName]);
            return redirect()->back()->with('success_message','Admin Details updated successfully!');
        }
        return view('admin.settings.update_admin_details');
    }
    public function updateVendorDetails($slug, Request $request){
        if($slug=="personal"){
            if($request->isMethod('post')){
                $data = $request->all();
                // echo "<pre>"; print_r($data); die;
                $rules = [
                    'vendor_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'vendor_city' => 'required|regex:/^[\pL\s\-]+$/u',
                    'vendor_mobile' => 'required|numeric', 
                ];
                $customMessages = [
                    'vendor_name.required' => 'Name is required',
                    'vendor_city.required' => 'City is required',
                    'vendor_name.regex' => 'Valid Name is required',
                    'vendor_city.regex' => 'Valid City is required',
                    'vendor_mobile.required' => 'Mobile is required',
                    'vendor_mobile.numeric' => 'Valid Mobile is required',
                ];
    
                $this->validate($request,$rules,$customMessages);
    
                //upload Admin Photo
                if($request->hasFile('vendor_image')){
                    $image_tmp = $request->file('vendor_image');
                    if($image_tmp->isValid()){
                        // Get Image
                        $extension = $image_tmp->getClientOriginalExtension();
                        // Generate New Image
                        $imageName = rand(111,99999).'.'.$extension;
                        $imagePath = 'admin/images/photos/'.$imageName;
                        // upload the image
                        Image::make($image_tmp)->save($imagePath);
                    }
                }else if(!empty($data['current_vendor_image'])){
                    $imageName = $data['current_vendor_image'];
                }else{
                    $imageName = "";
                }
    
                // Update Vendor Details
                vendor::where('id',Auth::guard('admin')->user()->vendor_id)->update(['name'=>$data['vendor_name'],'mobile'=>$data['vendor_mobile'],'address'=>$data['vendor_address'],'city'=>$data['vendor_city'],'state'=>$data['vendor_state'],'country'=>$data['vendor_country'],'pincode'=>$data['vendor_pincode']]);
                // Update Admin Details
                Admin::where('id',Auth::guard('admin')->user()->id)->update(['name'=>$data['vendor_name'],'mobile'=>$data['vendor_mobile'],'image'=>$imageName]);

                return redirect()->back()->with('success_message','Vendor Details updated successfully!');
            }
            $vendorDetails = vendor::where('id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
        }else if($slug=="business"){
            if($request->isMethod('post')){
                $data = $request->all();
                // echo "<pre>"; print_r($data); die;
                $rules = [
                    'shop_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'shop_city' => 'required|regex:/^[\pL\s\-]+$/u',
                    'shop_mobile' => 'required', 
                    'address_proof' => 'required',
                ];
                $customMessages = [
                    'shop_name.required' => 'Name is required',
                    'shop_city.required' => 'City is required',
                    'shop_name.regex' => 'Valid Name is required',
                    'shop_city.regex' => 'Valid City is required',
                    'shop_mobile.required' => 'Mobile is required',
                ];
    
                $this->validate($request,$rules,$customMessages);
    
                //upload Admin Photo
                if($request->hasFile('address_proof_image')){
                    $image_tmp = $request->file('address_proof_image');
                    if($image_tmp->isValid()){
                        // Get Image
                        $extension = $image_tmp->getClientOriginalExtension();
                        // Generate New Image
                        $imageName = rand(111,99999).'.'.$extension;
                        $imagePath = 'admin/images/proofs/'.$imageName;
                        // upload the image
                        Image::make($image_tmp)->save($imagePath);
                    }
                }else if(!empty($data['current_address_proof'])){
                    $imageName = $data['current_address_proof'];
                }else{
                    $imageName = "";
                }
    
                // Update Vendor business Details
                VendorsBusinessDetails::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update(['shop_name'=>$data['shop_name'],'shop_mobile'=>$data['shop_mobile'],'shop_address'=>$data['shop_address'],'shop_city'=>$data['shop_city'],'shop_state'=>$data['shop_state'],'shop_country'=>$data['shop_country'],'shop_pincode'=>$data['shop_pincode'],'business_license_number'=>$data['business_license_number'],'gst_number'=>$data['gst_number'],'pan_number'=>$data['pan_number'],'address_proof'=>$data['address_proof'],'address_proof_image'=>$imageName]);

                return redirect()->back()->with('success_message','shop Details updated successfully!');
            }
            $vendorDetails = VendorsBusinessDetails::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
        }else if($slug=="bank"){
            if($request->isMethod('post')){
                $data = $request->all();
                // echo "<pre>"; print_r($data); die;
                $rules = [
                    'account_holder_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'bank_name' => 'required',
                    'account_number' => 'required|numeric',
                    'bank_ifsc_code' => 'required',
                ];
                $customMessages = [
                    'account_holder_name.required' => 'Account Holder Name is required',
                    'account_holder_name.regex' => 'Valid Account Holder Name is required',
                    'bank_name.required' => 'Bank Name is required',
                    'account_number.required' => 'Account Number is required',
                    'account_number.numeric' => 'Valid Account Number is required',
                    'bank_ifsc_code.required' => 'Bank ifsc Code is required',
                ];
    
                $this->validate($request,$rules,$customMessages);
    
                // Update Vendor Details
                VendorsBankDetails::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update(['account_holder_name'=>$data['account_holder_name'],'bank_name'=>$data['bank_name'],'account_number'=>$data['account_number'],'bank_ifsc_code'=>$data['bank_ifsc_code']]);

                return redirect()->back()->with('success_message','Vendor Bank Details updated successfully!');
            }
            $vendorDetails = VendorsBankDetails::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
        }
        $countries =  Country::where('status',1)->get()->toArray();
        return view('admin.settings.update_vendor_details')->with(compact('slug','vendorDetails','countries'));
    }

    public function login(Request $request){
        // echo $password = hash::make('123456'); die;
        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];
            $customMessages = [
                //Add Custom Messages Here
                'email.required' => 'Email is required!',
                'email.email' => 'Valid Email is required',
                'password.required' => 'Password is required!',
            ];

            $this->validate($request,$rules,$customMessages);

        if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password'],'status'=>1])){
            return redirect('admin/dashboard');
        }else{
            return redirect()->back()->with('error_message','Invalid Email or Password');
        }
        }
        return view('admin.login');
    }
    public function admins($type=null){
        Session::put('page','dashboard');
        $admins = Admin::query();
        if(!empty($type)){
            $admins = $admins->where('type',$type);
            $title = ucfirst($type)."s";
            Session::put('page','view_'.strtolower($title));
        }else{
            $title = "All Admins/Subadmins/Vendors";
            Session::put('page','view_all');
        }
        $admins = $admins->get()->toArray();
        // dd($admins);
        return view('admin.admins.admins')->with(compact('admins','title'));
    }
    public function viewVendorDetails($id){
        $vendorDetails = Admin::with('vendorPersonal','vendorBusiness','vendorBank')->where('id',$id)->first();
        $vendorDetails = json_decode(json_encode($vendorDetails),true);
        // dd($vendorDetails);
        return view('admin.admins.view_vendor_details')->with(compact('vendorDetails'));
    }
    public function updateAdminStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Admin::where('id',$data['admin_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'admin_id'=>$data['admin_id']]);
        }
    }
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('admin/login'); 
    }
}
