@extends('backend.layouts.general')

@section('content')

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">@lang('backend.videos.all')</h3> 
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('videos.create') }}"><i class="fas fa-plus"></i> @lang('backend.add')</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('videos.index') }}"><i class="fas fa-list"></i> @lang('backend.list')</a></li>
        </ol>
    </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      @if(Session::has('message' ))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
      @endif
      <div class="card">
                <div class="card-title">
                    <h4>@lang('backend.videos.all')</h4>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                   <th>#id</th>
                                   <th>@lang('backend.title')</th>
                                   <th>@lang('backend.ordering')</th>
                                   <th>@lang('backend.date')</th>
                                   <th>@lang('backend.update')/@lang('backend.delete')</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach( $videos as $video)
                                <tr>
                                    <th scope="row">{{ $video->id }}</th>
                                    <td>{{ $video->translate()->title }}</td>
                                    <td>{{ $video->ordering }}</td>
                                    <td>{{ $video->created_at->format('d-m-Y H:i') }}</td>
                                    <td> 
                                      <a  class="btn btn-info btn-xs" href="{{ route('videos.edit', $video->id) }}">{{ __('backend.update') }}
                                      </a>
                                    <form class="d-inline" action="{{ route('videos.destroy', $video->id) }}" method="POST">
                                      {{ method_field('DELETE')}} @csrf
                                     <button class="btn btn-xs btn-danger"  onclick="if (!confirm('Silmək istədiyinizdən əminsiniz?')) { return false }"><i class="glyphicon glyphicon-remove"></i> {{ __('backend.delete') }}</button>
                                    </form>
                                    </td>
                                </tr>


                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
          </div>
    </div>
  </div>
</div>
@endsection