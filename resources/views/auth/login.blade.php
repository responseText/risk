@extends('layouts.page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">เข้าสู่ระบบ</h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">


                    <form method="POST" action="{{ route('login') }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">



                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">ชื่อเข้าใช้งานระบบ</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">รหัสผ่าน</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4  pull-right">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('เข้าสู่ระบบ') }}
                                </button>


                            </div>
                        </div>
                    </form>


              </div>
          </div>


        </div>
    </div>
</div>
@endsection
