@extends('layouts.app')

@section('content')


@if(session()->has('message-success'))
    <div class="alert alert-success mb-3 background-success" role="alert">
        {{ session()->get('message-success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@elseif(session()->has('message-danger'))
    <div class="alert alert-danger">
        {{ session()->get('message-danger') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif


<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Update Profile</div>

                    <div class="card-body">
        			    <form method="post" action=" {{ route('updateEmpProfile') }} " >

        			    	@csrf
        			    	
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->empDetails->name }}" required autocomplete="name">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="DOB" class="col-md-4 col-form-label text-md-right">{{ __('Date of Birth') }}</label>

                                <div class="col-md-6">
                                    <input id="DOB" type="date" class="form-control @error('DOB') is-invalid @enderror" name="DOB" value="{{ Auth::user()->empDetails->DOB }}" required autocomplete="DOB">

                                    @error('DOB')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="designation" class="col-md-4 col-form-label text-md-right">{{ __('Designation') }}</label>

                                <div class="col-md-6">
                                    <input id="designation" type="text" class="form-control @error('designation') is-invalid @enderror" name="designation" value="{{ Auth::user()->empDetails->designation }}" required autocomplete="designation">

                                    @error('designation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" readonly>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="salary" class="col-md-4 col-form-label text-md-right">{{ __('Salary') }}</label>

                                <div class="col-md-6">
                                    <input id="salary" type="number" class="form-control @error('salary') is-invalid @enderror" name="salary" value="{{ Auth::user()->empDetails->salary }}" readonly="">
                                </div>
                            </div>

        			        <div class="form-group row mb-0">
        			            <div class="col-md-6 offset-md-4">
        			                <button type="submit" class="btn btn-primary">
        			                    {{ __('Update Profile') }}
        			                </button>
        			            </div>
        			        </div>
        			    </form>
        			</div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
