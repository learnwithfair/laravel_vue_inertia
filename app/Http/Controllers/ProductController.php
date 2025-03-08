<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class ProductController extends Controller {

    protected function getSharedProps() {
        return [
            'canLogin'       => Route::has( 'login' ),
            'canRegister'    => Route::has( 'register' ),
            'laravelVersion' => Application::VERSION,
            'phpVersion'     => PHP_VERSION,
        ];
    }

    public function index() {
        $products = Product::latest()->get();

        return Inertia::render( 'Products/Index', array_merge(
            ['products' => ProductResource::collection( $products )],
            $this->getSharedProps()
        ) );
    }

    public function create() {
        return Inertia::render( 'Products/Create',
            $this->getSharedProps()
        );
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

        return Redirect::route( 'product.index' )->with( [
            'success' => 'Product created successfully',
        ] );
        // session()->flash( 'success', 'Product created successfully' ); // ✅ Ensure flash message is set

        // return Redirect::route( 'product.index' );

        // return redirect()->route( 'product.index' )->with( 'message', 'Product created successfully' );
    }

    public function edit( Product $product ) {
        return Inertia::render( 'Products/Edit', array_merge(
            ['product' => $product],
            $this->getSharedProps()
        ) );
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

        return Redirect::route( 'product.index' )->with( [
            'success' => 'Product updated successfully',
        ] );

    }

    public function show( Product $product ) {
        return Inertia::render( 'Products/Show', array_merge(
            ['product' => $product],
            $this->getSharedProps()
        ) );
    }

    public function destroy( Product $product ) {
        if ( $product->image ) {

            $imagePath = public_path( $product->image );
            if ( file_exists( $imagePath ) ) {
                unlink( $imagePath );
            }
        }
        $product->delete();

        return Redirect::route( 'product.index' )->with( [
            'success' => 'Product deleted successfully',
        ] );

    }
}