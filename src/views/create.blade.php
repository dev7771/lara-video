@extends('backend.layouts.general')

@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">@lang('backend.videos.all')</h3> 
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('videos.create') }}">@lang('backend.add')</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('videos.index') }}">@lang('backend.list')</a></li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
             @include('backend.errors.validation')
            <div class="card">
                            <div class="card-body p-b-0">
                                    <h4 class="card-title">@lang('backend.videos.create')</h4>
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs customtab" role="tablist">
                                        @foreach(config('app.locales') as $code => $locale)
                                        <li class="nav-item"> 
                                            <a class="nav-link @if($loop->iteration == 1)active show @endif" data-toggle="tab" href="#locale{{$code}}" role="tab" aria-selected="true"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">{{ $locale }}</span></a> 
                                        </li>
                                        @endforeach
                                    </ul>
                                    <!-- Tab panes -->
                                    <form action="{{route('videos.store')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                         <div class="tab-content">
                                            @foreach(config('app.locales') as $code => $locale)
                                            <div style="padding-top: 20px;" class="tab-pane @if($loop->iteration == 1)active show @endif" id="locale{{$code}}" role="tabpanel">
                                                <div class="p-20">
                                                    <div class="form-body">
                                                        <div class="form-group row">
                                                            <label class="control-label text-left col-md-3">@lang('backend.title')</label>
                                                            <div class="col-md-9">
                                                                <input type="text" name="title[{{$code}}]" value="{{  old('title.$code') }}"  class="form-control">
                                                            </div>
                                                        </div>

                                                       
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach

                                          </div>
                                          <div class="col-md-12">
                                             
                                              <div class="form-group row">
                                                  <label class="control-label col-md-3">@lang('backend.image')</label>
                                                  <div class="col-md-9">
                                                      <input type="file" name="image" class="form-control">
                                                  </div>
                                              </div>
                                              
                                              <div class="form-group row">
                                                  <label class="control-label col-md-3">@lang('backend.video')</label>
                                                  <div class="col-md-9">
                                                      <input type="file" name="video" class="form-control">
                                                  </div>
                                              </div>


                                               <div class="form-group row">
                                                  <label class="control-label col-md-3">@lang('backend.video_iframe')</label>
                                                  <div class="col-md-9">
                                                      <input type="text" name="link" class="form-control">
                                                  </div>
                                              </div>



                                                                                            <div class="form-group row">
                                              <label class="control-label col-md-3">@lang('backend.date')</label>
                                                  <div class="col-md-9">
                                                      <input type="date" name="date">
                                                  </div>
                                              </div>



                                              <div class="form-group row">
                                                  <label class="control-label col-md-3" >@lang('backend.ordering')</label>
                                                  <div class="col-md-9">
                                                      <input type="number" name="ordering" value="{{ $ordering }}" class="form-control">
                                                  </div>
                                              </div>
                  
                                           
                                          </div> 

                                           <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="offset-sm-3 col-md-9">
                                                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('backend.add')</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    </form>
                            </div>
            </div>
        </div>
    </div>
</div>


@endsection