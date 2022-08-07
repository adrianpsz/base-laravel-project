@extends('home.home')

@section('seo-subtitle'){{ __('Users') }} @endsection

@section('home')
    <h3>{{ __('Users') }}
        <small>
            {{ __('(Total: :count)',[
            'count' => count($users)
        ]) }}
        </small>
    </h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>
                    {{ __('Name') }}
                </th>
                <th>
                    {{ __('Role') }}
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>
                        {{ $user->name }}
                    </td>
                    <td>
                        {{ $user->rolesNames() }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex">
        {{ $users->links() }}
    </div>
@endsection
