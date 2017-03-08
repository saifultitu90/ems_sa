<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI = & get_instance();
$action_data=array();
$action_data["action_back"]=base_url($CI->controller_url);
if(!($item['status_forward']==$this->config->item('system_status_forward')))
{
    $action_data["action_save"]='#save_form';
    $action_data["action_clear"]='#save_form';
}
$CI->load->view("action_buttons",$action_data);
?>
<form class="form_valid" id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save');?>" method="post">
    <input type="hidden" id="id" name="id" value="<?php echo $item['id']; ?>" />
    <input type="hidden" id="system_save_new_status" name="system_save_new_status" value="0" />
    <div class="row widget">
        <div class="widget-header">
            <div class="title">
                <?php echo $title; ?>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle external" data-toggle="collapse" data-target="#collapse1" href="#">
                            Agenda Information</a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse in">

                    <?php if($item['status_forward']==$this->config->item('system_status_forward')){?>
                        <div class="row show-grid">
                            <div class="col-xs-4">
                                <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_DATE_AGENDA');?></label>
                            </div>
                            <div class="col-sm-4 col-xs-8">
                                <?php echo System_helper::display_date($item['date']);?>
                            </div>
                        </div>
                        <div class="row show-grid">
                            <div class="col-xs-4">
                                <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_PURPOSE');?></label>
                            </div>
                            <div class="col-sm-4 col-xs-8">
                                <?php echo $item['purpose'];?>
                            </div>
                        </div>
                    <?php }else{?>
                        <div class="row show-grid">
                            <div class="col-xs-4">
                                <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_DATE_AGENDA');?><span style="color:#FF0000">*</span></label>
                            </div>
                            <div class="col-sm-4 col-xs-8">
                                <input type="text" name="item[date]" id="date_stock_in" class="form-control datepicker" value="<?php echo System_helper::display_date($item['date']);?>"/>
                            </div>
                        </div>
                        <div class="row show-grid">
                            <div class="col-xs-4">
                                <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_PURPOSE');?><span style="color:#FF0000">*</span></label>
                            </div>
                            <div class="col-sm-4 col-xs-8">
                                <textarea class="form-control" name="item[purpose]"><?php echo $item['purpose'];?></textarea>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
</form>
<script type="text/javascript">
    jQuery(document).ready(function()
    {
        turn_off_triggers();
        $(".datepicker").datepicker({dateFormat : display_date_format});
    });
</script>
