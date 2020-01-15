<?php

namespace Turanzamanli\LaraVideo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Turanzamanli\LaraVideo\Video;
use Validator;


class VideoController extends Controller
{   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $videos = Video::orderBy('id','desc')->get();

        return view('laravideo::index', compact('videos'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $ordering = Video::max('ordering') + 1;

        return view('laravideo::create', compact('ordering'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        


        $rules = [
           
            'title.az'      =>   'required',
            'ordering'      =>   'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
           
            return back()
                   ->withErrors($validator)->withInput();
        }

        $video = new Video();


        foreach (config('app.locales') as $code => $locale) {

              $video->translateOrNew($code)->title               =   $request->input('title')[$code];
        }


        if($request->hasFile('image')) {

             $video->image   =    $request->file('image')->hashName();

             $request->image->storeAs('videos', $video->image, 'public' );
        }

        if($request->hasFile('video')) {
            
             $video->video   =    $request->file('video')->hashName();

             $request->image->storeAs('videos', $video->video, 'public' );
        }


        $video->ordering   =  $request->input('ordering');
        $video->date       =  $request->input('date');


        if($request->link):

             preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $request->input('link'), $match);

             $youtube_id = 'https://www.youtube.com/embed/'.$match[1];

             $video->link = $youtube_id;

        endif;


        $video->save();


        return redirect()->route('videos.index')->withMessage(__('backend.videos.added'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {

        return view('laravideo::edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        

            $rules = [
               
                'title.az'      =>   'required',
                'ordering'      =>   'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
               
                return back()
                       ->withErrors($validator)->withInput();
            }



            foreach (config('app.locales') as $code => $locale) {

                  $video->translateOrNew($code)->title               =   $request->input('title')[$code];
            }

            if($request->hasFile('image')) {
                
                 $video->image   =    $request->file('image')->hashName();

                 $request->image->storeAs('videos', $video->image, 'public' );
            }

            if($request->hasFile('video')) {
                
                 $video->video   =    $request->file('video')->hashName();

                 $request->video->storeAs('videos', $video->video, 'public' );
            }


            $video->ordering   =  $request->input('ordering');
            $video->date       =  $request->input('date');
            
            if($request->link):

             if(preg_match('/embed/i', $request->link)) {

                $video->link = $request->link;

             }
             else{



             preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $request->input('link'), $match);

             $youtube_id = 'https://www.youtube.com/embed/'.$match[1];

             $video->link = $youtube_id;
            }
             
            endif;

            $video->save();


           return redirect()->route('videos.index')->withMessage(__('backend.videos.edited'));
    }




    public function removePhoto($id){

       $video   =  Video::findOrFail($id);

       $path   =  base_path() . '/storage/app/public/videos/' . $video->image;

       if( @unlink($path) ) {

         $video->image = null;
         $video->save();

         return back()->withMessage(__('backend.image.deleted'));
       }
       else {
         return back()->withMessage(__('backend.image.notdeleted'));
       }


    }

    public function removeVideo($id){



       $video   =  Video::findOrFail($id);

       $path   =  base_path() . '/storage/app/public/videos/' . $video->video;

       if( @unlink($path) ) {

         $video->video = NULL;
         $video->save();

         return back()->withMessage(__('backend.video.deleted'));
       }
       else {
         return back()->withMessage(__('backend.video.notdeleted'));
       }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
       $video   =  Video::findOrFail($id);

       if($video->image) {

         self::removePhoto($video->id);
       }

       if($video->video) {

         self::removeVideo($video->id);
       }

       $video->delete();

       return redirect()->route('videos.index')->withMessage(__('backend.videos.deleted'));

    }
}
