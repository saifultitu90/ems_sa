<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI = & get_instance();
$action_data=array();
if(isset($CI->permissions['add'])&&($CI->permissions['add']==1))
{
    $action_data["action_new"]=base_url($CI->controller_url."/index/add");
}
if(isset($CI->permissions['edit'])&&($CI->permissions['edit']==1))
{
    $action_data["action_edit"]=base_url($CI->controller_url."/index/edit");
}
if(isset($CI->permissions['edit'])&&($CI->permissions['edit']==1))
{
    $action_data["action_details"]=base_url($CI->controller_url."/index/details");
}
$CI->load->view("action_buttons",$action_data);
?>

<div class="row widget">
    <div class="widget-header">
        <div class="title">
            <?php echo $title; ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="col-xs-12" id="system_jqx_container">

    </div>
</div>
<div class="clearfix"></div>
<script type="text/javascript">
    $(document).ready(function ()
    {
        turn_off_triggers();
        var url = "<?php echo base_url($CI->controller_url.'/index/get_items');?>";
        var source =
        {

            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'purpose', type: 'string' },
                { name: 'date_di', type: 'string' },
                { name: 'status_forward', type: 'string' },
                { name: 'status_complete', type: 'string' }
            ],
            id: 'id',
            url: url
        };
        var dataAdapter = new $.jqx.dataAdapter(source);
        // create jqxgrid.
        $("#system_jqx_container").jqxGrid(
            {
                width: '100%',
                source: dataAdapter,
                pageable: true,
                filterable: true,
                sortable: true,
                showfilterrow: true,
                columnsresize: true,
                pagesize:50,
                pagesizeoptions: ['20', '50', '100', '200','300','500'],
                selectionmode: 'singlerow',
                altrows: true,
                autoheight: true,
                columns: [
                    { text: '<?php echo $CI->lang->line('LABEL_PURPOSE'); ?>', dataField: 'purpose'},
                    { text: '<?php echo $CI->lang->line('LABEL_DATE_MEETING'); ?>', dataField: 'date_di'},
                    { text: '<?php echo $CI->lang->line('STATUS_FORWARD'); ?>', dataField: 'status_forward',filtertype: 'list',width:'150',cellsalign: 'right'},
                    { text: '<?php echo $CI->lang->line('STATUS_COMPLETE'); ?>', dataField: 'status_complete',filtertype: 'list',width:'150',cellsalign: 'right'}
                ]
            });
    });
</script>