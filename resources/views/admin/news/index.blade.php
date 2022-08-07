@extends('home.home')

@section('seo-subtitle'){{ __('News') }} @endsection

@section('home')
    <div class="row mb3">
        <div class="col-12">
            <h3>{{ __('List of news') }}</h3>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th class="w-15">{{ __('Images') }}</th>
                        <th>{{ __('Title') }}</th>
                        <th class="d-none d-lg-table-cell">{{ __('Message') }}</th>
                        <th>{{ __('Active') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($news as $n)
                        <tr>
                            <td>{{ $n->id }}</td>
                            <td>
                                <image-browser :url="'{{ url('image') }}'"
                                               :images='{{ $n->images }}'></image-browser>
                            </td>
                            <td>
                                <a class="fw-bold" href="{{ route('home.news.show',['news' => $n->id]) }}">
                                    {{ $n->title }}
                                </a> <br>
                                <small>{{ __('Author') }}:</small> <br> {{ $n->user->name }} ({{ $n->user->id }})
                            </td>
                            <td class="d-none d-lg-table-cell">{!! nl2br($n->message) !!}</td>
                            <td class="text-center">
                                <toggle-news-activation :active="{{ $n->is_active }}"
                                                        :url="'{{ url('/admin/news/ajax/active') }}'"
                                                        :id="'{{ $n->id }}'"></toggle-news-activation>
                            </td>
                            <td>

                                <a href="{{ route('home.news.edit',['news'=>$n->id]) }}"
                                   class="btn btn-info btn-sm d-block w-100 mb-2">
                                    {{ __('Update') }}
                                </a>
                                <form method="POST" class="d-inline"
                                      action="{{ route('home.news.destroy', ['news' => $n->id]) }}"
                                      onsubmit="return confirm('Remove?');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-danger btn-sm d-block w-100"
                                           value="{{ __('Remove') }}">
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
        {{ $news->links() }}
    </div>
@endsection
