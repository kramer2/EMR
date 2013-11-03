<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html{if $Page->GetPageDirection() != null} dir="{$Page->GetPageDirection()}"{/if}>
<head>
    <meta http-equiv="content-type" content="text/html{if $Page->GetContentEncoding() != null}; charset={$Page->GetContentEncoding()}{/if}" />
    <meta name="generator" content="Maestro PHP Generator" />
    {$HeadMetaTags}
    <title>{$Page->GetCaption()}</title>
    <!--[if lte IE 6]>
    <style>
        th {ldelim} behavior: url('iepngfix.htc'); {rdelim}
        div.site_header_pad
        {ldelim}
            margin: 0px;
            display: none;
        {rdelim}
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

    {$Page->GetCustomPageHeader()}

    <script type="text/javascript">
        try
        {ldelim}
        {$Page->GetCustomClientScript()}
        {rdelim}
        catch(error)
        {ldelim}
        {rdelim}
    </script>

    <script type="text/javascript">
        $(document).ready(function()
        {ldelim}
        try
        {ldelim}
        {$Page->GetOnPageLoadedClientScript()}
        {rdelim}
        catch(error)
        {ldelim}
        {rdelim}
        {rdelim}
        );
    </script>

	<script type="text/javascript">
	   $(document).ready(function(){ldelim}
	           $("a[rel=zoom]").lightbox();
	       {rdelim});
	   $(document).ready(function(){ldelim}
            $('span.more_hint').each(function(i)
                {ldelim}
                    $(this).qtip(
                        {ldelim}
                            container:('tip_' + i),
                            content:($(this).children('div.box_hidden').html()),
                            position:'center'
                        {rdelim}
                    );
	      {rdelim});
	   {rdelim});

    sideBarHidden = GetCookie('sideBarHidden') == 'true';

    function ApplySideBarPosition()
    {ldelim}
        if (sideBarHidden)
            $('#right_side_bar').hide();
    {rdelim}

    function ToogleSideBar()
    {ldelim}
        if (sideBarHidden)
            $('#right_side_bar').show('normal');
        else
            $('#right_side_bar').hide('normal');
        sideBarHidden = !sideBarHidden;
        SetCookie('sideBarHidden', sideBarHidden ? 'true' : 'false');
    {rdelim}

    $(document).ready(function()
    {ldelim}

        $('.hinted_header').each(function(i)
        {ldelim}
            if ($(this).children('div.box_hidden_header').html())
            $(this).qtip(
                {ldelim}
                    container:  ('header_tip_' + i),
                    content:($(this).children('div.box_hidden_header').html()),
                    position:'center',
                    tip_class: 'qtip-wrapper-header'
                {rdelim});

        {rdelim});

    {rdelim});
	</script>
</head>
{$ContentBlock}
{$DebugFooter}
</html>