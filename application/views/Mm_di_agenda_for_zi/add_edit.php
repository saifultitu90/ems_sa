<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI = & get_instance();
$action_data=array();
$action_data["action_back"]=base_url($CI->controller_url);
$action_data["action_save"]='#save_form';
$action_data["action_clear"]='#save_form';
$CI->load->view("action_buttons",$action_data);
?>
<form class="form_valid" id="save_form" action="<?php echo site_url($CI->controller_url.'/index/save');?>" method="post">
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
                                        <th>Current Month Target</th>
                                        <th>Current Month Achievement</th>
                                        <th>Next Month Target</th>
                                        <th>Remarks Before Meeting</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php foreach($s_items_hom as $s_item_hom){?>
                                        <tr>
                                            <td><b><?php echo $s_item_hom['division_name'];?></b></td>
                                            <input type="hidden" name="sales_division_id" value="<?php echo $s_item_hom['division_id'];?>"></td>
                                            <td><b><?php echo $s_item_hom['total_budget'];?></b></td>
                                            <td><b><?php echo $s_item_hom['total_achievement'];?></b></td>
                                            <td><b><?php echo $s_item_hom['current_month_target'];?></b></td>
                                            <td><b><?php echo $s_item_hom['current_month_achievement'];?></b></td>
                                            <td><b><?php echo $s_item_hom['next_month_target'];?></b></td>
                                            <td><b><?php echo $s_item_hom['remarks_before_meeting'];?></b></td>
                                        </tr>
                                    <?php } ?>
                                    <?php foreach($s_items as $s_item){?>
                                        <tr>
                                            <?php if(isset($meeting_complete) && ($meeting_complete['meeting_status']==$this->config->item('system_status_hom_approval_approved'))){?>
                                                <td><?php echo $s_item['zone_name'];?></td>
                                                <input type="hidden" name="sales_zone_id[]" value="<?php echo $s_item['zone_id'];?>"></td>
                                                <td><?php echo $s_item['total_budget'];?></td>
                                                <td><?php echo $s_item['total_achievement'];?></td>
                                                <td><?php echo $s_item['current_month_target'];?></td>
                                                <td><?php echo $s_item['current_month_achievement'];?></td>
                                                <td><?php echo $s_item['next_month_target'];?></td>
                                                <td><?php echo $s_item['remarks_before_meeting'];?></td>
                                            <?php } else{?>
                                                <td><?php echo $s_item['zone_name'];?></td>
                                                <input type="hidden" name="s_items[<?php echo $s_item['zone_id'];?>][zone_id]" value="<?php echo $s_item['zone_id'];?>"></td>
                                                <td><input type="text" name="s_items[<?php echo $s_item['zone_id'];?>][total_budget]" value="<?php echo $s_item['total_budget'];?>">
                                                <td><input type="text" name="s_items[<?php echo $s_item['zone_id'];?>][total_achievement]" value="<?php echo $s_item['total_achievement'];?>"></td>
                                                <td><input type="text" name="s_items[<?php echo $s_item['zone_id'];?>][current_month_target]" value="<?php echo $s_item['current_month_target'];?>"></td>
                                                <td><input type="text" name="s_items[<?php echo $s_item['zone_id'];?>][current_month_achievement]" value="<?php echo $s_item['current_month_achievement'];?>"></td>
                                                <td><input type="text" name="s_items[<?php echo $s_item['zone_id'];?>][next_month_target]" value="<?php echo $s_item['next_month_target'];?>"></td>
                                                <td><input type="text" name="s_items[<?php echo $s_item['zone_id'];?>][remarks_before_meeting]" value="<?php echo $s_item['remarks_before_meeting'];?>"></td>
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
                                        <th>Current Month Target</th>
                                        <th>Current Month Achievement</th>
                                        <th>Next Month Target</th>
                                        <th>Remarks Before Meeting</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($c_items_hom as $c_item_hom){?>
                                        <tr>
                                            <td><b><?php echo $c_item_hom['division_name'];?></b></td>
                                            <input type="hidden" name="collection_division_id" value="<?php echo $c_item_hom['division_id'];?>">
                                            <td><b><?php echo $c_item_hom['total_budget'];?></b></td>
                                            <td><b><?php echo $c_item_hom['total_achievement'];?></b></td>
                                            <td><b><?php echo $c_item_hom['current_month_target'];?></b></td>
                                            <td><b><?php echo $c_item_hom['current_month_achievement'];?></b></td>
                                            <td><b><?php echo $c_item_hom['next_month_target'];?></b></td>
                                            <td><b><?php echo $c_item_hom['remarks_before_meeting'];?></b></td>
                                        </tr>
                                    <?php } ?>
                                    <?php foreach($c_items as $c_item){?>
                                        <tr>
                                            <?php if(isset($meeting_complete) && ($meeting_complete['meeting_status']==$this->config->item('system_status_hom_approval_approved'))){?>
                                                <td><?php echo $c_item['zone_name'];?></td>
                                                <input type="hidden" name="collection_zone_id[]" value="<?php echo $c_item['zone_id'];?>"></td>
                                                <td><?php echo $c_item['total_budget'];?></td>
                                                <td><?php echo $c_item['total_achievement'];?></td>
                                                <td><?php echo $c_item['current_month_target'];?></td>
                                                <td><?php echo $c_item['current_month_achievement'];?></td>
                                                <td><?php echo $c_item['next_month_target'];?></td>
                                                <td><?php echo $c_item['remarks_before_meeting'];?></td>

                                            <?php } else{?>

                                                <td><?php echo $c_item['zone_name'];?></td>
                                                <input type="hidden" name="c_items[<?php echo $c_item['zone_id'];?>][zone_id]" value="<?php echo $c_item['zone_id'];?>"></td>
                                                <td><input type="text" name="c_items[<?php echo $c_item['zone_id'];?>][total_budget]" value="<?php echo $c_item['total_budget'];?>">
                                                <td><input type="text" name="c_items[<?php echo $c_item['zone_id'];?>][total_achievement]" value="<?php echo $c_item['total_achievement'];?>"></td>
                                                <td><input type="text" name="c_items[<?php echo $c_item['zone_id'];?>][current_month_target]" value="<?php echo $c_item['current_month_target'];?>"></td>
                                                <td><input type="text" name="c_items[<?php echo $c_item['zone_id'];?>][current_month_achievement]" value="<?php echo $c_item['current_month_achievement'];?>"></td>
                                                <td><input type="text" name="c_items[<?php echo $c_item['zone_id'];?>][next_month_target]" value="<?php echo $c_item['next_month_target'];?>"></td>
                                                <td><input type="text" name="c_items[<?php echo $c_item['zone_id'];?>][remarks_before_meeting]" value="<?php echo $c_item['remarks_before_meeting'];?>"></td>
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
                    url: base_url+"mm_di_agenda_for_zi/get_zone/",
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
