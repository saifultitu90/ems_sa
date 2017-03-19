<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI = & get_instance();
$action_data=array();
$action_data["action_back"]=base_url($CI->controller_url);
$action_data["action_save"]='#save_form';
$action_data["action_refresh"]=base_url($CI->controller_url."/index/details/".$item['agenda_id']);
$CI->load->view("action_buttons",$action_data);
?>
<form class="form_valid" id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save');?>" method="post">
<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
<input type="hidden" id="agenda_id" name="agenda_id" value="<?php echo $item['agenda_id']; ?>" />
<input type="hidden" id="system_save_new_status" name="system_save_new_status" value="0" />
<div class="row widget">
<div class="widget-header">
    <div class="title">
        <?php echo $title.' '.'(Before Meeting)'; ?>
    </div>
    <div class="clearfix"></div>
</div>
<div class="panel-group" id="accordion">
<?php if($div_id==0){?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="external" data-toggle="collapse" data-target="#collapse4" href="#">
                    Select division</a>
            </h4>
        </div>
        <div id="collapse4" class="panel-collapse collapse">
            <div class="row show-grid">
                <div class="col-xs-12" id="system_jqx_containers">
                    <div style="" class="row show-grid">
                        <div class="col-xs-4">
                            <label class="control-label pull-right"><?php echo $CI->lang->line('LABEL_DIVISION_NAME');?><span style="color:#FF0000">*</span></label>
                        </div>
                        <div class="col-sm-4 col-xs-8">
                            <select id="division_id" name="division_id" class="form-control">

                                <option value=""><?php echo $this->lang->line('SELECT');?></option>
                                <?php
                                foreach($divisions as $division)
                                {?>
                                    <option value="<?php echo $division['value']?>"><?php echo $division['text'];?></option>
                                <?php
                                }
                                ?>
                            </select>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<div style="<?php if($div_id==0){echo 'display:none';} ?>" class="row show-grid" id="agenda_info_container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle external" data-toggle="collapse" data-target="#collapse1" href="#">
                    Agenda Information</a>
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

                    <label class="control-label"><?php echo System_helper::display_date($item['agenda_date_hom']);?></label>

                </div>
            </div>
        </div>
    </div>
</div>
<div style="<?php if($div_id==0){echo 'display:none';} ?>" class="row show-grid" id="target_container">
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
                            <?php if($hom_meeting_status['status_complete']==$this->config->item('system_status_complete')){?>
                                <th>Next Month Target For ZI</th>
                            <?php } ?>
                            <th>Remarks Before Meeting</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach($sales_items_hom as $s_item_hom){?>
                            <tr>
                                <td><b><?php echo $s_item_hom['division_name'];?></b></td>
                                <input type="hidden" name="sales_division_id" value="<?php echo $s_item_hom['division_id'];?>"></td>
                                <td><b><?php echo $s_item_hom['budget_total'];?></b></td>
                                <td><b><?php echo $s_item_hom['achievement_total'];?></b></td>
                                <td><b><?php echo ($s_item_hom['budget_total']-$s_item_hom['achievement_total']);?></b></td>
                                <td><b><?php echo $s_item_hom['target_last_month'];?></b></td>
                                <td><b><?php echo $s_item_hom['achievement_last_month'];?></b></td>
                                <td><b><?php echo ($s_item_hom['target_last_month']-$s_item_hom['achievement_last_month']);?></b></td>
                                <td><b><?php echo $s_item_hom['target_current_month'];?></b></td>
                                <td><b><?php echo $s_item_hom['achievement_current_month'];?></b></td>
                                <td><b><?php echo ($s_item_hom['target_current_month']-$s_item_hom['achievement_current_month']);?></b></td>
                                <td><b><?php echo $s_item_hom['target_next_month'];?></b></td>
                                <?php if(($hom_meeting_status['status_complete']==$this->config->item('system_status_complete'))){?>
                                    <td><b><?php echo $s_item_hom['target_next_month'];?></b></td>
                                <?php } ?>
                                <td><b><?php echo $s_item_hom['remarks_before_meeting'];?></b></td>
                            </tr>
                        <?php } ?>
                        <?php foreach($sales_items as $sales_item){?>
                            <tr>
                                <?php if(($hom_meeting_status['status_complete']==$this->config->item('system_status_complete'))){?>
                                    <td><?php echo $sales_item['zone_name'];?></td>
                                    <input type="hidden" name="s_items[<?php echo $sales_item['zone_id'];?>][zone_id]" value="<?php echo $sales_item['zone_id'];?>"></td>
                                    <!--<input type="hidden" name="sales_zone_id[]" value="--><?php //echo $sales_item['zone_id'];?><!--"></td>-->
                                    <td><input class="form-control budget_total float_type_positive" type="text" name="s_items[<?php echo $sales_item['zone_id'];?>][budget_total]" value="<?php echo $sales_item['budget_total'];?>">
                                    <td><input class="form-control achievement_total float_type_positive" type="text" name="s_items[<?php echo $sales_item['zone_id'];?>][achievement_total]" value="<?php echo $sales_item['achievement_total'];?>"></td>
                                    <td><input type="text" class="form-control variance_total" value="<?php echo ($sales_item['budget_total']-$sales_item['achievement_total'])?>" disabled></td>
                                    <td><input class="form-control target_last_month float_type_positive" type="text" name="s_items[<?php echo $sales_item['zone_id'];?>][target_last_month]" value="<?php echo $sales_item['target_last_month'];?>"></td>
                                    <td><input class="form-control achievement_last_month float_type_positive" type="text" name="s_items[<?php echo $sales_item['zone_id'];?>][achievement_last_month]" value="<?php echo $sales_item['achievement_last_month'];?>"></td>
                                    <td><input type="text" class="form-control variance_last_month" value="<?php echo ($sales_item['target_last_month']-$sales_item['achievement_last_month'])?>" disabled></td>
                                    <td><input class="form-control target_current_month float_type_positive" type="text" name="s_items[<?php echo $sales_item['zone_id'];?>][target_current_month]" value="<?php echo $sales_item['target_current_month'];?>"></td>
                                    <td><input class="form-control achievement_current_month float_type_positive" type="text" name="s_items[<?php echo $sales_item['zone_id'];?>][achievement_current_month]" value="<?php echo $sales_item['achievement_current_month'];?>"></td>
                                    <td><input type="text" class="form-control variance_current_month" value="<?php echo ($sales_item['target_current_month']-$sales_item['achievement_current_month'])?>" disabled></td>
                                    <td><input type="text" class="form-control" value="<?php echo $sales_item['target_next_month'];?>" disabled></td>
                                    <td><input class="form-control float_type_positive" type="text" name="s_items[<?php echo $sales_item['zone_id'];?>][target_next_month_for_zi]" value="<?php echo $sales_item['target_next_month_for_zi'];?>"></td>
                                    <td><textarea class="form-control" name="s_items[<?php echo $sales_item['zone_id']?>][remarks_before_meeting]"><?php echo $sales_item['remarks_before_meeting'];?></textarea></td>
                                <?php } else{?>
                                    <td><?php echo $sales_item['zone_name'];?></td>
                                    <input type="hidden" name="s_items[<?php echo $sales_item['zone_id'];?>][zone_id]" value="<?php echo $sales_item['zone_id'];?>"></td>
                                    <td><input class="form-control budget_total float_type_positive" type="text" name="s_items[<?php echo $sales_item['zone_id'];?>][budget_total]" value="<?php echo $sales_item['budget_total'];?>">
                                    <td><input class="form-control achievement_total float_type_positive" type="text" name="s_items[<?php echo $sales_item['zone_id'];?>][achievement_total]" value="<?php echo $sales_item['achievement_total'];?>"></td>
                                    <td><input type="text" class="form-control variance_total" value="<?php echo ($sales_item['budget_total']-$sales_item['achievement_total'])?>" disabled></td>
                                    <td><input class="form-control target_last_month float_type_positive" type="text" name="s_items[<?php echo $sales_item['zone_id'];?>][target_last_month]" value="<?php echo $sales_item['target_last_month'];?>"></td>
                                    <td><input class="form-control achievement_last_month float_type_positive" type="text" name="s_items[<?php echo $sales_item['zone_id'];?>][achievement_last_month]" value="<?php echo $sales_item['achievement_last_month'];?>"></td>
                                    <td><input type="text" class="form-control variance_last_month" value="<?php echo ($sales_item['target_last_month']-$sales_item['achievement_last_month'])?>" disabled></td>
                                    <td><input class="form-control target_current_month float_type_positive" type="text" name="s_items[<?php echo $sales_item['zone_id'];?>][target_current_month]" value="<?php echo $sales_item['target_current_month'];?>"></td>
                                    <td><input class="form-control achievement_current_month float_type_positive" type="text" name="s_items[<?php echo $sales_item['zone_id'];?>][achievement_current_month]" value="<?php echo $sales_item['achievement_current_month'];?>"></td>
                                    <td><input type="text" class="form-control variance_current_month" value="<?php echo ($sales_item['target_current_month']-$sales_item['achievement_current_month'])?>" disabled></td>
                                    <td><input class="form-control float_type_positive" type="text" name="s_items[<?php echo $sales_item['zone_id'];?>][target_next_month]" value="<?php echo $sales_item['target_next_month'];?>"></td>
                                    <td><textarea class="form-control" name="s_items[<?php echo $sales_item['zone_id']?>][remarks_before_meeting]"><?php echo $sales_item['remarks_before_meeting'];?></textarea></td>
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
                            <?php if($hom_meeting_status['status_complete']==$this->config->item('system_status_complete')){?>
                                <th>Next Month Target For ZI</th>
                            <?php } ?>
                            <th>Remarks Before Meeting</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($collection_items_hom as $c_item_hom){?>
                            <tr>
                                <td><b><?php echo $c_item_hom['division_name'];?></b></td>
                                <input type="hidden" name="collection_division_id" value="<?php echo $c_item_hom['division_id'];?>">
                                <td><b><?php echo $c_item_hom['budget_total'];?></b></td>
                                <td><b><?php echo $c_item_hom['achievement_total'];?></b></td>
                                <td><b><?php echo ($c_item_hom['budget_total']-$c_item_hom['achievement_total'])?></b></td>
                                <td><b><?php echo $c_item_hom['target_last_month'];?></b></td>
                                <td><b><?php echo $c_item_hom['achievement_last_month'];?></b></td>
                                <td><b><?php echo ($c_item_hom['target_last_month']-$c_item_hom['achievement_last_month'])?></b></td>
                                <td><b><?php echo $c_item_hom['target_current_month'];?></b></td>
                                <td><b><?php echo $c_item_hom['achievement_current_month'];?></b></td>
                                <td><b><?php echo ($c_item_hom['target_current_month']-$c_item_hom['achievement_current_month'])?></b></td>
                                <td><b><?php echo $c_item_hom['target_next_month'];?></b></td>
                                <?php if(($hom_meeting_status['status_complete']==$this->config->item('system_status_complete'))){?>
                                    <td><b><?php echo $c_item_hom['target_next_month'];?></b></td>
                                <?php } ?>
                                <td><b><?php echo $c_item_hom['remarks_before_meeting'];?></b></td>
                            </tr>
                        <?php } ?>
                        <?php foreach($collection_items as $collection_item){?>
                            <tr>
                                <?php if(($hom_meeting_status['status_complete']==$this->config->item('system_status_complete'))){?>
                                    <td><?php echo $collection_item['zone_name'];?></td>
                                    <input type="hidden" name="c_items[<?php echo $collection_item['zone_id'];?>][zone_id]" value="<?php echo $collection_item['zone_id'];?>"></td>
                                    <td><input class="form-control budget_total float_type_positive" type="text" name="c_items[<?php echo $collection_item['zone_id'];?>][budget_total]" value="<?php echo $collection_item['budget_total'];?>">
                                    <td><input class="form-control achievement_total float_type_positive" type="text" name="c_items[<?php echo $collection_item['zone_id'];?>][achievement_total]" value="<?php echo $collection_item['achievement_total'];?>"></td>
                                    <td><input type="text" class="form-control variance_total" value="<?php echo ($collection_item['budget_total']-$collection_item['achievement_total'])?>" disabled></td>
                                    <td><input class="form-control target_last_month float_type_positive" type="text" name="c_items[<?php echo $collection_item['zone_id'];?>][target_last_month]" value="<?php echo $collection_item['target_last_month'];?>"></td>
                                    <td><input class="form-control achievement_last_month float_type_positive" type="text" name="c_items[<?php echo $collection_item['zone_id'];?>][achievement_last_month]" value="<?php echo $collection_item['achievement_last_month'];?>"></td>
                                    <td><input type="text" class="form-control variance_last_month" value="<?php echo ($collection_item['target_last_month']-$collection_item['achievement_last_month'])?>" disabled></td>
                                    <td><input class="form-control target_current_month float_type_positive" type="text" name="c_items[<?php echo $collection_item['zone_id'];?>][target_current_month]" value="<?php echo $collection_item['target_current_month'];?>"></td>
                                    <td><input class="form-control achievement_current_month float_type_positive" type="text" name="c_items[<?php echo $collection_item['zone_id'];?>][achievement_current_month]" value="<?php echo $collection_item['achievement_current_month'];?>"></td>
                                    <td><input type="text" class="form-control variance_current_month" value="<?php echo ($collection_item['target_current_month']-$collection_item['achievement_current_month'])?>" disabled></td>
                                    <td><input type="text" class="form-control" value="<?php echo $collection_item['target_next_month'];?>" disabled></td>
                                    <td><input class="form-control float_type_positive" type="text" name="c_items[<?php echo $collection_item['zone_id'];?>][target_next_month_for_zi]" value="<?php echo $collection_item['target_next_month_for_zi'];?>"></td>
                                    <td><textarea class="form-control" name="c_items[<?php echo $collection_item['zone_id'];?>][remarks_before_meeting]"><?php echo $collection_item['remarks_before_meeting'];?></textarea></td>
                                <?php } else{?>
                                    <td><?php echo $collection_item['zone_name'];?></td>
                                    <input type="hidden" name="c_items[<?php echo $collection_item['zone_id'];?>][zone_id]" value="<?php echo $collection_item['zone_id'];?>"></td>
                                    <td><input class="form-control budget_total float_type_positive" type="text" name="c_items[<?php echo $collection_item['zone_id'];?>][budget_total]" value="<?php echo $collection_item['budget_total'];?>">
                                    <td><input class="form-control achievement_total float_type_positive" type="text" name="c_items[<?php echo $collection_item['zone_id'];?>][achievement_total]" value="<?php echo $collection_item['achievement_total'];?>"></td>
                                    <td><input type="text" class="form-control variance_total" value="<?php echo ($collection_item['budget_total']-$collection_item['achievement_total'])?>" disabled></td>
                                    <td><input class="form-control target_last_month float_type_positive" type="text" name="c_items[<?php echo $collection_item['zone_id'];?>][target_last_month]" value="<?php echo $collection_item['target_last_month'];?>"></td>
                                    <td><input class="form-control achievement_last_month float_type_positive" type="text" name="c_items[<?php echo $collection_item['zone_id'];?>][achievement_last_month]" value="<?php echo $collection_item['achievement_last_month'];?>"></td>
                                    <td><input type="text" class="form-control variance_last_month" value="<?php echo ($collection_item['target_last_month']-$collection_item['achievement_last_month'])?>" disabled></td>
                                    <td><input class="form-control target_current_month float_type_positive" type="text" name="c_items[<?php echo $collection_item['zone_id'];?>][target_current_month]" value="<?php echo $collection_item['target_current_month'];?>"></td>
                                    <td><input class="form-control achievement_current_month float_type_positive" type="text" name="c_items[<?php echo $collection_item['zone_id'];?>][achievement_current_month]" value="<?php echo $collection_item['achievement_current_month'];?>"></td>
                                    <td><input type="text" class="form-control variance_current_month" value="<?php echo ($collection_item['target_current_month']-$collection_item['achievement_current_month'])?>" disabled></td>
                                    <td><input class="form-control float_type_positive" type="text" name="c_items[<?php echo $collection_item['zone_id'];?>][target_next_month]" value="<?php echo $collection_item['target_next_month'];?>"></td>
                                    <td><textarea class="form-control" name="c_items[<?php echo $collection_item['zone_id'];?>][remarks_before_meeting]"><?php echo $collection_item['remarks_before_meeting'];?></textarea></td>
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

<script type="text/javascript">
    jQuery(document).ready(function()
    {
        turn_off_triggers();
        $(document).on("change","#division_id",function()
        {
            var division_id=$('#division_id').val();
            var agenda_id=$('#id').val();
            if(division_id>0)
            {
                $('#target_container').show();
                $('#agenda_info_container').show();


                $.ajax({
                    url: base_url+"mm_agenda_di/get_zone/",
                    type: 'POST',
                    datatype: "JSON",
                    data:{division_id:division_id, agenda_id:agenda_id},
                    success: function (data, status)
                    {

                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");

                    }
                });
            }
            else
            {
                $('#target_container').hide();
            }
        });
    });
</script>

<script type="text/javascript">
    jQuery(document).ready(function()
    {
        turn_off_triggers();
        $(document).off('input','.achievement_total');
        $(document).off('input','.budget_total');
        $(document).off('input','.achievement_last_month');
        $(document).off('input','.target_last_month');
        $(document).off('input','.achievement_current_month');
        $(document).off('input','.target_current_month');
        $(".datepicker").datepicker({dateFormat : display_date_format});
        $(document).on("input",".achievement_total,.budget_total",function()
        {
            var budget_total=$(this).closest('tr').find('.budget_total').val();
            var achievement_total=$(this).closest('tr').find('.achievement_total').val();
            var variance_total=budget_total-achievement_total;
            $(this).closest('tr').find('.variance_total').val(variance_total);
        });
        $(document).on("input",".target_last_month,.achievement_last_month",function()
        {
            var target_last_month=$(this).closest('tr').find('.target_last_month').val();
            var achievement_last_month=$(this).closest('tr').find('.achievement_last_month').val();
            var variance_last_month=target_last_month-achievement_last_month;
            $(this).closest('tr').find('.variance_last_month').val(variance_last_month);
        });
        $(document).on("input",".target_current_month,.achievement_current_month",function()
        {
            var target_current_month=$(this).closest('tr').find('.target_current_month').val();
            var achievement_current_month=$(this).closest('tr').find('.achievement_current_month').val();
            var variance_current_month=target_current_month-achievement_current_month;
            $(this).closest('tr').find('.variance_current_month').val(variance_current_month);
        });

    });
</script>
