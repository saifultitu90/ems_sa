<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI = & get_instance();
$action_data=array();
$action_data["action_back"]=base_url($CI->controller_url);
$action_data["action_clear"]='#save_form';
if(isset($CI->permissions['edit'])&&($CI->permissions['edit']==1))
{
    $action_data["action_meeting_complete"]=base_url($CI->controller_url."/index/meeting_complete/".$agenda_id);
}
$CI->load->view("action_buttons",$action_data);
?>
<form class="form_valid" id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save');?>" method="post">
    <input type="hidden" id="id" name="id" value="<?php echo $item['id']; ?>" />
    <input type="hidden" id="agenda_id" name="agenda_id" value="<?php echo $agenda_id; ?>" />
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
                            Create Agenda</a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse in">
                    <div class="row show-grid">

                        <div class="col-xs-4">
                            <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_DATE_AGENDA');?><span>:</span></label>
                        </div>
                        <div class="col-xs-4">
                            <label class="control-label"><?php echo System_helper::display_date($item['date_hom_agenda']);?></label>
                        </div>

                    </div>
                    <div class="row show-grid">
                        <div class="col-xs-4">
                            <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_PURPOSE');?><span>:</span></label>
                        </div>
                        <div class="col-xs-4">
                            <label class="control-label"><?php echo $item['purpose'];?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="external" data-toggle="collapse" data-target="#collapse2" href="#">
                            Sales</a>
                    </h4>
                </div>
                <div id="collapse2" class="panel-collapse collapse">
                    <div class="row show-grid">
                        <div class="col-xs-12" id="system_jqx_containers">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Total Budget</th>
                                        <th>Total Achievement</th>
                                        <th>Current Month Target</th>
                                        <th>Current Month Achievement</th>
                                        <th>Next Month Target Before Meeting</th>
                                        <th>Next Month Target In Meeting</th>
                                        <th>Remarks Before Meeting</th>
                                        <th>Remarks IN Meeting</th>
                                    </tr>
                                    </thead>
                                    <?php foreach($s_items as $s_item){?>
                                        <tbody>
                                        <tr>
                                            <td><?php echo $s_item['division_name'];?></td>
                                            <input type="hidden" name="sales_division_id[]" value="<?php echo $s_item['division_id'];?>"></td>
                                            <td><?php echo $s_item['total_budget'];?></td>
                                            <td><?php echo $s_item['total_achievement'];?></td>
                                            <td><?php echo $s_item['current_month_target'];?></td>
                                            <td><?php echo $s_item['current_month_achievement'];?></td>
                                            <td><?php echo $s_item['next_month_target'];?></td>
                                            <td><?php echo $s_item['next_month_target_im'];?></td>
                                            <td><?php echo $s_item['remarks_before_meeting'];?></td>
                                            <td><?php echo $s_item['remarks_in_meeting'];?></td>
                                        </tr>
                                        </tbody>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="external" data-toggle="collapse" data-target="#collapse3" href="#">
                            Collection</a>
                    </h4>
                </div>
                <div id="collapse3" class="panel-collapse collapse">
                    <div class="row show-grid">
                        <div class="col-xs-12" id="system_jqx_containers">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Total Budget</th>
                                        <th>Total Achievement</th>
                                        <th>Current Month Target</th>
                                        <th>Current Month Achievement</th>
                                        <th>Next Month Target Before Meeting</th>
                                        <th>Next Month Target In Meeting</th>
                                        <th>Remarks Before Meeting</th>
                                        <th>Remarks IN Meeting</th>
                                    </tr>
                                    </thead>
                                    <?php foreach($c_items as $c_item){?>
                                        <tbody>
                                        <tr>
                                            <td><?php echo $c_item['division_name'];?></td>
                                            <input type="hidden" name="collection_division_id[]" value="<?php echo $c_item['division_id'];?>">
                                            <td><?php echo $c_item['total_budget'];?></td>
                                            <td><?php echo $c_item['total_achievement'];?></td>
                                            <td><?php echo $c_item['current_month_target'];?></td>
                                            <td><?php echo $c_item['current_month_achievement'];?></td>
                                            <td><?php echo $c_item['next_month_target'];?></td>
                                            <td><?php echo $c_item['next_month_target_im'];?></td>
                                            <td><?php echo $c_item['remarks_before_meeting'];?></td>
                                            <td><?php echo $c_item['remarks_in_meeting'];?></td>
                                        </tr>
                                        </tbody>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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
        $(".dob").datepicker({dateFormat : display_date_format,changeMonth: true,changeYear: true,yearRange: "-100:+0"});
        $(":file").filestyle({input: false,buttonText: "<?php echo $CI->lang->line('UPLOAD');?>", buttonName: "btn-danger"});

    });
</script>
