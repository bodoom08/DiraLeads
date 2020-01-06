<?php if(defined('IS_ADMIN') && IS_ADMIN): ?>
<div class="dashboard-inner">
    <h4>Main</h4>
    <ul>
        <li class="active"><a href="<?php echo site_url('dashboard'); ?>"><i class="flaticon-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo site_url('property'); ?>"><i class="flaticon-apartment"></i>Properties</a></li>
        <li><a href="<?php echo site_url('users'); ?>"><i class="fa fa-users"></i>Users</a></li>
        <li><a href="<?php echo site_url('areas'); ?>"><i class="fa fa-map"></i>Areas</a></li>
        <li><a href="<?php echo site_url('agents'); ?>"><i class="fa fa-vcard"></i>Customer Service Representative</a></li>
    </ul>
    <h4>Subscribed Packages</h4>
    <ul>
        <li><a href="<?php echo site_url('package'); ?>"><i class="fa fa-envelope-o"></i>User subscribed packages</a></li>
        <li><a href="<?php echo site_url('subscription/user'); ?>"><i class="fa fa-envelope-o"></i>Manage User subscribed packages</a></li>
    </ul>
    <h4>Configure Packages</h4>
    <ul>
        <li><a href="<?php echo site_url('custompackage'); ?>"><i class="flaticon-clock"></i>Manage Packages</a></li>        
    </ul>
    <h4>Logs</h4>
    <ul>
        <li><a href="<?php echo site_url('logs/cdr'); ?>"><i class="fa fa-database"></i>CDR</a></li>
        <li><a href="<?php echo site_url('logs/invoices'); ?>"><i class="fa fa-money"></i> Payment</a></li>
    </ul>
    <h4>Website</h4>
    <ul>
        <li><a href="<?php echo site_url('website/widgets'); ?>"><i class="fa fa-th-large"></i>Widgets</a></li>
        <li><a href="<?php echo site_url('website/pages'); ?>"><i class="fa fa-wpforms"></i>Pages</a></li>
        <li><a href="<?php echo site_url('website/menus'); ?>"><i class="fa fa-list-ul"></i>Menus</a></li>
        <li><a href="<?php echo site_url('website/configs'); ?>"><i class="fa fa-wrench"></i>Configurations</a></li>
    </ul>
    <h4>Database Management</h4>
    <ul>
        <li><a href="<?php echo site_url('database'); ?>"><i class="fa fa-database"></i>Backup Database</a></li>
    </ul>
    <h4>Account</h4>
    <ul>
        <li><a href="javascript:alert('Under Development')"><i class="flaticon-people"></i>My Profile</a></li>
        <li><a href="<?php echo site_url('login/logout'); ?>"><i class="flaticon-logout"></i>Logout</a></li>
    </ul>
</div>
<?php endif; ?>

<?php if(defined('IS_AGENT') && IS_AGENT): ?>
<div class="dashboard-inner">
    <h4>Properties</h4>
    <ul>
        <li class="active"><a href="<?php echo site_url('dashboard'); ?>"><i class="flaticon-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo site_url('property'); ?>"><i class="flaticon-apartment"></i>Pending Listing</a></li>
        <li><a href="<?php echo site_url('users'); ?>"><i class="fa fa-users"></i>Users</a></li>
    </ul>
    <h4>Account</h4>
    <ul>
        <li><a href="my-profile.html"><i class="flaticon-people"></i>My Profile</a></li>
        <li><a href="<?php echo site_url('login/logout'); ?>"><i class="flaticon-logout"></i>Logout</a></li>
    </ul>
</div>
<?php endif; ?>
