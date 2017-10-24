<?php use Cake\Core\Configure; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->CompanyData->getAppTitle() ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php echo $this->Html->meta('icon', $this->Url->build("/img/flats.png")) ?>
    <!-- Bootstrap 3.3.5 -->
    <?php echo $this->Html->css('AdminLTE./bootstrap/css/bootstrap.min'); ?>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <?php echo $this->Html->css('AdminLTE.AdminLTE.min'); ?>
    <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
    <?php echo $this->Html->css('AdminLTE.skins/skin-' . Configure::read('Theme.skin') . '.min'); ?>

    <?php echo $this->Html->css('AdminLTE./plugins/datatables/jquery.dataTables.min'); ?>
    <?php echo $this->Html->css('AdminLTE./plugins/datatables/dataTables.bootstrap'); ?>
    <?php echo $this->Html->css('AdminLTE./plugins/datatables/extensions/Responsive/css/dataTables.responsive'); ?>

    <?php echo $this->Html->css('https://code.jquery.com/ui/1.12.1/themes/black-tie/jquery-ui.css'); ?>

    <?php echo $this->Html->css('masonry.min'); ?>

    <?php echo $this->Html->css('AdminLTE./plugins/datepicker/datepicker3'); ?>
    <?php echo $this->Html->css('AdminLTE./plugins/daterangepicker/daterangepicker'); ?>

    <?php echo $this->Html->css('app.min'); ?>

    <?php echo $this->fetch('css'); ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-<?php echo Configure::read('Theme.skin'); ?> sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo $this->Url->build('/'); ?>" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><?php echo $this->Html->image($this->CompanyData->getAppSmallLogo()) ?></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><?php echo $this->Html->image($this->CompanyData->getAppLogo()) ?></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <?php echo $this->element('nav-top') ?>
    </header>

    <!-- Left side column. contains the sidebar -->
    <?php echo $this->element('aside-main-sidebar'); ?>

    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <?php echo $this->Flash->render(); ?>
        <?php echo $this->Flash->render('auth'); ?>
        <?php echo $this->fetch('content'); ?>

    </div>
    <!-- /.content-wrapper -->

    <?php echo $this->element('footer'); ?>

    <!-- Control Sidebar -->
    <?php echo $this->element('aside-control-sidebar'); ?>

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
        immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<?php echo $this->Html->script('AdminLTE./plugins/jQuery/jquery-2.2.3.min'); ?>

<?php echo $this->Html->script('https://code.jquery.com/ui/1.12.0/jquery-ui.min.js'); ?>

<?php echo $this->Html->script('AdminLTE./bootstrap/js/bootstrap.min'); ?>
<!-- SlimScroll -->
<?php echo $this->Html->script('AdminLTE./plugins/slimScroll/jquery.slimscroll.min'); ?>
<!-- FastClick -->
<?php echo $this->Html->script('AdminLTE./plugins/fastclick/fastclick'); ?>

<?php echo $this->Html->script('AdminLTE./plugins/datatables/jquery.dataTables.min'); ?>
<?php echo $this->Html->script('AdminLTE./plugins/datatables/dataTables.bootstrap.min'); ?>
<?php echo $this->Html->script('AdminLTE./plugins/datatables/extensions/Responsive/js/dataTables.responsive.min'); ?>
<?php echo $this->Html->script('initializers/datatables.min'); ?>

<?php echo $this->Html->script('AdminLTE./plugins/input-mask/jquery.inputmask'); ?>
<?php echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js'); ?>

<?php echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js'); ?>
<?php echo $this->Html->script('initializers/jquery-validate.min'); ?>


<?php echo $this->Html->script('http://ajax.microsoft.com/ajax/jquery.templates/beta1/jquery.tmpl.js'); ?>

<?php echo $this->Html->script('https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js'); ?>
<?php echo $this->Html->script('initializers/masonry.min'); ?>

<?php echo $this->Html->script('AdminLTE./plugins/datepicker/bootstrap-datepicker'); ?>
<?php echo $this->Html->script('AdminLTE./plugins/daterangepicker/moment.min'); ?>
<?php echo $this->Html->script('AdminLTE./plugins/daterangepicker/daterangepicker'); ?>
<?php echo $this->Html->script('initializers/datepickers.min'); ?>

<?php echo $this->Html->script('initializers/maskedinput.min'); ?>

<?php echo $this->Html->script('general.min') ?>

<!-- AdminLTE App -->
<?php echo $this->Html->script('AdminLTE./js/app.min'); ?>
<!-- AdminLTE for demo purposes -->
<?php echo $this->fetch('script'); ?>
<?php echo $this->fetch('scriptBottom'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $(".navbar .menu").slimscroll({
            height: "200px",
            alwaysVisible: false,
            size: "3px"
        }).css("width", "100%");

        var a = $('a[href="<?php echo $this->request->webroot . $this->request->url ?>"]');
        if (!a.parent().hasClass('treeview') && !a.parent().parent().hasClass('pagination')) {
            a.parent().addClass('active').parents('.treeview').addClass('active');
        }
    });
</script>
</body>
</html>
