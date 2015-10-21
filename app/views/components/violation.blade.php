<div class="content-box">
	<div class="violation-container">
		<!-- 办理进程 START  -->
		<!-- @include("components.vio-process", array("num" => "1")) -->
		<!-- 办理进程 END	 -->
		@if(isset($process))
			@include("components.vio-process", array("num" => "1"))
		@endif
		<!-- 查询框 START -->
		<div class="violation-search">
			<div class="violation-wrapper">
				<div class="input-wrapper">
					<div class="input-title">车牌号码：</div>
					<div class="inputs plate-number-container">
						@include("components.province-abbre")
						<input class="input plate-num" id="vio_plate_num" type="text" placeholder="车牌号码后六位"/>
						@include("components.select-types")
					</div>
				</div>
				<div class="input-wrapper">
					<div class="input-title">车架号：</div>
					<div class="inputs">
						<input class="input fullwidth" id="frame_num" type="text" placeholder="请输入车架号后六位"/>
					</div>
				</div>
				<div class="input-wrapper">
					<div class="input-title">发动机号码：</div>
					<div class="inputs">
						<input class="input fullwidth" id="engine_num" type="text" placeholder="请输入发动机号码后六位"/>
					</div>
				</div>
				<div class="tips-words vio-warn-tips"></div>
				<div class="input-wrapper input-btn vio-btn">
					确定
				</div>
			</div>
		</div>
		<!-- 查询框 END -->

		@if ( isset( $account ) )
			@include("components.violation-info", [ 'account', $account ])
		@endif

		<div class="violation-noresulte-tips" id="no_resulte">暂无车辆<span class="records-plate">XXXXXX</span>的违章信息</div>
		<div class="violation-records clearfix vio-records">
			<input id="sign" type="hidden" value=""/>
			<div class="vio-records-title">
				车牌号<span class="records-plate">XXXXXX</span> | 发动机号<span class="records-engine"></span> | 车架号<span class="records-frame"></span> <br/> 共有<span class="records-total">3</span>笔违章记录
			</div>
			<div class="vio-records-table vio-records-table01">
				<table>
					<tr class="tb-head">
						<th>
							<label for="vio_select_all">
								<input type="checkbox" class="vio-select-all"/>
								全选
							</label>
						</th>
						<th>序号</th>
						<th>违章时间</th>
						<th>[违章城市]违章地点</th>
						<th>违章行为</th>
						<th>违法序号</th>
						<th>扣分分值</th>
						<th>本金</th>
						<th>滞纳金</th>
						<th>服务费</th>
						<th>罚款总额</th>
					</tr>
					
				</table>
				<div class="vio-select-resulte">
					总本金： <span class="total-principal">0</span>	
					总滞纳金： <span class="total-late-fee">0</span>	
					总服务费： <span class="total-service-fee">0</span>	
					合计总金额： <span class="total-money">0</span>	
				</div>
				<div class="vio-submit-btn deal-btn">
					<a href="javascript:">办理违章</a>
				</div>
			</div>
			<div class="vio-records-table vio-records-table02">
				<table>
					<tr class="tb-head">
						<th>
							<label for="vio_select_all">
								<input type="checkbox" class="vio-select-all"/>
								全选
							</label>
						</th>
						<th>序号</th>
						<th>违章时间</th>
						<th class="position">[违章城市]违章地点</th>
						<th>违章行为</th>
						<th>违法序号</th>
						<th>扣分分值</th>
						<th>本金</th>
						<th>滞纳金</th>
						<th>服务费</th>
						<th>罚款总额</th>
					</tr>
					
				</table>
				<div class="vio-submit-btn">
					@include("components.contact-us-a")
				</div>
			</div>
		</div>
	</div>
</div>
@include("components.warn-mask")

<script type="text/template" id="vio_template">
	<% for (var i = 0; i < array.length; i++){ 
		var total_sum = parseInt(array[i]["fkje"]) + parseInt(service_fee);
		var number = i + 1;
	%>
		<tr class="tb-tr">
			<td>
				<input class="checkbox" type="checkbox" data-xh="<%- array[i]['xh'] %>" />
			</td>
			<td>
				<span class="number"><%- number %></span>
			</td>
			<td>
				<span class="date"><%- array[i]["wfsj"] %></span>
			</td>
			<td>
				<span>[<%- array[i]["wfcs"] %>]</span>
				<span class="block"><%- array[i]["wfdz"] %></span>
			</td>
			<td>
				<span class="describe">
					<%- array[i]["wfxwzt"] %>
				</span>
				<span class="num">[<%- array[i]["wfxw"] %>]</span>
			</td>
			<td>
				<span class="xh"><%- array[i]["xh"] %></span>
			</td>
			<td>
				<span class="scores"><%- array[i]["wfjfs"] %></span>
			</td>
			<td>
				<span class="principal"><%- array[i]["fkje"] %></span>
			</td>
			<td>
				<span class="late-fee">0</span>
			</td>
			<td>
				<span class="serve-money"><%- service_fee %></span>
			</td>
			<td>
				<span class="total-sum"><%- total_sum %></span>
			</td>
		</tr>
	<% } %>

</script>