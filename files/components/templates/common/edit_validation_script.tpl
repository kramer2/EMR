<script type="text/javascript">


    function CustomValidate(fieldValues, errorInfo)
    {ldelim}
        {$ClientValidationScript}
        return true;
    {rdelim}
   
    var adaptersCreated = false;
    
    var ControlsToValidate;
    var ArrayOnInvalidActions;
    var ArrayOnValidActions;
    var ControlValidators;
    
    function CreateAdaptersIfNeed()
    {ldelim}
        if (!adaptersCreated)
        {ldelim}
            adaptersCreated = true;
        ControlsToValidate =
        [
{foreach item=column from=$Columns name=ControlsAdapters}
            {$column->GetCreateJSControlAdapter()}{if not $smarty.foreach.ControlsAdapters.last},{/if}

{/foreach}
        ];

        ArrayOnInvalidActions =
        [
{foreach item=column from=$Columns name=OnInvalidActions}
            function (controlAdapter) {ldelim} controlAdapter.SetBackgroundColor('#FFAAAA'); {rdelim}{if not $smarty.foreach.OnInvalidActions.last},{/if}

{/foreach}
        ];

        ArrayOnValidActions =
        [
{foreach item=column from=$Columns name=OnValidActions}
            function (controlAdapter) {ldelim} controlAdapter.ResetBackgroundColor(); {rdelim}{if not $smarty.foreach.OnValidActions.last},{/if}

{/foreach}
        ];

        ControlValidators =
        [
{foreach item=column from=$Columns name=Controls}
            [
{foreach item=validator from=$column->GetValidators() name=Validators}
                {$validator->GetCreateJSValidator()}{if not $smarty.foreach.Validators.last},{/if}

{/foreach}
            ]{if not $smarty.foreach.Controls.last},{/if}

{/foreach}
        ];
        {rdelim}
    {rdelim}

    function ValidateControls()
    {ldelim}
        CreateAdaptersIfNeed();
        var errorMessages = [];
        var isAllControlsValid = true;
        var fieldValues = new Array();

        for(var controlIndex = 0; controlIndex < ControlsToValidate.length; controlIndex++)
        {ldelim}
            if (ControlsToValidate[controlIndex].IsSetToDefault() || ControlsToValidate[controlIndex].IsSetToNull())
            {ldelim}
                fieldValues[ControlsToValidate[controlIndex].GetFieldName()] = '';
            {rdelim}
            else
            {ldelim}
                fieldValues[ControlsToValidate[controlIndex].GetFieldName()] =
                  ControlsToValidate[controlIndex].GetValue();
            {rdelim}
        {rdelim}
        var errorInfo = new ErrorInfo();

        try
        {ldelim}
            if (!CustomValidate(fieldValues, errorInfo))
            {ldelim}
                errorMessages.push(errorInfo.GetMessage());
                isAllControlsValid = false;
            {rdelim}
        {rdelim}
        catch(error) {ldelim} {rdelim}

        for(var controlIndex = 0; controlIndex < ControlsToValidate.length; controlIndex++)
        {ldelim}
            var isControlValid = true;
            if (ControlsToValidate[controlIndex].IsSetToDefault() || ControlsToValidate[controlIndex].IsSetToNull())
                isControlValid = true;
            else
            {ldelim}
                for(var validatorIndex = 0; validatorIndex < ControlValidators[controlIndex].length; validatorIndex++)
                {ldelim}
                    if(!ControlValidators[controlIndex][validatorIndex].Validate(ControlsToValidate[controlIndex].GetValue()))
                    {ldelim}
                        errorMessages.push(ControlValidators[controlIndex][validatorIndex].GetErrorMessage());
                        isControlValid = false;
                    {rdelim}
                {rdelim}
            {rdelim}
            if (!isControlValid)
            {ldelim}
                isAllControlsValid = false;
                ArrayOnInvalidActions[controlIndex](ControlsToValidate[controlIndex]);
            {rdelim}
            else
                ArrayOnValidActions[controlIndex](ControlsToValidate[controlIndex]);
        {rdelim}
        if (!isAllControlsValid)
        {ldelim}
            document.getElementById('errorMessagesRow').style.display = '';
            document.getElementById('errorMessages').innerHTML = CreateListByArray(errorMessages);
        {rdelim}
        else
            document.getElementById('errorMessagesRow').style.display = 'none';
        return isAllControlsValid;
    {rdelim}
</script>