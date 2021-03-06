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
                  <h4 class="modal-title" id="delete_confirmation_modal_title">{{ trans('string.confirmation_modal_title',['title'=>'Deletion']) }}</h4>
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
                  <h4 class="modal-title" id="signout_confirmation_modal_title">{{ trans('string.confirmation_modal_title',['title'=>'Sign Out']) }}</h4>
              </div>
              <div class="modal-body" id="signout_confirmation_modal_content">
                {{ trans('string.signout_confirmation_modal_content') }}
              </div>
              <div class="modal-footer">
                  <a class="btn btn-link waves-effect" id="signout_confirmation_modal_confirm" href="{{ route('auth.signout') }}">{{ trans('string.confirm_button') }}</a>
                  <button type="button" id="signout_cancel_button" class="btn btn-link waves-effect" data-dismiss="modal">{{ trans('string.cancel_button') }}</button>
              </div>
          </div>
      </div>
  </div>
  <div class="modal fade" id="printwarning_confirmation_modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="printwarning_confirmation_modal_title">{{ trans('string.confirmation_modal_title',['title'=>'Printing']) }}</h4>
              </div>
              <div class="modal-body" id="printwarning_confirmation_modal_content">
                {{ trans('string.printwarning_confirmation_modal_content') }}
                <div class="collapse" id="warning_details_collapse">
                    <div id="warning_details_collapse_content" class="well">
                    </div>
                </div>
                <br><br> <a id="warning-details_toggle" class='waves-effect' data-toggle='collapse' href='#warning_details_collapse' aria-expanded='false' aria-controls='warningDetails'>Details</a>
              </div>
              <div class="modal-footer">
                  <a class="btn btn-link waves-effect" id="printwarning_confirmation_modal_confirm">{{ trans('string.confirm_button') }}</a>
                  <button type="button" id="printwarning_cancel_button" class="btn btn-link waves-effect" data-dismiss="modal">{{ trans('string.cancel_button') }}</button>
              </div>
          </div>
      </div>
  </div>
  <div class="modal fade" id="status_update_confirmation_modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="status_update_confirmation_modal_title">{{ trans('string.confirmation_modal_title',['title'=>'Update']) }}</h4>
              </div>
              <div class="modal-body" id="status_update_confirmation_modal_content">
              </div>
              <div class="modal-footer">
                  <a class="btn btn-link waves-effect" id="status_update_confirmation_modal_confirm">{{ trans('string.confirm_button') }}</a>
                  <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">{{ trans('string.cancel_button') }}</button>
              </div>
          </div>
      </div>
  </div>
@endsection
