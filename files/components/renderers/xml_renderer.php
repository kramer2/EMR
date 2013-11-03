<?php

require_once 'renderer.php';
require_once 'components/utils/file_utils.php';

class XmlRenderer extends Renderer
{
    function RenderPageNavigator($PageNavigator)
    { }

    function RenderDetailPageEdit($DetailPage)
    {
        $this->RenderPage($DetailPage);
    }
    
    function RenderPage($Page)
    {
        header("Content-type: text/xml");
        $this->DisableCacheControl();
        header("Content-Disposition: attachment;Filename=" .
            Path::ReplaceFileNameIllegalCharacters($Page->GetCaption() . ".xml"));
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Pragma: public");
        
        $Grid = $this->Render($Page->GetGrid());
        $this->DisplayTemplate('export/xml_page.tpl',
            array('Page' => $Page),
            array('Grid' => $Grid));
    }
    
    function RenderCustomViewColumn($column)
    {
        $this->result = $column->GetValue();
    }
    
    private function PrepareColumnCaptionForXml($caption)
    {
        return htmlspecialchars(str_replace(' ', '', $caption));
    }
    
    function RenderGrid(Grid $Grid)
    {
        $Rows = array();
        $Grid->GetDataset()->Open();
        while($Grid->GetDataset()->Next())
        {
            $Row = array();
            foreach($Grid->GetExportColumns() as $Column)
                $Row[$this->PrepareColumnCaptionForXml($Column->GetCaption())] = $this->Render($Column);
            $Rows[] = $Row;
        }
        
        $this->DisplayTemplate('export/xml_grid.tpl',
            array(
                    'Grid' => $Grid
                    ),
                array(
                    'Rows' => $Rows,
                    'TableName' => $Grid->GetPage()->GetCaption()
                    ));
    }
    
    protected function HttpHandlersAvailable() 
    { 
        return false; 
    }
    
    protected function HtmlMarkupAvailable() 
    { 
        return false;
    }
}
?>