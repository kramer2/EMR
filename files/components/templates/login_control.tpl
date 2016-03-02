
<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
          <h1 class="text-center">{$Captions->GetMessageString('LoginTitle')}</h1>
      </div>
      <div class="modal-body">
        {if $LoginControl->GetErrorMessage() != '' }
        {strip}
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Error:</strong> {$LoginControl->GetErrorMessage()}
        </div>
        {/strip}
        {/if}
          <form class="form col-md-12 center-block" method="post" action="login.php" rule="form" style="float: none;">
            <div class="form-group">
              <input type="text" name="username" id="username" class="form-control input-lg" placeholder="{$Captions->GetMessageString('Username')}" {if $LoginControl->GetLastUserName() != ''} value="{$LoginControl->GetLastUserName()}"{/if}>
            </div>
            <div class="form-group">
              <input type="password" name="password" id="password" class="form-control input-lg" placeholder="{$Captions->GetMessageString('Password')}">
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox" name="saveidentity" id="saveidentity" {if $LoginControl->GetLastSaveidentity()} checked="checked"{/if}>{$Captions->GetMessageString('RememberMe')}</label>
                </div>
            </div>
            <div class="form-group">
              <button class="btn btn-primary btn-lg btn-block">{$Captions->GetMessageString('Login')}</button>
            </div>
            {if $LoginControl->CanLoginAsGuest()}
            {strip}
            <div class="form-group">
                <a href="{$LoginControl->GetLoginAsGuestLink()}">Login as guest</a>
            </div>
            {/strip}
            {/if}
          </form>
      </div>
      <div class="modal-footer">
          <div class="col-md-12">
          
          </div>    
      </div>
  </div>
  </div>
</div>
