@extends('backend.layouts.general')

@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">@lang('backend.articles.all')</h3> 
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('articles.create') }}">@lang('backend.add')</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('articles.index') }}">@lang('backend.list')</a></li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
             @include('backend.errors.validation')
            <div class="card">
                            <div class="card-body p-b-0">
                                    <h4 class="card-title">@lang('backend.articles.create')</h4>
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs customtab" role="tablist">
                                        @foreach(config('app.locales') as $code => $locale)
                                        <li class="nav-item"> 
                                            <a class="nav-link @if($loop->iteration == 1)active show @endif" data-toggle="tab" href="#locale{{$code}}" role="tab" aria-selected="true"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">{{ $locale }}</span></a> 
                                        </li>
                                        @endforeach
                                    </ul>
                                    <!-- Tab panes -->
                                    <form action="{{route('articles.update', $article->id)}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        {{ method_field('PUT') }}
                                         <div class="tab-content">
                                            @foreach(config('app.locales') as $code => $locale)
                                            <div style="padding-top: 20px;" class="tab-pane @if($loop->iteration == 1)active show @endif" id="locale{{$code}}" role="tabpanel">
                                                <div class="p-20">
                                                    <div class="form-body">
                                                        <div class="form-group row">
                                                            <label class="control-label text-left col-md-3">@lang('backend.title')</label>
                                                            <div class="col-md-9">
                                                                <input type="text" name="title[{{$code}}]" value="{{ $article->translate($code)->title }}"  class="form-control">
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="form-group row">
                                                            <label class="control-label text-left col-md-3">@lang('backend.body')</label>
                                                            <div class="col-md-9">
                                                                <textarea  class="form-control editor" name="body[{{$code}}]">{{ $article->translate($code)->body }}</textarea>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="form-group row">
                                                            <label class="control-label text-left col-md-3">@lang('backend.description')</label>
                                                            <div class="col-md-9">
                                                                <textarea  class="form-control" name="description[{{$code}}]">{{ $article->translate($code)->description }}</textarea>
                                                            </div>
                                                        </div>
                                                       
                                                       <div class="form-group row source" style="display: none">
                                                            <label class="control-label text-left col-md-3">@lang('backend.source')</label>
                                                            <div class="col-md-9">

                                                              <input type="text" name="source[{{$code}}]" value="{{ $article->translate($code)->source }}"  class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="control-label text-left col-md-3">@lang('backend.link')</label>
                                                            <div class="col-md-9">
                                                                <textarea  class="form-control" name="link[{{$code}}]">{{ $article->translate($code)->link }}</textarea>
                                                            </div>
                                                        </div>
                                                       
                                                     {{--   <div class="form-group row">
                                                            <label class="control-label text-left col-md-3">@lang('backend.slogan_author')</label>
                                                            <div class="col-md-9">
                                                                <textarea  class="form-control" name="slogan_author[{{$code}}]">{{ $article->translate($code)->slogan_author }}</textarea>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach

                                          </div>
                                          <div class="col-md-12">
                                              <div class="form-group row">
                                                  <label class="control-label col-md-3">@lang('backend.category')</label>
                                                  <div class="col-md-9">
                                                      <select class="form-control category" multiple="multiple" name="categories[]" style="height: 150px;">
                                                                @foreach($categories as $key => $category)
                                                                  <option value="{{ $category->id }}" @if(in_array($category->id, $categoriesIds)) selected="selected" @endif >{{ $category->translate()->title }}</option>
                                                                 @endforeach                               
                                                      </select>
                                                  </div>
                                              </div> 

                                              <div class="form-group row">
                                                  <label class="control-label col-md-3">Örtük @lang('backend.image')</label>
                                                  <div class="col-md-3">
                                                      <input type="file" name="image" class="form-control">
                                                  </div>
                                                   @if($article->image)
                                                     <div class="col-md-5">
                                                        <img src="{{ url('/')}}/storage/articles/{{ $article->image }}" width="100" height="100">
                                                        <a class="btn btn-xs btn-danger" href="{{ route('articles.removePhoto', $article->id) }}"> {{ __('backend.delete') }} </a>
                                                        <a class="btn btn-xs btn-success" target="_blank" href="{{ url('/')}}/storage/articles/{{ $article->image }}" >Aç</a>
                                                     </div>
                                                   @endif
                                              </div>

                                              <div class="form-group row">
                                                  <label class="control-label col-md-3">Galeria</label>
                                                  <div class="col-md-3">
                                                      <input type="file" name="images[]" multiple="multiple" class="form-control">
                                                  </div>

                                                    @if($images = $article->images()->get())
                                                      @foreach($images as $image)
                                                       <div class="col-md-2">
                                                          <img src="{{ url('/')}}/storage/articles/{{ $image->image }}" width="100" height="100">
                                                          <a class="btn btn-xs btn-danger" href="{{ route('articles.removeSliderPhoto', $image->id) }}"> {{ __('backend.delete') }} </a>
                                                          <a class="btn btn-xs btn-success" target="_blank" href="{{ url('/')}}/storage/articles/{{ $image->image }}" >Aç</a>
                                                       </div>
                                                      @endforeach
                                                   @endif
                                              </div>

                                              <div class="form-group row">
                                                  <label class="control-label col-md-3">@lang('backend.date')</label>
                                                  <div class="col-md-9">
                                                      <input type="datetime-local" class="form-control" id="myDate" value="{{ str_replace(' ', 'T', $article->date->format('Y-m-d H:i:s'))}}" name="date">
                                                  </div>
                                              </div>




                                              <div class="form-group row">
                                                  <label class="control-label col-md-3">Ana səhifədə</label>
                                                  <div class="col-md-9">
                                                        <div class="form-check">
                                                          <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" @if($article->slider==true) checked="checked" @endif name="slider" value="1">Olsun
                                                          </label>
                                                        </div>
                                                        <div class="form-check">
                                                          <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" @if($article->slider==false) checked="checked" @endif name="slider" value="0">Olmasın
                                                          </label>
                                                        </div>
                                                  </div>
                                              </div>

                                                <div class="form-group row">
                                                  <label class="control-label col-md-3">@lang('backend.status')</label>
                                                  <div class="col-md-9">
                                                        <div class="form-check">
                                                          <label class="form-check-label">
                                                            <input type="radio"   @if($article->status == 1) checked="checked" @endif  class="form-check-input" name="status" value="1">Aktiv
                                                          </label>
                                                        </div>
                                                        <div class="form-check">
                                                          <label class="form-check-label">
                                                            <input type="radio" @if($article->status == 0) checked="checked" @endif  class="form-check-input" name="status" value="0">Dekaktiv
                                                          </label>
                                                        </div>
                                                  </div>
                                              </div>

                                          </div> 

                                           <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="offset-sm-3 col-md-9">
                                                                <input type="hidden" name="parent_id" value="{{ \Request::get('parent_id') }}">
                                                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('backend.update')</button>
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


<script type="text/javascript">
  
  $(document).ready(function() {

      var current_category = $('.category').val();

      if(current_category == 5) {
           
            $('.source').css('display', 'flex');
      }

      $('.category').on('change', function() {

          if( $( this ).val() == 5) {

            $('.source').css('display', 'flex');
          } 
          else {
            $('.source').css('display', 'none');

          }
      });
  });
</script>



@endsection