<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/layout/top', [
	'title' => 'Set New Password'
]);
?>
<div class="contact-section overview-bgi">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="form-content-box">					
					<div class="details">
						<?php if(isset($error) && (!empty($error))) : ?>
							<div class="alert alert-danger alert-dismissible">
								<div style="font-size: 13px; line-height: inherit; text-align: left; margin-bottom: 0px; text-transform: initial;"><?php echo $error; ?></div>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						<?php endif; ?>
						<?php echo form_open(); ?>
						<div class="form-group">
							<input type="password" name="password" class="input-text" placeholder="Password" required>
						</div>
						<div class="form-group">
							<input type="password" name="cnf_password" class="input-text" placeholder="Confirm Password" required>
						</div>
						<div class="form-group mb-0">
							<button type="submit" class="btn-md button-theme btn-block">Set Password</button>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('common/layout/bottom'); ?>