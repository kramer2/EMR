<?php
    require_once 'database_engine/mysql_engine.php';
    require_once 'components/page.php';
    require_once 'components/renderers/renderer.php';
    require_once 'components/renderers/list_renderer.php';
    require_once 'authorization.php';
    require_once 'settings.php';

    class LoginControl
    {
        private $identityCheckStrategy;
        private $urlToRedirectAfterLogin;
        private $errorMessage;
        private $lastUserName;
        private $lastSaveidentity;
        private $loginAsGuestLink;

        public function __construct($identityCheckStrategy, $urlToRedirectAfterLogin)
        {
            $this->identityCheckStrategy = $identityCheckStrategy;
            $this->urlToRedirectAfterLogin = $urlToRedirectAfterLogin;
            $this->errorMessage = '';
            $this->lastSaveidentity = false;
        }

        public function Accept($renderer)
        {
            $renderer->RenderLoginControl($this);
        }

        public function GetErrorMessage() { return $this->errorMessage; }

        public function GetLastUserName() { return $this->lastUserName; }
        public function GetLastSaveidentity() { return $this->lastSaveidentity; }
        public function CanLoginAsGuest() { return true; }
        
        public function GetLoginAsGuestLink() 
        { 
            $pageInfos = GetPageInfos();
            foreach($pageInfos as $pageInfo)
            {
                if (GetApplication()->GetUserRoles('guest', $pageInfo['name'])->HasViewGrant())
                {   
                    return $pageInfo['filename'];
                }
            }
            return $this->urlToRedirectAfterLogin; 
        }

        public function CheckUsernameAndPassword($username, $password, &$errorMessage)
        {
            $captions= new Captions('UTF-8');
            try
            {
                if ($username == "") {
                    $errorMessage = $captions->GetMessageString('EmptyUserName');
                    return false;
                }
                if ($password == '') {
                    $errorMessage = $captions->GetMessageString('EmptyPassword');
                    return false;
                }
                return $this->identityCheckStrategy->CheckUsernameAndPassword($username, $password, $errorMessage);
            }
            catch(Exception $e)
            {
                $errorMessage = $e->getMessage();
                return false;
            }
        }

        public function SaveUserIdentity($username, $password, $saveidentity)
        {
            $expire = $saveidentity ? time() + 3600 * 24 * 365 : 0;
            setcookie('scplu', json_encode(array('u'=>$this->encryptIt($username), 'p'=>$this->encryptIt($password))), $expire);
        }

        public function ClearUserIdentity()
        {
            setcookie('scplu', '', time() - 3600);
        }


        private function encryptIt( $q ) {
            $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
            $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
            return( $qEncoded );
        }

        private function decryptIt( $q ) {
            $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
            $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
            return( $qDecoded );
        }

        private function DoOnAfterLogin($userName)
        {
            $connectionFactory = new MyConnectionFactory;
            $connection = $connectionFactory->CreateConnection(GetGlobalConnectionOptions());
            $connection->Connect();

            $this->OnAfterLogin($userName, $connection);

            $connection->Disconnect();
        }

        private function OnAfterLogin($userName, $connection)
        {

        }

        private function GetUrlToRedirectAfterLogin()
        {
            $pageInfos = GetPageInfos();
            foreach($pageInfos as $pageInfo)
            {
                if (GetCurrentUserGrantForDataSource($pageInfo['name'])->HasViewGrant())
                {   
                    return $pageInfo['filename'];
                }
            }
            return $this->urlToRedirectAfterLogin;
        }
        
        public function ProcessMessages()
        {
            if (isset($_GET[OPERATION_PARAMNAME]) && $_GET[OPERATION_PARAMNAME] == 'logout')
            {
                $this->ClearUserIdentity();
            }
            elseif (isset($_COOKIE['scplu']) && !(isset($_POST['username']) && isset($_POST['password'])))
            {
                /*$username = $_COOKIE['username'];
                $password = $_COOKIE['password'];

                if ($this->CheckUsernameAndPassword($username, $password, $this->errorMessage))
                {
                    header('Location: ' . $this->urlToRedirectAfterLogin );
                }
                else
                {
                }*/
                $uar = json_decode($_COOKIE['scplu']);
                $usr = $this->decryptIt($uar->u);
                $usrp = $this->decryptIt($uar->p);
                if ($this->CheckUsernameAndPassword($usr, $usrp, $this->errorMessage)) {
                    $this->SaveUserIdentity($usr, $usrp, true);
                    $this->DoOnAfterLogin($usr);
                    header('Location: ' . $this->GetUrlToRedirectAfterLogin() );
                    exit;
                } else {
                    $this->lastUserName = $usr;
                    $this->lastSaveidentity = true;
                }
            }
            elseif (isset($_POST['username']) && isset($_POST['password']))
            {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $saveidentity = isset($_POST['saveidentity']);

                if ($this->CheckUsernameAndPassword($username, $password, $this->errorMessage))
                {
                    $this->SaveUserIdentity($username, $password, $saveidentity);
                    $this->DoOnAfterLogin($username);
                    header('Location: ' . $this->GetUrlToRedirectAfterLogin() );
                    exit;
                }
                else
                {
                    $this->lastUserName = $username;
                    $this->lastSaveidentity = $saveidentity;
                }
            }
        }
    }

    class LoginPage extends CustomLoginPage
    {
        private $loginControl;
        private $renderer;
        private $header;
        private $footer;

        public function __construct($loginControl)
        {
            parent::__construct();
            $this->loginControl = $loginControl;
            $this->renderer = new ViewAllRenderer(GetCaptions('UTF-8'));
        }

        public function GetLoginControl()
        {
            return $this->loginControl;
        }

        public function Accept($renderer)
        {
            $renderer->RenderLoginPage($this);
        }

        public function GetContentEncoding() { return 'UTF-8'; }
        
        public function GetCaption() { return 'Login'; }
        
        public function SetHeader($value) { $this->header = $value; }
        public function GetHeader() { return $this->RenderText($this->header); }
        
        public function SetFooter($value) { $this->footer = $value; }
        public function GetFooter() { return $this->RenderText($this->footer); }

        public function BeginRender()
        {
            $this->loginControl->ProcessMessages();
        }

        public function EndRender()
        {
            echo $this->renderer->Render($this);
        }
    }

    $loginPage = new LoginPage(
        new LoginControl(
            GetIdentityCheckStrategy(),
            'crew.php'));

    SetUpUserAuthorization();

    $loginPage->SetHeader(GetPagesHeader());
    $loginPage->SetFooter(GetPagesFooter());
    $loginPage->BeginRender();
    $loginPage->BeginRender();
    $loginPage->EndRender();
?>
