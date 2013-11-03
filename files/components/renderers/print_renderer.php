<?php

require_once 'renderer.php';

class PrintRenderer extends Renderer
{
    function RenderPageNavigator($PageNavigator)
    { }

    function RenderDetailPageEdit($DetailPage)
    {
        $Grid = $this->Render($DetailPage->GetGrid());
        $this->DisplayTemplate('print/page.tpl',
            array('Page' => $DetailPage),
            array('Grid' => $Grid));
    }

    function RenderPage($Page)
    {
        $this->SetHTTPContentTypeByPage($Page);
        $Page->BeforePageRender->Fire(array(&$Page));

        $Grid = $this->Render($Page->GetGrid());
        $this->DisplayTemplate('print/page.tpl',
            array('Page' => $Page),
            array('Grid' => $Grid));
    }

    function RenderGrid(Grid $Grid)
    {
        $Rows = array();
        $Grid->GetDataset()->Open();
        while($Grid->GetDataset()->Next())
        {
            $Row = array();
            foreach($Grid->GetPrintColumns() as $Column)
                $Row[] = $this->Render($Column);
            $Rows[] = $Row;
        }

        $this->DisplayTemplate('print/grid.tpl',
            array(
                'Grid' => $Grid
                ),
            array(
                'Columns' => $Grid->GetPrintColumns(),
                'Rows' => $Rows
            ));
    }
    
    protected function ChildPagesAvailable() 
    { 
        return false; 
    }
}
?>