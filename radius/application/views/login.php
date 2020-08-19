<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/layout/top', [
	'title' => 'Login'
]);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<div class="contact-section overview-bgi">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="form-content-box">
					<div class="details">
					<h6 class="mb-20"><img src="/uploads/<?php echo CFG_LOGO; ?>" width="70%"><sup style="color: #ff214f">RADIUS</sup></h6>
						<?php echo form_open('login/validate', 'id="loginForm" class=""'); ?>
						<div class="form-group">
							<input type="email" name="email" class="input-text" placeholder="Email Address">
						</div>
						<div class="form-group">
							<input type="password" name="password" class="input-text" placeholder="Password">
						</div>
						<div class="form-group mb-0">
							<button type="submit" class="btn-md button-theme btn-block">login</button>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('common/layout/bottom'); ?>
<script>
	$('#loginForm').ajaxForm({
		dataType: 'json',
		beforeSubmit: function() {
			event.preventDefault();
		},
		success: function(arg) {
			toastr[arg.type](arg.text);
			if (arg.type == 'success') {
				window.location.href = "<?php echo site_url('dashboard') ?>"
			}
		}
	});
</script>