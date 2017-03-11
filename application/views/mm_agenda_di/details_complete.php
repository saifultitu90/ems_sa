<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI = & get_instance();
$action_data=array();
$action_data["action_back"]=base_url($CI->controller_url);
$CI->load->view("action_buttons",$action_data);
?>
<form class="form_valid" id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save_im');?>" method="post">
<input type="hidden" id="id" name="id" value="<?php echo $item['id']; ?>" />
<input type="hidden" id="agenda_id" name="agenda_id" value="<?php echo $item['id']; ?>" />
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
                Agenda</a>
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
                                <th>Next Month Target Before Meeting</th>
                                <th>Next Month Target In Meeting</th>
                                <th>Remarks Before Meeting</th>
                                <th>Remarks IN Meeting</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($sales_items_hom as $s_item_hom){?>
                                <tr>
                                    <td><b><?php echo $s_item_hom['division_name'];?></b></td>
                                    <td><b><?php echo $s_item_hom['budget_total'];?></b></td>
                                    <td><b><?php echo $s_item_hom['achievement_total'];?></b></td>
                                    <td><b><?php echo ($s_item_hom['budget_total']-$s_item_hom['achievement_total'])?></b></td>
                                    <td><b><?php echo $s_item_hom['target_last_month'];?></b></td>
                                    <td><b><?php echo $s_item_hom['achievement_last_month'];?></b></td>
                                    <td><b><?php echo ($s_item_hom['target_last_month']-$s_item_hom['achievement_last_month'])?></b></td>
                                    <td><b><?php echo $s_item_hom['target_current_month'];?></b></td>
                                    <td><b><?php echo $s_item_hom['achievement_current_month'];?></b></td>
                                    <td><b><?php echo ($s_item_hom['target_current_month']-$s_item_hom['achievement_current_month'])?></b></td>
                                    <td><b><?php echo $s_item_hom['target_next_month'];?></b></td>
                                    <td><?php echo $s_item_hom['target_next_month_im'];?></td>
                                    <td><b><?php echo $s_item_hom['remarks_before_meeting'];?></b></td>
                                    <td><?php echo $s_item_hom['remarks_in_meeting'];?></td>

                                </tr>
                            <?php } ?>
                            <?php foreach($sales_items as $s_item){?>
                                <tr>
                                    <td><?php echo $s_item['zone_name'];?></td>
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
                                    <td><?php echo $s_item['target_next_month_im'];?></td>
                                    <td><?php echo $s_item['remarks_before_meeting'];?></td>
                                    <td><?php echo $s_item['remarks_in_meeting'];?></td>
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
                                <th>Next Month Target Before Meeting</th>
                                <th>Next Month Target In Meeting</th>
                                <th>Remarks Before Meeting</th>
                                <th>Remarks IN Meeting</th>
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
                                    <td><?php echo $c_item_hom['target_next_month_im'];?></td>
                                    <td><b><?php echo $c_item_hom['remarks_before_meeting'];?></b></td>
                                    <td><?php echo $c_item_hom['remarks_in_meeting'];?></td>
                                </tr>
                            <?php } ?>
                            <?php foreach($collection_items as $c_item){?>
                                <tr>
                                    <td><?php echo $c_item['zone_name'];?></td>
                                    <input type="hidden" name="citems[<?php echo $c_item['zone_id']?>][zone_id]" value="<?php echo $c_item['zone_id'];?>"></td>
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
                                    <td><?php echo $c_item['target_next_month_im'];?></td>
                                    <td><?php echo $c_item['remarks_before_meeting'];?></td>
                                    <td><?php echo $c_item['remarks_in_meeting'];?></td>
                                </tr>
                            <?php } ?>
                            </tbody>

                        </table>
                    </div>
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
<script type="text/javascript">
    jQuery(document).ready(function()
    {
        turn_off_triggers();
        $(document).on("change","#division_id",function()
        {
//            $("#zone_id").val("");
            var division_id=$('#division_id').val();
            var agenda_id=$('#agenda_id').val();
            if(division_id>0)
            {
                $('#target_container').show();
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