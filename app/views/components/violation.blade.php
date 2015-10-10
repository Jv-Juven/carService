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

		@include("components.violation-info")

		<div class="violation-records clearfix vio-records">
			<div class="vio-records-title">
				车牌号码为<span class="records-plate">XXXXXX</span>的车辆共有<span class="records-total">3</span>笔违章记录
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
						<th>违章时间</th>
						<th>[违章城市]违章地点</th>
						<th>违章行为</th>
						<th>扣分分值</th>
						<th>本金</th>
						<!-- <th>滞纳金</th> -->
						<th>服务费</th>
					</tr>
					
				</table>
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
						<th>违章时间</th>
						<th>[违章城市]违章地点</th>
						<th>违章行为</th>
						<th>扣分分值</th>
						<th>本金</th>
						<!-- <th>滞纳金</th> -->
						<th>服务费</th>
					</tr>
					
				</table>
				<div class="vio-submit-btn">
					<a href="javascript:">联系客服</a>
				</div>
			</div>
		</div>
	</div>
</div>
@include("components.warn-mask")

<script type="text/template" id="vio_template">
	<% for (var i = 0; i < array.length; i++){ %>
		<tr class="tb-tr">
			<td>
				<input class="checkbox" type="checkbox" data-xh="<%- array[i]['xh'] %>" />
			</td>
			<td>
				<span class="date"><%- array[i]["wfsj"] %></span>
			</td>
			<td>
				<span class="block"><%- array[i]["wfdz"] %></span>
			</td>
			<td>
				<span class="describe">
					<%- array[i]["wfxwzt"] %>
				</span>
				<span class="num">[<%- array[i]["wfxw"] %>]</span>
			</td>
			<td>
				<span class="scores"><%- array[i]["wfjfs"] %></span>
			</td>
			<td>
				<span class="principal"><%- array[i]["fkje"] %></span>
			</td>
			<td>
				<span class="serve-money"><%- service_fee %></span>
			</td>
		</tr>
	<% } %>

</script>