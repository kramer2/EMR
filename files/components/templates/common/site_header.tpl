
<nav id="myNavmenu" class="navmenu navmenu-default navmenu-fixed-left offcanvas" role="navigation">
  <a class="navmenu-brand" href="#">{$Page->GetHeader()}</a>
  {if $Page->GetCaption() !== 'Login'}
  <ul class="nav navmenu-nav">
    {if $Page->GetShowPageList()}
    {$PageList}
    {/if}

    {if $Page->GetPrinterFriendlyAvailable()}
    {/if}

    {if $Page->GetExportToExcelAvailable() or $Page->GetExportToWordAvailable() or $Page->GetExportToXmlAvailable() or $Page->GetExportToCsvAvailable() or $Page->GetExportToPdfAvailable()}
    {/if}
  </ul>
  {/if}
</nav>
<div class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid"> 
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target="#myNavmenu" data-canvas="body">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    {if $Page->GetCaption() !== 'Login'}
    {if $Page->GetShowUserAuthBar()}
      <ul class="nav navbar-nav navbar-right">
        {if $Page->IsCurrentUserLoggedIn()}
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="glyphicon glyphicon-user"></span> 
              <strong>{$Page->GetCurrentUserName()}</strong>
              <span class="glyphicon glyphicon-chevron-down"></span>
            </a>
            <ul class="dropdown-menu">
              <li>
                <div class="navbar-login">
                  <div class="row">
                    <div class="col-lg-4">
                      <p class="text-center">
                        <span class="glyphicon glyphicon-user icon-size"></span>
                      </p>
                    </div>
                    <div class="col-lg-8">
                      <p class="text-left"><strong>{$Page->GetCurrentUserName()}</strong></p>
                      <p class="text-left small hide">correoElectronico@email.com</p>
                      <p class="text-left hide">
                        <a href="#" class="btn btn-primary btn-block btn-sm">Actualizar Datos</a>
                      </p>
                    </div>
                  </div>
                </div>
              </li>
              <li class="divider"></li>
              <li>
                <div class="navbar-login navbar-login-session">
                  <div class="row">
                    <div class="col-lg-12">
                      <p>
                        <a href="login.php?operation=logout" class="btn btn-danger btn-block">{$Captions->GetMessageString('Logout')}</a>
                      </p>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </li>
        {else}
          <li><a href="login.php">{$Captions->GetMessageString('Login')}</a></li>
        {/if}
      </ul>
    {/if}
    {/if}
  </div>
</div>