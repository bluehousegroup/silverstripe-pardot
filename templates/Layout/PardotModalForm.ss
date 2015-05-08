<div class="main">
	<div class="container" style="padding:20px">
		<img src="/silverstripe-pardot/images/pardot-logo.png" height="50">
		<hr>
		<form class="cms">
			<h4>
				<span class="step-label">
					<span class="flyout">A</span><span class="arrow"></span>
					<span class="title">Forms</span>
				</span>
			</h4>
			<p class="field dropdown">
				<select id="selected_form">
					<% loop $Forms %>
					<option value="[pardot_form, title='$name'">$name</option>
					<% end_loop %>
				</select>
			</p>
			<p><strong>Optional attributes:</strong></p>
			<p>
				Height: <input type="text" id="form-height" size="7"> Width: <input type="text" id="form-width" size="7"> Classes: <input type="text" id="form-classes">
			</p>
			<p>
				<button class="action ss-ui-alternate ui-button ui-widget ui-state-default ui-corner-right ss-ui-button ui-button-text-icon-primary ss-ui-action-constructive" id="pardot-submit-form">Add Form</button>
			</p>

			<hr>

			<h4>
				<span class="step-label">
					<span class="flyout">B</span><span class="arrow"></span>
					<span class="title">Dynamic Content</span>
				</span>
			</h4>
			<p class="field dropdown">
				<select id="selected_content">
					<% loop $DynamicContent %>
					<option value="[pardot_dynamic, name='$name'">$name</option>
					<% end_loop %>
				</select>
			</p>
			<p><strong>Optional attributes:</strong></p>
			<p>
				Height: <input type="text" id="content-height" size="7"> Width: <input type="text" id="content-width" size="7"> Classes: <input type="text" id="content-classes">
			</p>
			<p>
				<button class="action ss-ui-alternate ui-button ui-widget ui-state-default ui-corner-right ss-ui-button ui-button-text-icon-primary ss-ui-action-constructive" id="pardot-submit-dynamic">Add Dynamic content</button>
			</p>
		</form>
	</div>
</div>