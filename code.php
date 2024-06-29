<?php
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