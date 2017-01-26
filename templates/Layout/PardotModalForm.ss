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
            <div class="form-group row">
                <label for="form-height" class="col-sm-1 col-form-label">Height:</label>
                <div class="col-sm-2">
                    <input class="form-control" type="text" id="form-height">
                </div>
                <label for="form-height" class="col-sm-1 col-form-label">Width:</label>
                <div class="col-sm-2">
                    <input class="form-control" type="text" id="form-width">
                </div>
                <label for="form-height" class="col-sm-1 col-form-label">Classes:</label>
                <div class="col-sm-2">
                    <input class="form-control" type="text" id="form-classes">
                </div>
            </div>
			<p>
				<button class="action btn btn-primary font-icon-plus" id="pardot-submit-form">Add Form</button>
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
            <div class="form-group row">
                <label for="content-height" class="col-sm-1 col-form-label">Height:</label>
                <div class="col-sm-2">
                    <input class="form-control" type="text" id="content-height">
                </div>
                <label for="content-height" class="col-sm-1 col-form-label">Width:</label>
                <div class="col-sm-2">
                    <input class="form-control" type="text" id="content-width">
                </div>
                <label for="content-height" class="col-sm-1 col-form-label">Classes:</label>
                <div class="col-sm-2">
                    <input class="form-control" type="text" id="content-classes">
                </div>
            </div>
			<p>
				<button class="btn btn-primary font-icon-plus" id="pardot-submit-dynamic">Add Dynamic content</button>
			</p>
		</form>
	</div>
</div>
