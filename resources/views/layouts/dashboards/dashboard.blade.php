@extends("layouts.app")
@section("title")
  @parent
  @yield("dashboard.title")
@endsection
@section("content")
  @yield("dashboard.sidebar")
  @yield("dashboard.content")
  <div class="modal fade" id="delete_confirmation_modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="delete_confirmation_modal_title">{{ trans('string.delete_confirmation_modal_title') }}</h4>
              </div>
              <div class="modal-body" id="delete_confirmation_modal_content">
              </div>
              <div class="modal-footer">
                  <a class="btn btn-link waves-effect" id="delete_confirmation_modal_confirm">{{ trans('string.confirm_button') }}</a>
                  <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">{{ trans('string.cancel_button') }}</button>
              </div>
          </div>
      </div>
  </div>
  <div class="modal fade" id="signout_confirmation_modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="signout_confirmation_modal_title">{{ trans('string.signout_confirmation_modal_title') }}</h4>
              </div>
              <div class="modal-body" id="signout_confirmation_modal_content">
                {{ trans('string.signout_confirmation_modal_content') }}
              </div>
              <div class="modal-footer">
                  <a class="btn btn-link waves-effect" id="delete_confirmation_modal_confirm" href="{{ route('auth.signout') }}">{{ trans('string.confirm_button') }}</a>
                  <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">{{ trans('string.cancel_button') }}</button>
              </div>
          </div>
      </div>
  </div>
@endsection
