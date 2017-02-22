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