@section('stylesheets')
@stop
@section('scripts')
{{ HTML::script('js/schedules_new_frontend.js') }}
@stop

@section('content')

    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="well clearfix">
              <h2>Members</h2>
              <hr>
              <form role="form">
                <div class="form-group">
                  <label class="control-label" for="exampleInputEmail1">Email address</label>
                  <input class="form-control" id="exampleInputEmail1"
                  placeholder="Enter email" type="email">
                </div>
                <div class="form-group">
                  <label class="control-label" for="exampleInputPassword1">Password</label>
                  <input class="form-control" id="exampleInputPassword1"
                  placeholder="Password" type="password">
                </div>
                <a href="">Forgot password?</a>
            	</br>
                <button type="submit" class="btn btn-primary pull-right">Submit</button>
              </form>
            </div>
          </div>
          <div class="col-md-6">
            <div class="well clearfix">
              <h2>Guests</h2>
              <hr>
              <form role="form">
                <div class="form-group">
                  <label class="control-label" for="exampleInputEmail1">Email address</label>
                  <input class="form-control" id="exampleInputEmail1"
                  placeholder="Enter email" type="email">
                </div>
                <div class="form-group">
                  <label class="control-label" for="exampleInputEmail1">Email address</label>
                  <input class="form-control" id="exampleInputEmail1"
                  placeholder="Enter email" type="email">
                </div>
                <div class="form-group">
                  <label class="control-label" for="exampleInputEmail1">Email address</label>
                  <input class="form-control" id="exampleInputEmail1"
                  placeholder="Enter email" type="email">
                </div>
                <div class="form-group">
                  <label class="control-label" for="exampleInputEmail1">Email address</label>
                  <input class="form-control" id="exampleInputEmail1"
                  placeholder="Enter email" type="email">
                </div>
                <div class="form-group">
                  <label class="control-label" for="exampleInputEmail1">Email address</label>
                  <input class="form-control" id="exampleInputEmail1"
                  placeholder="Enter email" type="email">
                </div>
                <div class="form-group">
                  <label class="control-label" for="exampleInputEmail1">Email address</label>
                  <input class="form-control" id="exampleInputEmail1"
                  placeholder="Enter email" type="email">
                </div>
                <div class="form-group">
                  <label class="control-label" for="exampleInputEmail1">Email address</label>
                  <input class="form-control" id="exampleInputEmail1"
                  placeholder="Enter email" type="email">
                </div>
                <a class="btn btn-primary pull-right">Continue As Guest</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

@stop