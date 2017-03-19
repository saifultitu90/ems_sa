<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI = & get_instance();
$action_data=array();
$action_data["action_back"]=base_url($CI->controller_url);
$action_data["action_save"]='#save_form';
$CI->load->view("action_buttons",$action_data);
?>
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

        <div style="<?php if($div_id==0){echo 'display:none';} ?>" class="row show-grid" id="zone_container">

        </div>

        <div style="<?php if($div_id==0){echo 'display:none';} ?>" class="row show-grid" id="target_container">

        </div>

    </div>
</div>
<div class="clearfix"></div>
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
        $(document).on("change","#division_id",function()
        {
            $('#target_container').hide();
            var division_id=$('#division_id').val();
            var agenda_id=$('#agenda_id').val();
            if(division_id>0)
            {
                $('#zone_container').show();
                $.ajax({
                    url: base_url+"mm_agenda_zi/get_zone_by_division_id/",
                    type: 'POST',
                    datatype: "JSON",
                    data:{division_id:division_id,agenda_id:agenda_id},
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
                $('#zone_container').hide();
            }
        });
        $(document).on("change","#zone_id",function()
        {
            var zone_id=$('#zone_id').val();
            var division_id=$('#division_id').val();
            var agenda_id=$('#agenda_id').val();
            if(zone_id>0)
            {
                $('#target_container').show();
                $.ajax({
                    url: base_url+"mm_agenda_zi/get_zone/",
                    type: 'POST',
                    datatype: "JSON",
                    data:{zone_id:zone_id, agenda_id:agenda_id,division_id:division_id},
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
        $(".datepicker").datepicker({dateFormat : display_date_format});
    });
</script>