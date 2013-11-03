<?php /* Smarty version 2.6.26, created on 2011-03-16 21:33:24
         compiled from common/base_page_template.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html<?php if ($this->_tpl_vars['Page']->GetPageDirection() != null): ?> dir="<?php echo $this->_tpl_vars['Page']->GetPageDirection(); ?>
"<?php endif; ?>>
<head>
    <meta http-equiv="content-type" content="text/html<?php if ($this->_tpl_vars['Page']->GetContentEncoding() != null): ?>; charset=<?php echo $this->_tpl_vars['Page']->GetContentEncoding(); ?>
<?php endif; ?>" />
    <meta name="generator" content="Maestro PHP Generator" />
    <?php echo $this->_tpl_vars['HeadMetaTags']; ?>

    <title><?php echo $this->_tpl_vars['Page']->GetCaption(); ?>
</title>
    <!--[if lte IE 6]>
    <style>
        th { behavior: url('iepngfix.htc'); }
        div.site_header_pad
        {
            margin: 0px;
            display: none;
        }
    </style>
    <![endif]-->
    <script type="text/javascript" src="libs/calendar/js/jscal2.js"></script>
    <script type="text/javascript" src="libs/calendar/js/lang/en.js"></script>

    <link rel="stylesheet" type="text/css" href="libs/calendar/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="libs/calendar/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="phpgen.css" />
    <link rel="stylesheet" type="text/css" href="grid.css" />
    <link rel="stylesheet" type="text/css" href="common_style.css" />
    <link rel="stylesheet" type="text/css" href="libs/jquery/css/lightbox.css" media="screen" />
    <!-- link rel="stylesheet" type="text/css" href="libs/jquery/css/jquery.ui.all.css" / -->
	<link rel="stylesheet" type="text/css" href="libs/jquery/css/jquery-ui-1.8.2.custom.css" media="screen" />

    <script type="text/javascript" src="libs/jquery/jquery.js"></script>
    <script type="text/javascript" src="libs/jquery/jquery.highlight-3.js"></script>
    <script type="text/javascript" src="libs/jquery/jquery.hotkeys-0.7.9.min.js"></script>
    <script type="text/javascript" src="libs/jquery/jquery.qtips.js"></script>
    <script type="text/javascript" src="libs/jquery/jquery.lightbox.js"></script>
    <script type="text/javascript" src="libs/jquery/tiny_mce/jquery.tinymce.js"></script>
    <script type="text/javascript" src="libs/jquery/jquery.color.js"></script>
    <script type="text/javascript" src="libs/jquery/jquery.colors.js"></script>
    <script type="text/javascript" src="libs/jquery/jquery.clearfield.js"></script>
    <!-- script type="text/javascript" src="libs/jquery/jquery-ui-1.8.custom.min.js"></script -->
	<script type="text/javascript" src="libs/jquery/jquery-ui-1.8.2.custom.min.js"></script>
	<script type="text/javascript" src="libs/jquery/jquery.query.js	"></script>

    <script type="text/javascript" src="libs/jquery/jquery.blockui.js"></script>
	<script type="text/javascript" src="libs/jquery/jquery.blockui.js"></script>

    <script type="text/javascript" src="components/js/common.js"></script>

    <script type="text/javascript" src="phpgen.js"></script>
    <script type="text/javascript" src="components/js/inline_editing.js"></script>
    <script type="text/javascript" src="components/js/utils.js"></script>
    <script type="text/javascript" src="components/js/control_adapters.js"></script>
    <script type="text/javascript" src="components/js/validators.js"></script>

    <link rel="stylesheet" type="text/css" href="libs/spinedit/spincontrol.css" media="screen" />
    <script type="text/javascript" src="libs/spinedit/spincontrol.js"></script>

    <?php echo $this->_tpl_vars['Page']->GetCustomPageHeader(); ?>


    <script type="text/javascript">
        try
        {
        <?php echo $this->_tpl_vars['Page']->GetCustomClientScript(); ?>

        }
        catch(error)
        {
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function()
        {
        try
        {
        <?php echo $this->_tpl_vars['Page']->GetOnPageLoadedClientScript(); ?>

        }
        catch(error)
        {
        }
        }
        );
    </script>

	<script type="text/javascript">
	   $(document).ready(function(){
	           $("a[rel=zoom]").lightbox();
	       });
	   $(document).ready(function(){
            $('span.more_hint').each(function(i)
                {
                    $(this).qtip(
                        {
                            container:('tip_' + i),
                            content:($(this).children('div.box_hidden').html()),
                            position:'center'
                        }
                    );
	      });
	   });

    sideBarHidden = GetCookie('sideBarHidden') == 'true';

    function ApplySideBarPosition()
    {
        if (sideBarHidden)
            $('#right_side_bar').hide();
    }

    function ToogleSideBar()
    {
        if (sideBarHidden)
            $('#right_side_bar').show('normal');
        else
            $('#right_side_bar').hide('normal');
        sideBarHidden = !sideBarHidden;
        SetCookie('sideBarHidden', sideBarHidden ? 'true' : 'false');
    }

    $(document).ready(function()
    {

        $('.hinted_header').each(function(i)
        {
            if ($(this).children('div.box_hidden_header').html())
            $(this).qtip(
                {
                    container:  ('header_tip_' + i),
                    content:($(this).children('div.box_hidden_header').html()),
                    position:'center',
                    tip_class: 'qtip-wrapper-header'
                });

        });

    });
	</script>
</head>
<?php echo $this->_tpl_vars['ContentBlock']; ?>

<?php echo $this->_tpl_vars['DebugFooter']; ?>

</html>