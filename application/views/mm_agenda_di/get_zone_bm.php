<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI = & get_instance();
?>
<form class="form_valid" id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save');?>" method="post">
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
                    <input type="text" name="item[date]" id="date_stock_in" class="form-control datepicker" value="<?php echo System_helper::display_date($item['date']);?>"/>
                </div>
            </div>
            <div class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $this->lang->line('LABEL_PURPOSE');?><span>:</span></label>
                </div>
                <div class="col-xs-4">
                    <!--                <label class="control-label">--><?php //echo $item['purpose'];?><!--</label>-->
                    <label class="control-label">On process</label>
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
                                <th>Last Month Target</th>
                                <th>Last Month Achievement</th>
                                <th>Current Month Target</th>
                                <th>Current Month Achievement</th>
                                <th>Next Month Target</th>
                                <th>Remarks Before Meeting</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($sales_items_hom as $s_item_hom){?>
                                <tr>
                                    <td><b><?php echo $s_item_hom['division_name'];?></b></td>
                                    <input class="form-control" type="hidden" name="sales_division_id" value="<?php echo $s_item_hom['division_id'];?>"></td>
                                    <td><b><?php echo $s_item_hom['budget_total'];?></b></td>
                                    <td><b><?php echo $s_item_hom['achievement_total'];?></b></td>
                                    <td><b><?php echo $s_item_hom['target_last_month'];?></b></td>
                                    <td><b><?php echo $s_item_hom['achievement_last_month'];?></b></td>
                                    <td><b><?php echo $s_item_hom['target_current_month'];?></b></td>
                                    <td><b><?php echo $s_item_hom['achievement_current_month'];?></b></td>
                                    <td><b><?php echo $s_item_hom['target_next_month'];?></b></td>
                                    <td><b><?php echo $s_item_hom['remarks_before_meeting'];?></b></td>
                                </tr>
                            <?php } ?>
                            <?php foreach($sales_items as $s_item){?>
                                <tr>
                                    <?php if(($hom_meeting_status['status_complete']==$this->config->item('system_status_complete'))){?>
                                        <td><?php echo $s_item['zone_name'];?></td>
                                        <input class="form-control" type="hidden" name="sales_zone_id[]" value="<?php echo $s_item['zone_id'];?>"></td>
                                        <td><?php echo $s_item['budget_total'];?></td>
                                        <td><?php echo $s_item['achievement_total'];?></td>
                                        <td><?php echo $s_item['target_last_month'];?></td>
                                        <td><?php echo $s_item['achievement_last_month'];?></td>
                                        <td><?php echo $s_item['target_current_month'];?></td>
                                        <td><?php echo $s_item['achievement_current_month'];?></td>
                                        <td><?php echo $s_item['target_next_month'];?></td>
                                        <td><?php echo $s_item['remarks_before_meeting'];?></td>
                                    <?php } else{?>
                                        <td><?php echo $s_item['zone_name'];?></td>
                                        <input class="form-control" type="hidden" name="s_items[<?php echo $s_item['zone_id'];?>][zone_id]" value="<?php echo $s_item['zone_id'];?>"></td>
                                        <td><input class="form-control" type="text" name="s_items[<?php echo $s_item['zone_id'];?>][budget_total]" value="<?php echo $s_item['budget_total'];?>">
                                        <td><input class="form-control" type="text" name="s_items[<?php echo $s_item['zone_id'];?>][achievement_total]" value="<?php echo $s_item['achievement_total'];?>"></td>
                                        <td><input class="form-control" type="text" name="s_items[<?php echo $s_item['zone_id'];?>][target_last_month]" value="<?php echo $s_item['target_last_month'];?>"></td>
                                        <td><input class="form-control" type="text" name="s_items[<?php echo $s_item['zone_id'];?>][achievement_last_month]" value="<?php echo $s_item['achievement_last_month'];?>"></td>
                                        <td><input class="form-control" type="text" name="s_items[<?php echo $s_item['zone_id'];?>][target_current_month]" value="<?php echo $s_item['target_current_month'];?>"></td>
                                        <td><input class="form-control" type="text" name="s_items[<?php echo $s_item['zone_id'];?>][achievement_current_month]" value="<?php echo $s_item['achievement_current_month'];?>"></td>
                                        <td><input class="form-control" type="text" name="s_items[<?php echo $s_item['zone_id'];?>][target_next_month]" value="<?php echo $s_item['target_next_month'];?>"></td>
                                        <td><textarea class="form-control" name="s_items[<?php echo $s_item['zone_id'];?>][remarks_before_meeting]"><?php echo $s_item['remarks_before_meeting'];?></textarea></td>
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
                                <th>Last Month Target</th>
                                <th>Last Month Achievement</th>
                                <th>Current Month Target</th>
                                <th>Current Month Achievement</th>
                                <th>Next Month Target</th>
                                <th>Remarks Before Meeting</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($collection_items_hom as $c_item_hom){?>
                                <tr>
                                    <td><b><?php echo $c_item_hom['division_name'];?></b></td>
                                    <input class="form-control" type="hidden" name="collection_division_id" value="<?php echo $c_item_hom['division_id'];?>">
                                    <td><b><?php echo $c_item_hom['budget_total'];?></b></td>
                                    <td><b><?php echo $c_item_hom['achievement_total'];?></b></td>
                                    <td><b><?php echo $c_item_hom['target_last_month'];?></b></td>
                                    <td><b><?php echo $c_item_hom['achievement_last_month'];?></b></td>
                                    <td><b><?php echo $c_item_hom['target_current_month'];?></b></td>
                                    <td><b><?php echo $c_item_hom['achievement_current_month'];?></b></td>
                                    <td><b><?php echo $c_item_hom['target_next_month'];?></b></td>
                                    <td><b><?php echo $c_item_hom['remarks_before_meeting'];?></b></td>
                                </tr>
                            <?php } ?>
                            <?php foreach($collection_items as $c_item){?>
                                <tr>
                                    <?php if(($hom_meeting_status['status_complete']==$this->config->item('system_status_complete'))){?>
                                        <td><?php echo $c_item['zone_name'];?></td>
                                        <input class="form-control" type="hidden" name="collection_zone_id[]" value="<?php echo $c_item['zone_id'];?>"></td>
                                        <td><?php echo $c_item['budget_total'];?></td>
                                        <td><?php echo $c_item['achievement_total'];?></td>
                                        <td><?php echo $c_item['target_last_month'];?></td>
                                        <td><?php echo $c_item['achievement_last_month'];?></td>
                                        <td><?php echo $c_item['target_current_month'];?></td>
                                        <td><?php echo $c_item['achievement_current_month'];?></td>
                                        <td><?php echo $c_item['target_next_month'];?></td>
                                        <td><?php echo $c_item['remarks_before_meeting'];?></td>
                                    <?php } else{?>
                                        <td><?php echo $c_item['zone_name'];?></td>
                                        <input class="form-control" type="hidden" name="c_items[<?php echo $c_item['zone_id'];?>][zone_id]" value="<?php echo $c_item['zone_id'];?>"></td>
                                        <td><input class="form-control" type="text" name="c_items[<?php echo $c_item['zone_id'];?>][budget_total]" value="<?php echo $c_item['budget_total'];?>">
                                        <td><input class="form-control" type="text" name="c_items[<?php echo $c_item['zone_id'];?>][achievement_total]" value="<?php echo $c_item['achievement_total'];?>"></td>
                                        <td><input class="form-control" type="text" name="c_items[<?php echo $c_item['zone_id'];?>][target_last_month]" value="<?php echo $c_item['target_last_month'];?>"></td>
                                        <td><input class="form-control" type="text" name="c_items[<?php echo $c_item['zone_id'];?>][achievement_last_month]" value="<?php echo $c_item['achievement_last_month'];?>"></td>
                                        <td><input class="form-control" type="text" name="c_items[<?php echo $c_item['zone_id'];?>][target_current_month]" value="<?php echo $c_item['target_current_month'];?>"></td>
                                        <td><input class="form-control" type="text" name="c_items[<?php echo $c_item['zone_id'];?>][achievement_current_month]" value="<?php echo $c_item['achievement_current_month'];?>"></td>
                                        <td><input class="form-control" type="text" name="c_items[<?php echo $c_item['zone_id'];?>][target_next_month]" value="<?php echo $c_item['target_next_month'];?>"></td>
                                        <td><input class="form-control" type="text" name="c_items[<?php echo $c_item['zone_id'];?>][remarks_before_meeting]" value="<?php echo $c_item['remarks_before_meeting'];?>"></td>
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
            Forward
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