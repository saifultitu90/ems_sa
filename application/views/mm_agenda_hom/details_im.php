<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI = & get_instance();
$action_data=array();
$action_data["action_back"]=base_url($CI->controller_url);
$action_data["action_save"]='#save_form';
$action_data["action_clear"]='#save_form';
$CI->load->view("action_buttons",$action_data);
?>
<form class="form_valid" id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save_sales_im');?>" method="post">
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
                            Create Agenda</a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse in">
                    <div class="row show-grid">

                        <div class="col-xs-4">
                            <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_DATE_AGENDA');?><span>:</span></label>
                        </div>
                        <div class="col-xs-4">
                            <label class="control-label"><?php echo System_helper::display_date($item['date']);?></label>
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
                                    <?php foreach($sales_items as $sales_item){?>
                                        <tbody>
                                        <tr>
                                            <td><?php echo $sales_item['division_name'];?></td>
                                            <input type="hidden" name="sales_items[<?php echo $sales_item['division_id']?>][division_id]" value="<?php echo $sales_item['division_id'];?>"></td>
                                            <td><?php echo $sales_item['budget_total'];?></td>
                                            <td><?php echo $sales_item['achievement_total'];?></td>
                                            <td><?php echo $sales_item['target_current_month'];?></td>
                                            <td><?php echo $sales_item['achievement_current_month'];?></td>
                                            <td><?php echo $sales_item['target_next_month'];?></td>
                                            <td><?php echo $sales_item['target_next_month_im'];?></td>
                                            <td><?php echo $sales_item['remarks_before_meeting'];?></td>
                                            <td><textarea rows="3" cols="10" class="form-control" name="sales_items[<?php echo $sales_item['division_id']?>][remarks_in_meeting]"><?php echo $sales_item['remarks_in_meeting'];?></textarea></td>
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
                                    <?php foreach($collection_items as $collection_item){?>
                                        <tbody>
                                        <tr>
                                            <td><?php echo $collection_item['division_name'];?></td>
                                            <input type="hidden" name="collection_items[<?php echo $collection_item['division_id'];?>][division_id]" value="<?php echo $collection_item['division_id'];?>">
                                            <td><?php echo $collection_item['budget_total'];?></td>
                                            <td><?php echo $collection_item['achievement_total'];?></td>
                                            <td><?php echo $collection_item['target_current_month'];?></td>
                                            <td><?php echo $collection_item['achievement_current_month'];?></td>
                                            <td><?php echo $collection_item['target_next_month'];?></td>
                                            <td><?php echo $collection_item['target_next_month_im'];?></td>
                                            <td><?php echo $collection_item['remarks_before_meeting'];?></td>
                                            <td><textarea rows="3" cols="20" class="form-control" name="collection_items[<?php echo $collection_item['division_id'];?>][remarks_in_meeting]"><?php echo $collection_item['remarks_in_meeting'];?></textarea></td>
                                        </tr>
                                        </tbody>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget-header">
                <div class="title">
                    Complete
                </div>
                <div class="clearfix"></div>
            </div>
            <div style="" class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_MEETING_COMPLETE');?></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <select id="status_complete" name="status_complete" class="form-control">
                        <option value=""><?php echo $CI->lang->line('SELECT');?></option>
                        <option value="<?php echo $CI->config->item('system_status_complete');?>"><?php echo $CI->config->item('system_status_complete');?></option>
                    </select>
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
    });
</script>
