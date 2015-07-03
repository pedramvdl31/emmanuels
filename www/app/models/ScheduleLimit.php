<?php

class ScheduleLimit extends \Eloquent {
	protected $fillable = [];

	public static function prepareValidationResults($data){
		$message = [];
		if (isset($data)) {
			$today = date('m/d/y');
			foreach ($data as $key => $value) {
				$message[$key]['start'] =  strtotime($today.' '.$value[0].':'.$value[1].' '.$value[2]);
				$message[$key]['end'] =  strtotime($today.' '.$value[3].':'.$value[4].' '.$value[5]);
				if ($message[$key]['end'] < $message[$key]['start']) {
					$message[$key]['info'] = "error";
				} else {
					$message[$key]['info'] = "fine";
				}
			}
		}
		return $message;
	}

	public static function prepareNewOverwrite($new_count) {
			
		$overwrite_hours = array();
		$overwrite_minutes = array();
		$overwrite_ampm = array('am'=>'am','pm'=>'pm');
		for ($ov_i=0; $ov_i < 13; $ov_i++) { 
			$overwrite_hours[$ov_i] = ($ov_i == 0) ? 'Select hour' : $ov_i;
		}
		for ($ov_i=0; $ov_i <= 60; $ov_i++) {
			if($ov_i == 0) {
				$overwrite_minutes[""] = 'Select minute';
			} else {
				$overwrite_minutes[$ov_i-1] = ":".str_pad($ov_i-1, 2, '0', STR_PAD_LEFT);
			}
		}
		if(isset($new_count)) {
			$html = '';
			$html = '
					<div class="panel panel-default content-set this-wrapper" this-set="'.$new_count.'" style="margin-top:10px;border:none;border-radius:0;  border-bottom: 1px solid rgb(174, 174, 174);
						border-top: 1px solid rgb(174, 174, 174);">

						<div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse"
						data-parent="#accordion" href="#accordion-'.$new_count.'" aria-expanded="true" aria-controls="collapseOne"
						style="cursor: pointer;border:none;">
						<h4 class="panel-title">
							<a class="this-title">
								OverWrite Date '.($new_count+1).'
							</a>
							<a>
								<i class="glyphicon glyphicon-chevron-down pull-right"></i>
							</a>
						</h4>
						</div>
						<div id="accordion-'.$new_count.'" this-set="'.$new_count.'" class="panel-collapse collapse in collapse-'.$new_count.'" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body panel-input">
								<!-- PANEL START -->

								<div class="overwrite-container">
									<!-- PANEL START -->
									<div class="panel-body overwrite-wrapper"  style="padding: 6px;">

										<h4 class="first-group-title">Type</h4>
										<hr class="title-hr">
										<div class="form-group">
											<select class="form-control type-select" name="overwrite['.$new_count.'][type]">
												<option value="single">Single</option>
												<option value="range">Range</option>
											</select>
										</div>


										<h4 class="group-title">Date</h4>
										<hr class="title-hr">

										<div class="single-wrapper">
											<div class="input-group input-group-md">
												<span class="input-group-addon" >Select Date</span>
												<input type="text" name="overwrite['.$new_count.'][date]" id="overwrite-date-single-'.$new_count.'" class="form-control"  aria-describedby="sizing-addon1">
											</div>
										</div>

										<div  class=" hide range-wrapper">
											<div class="input-group input-group-md">
												<span class="input-group-addon" >Start Date</span>
												<input type="text" name="overwrite['.$new_count.'][start]"  id="overwrite-date-range-start-'.$new_count.'" class="form-control"  aria-describedby="sizing-addon'.$new_count.'">
											</div>
											<div class="input-group input-group-md" style="margin-top:10px;">
												<span class="input-group-addon" >End Date</span>
												<input type="text" name="overwrite['.$new_count.'][end]"  id="overwrite-date-range-end-'.$new_count.'" class="form-control"  aria-describedby="sizing-addon'.$new_count.'">
											</div>
										</div>

										<h4 class="group-title">Schedules</h4>
										<hr class="title-hr">

										<!-- TABLE START -->
										<table class="table table-bordered table-condensed" style="border:none">
											<tbody>
												<tr>
													<td class="list-group" style="border:none;">
														<fieldset>
															<div class="list-group-item" style="height:90px;">
																<h4 class="list-group-item-heading">Start</h4>
																<div class="col-xs-4">
																	<select class="form-control" placeholder="Select Hour" status="" name="overwrite['.$new_count.'][open_hour]">';
																		foreach ($overwrite_hours as $key => $value) {
																			$html .= '<option value="'.$key.'">'.$value.'</option>';
																		}
																		$html .= '
																	</select>
																</div>
																<div class="col-xs-4">
																	<select class="form-control" placeholder="Select Hour" status="" name="overwrite['.$new_count.'][open_minute]">';
																		foreach ($overwrite_minutes as $key => $value) {
																			$html .= '<option value="'.$key.'">'.$value.'</option>';
																		}
																		$html .= '
																	</select>																
																	</div>
																<div class="col-xs-4">
																	<select class="form-control" placeholder="" status="" name="overwrite['.$new_count.'][open_ampm]">';
																		foreach ($overwrite_ampm as $key => $value) {
																			$html .= '<option value="'.$key.'">'.$value.'</option>';
																		}
																		$html .= '
																	</select>																
																	</div>
															</div>
															<div class="list-group-item" style="height:90px;">
																<h4 class="list-group-item-heading">End</h4>
																<div class="col-xs-4">
																	<select class="form-control" placeholder="Select Hour" status="" name="overwrite['.$new_count.'][close_hour]">';
																	foreach ($overwrite_hours as $key => $value) {
																		$html .= '<option value="'.$key.'">'.$value.'</option>';
																	}
																	$html .= '
																	</select>																
																	</div>
																<div class="col-xs-4">
																	<select class="form-control" placeholder="Select Hour" status="" name="overwrite['.$new_count.'][close_minute]">';
																	foreach ($overwrite_minutes as $key => $value) {
																		$html .= '<option value="'.$key.'">'.$value.'</option>';
																	}
																	$html .= '
																	</select>																
																	</div>
																<div class="col-xs-4">
																	<select class="form-control" placeholder="" status="" name="overwrite['.$new_count.'][close_ampm]">';
																		foreach ($overwrite_ampm as $key => $value) {
																			$html .= '<option value="'.$key.'">'.$value.'</option>';
																		}
																		$html .= '
																	</select>																
																	</div>
															</div>
														</fieldset>
													</td>
												</tr>
											</tbody>
										</table>
										<!-- TABLE END -->

										<h4 class="group-title">Limit</h4>
										<hr class="title-hr">

										<div class="input-group input-group-md">
											<span class="input-group-addon" >Number Of Employees</span>
											<input type="text" name="overwrite[0][number_of_employee]" id="overwrite-date-single-1" class="form-control"  aria-describedby="sizing-addon1">
										</div>


									</div>
									<!-- PANEL END -->
								</div>
								<!-- PANEL END -->
							</div>
						</div>
					</div>
					';
		}
		return $html;
	}
}