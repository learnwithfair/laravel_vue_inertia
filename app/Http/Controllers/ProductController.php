<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller {
    public function index() {
        $products = Product::latest()->get();
        return Inertia::render( 'Products/Index', ['products' => $products] );
    }

    public function create() {
        return Inertia::render( 'Products/Create' );
    }

    public function store( Request $request ) {
        $request->validate( [
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ] );

        if ( $request->hasFile( 'image' ) ) {
            $image = $request->file( 'image' );
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move( public_path( 'products' ), $imageName );
            $imagePath = 'products/' . $imageName;
        } else {
            $imagePath = null;
        }
        Product::create( array_merge( $request->all(), ['image' => $imagePath] ) );

        return redirect()->route( 'product.index' )->with( 'message', 'Product created successfully' );
    }

    public function edit( Product $product ) {
        return Inertia::render( 'Products/Edit', ['product' => $product] );
    }

    public function update( Request $request, Product $product ) {

        // dd( $request->all() );

        $request->validate( [
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'image'       => 'nullable|image|max:2048',
        ] );

        if ( $request->hasFile( 'image' ) ) {

            if ( $product->image ) {
                $oldImagePath = public_path( $product->image );
                if ( file_exists( $oldImagePath ) ) {
                    unlink( $oldImagePath );
                }
            }

            $image = $request->file( 'image' );
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move( public_path( 'products' ), $imageName );
            $imagePath = 'products/' . $imageName;
        } else {
            $imagePath = $product->image;
        }

        $product->update( array_merge( $request->all(), ['image' => $imagePath] ) );

        return redirect()->route( 'product.index' )->with( 'message', 'Product updated successfully' );
    }

    public function show( Product $product ) {
        return Inertia::render( 'Products/Show', ['product' => $product] );
    }

    public function destroy( Product $product ) {
        if ( $product->image ) {

            $imagePath = public_path( $product->image );
            if ( file_exists( $imagePath ) ) {
                unlink( $imagePath );
            }
        }
        $product->delete();

        return redirect()->route( 'product.index' )->with( 'message', 'Product deleted successfully' );
    }
}