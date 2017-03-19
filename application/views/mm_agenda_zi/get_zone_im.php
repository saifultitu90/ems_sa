<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI = & get_instance();
?>
<form class="form_valid" id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save_im');?>" method="post">
<input type="hidden" id="agenda_id" name="agenda_id" value="<?php echo $agenda_id; ?>" />
<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a class="accordion-toggle external" data-toggle="collapse" data-target="#collapse1" href="#">
                Agenda</a>
        </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse in">
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_DATE_AGENDA');?><span style="color:#FF0000">*</span></label>
            </div>
            <div class="col-sm-4 col-xs-8">
                <label class="control-label"><?php echo System_helper::display_date($item['date']);?></label>
                <!--                    <input type="text" name="item[date]" id="date_stock_in" class="form-control datepicker" value="--><?php //echo System_helper::display_date($item['date']);?><!--"/>-->
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
                            <th>Total Variance</th>
                            <th>Last Month Target</th>
                            <th>Last Month Achievement</th>
                            <th>Last Month Variance</th>
                            <th>Current Month Target</th>
                            <th>Current Month Achievement</th>
                            <th>Current Month Variance</th>
                            <th>Next Month Target(To DI)</th>
                            <th>Next Month Target(For TI)</th>
                            <th>Next Month Target In Meeting</th>
                            <th>Remarks Before Meeting</th>
                            <th>Remarks IN Meeting</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($s_items_di as $s_item_di){?>
                            <tr>
                                <td><b><?php echo $s_item_di['zone_name'];?></b></td>
                                <input type="hidden" name="sales_zone_id" value="<?php echo $s_item_di['zone_id'];?>"></td>
                                <td><b><?php echo $s_item_di['budget_total'];?></b></td>
                                <td><b><?php echo $s_item_di['achievement_total'];?></b></td>
                                <td><b><?php echo ($s_item_di['budget_total']-$s_item_di['achievement_total'])?></b></td>
                                <td><b><?php echo $s_item_di['target_last_month'];?></b></td>
                                <td><b><?php echo $s_item_di['achievement_last_month'];?></b></td>
                                <td><b><?php echo ($s_item_di['target_last_month']-$s_item_di['achievement_last_month'])?></b></td>
                                <td><b><?php echo $s_item_di['target_current_month'];?></b></td>
                                <td><b><?php echo $s_item_di['achievement_current_month'];?></b></td>
                                <td><b><?php echo ($s_item_di['target_current_month']-$s_item_di['achievement_current_month'])?></b></td>
                                <td><b><?php echo $s_item_di['target_next_month'];?></b></td>
                                <td><b><?php echo $s_item_di['target_next_month'];?></b></td>
                                <td><?php echo $s_item_di['target_next_month_im'];?></td>
                                <td><b><?php echo $s_item_di['remarks_before_meeting'];?></b></td>
                                <td><?php echo $s_item_di['remarks_in_meeting'];?></td>
                            </tr>
                        <?php } ?>
                        <?php foreach($sales_items as $s_item){?>
                            <tr>
                                <td><?php echo $s_item['territory_name'];?></td>
                                <input type="hidden" name="sitems[<?php echo $s_item['territory_id']?>][territory_id]" value="<?php echo $s_item['territory_id'];?>"></td>
                                <td><?php echo $s_item['budget_total'];?></td>
                                <td><?php echo $s_item['achievement_total'];?></td>
                                <td><?php echo ($s_item['budget_total']-$s_item['achievement_total'])?></td>
                                <td><?php echo $s_item['target_last_month'];?></td>
                                <td><?php echo $s_item['achievement_last_month'];?></td>
                                <td><?php echo ($s_item['target_last_month']-$s_item['achievement_last_month'])?></td>
                                <td><?php echo $s_item['target_current_month'];?></td>
                                <td><?php echo $s_item['achievement_current_month'];?></td>
                                <td><?php echo ($s_item['target_current_month']-$s_item['achievement_current_month'])?></td>
                                <td><?php echo $s_item['target_next_month'];?></td>
                                <td><?php echo $s_item['target_next_month_for_ti'];?></td>
                                <td><?php echo $s_item['target_next_month_im'];?></td>
                                <td><?php echo $s_item['remarks_before_meeting'];?></td>
                                <td><textarea class="form-control" name="sitems[<?php echo $s_item['territory_id']?>][remarks_in_meeting]"><?php echo $s_item['remarks_in_meeting'];?></textarea></td>
                            </tr>
                        <?php } ?>
                        </tbody>
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
                            <th>Total Variance</th>
                            <th>Last Month Target</th>
                            <th>Last Month Achievement</th>
                            <th>Last Month Variance</th>
                            <th>Current Month Target</th>
                            <th>Current Month Achievement</th>
                            <th>Current Month Variance</th>
                            <th>Next Month Target(To DI)</th>
                            <th>Next Month Target(For TI)</th>
                            <th>Next Month Target In Meeting</th>
                            <th>Remarks Before Meeting</th>
                            <th>Remarks IN Meeting</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($c_items_di as $c_item_di){?>
                            <tr>
                                <td><b><?php echo $c_item_di['zone_name'];?></b></td>
                                <input type="hidden" name="collection_division_id" value="<?php echo $c_item_di['division_id'];?>">
                                <td><b><?php echo $c_item_di['budget_total'];?></b></td>
                                <td><b><?php echo $c_item_di['achievement_total'];?></b></td>
                                <td><b><?php echo ($c_item_di['budget_total']-$c_item_di['achievement_total'])?></b></td>
                                <td><b><?php echo $c_item_di['target_last_month'];?></b></td>
                                <td><b><?php echo $c_item_di['achievement_last_month'];?></b></td>
                                <td><b><?php echo ($c_item_di['target_last_month']-$c_item_di['achievement_last_month'])?></b></td>
                                <td><b><?php echo $c_item_di['target_current_month'];?></b></td>
                                <td><b><?php echo $c_item_di['achievement_current_month'];?></b></td>
                                <td><b><?php echo ($c_item_di['target_current_month']-$c_item_di['achievement_current_month'])?></b></td>
                                <td><b><?php echo $c_item_di['target_next_month'];?></b></td>
                                <td><b><?php echo $c_item_di['target_next_month'];?></b></td>
                                <td><?php echo $c_item_di['target_next_month_im'];?></td>
                                <td><b><?php echo $c_item_di['remarks_before_meeting'];?></b></td>
                                <td><?php echo $c_item_di['remarks_in_meeting'];?></td>
                            </tr>
                        <?php } ?>
                        <?php foreach($collection_items as $c_item){?>
                            <tr>
                                <td><?php echo $c_item['territory_name'];?></td>
                                <input type="hidden" name="citems[<?php echo $c_item['territory_id']?>][territory_id]" value="<?php echo $c_item['territory_id'];?>"></td>
                                <td><?php echo $c_item['budget_total'];?></td>
                                <td><?php echo $c_item['achievement_total'];?></td>
                                <td><?php echo ($c_item['budget_total']-$c_item['achievement_total'])?></td>
                                <td><?php echo $c_item['target_last_month'];?></td>
                                <td><?php echo $c_item['achievement_last_month'];?></td>
                                <td><?php echo ($c_item['target_last_month']-$c_item['achievement_last_month'])?></td>
                                <td><?php echo $c_item['target_current_month'];?></td>
                                <td><?php echo $c_item['achievement_current_month'];?></td>
                                <td><?php echo ($c_item['target_current_month']-$c_item['achievement_current_month'])?></td>
                                <td><?php echo $c_item['target_next_month'];?></td>
                                <td><?php echo $c_item['target_next_month_for_ti'];?></td>
                                <td><?php echo $c_item['target_next_month_im'];?></td>
                                <td><?php echo $c_item['remarks_before_meeting'];?></td>
                                <td><textarea class="form-control" name="citems[<?php echo $c_item['territory_id']?>][remarks_in_meeting]"><?php echo $c_item['remarks_in_meeting'];?></textarea></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="widget-header">
    <div class="title">
        Complete Agenda
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
</form>