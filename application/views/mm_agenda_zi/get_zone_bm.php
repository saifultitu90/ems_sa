<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI = & get_instance();
?>
<form class="form_valid" id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save');?>" method="post">
<input type="hidden" id="agenda_id" name="agenda_id" value="<?php echo $agenda_id; ?>" />
<input type="hidden" id="agenda_id" name="division_id" value="<?php echo $division_id; ?>" />
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
                <input type="text" name="item[date]" id="date_stock_in" class="form-control datepicker" value="<?php echo System_helper::display_date($item['date']);?>"/>
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
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_DATE_MEETING');?><span>:</span></label>
            </div>
            <div class="col-xs-4">
                <label class="control-label"><?php echo System_helper::display_date($item['date_di']);?></label>
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
                            <th>Next Month Target</th>
                            <?php if(($di_meeting_status['status_complete']==$this->config->item('system_status_complete'))){?>
                                <th>Next Month Target For TI</th>
                            <?php } ?>
                            <th>Remarks Before Meeting</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($s_items_di as $s_item_di){?>
                            <tr>
                                <td><b><?php echo $s_item_di['zone_name'];?></b></td>
                                <input type="hidden" name="sales_zone_id" value="<?php echo $s_item_di['zone_id'];?>"></td>
                                <td><b><?php echo $s_item_di['budget_total'];?></b></td>
                                <td><b><?php echo $s_item_di['achievement_total'];?></b></td>
                                <td><b><?php echo ($s_item_di['budget_total']-$s_item_di['achievement_total']);?></b></td>
                                <td><b><?php echo $s_item_di['target_last_month'];?></b></td>
                                <td><b><?php echo $s_item_di['achievement_last_month'];?></b></td>
                                <td><b><?php echo ($s_item_di['target_last_month']-$s_item_di['achievement_last_month']);?></b></td>
                                <td><b><?php echo $s_item_di['target_current_month'];?></b></td>
                                <td><b><?php echo $s_item_di['achievement_current_month'];?></b></td>
                                <td><b><?php echo ($s_item_di['target_current_month']-$s_item_di['achievement_current_month']);?></b></td>
                                <?php if(($di_meeting_status['status_complete']==$this->config->item('system_status_complete'))){?>
                                    <td><b><?php echo $s_item_di['target_next_month_im_by_di'];?></b></td>
                                <?php }else{?>
                                    <td><b><?php echo $s_item_di['target_next_month_for_zi'].' <br>'.'(Before Meeting)';?></b></td>
                                <?php } ?>
                                <?php if(($di_meeting_status['status_complete']==$this->config->item('system_status_complete'))){?>
                                    <td><b><?php echo $s_item_di['target_next_month_im_by_di'];?></b></td>
                                <?php } ?>
                                <td><b><?php echo $s_item_di['remarks_before_meeting'];?></b></td>
                            </tr>
                        <?php } ?>
                        <?php if(!($di_meeting_status['status_complete']==$this->config->item('system_status_complete'))){?>
                            <?php foreach($s_items_di as $s_item_di){?>
                                <tr>
                                    <td><b><?php echo $s_item_di['zone_name'];?></b></td>
                                    <input type="hidden" name="sales_zone_id" value="<?php echo $s_item_di['zone_id'];?>"></td>
                                    <td><b><?php echo $s_item_di['budget_total'];?></b></td>
                                    <td><b><?php echo $s_item_di['achievement_total'];?></b></td>
                                    <td><b><?php echo ($s_item_di['budget_total']-$s_item_di['achievement_total']);?></b></td>
                                    <td><b><?php echo $s_item_di['target_last_month'];?></b></td>
                                    <td><b><?php echo $s_item_di['achievement_last_month'];?></b></td>
                                    <td><b><?php echo ($s_item_di['target_last_month']-$s_item_di['achievement_last_month']);?></b></td>
                                    <td><b><?php echo $s_item_di['target_current_month'];?></b></td>
                                    <td><b><?php echo $s_item_di['achievement_current_month'];?></b></td>
                                    <td><b><?php echo ($s_item_di['target_current_month']-$s_item_di['achievement_current_month']);?></b></td>
                                    <td><b><?php echo $s_item_di['target_next_month_im_by_di'].' <br>'.'(In Meeting)';?></b></td>
                                    <?php if(($di_meeting_status['status_complete']==$this->config->item('system_status_complete'))){?>
                                        <td><b><?php echo $s_item_di['target_next_month_im_by_di'];?></b></td>
                                    <?php } ?>
                                    <td><b><?php echo $s_item_di['remarks_before_meeting'];?></b></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        <?php foreach($sales_items as $sales_item){?>
                            <tr>
                                <?php if(($di_meeting_status['status_complete']==$this->config->item('system_status_complete'))){?>
                                    <td><?php echo $sales_item['territory_name'];?></td>
                                    <input type="hidden" name="s_items[<?php echo $sales_item['territory_id'];?>][territory_id]" value="<?php echo $sales_item['territory_id'];?>"></td>

                                    <!--                                        <input type="hidden" name="sales_territory_id[]" value="--><?php //echo $sales_item['territory_id'];?><!--"></td>-->
                                    <td><input class="form-control budget_total float_type_positive" type="text" name="s_items[<?php echo $sales_item['territory_id'];?>][budget_total]" value="<?php echo $sales_item['budget_total'];?>">
                                    <td><input class="form-control achievement_total float_type_positive" type="text" name="s_items[<?php echo $sales_item['territory_id'];?>][achievement_total]" value="<?php echo $sales_item['achievement_total'];?>"></td>
                                    <td><input type="text" class="form-control variance_total" value="<?php echo ($sales_item['budget_total']-$sales_item['achievement_total'])?>" disabled></td>
                                    <td><input class="form-control target_last_month float_type_positive" type="text" name="s_items[<?php echo $sales_item['territory_id'];?>][target_last_month]" value="<?php echo $sales_item['target_last_month'];?>"></td>
                                    <td><input class="form-control achievement_last_month float_type_positive" type="text" name="s_items[<?php echo $sales_item['territory_id'];?>][achievement_last_month]" value="<?php echo $sales_item['achievement_last_month'];?>"></td>
                                    <td><input type="text" class="form-control variance_last_month" value="<?php echo ($sales_item['target_last_month']-$sales_item['achievement_last_month'])?>" disabled></td>
                                    <td><input class="form-control target_current_month float_type_positive" type="text" name="s_items[<?php echo $sales_item['territory_id'];?>][target_current_month]" value="<?php echo $sales_item['target_current_month'];?>"></td>
                                    <td><input class="form-control achievement_current_month float_type_positive" type="text" name="s_items[<?php echo $sales_item['territory_id'];?>][achievement_current_month]" value="<?php echo $sales_item['achievement_current_month'];?>"></td>
                                    <td><input type="text" class="form-control variance_current_month" value="<?php echo ($sales_item['target_current_month']-$sales_item['achievement_current_month'])?>" disabled></td>
                                    <td><input type="text" class="form-control" value="<?php echo $sales_item['target_next_month'];?>" disabled></td>
                                    <td><input class="form-control float_type_positive" type="text" name="s_items[<?php echo $sales_item['territory_id'];?>][target_next_month_for_ti]" value="<?php echo $sales_item['target_next_month_for_ti'];?>"></td>
                                    <td><textarea class="form-control" name="s_items[<?php echo $sales_item['territory_id']?>][remarks_before_meeting]"><?php echo $sales_item['remarks_before_meeting'];?></textarea></td>
                                <?php } else{?>
                                    <td><?php echo $sales_item['territory_name'];?></td>
                                    <input type="hidden" name="s_items[<?php echo $sales_item['territory_id'];?>][territory_id]" value="<?php echo $sales_item['territory_id'];?>"></td>
                                    <td><input class="form-control budget_total float_type_positive" type="text" name="s_items[<?php echo $sales_item['territory_id'];?>][budget_total]" value="<?php echo $sales_item['budget_total'];?>">
                                    <td><input class="form-control achievement_total float_type_positive" type="text" name="s_items[<?php echo $sales_item['territory_id'];?>][achievement_total]" value="<?php echo $sales_item['achievement_total'];?>"></td>
                                    <td><input type="text" class="form-control variance_total" value="<?php echo ($sales_item['budget_total']-$sales_item['achievement_total'])?>" disabled></td>
                                    <td><input class="form-control target_last_month float_type_positive" type="text" name="s_items[<?php echo $sales_item['territory_id'];?>][target_last_month]" value="<?php echo $sales_item['target_last_month'];?>"></td>
                                    <td><input class="form-control achievement_last_month float_type_positive" type="text" name="s_items[<?php echo $sales_item['territory_id'];?>][achievement_last_month]" value="<?php echo $sales_item['achievement_last_month'];?>"></td>
                                    <td><input type="text" class="form-control variance_last_month" value="<?php echo ($sales_item['target_last_month']-$sales_item['achievement_last_month'])?>" disabled></td>
                                    <td><input class="form-control target_current_month float_type_positive" type="text" name="s_items[<?php echo $sales_item['territory_id'];?>][target_current_month]" value="<?php echo $sales_item['target_current_month'];?>"></td>
                                    <td><input class="form-control achievement_current_month float_type_positive" type="text" name="s_items[<?php echo $sales_item['territory_id'];?>][achievement_current_month]" value="<?php echo $sales_item['achievement_current_month'];?>"></td>
                                    <td><input type="text" class="form-control variance_current_month" value="<?php echo ($sales_item['target_current_month']-$sales_item['achievement_current_month'])?>" disabled></td>
                                    <td><input class="form-control float_type_positive" type="text" name="s_items[<?php echo $sales_item['territory_id'];?>][target_next_month]" value="<?php echo $sales_item['target_next_month'];?>"></td>
                                    <td><textarea class="form-control" name="s_items[<?php echo $sales_item['territory_id']?>][remarks_before_meeting]"><?php echo $sales_item['remarks_before_meeting'];?></textarea></td>
                                <?php } ?>
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
                            <th>Next Month Target</th>
                            <?php if(($di_meeting_status['status_complete']==$this->config->item('system_status_complete'))){?>
                                <th>Next Month Target For TI</th>
                            <?php } ?>
                            <th>Remarks Before Meeting</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($c_items_di as $c_item_di){?>
                            <tr>
                                <td><b><?php echo $c_item_di['zone_name'];?></b></td>
                                <input type="hidden" name="collection_zone_id" value="<?php echo $c_item_di['zone_id'];?>">
                                <td><b><?php echo $c_item_di['budget_total'];?></b></td>
                                <td><b><?php echo $c_item_di['achievement_total'];?></b></td>
                                <td><b><?php echo ($c_item_di['budget_total']-$c_item_di['achievement_total'])?></b></td>
                                <td><b><?php echo $c_item_di['target_last_month'];?></b></td>
                                <td><b><?php echo $c_item_di['achievement_last_month'];?></b></td>
                                <td><b><?php echo ($c_item_di['target_last_month']-$c_item_di['achievement_last_month'])?></b></td>
                                <td><b><?php echo $c_item_di['target_current_month'];?></b></td>
                                <td><b><?php echo $c_item_di['achievement_current_month'];?></b></td>
                                <td><b><?php echo ($c_item_di['target_current_month']-$c_item_di['achievement_current_month'])?></b></td>
                                <?php if(($di_meeting_status['status_complete']==$this->config->item('system_status_complete'))){?>
                                    <td><b><?php echo $c_item_di['target_next_month_im_by_di'];?></b></td>
                                <?php }else{?>
                                    <td><b><?php echo $c_item_di['target_next_month_for_zi'].' <br>'.'(Before Meeting)';?></b></td>
                                <?php } ?>
                                <?php if(($di_meeting_status['status_complete']==$this->config->item('system_status_complete'))){?>
                                    <td><b><?php echo $c_item_di['target_next_month_im_by_di'];?></b></td>
                                <?php } ?>
                                <td><b><?php echo $c_item_di['remarks_before_meeting'];?></b></td>
                            </tr>
                        <?php } ?>
                        <?php if(!($di_meeting_status['status_complete']==$this->config->item('system_status_complete'))){?>
                            <?php foreach($c_items_di as $c_item_di){?>
                                <tr>
                                    <td><b><?php echo $c_item_di['zone_name'];?></b></td>
                                    <input type="hidden" name="collection_zone_id" value="<?php echo $c_item_di['zone_id'];?>">
                                    <td><b><?php echo $c_item_di['budget_total'];?></b></td>
                                    <td><b><?php echo $c_item_di['achievement_total'];?></b></td>
                                    <td><b><?php echo ($c_item_di['budget_total']-$c_item_di['achievement_total'])?></b></td>
                                    <td><b><?php echo $c_item_di['target_last_month'];?></b></td>
                                    <td><b><?php echo $c_item_di['achievement_last_month'];?></b></td>
                                    <td><b><?php echo ($c_item_di['target_last_month']-$c_item_di['achievement_last_month'])?></b></td>
                                    <td><b><?php echo $c_item_di['target_current_month'];?></b></td>
                                    <td><b><?php echo $c_item_di['achievement_current_month'];?></b></td>
                                    <td><b><?php echo ($c_item_di['target_current_month']-$c_item_di['achievement_current_month'])?></b></td>
                                    <td><b><?php echo $c_item_di['target_next_month_im_by_di'].' '.'(In Meeting)';?></b></td>
                                    <?php if(($di_meeting_status['status_complete']==$this->config->item('system_status_complete'))){?>
                                        <td><b><?php echo $c_item_di['target_next_month_im_by_di'];?></b></td>
                                    <?php } ?>
                                    <td><b><?php echo $c_item_di['remarks_before_meeting'];?></b></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        <?php foreach($collection_items as $collection_item){?>
                            <tr>
                                <?php if(($di_meeting_status['status_complete']==$this->config->item('system_status_complete'))){?>
                                    <td><?php echo $collection_item['territory_name'];?></td>
                                    <input type="hidden" name="c_items[<?php echo $collection_item['territory_id'];?>][territory_id]" value="<?php echo $collection_item['territory_id'];?>"></td>

                                    <!--                                        <input type="hidden" name="collection_territory_id[]" value="--><?php //echo $collection_item['territory_id'];?><!--"></td>-->
                                    <td><input class="form-control budget_total float_type_positive" type="text" name="c_items[<?php echo $collection_item['territory_id'];?>][budget_total]" value="<?php echo $collection_item['budget_total'];?>">
                                    <td><input class="form-control achievement_total float_type_positive" type="text" name="c_items[<?php echo $collection_item['territory_id'];?>][achievement_total]" value="<?php echo $collection_item['achievement_total'];?>"></td>
                                    <td><input type="text" class="form-control variance_total" value="<?php echo ($collection_item['budget_total']-$collection_item['achievement_total'])?>" disabled></td>
                                    <td><input class="form-control target_last_month float_type_positive" type="text" name="c_items[<?php echo $collection_item['territory_id'];?>][target_last_month]" value="<?php echo $collection_item['target_last_month'];?>"></td>
                                    <td><input class="form-control achievement_last_month float_type_positive" type="text" name="c_items[<?php echo $collection_item['territory_id'];?>][achievement_last_month]" value="<?php echo $collection_item['achievement_last_month'];?>"></td>
                                    <td><input type="text" class="form-control variance_last_month" value="<?php echo ($collection_item['target_last_month']-$collection_item['achievement_last_month'])?>" disabled></td>
                                    <td><input class="form-control target_current_month float_type_positive" type="text" name="c_items[<?php echo $collection_item['territory_id'];?>][target_current_month]" value="<?php echo $collection_item['target_current_month'];?>"></td>
                                    <td><input class="form-control achievement_current_month float_type_positive" type="text" name="c_items[<?php echo $collection_item['territory_id'];?>][achievement_current_month]" value="<?php echo $collection_item['achievement_current_month'];?>"></td>
                                    <td><input type="text" class="form-control variance_current_month" value="<?php echo ($collection_item['target_current_month']-$collection_item['achievement_current_month'])?>" disabled></td>
                                    <td><input type="text" class="form-control" value="<?php echo $collection_item['target_next_month'];?>" disabled></td>
                                    <td><input class="form-control float_type_positive" type="text" name="c_items[<?php echo $collection_item['territory_id'];?>][target_next_month_for_ti]" value="<?php echo $collection_item['target_next_month_for_ti'];?>"></td>
                                    <td><textarea class="form-control" name="c_items[<?php echo $collection_item['territory_id'];?>][remarks_before_meeting]"><?php echo $collection_item['remarks_before_meeting'];?></textarea></td>
                                <?php } else{?>
                                    <td><?php echo $collection_item['territory_name'];?></td>
                                    <input type="hidden" name="c_items[<?php echo $collection_item['territory_id'];?>][territory_id]" value="<?php echo $collection_item['territory_id'];?>"></td>
                                    <td><input class="form-control budget_total float_type_positive" type="text" name="c_items[<?php echo $collection_item['territory_id'];?>][budget_total]" value="<?php echo $collection_item['budget_total'];?>">
                                    <td><input class="form-control achievement_total float_type_positive" type="text" name="c_items[<?php echo $collection_item['territory_id'];?>][achievement_total]" value="<?php echo $collection_item['achievement_total'];?>"></td>
                                    <td><input type="text" class="form-control variance_total" value="<?php echo ($collection_item['budget_total']-$collection_item['achievement_total'])?>" disabled></td>
                                    <td><input class="form-control target_last_month float_type_positive" type="text" name="c_items[<?php echo $collection_item['territory_id'];?>][target_last_month]" value="<?php echo $collection_item['target_last_month'];?>"></td>
                                    <td><input class="form-control achievement_last_month float_type_positive" type="text" name="c_items[<?php echo $collection_item['territory_id'];?>][achievement_last_month]" value="<?php echo $collection_item['achievement_last_month'];?>"></td>
                                    <td><input type="text" class="form-control variance_last_month" value="<?php echo ($collection_item['target_last_month']-$collection_item['achievement_last_month'])?>" disabled></td>
                                    <td><input class="form-control target_current_month float_type_positive" type="text" name="c_items[<?php echo $collection_item['territory_id'];?>][target_current_month]" value="<?php echo $collection_item['target_current_month'];?>"></td>
                                    <td><input class="form-control achievement_current_month float_type_positive" type="text" name="c_items[<?php echo $collection_item['territory_id'];?>][achievement_current_month]" value="<?php echo $collection_item['achievement_current_month'];?>"></td>
                                    <td><input type="text" class="form-control variance_current_month" value="<?php echo ($collection_item['target_current_month']-$collection_item['achievement_current_month'])?>" disabled></td>
                                    <td><input class="form-control" type="text" name="c_items[<?php echo $collection_item['territory_id'];?>][target_next_month]" value="<?php echo $collection_item['target_next_month'];?>"></td>
                                    <td><textarea class="form-control" name="c_items[<?php echo $collection_item['territory_id'];?>][remarks_before_meeting]"><?php echo $collection_item['remarks_before_meeting'];?></textarea></td>
                                <?php } ?>
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
        Forward Agenda
    </div>
    <div class="clearfix"></div>
</div>
<div style="" class="row show-grid">
    <div class="col-xs-4">

        <label class="control-label pull-right"><?php echo $CI->lang->line('ACTION_FORWARD');?></label>
    </div>
    <div class="col-sm-4 col-xs-8">
        <select id="status_forward" name="status_forward" class="form-control">

            <option value=""><?php echo $CI->lang->line('SELECT');?></option>
            <option value="<?php echo $CI->config->item('system_status_forward');?>"><?php echo $CI->config->item('system_status_forward');?></option>
        </select>
    </div>
</div>
</form>
<script type="text/javascript">

    jQuery(document).ready(function()
    {
        $(".datepicker").datepicker({dateFormat : display_date_format});
    });
</script>


