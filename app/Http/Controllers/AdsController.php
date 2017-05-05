<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdsRequest;
use App\Category;
use App\Ads;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class AdsController extends Controller {

	public function __construct() {
		$this->middleware( 'auth', [ 'only' => [ 'create', 'imageUpload' ] ] );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//return \Auth::user()->name;
		$ads = Ads::latest( 'published_at' )->published()->get();
		// dd($ads);
		//$ads = '1';
		return view( 'ads.index', compact( 'ads' ) );
	}

	/**
	 * @return mixed
	 */
	public function getCategories() {
		$nodes = Category::all()->toHierarchy();

		return response()->json( $nodes, 200 );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
//        if(Auth::guest()) {
//            return redirect('ads');
//        }
		$categories = Category::roots()->get();
		$node       = Category::where( 'name', '=', 'Computers' )->first()->getDescendantsAndSelf()->toHierarchy();
		//dd($node);
		//$category->getNestedList('name');
		//dd($categories);
		return view( 'ads.create', compact( 'node', 'categories' ) );
	}

	/**
	 * @param Request $request
	 *
	 * @return string
	 */
	public function imageUpload( Request $request ) {
		$input = $request->all();
		//return response()->json([], 200);


		$files = $request->file( 'uploadImages' );
		//dd($files);
		$links = array();
		if ( $files !== null ) {
			foreach ( $files as $file ) {
				$image_name = $input['clearTitle'] . $file->getClientOriginalName();
				$file->move( 'uploads/', $image_name );
				array_push( $links, $image_name );
				Image::make( sprintf( 'uploads/%s', $image_name ) )->resize( null, 400, function ( $constraint ) {
					$constraint->aspectRatio();
					$constraint->upsize();
				} )->save();
			}
		} else {
			return json_encode( [] );
		}

		return json_encode( $links );
	}

	/**
	 * @param Request $request
	 *
	 * @return string
	 */
	public function imageDelete( Request $request ) {
		$input = $request->all();
		$id    = $input['id'];
		$ads   = Ads::findOrFail( $id );
		//dd(json_decode($ads->pictures), $input['pictures']);
		$pictures           = json_decode( $ads->pictures );
		$input['imageData'] = $pictures;
		//dd($pictures, $input['key']);

		if ( ( $key = array_search( $input['key'], $pictures ) ) !== false ) {
			unset( $pictures[ $key ] );
		}

		//dd($pictures, $id);
		Storage::delete( '/uploads/' . $input['key'] );
		$this->updateAdsPictures( $pictures, $id );
		//return response()->json([], 200);
		//dd($request->all());
//        $files = $request->file('pictures');
//        $links = array();
//        if ($files !== null) {
//            foreach ($files as $file) {
//                $image_name = time() . "-" . $file->getClientOriginalName();
//                $file->move('uploads/', $image_name);
//                array_push($links, $image_name);
//                Image::make(sprintf('uploads/%s', $image_name))->resize(null, 400, function ($constraint) {
//                    $constraint->aspectRatio();
//                    $constraint->upsize();
//                })->save();
//            }
//        } else {
//            return json_encode([]);
//        }

		return json_encode( [] );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\AdsRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( AdsRequest $request ) {

		//Auth::user();
		//dd($request->file('pictures'));
		$input = $request->all();

		$input['pictures'] = json_encode( $input['pictures'] );
		//dd($input['pictures']);
		$ads = new Ads( $input );
		//dd($ads);
		Auth::user()->ads()->save( $ads );

		//session()->flash('flash_message', 'Your ads has been created!');
		//session()->flash('flash_message_important', true);
		//Auth::user()->ads()->create($request->all());
		//Articles::create($request->all()); // user_id => Auth::user()->id
//        $article = new Articles();
//        $article->title = $input['title'];

		return redirect( 'ads' )->with( [
			'flash_message'           => 'Your ads has been created!',
			'flash_message_important' => true
		] );
	}

	/**
	 * @param Ads $ads
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show( Ads $ads ) {
		//$ads = Articles::findOrFail($id);
		$pictures = json_decode( $ads->pictures );
		//dd($article->created_at->year);
		//dd($article->created_at->addDays(9)->format('Y-m'));
		// dd($article->published_at->addDays(9)->diffForHumans());
		return view( 'ads.show', compact( 'ads', 'pictures' ) );
	}

	/**
	 * @param Ads $ads
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit( Ads $ads ) {
		// $ads = Ads::findOrFail($id);
		$product = Category::find( $ads->category_id );
		//dd( $product );
		$ads->category_name = $product['attributes']['name'];

		//dd($ads);
		return view( 'ads.edit', compact( 'ads' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request ) {
		//dd('in update!!!');

		$input = $request->all();
		$id    = intval( $input['ads_id'] );
		$ads   = Ads::findOrFail( $id );
		//dd(json_decode($ads->pictures), $input['pictures']);
		if ( isset( $input['pictures'] ) ) {
			$input['pictures'] = json_encode( $input['pictures'] );
		}

		$ads->update( $input );

		return json_encode( [] );
	}

	public function updateAdsPictures( $pictures, $id ) {
		$ads = Ads::findOrFail( $id );

		//dd($ads);
		$arrayString = '[]';
		if ( count( $pictures ) !== 0 ) {
			$arrayString = '["' . implode( '","', $pictures ) . '"]';
		}

		$ads->update( [ 'pictures' => $arrayString ] );

		return json_encode( [] );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		//
	}
}
